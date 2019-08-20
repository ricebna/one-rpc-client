<?php
namespace OneRpcClient{
    class RpcClient
    {
        const RPC_REMOTE_OBJ = '#RpcRemoteObj#';

        public static $is_static = 0;

        public static $call_id = '';

        protected $need_close = 0;

        public static $called_list = [];
        public static $last_called = [];

        protected $remote_class_name = '';

        protected $secret = '';

        protected $consul_host = 'consul.client';
        protected $consul_port = '8520';

        protected $service_name = '';

        public function __construct(...$args)
        {
            $this->id    = self::$call_id ? self::$call_id : $this->uuid();
            $this->class = $this->remote_class_name ? $this->remote_class_name : get_called_class();
            $this->args  = $args;
        }

        public function setServerHost($host, $port){
            $this->consul_host = $host;
            $this->consul_port = $port;
        }

        public function setSecret($secret){
            $this->secret = $secret;
        }

        public function getToken($param_str){
            $time = time();
            $token = md5($this->secret . $param_str . $time);
            $token .= "|$time";
            return $token;
        }

        protected function getServer($type = 'tcp'){
            if(!$this->service_name){
                throw new \Exception('The property $service_name is not set');
            }
            $result = null;
            if(function_exists('cache')){
                try {
                    $result = unserialize(cache("consul_{$type}_{$this->service_name}"));
                }catch (\Exception $e){}
            }
            if(!$result){
                $sf = new \SensioLabs\Consul\ServiceFactory(["base_uri"=>"http://$this->consul_host:$this->consul_port/"]);
                $helth = $sf->get(\SensioLabs\Consul\Services\HealthInterface::class);
                $param = ["passing" => true];
                $param['tag'] = "rpc_$type";
                $result = $helth->service($this->service_name,$param)->json();
                if(!$result){
                    $i = 10;
                    while($i--){
                        $result = $helth->service($this->service_name,$param)->json();
                        if($result){
                            break;
                        }
                        if(!$i){
                            throw new \Exception("The service $this->service_name is unavailable");
                        }
                        sleep(1);
                    }
                }
                if(function_exists('cache')){
                    cache("consul_{$type}_{$this->service_name}", serialize($result), 3600*23);
                }
            }
            $service = $result[mt_rand(0, count($result) - 1)]["Service"];
            $server = "$type://{$service['Address']}:{$service['Port']}";
            return $server;
        }

        protected static function mstime(){
            $mstime = explode(' ', microtime());
            return $mstime[0] + $mstime[1];
        }

        public function __call($name, $arguments)
        {
            self::$last_called = ['class' => $this->class, 'name' => $name, 'args' =>  $arguments, 'time' => '----'];
            self::$called_list["$this->class:$name"] = self::$last_called;
            $begin = self::mstime();
            $result = $this->callRpc([
                'i' => $this->id,
                'c' => $this->class,
                'f' => $name,
                'a' => $arguments,
                't' => $this->args,
                's' => self::$is_static,
                'o' => $this->getToken(json_encode([$this->class, $name, $arguments, $this->args])),
            ]);
            $time = sprintf('%01.2f',round(self::mstime() - $begin, 2));
            self::$last_called['time'] = $time;
            self::$called_list["$this->class:$name"] = self::$last_called;
            return $result;
        }

        protected function uuid()
        {
            $str = uniqid('', true);
            $arr = explode('.', $str);
            $str = $arr[0] . base_convert($arr[1], 10, 16);
            $len = 32;
            while (strlen($str) <= $len) {
                $str .= bin2hex(openssl_random_pseudo_bytes(4));
            }
            $str = substr($str, 0, $len);
            $str = str_replace(['+', '/', '='], '', base64_encode(hex2bin($str)));
            return $str;
        }

        public static function __callStatic($name, $arguments)
        {
            self::$is_static = 1;
            return (new static)->{$name}(...$arguments);
        }

    }

    class RpcClientTcp extends RpcClient
    {

        private static $_connection = null;

        protected $time_out = 30;

        public function __construct(...$args)
        {
            parent::__construct($args);
            if (!self::$_connection) {
                self::$_connection = stream_socket_client($this->getServer(), $code, $msg, 3);
                if (!self::$_connection) {
                    self::$_connection = stream_socket_client($this->getServer(), $code, $msg, 6);
                    if (!self::$_connection) {
                        throw new \Exception($msg, 6);
                    }
                }
                stream_set_timeout(self::$_connection, $this->time_out);
            }
        }

        protected function callRpc($data)
        {
            self::$is_static = 0;

            $buffer = json_encode($data);//msgpack
            $buffer = pack('N', 4 + strlen($buffer)) . $buffer;
            $len    = fwrite(self::$_connection, $buffer);

            if ($len !== strlen($buffer)) {
                throw new \Exception('writeToRemote fail', 11);
            }
            $data = json_decode($this->read(),true);//msgpack
            if ($data === self::RPC_REMOTE_OBJ) {
                $this->need_close = 1;
                return $this;
            } else if (is_array($data) && isset($data['err'], $data['msg'])) {
                throw new \Exception($data['msg'], $data['err']);
            } else {
                return $data;
            }
        }

        protected function read()
        {
            $all_buffer = '';
            $total_len  = 4;
            $head_read  = false;
            $time = time();
            while (1) {
                $buffer = fread(self::$_connection, 8192);
                if ($buffer === '' || $buffer === false) {
                    throw new \Exception('read from remote fail', 2);
                }
                $all_buffer .= $buffer;
                $recv_len   = strlen($all_buffer);
                if ($recv_len >= $total_len) {
                    if ($head_read) {
                        break;
                    }
                    $unpack_data = unpack('Ntotal_length', $all_buffer);
                    $total_len   = $unpack_data['total_length'];
                    if ($recv_len >= $total_len) {
                        break;
                    }
                    $head_read = true;
                }
            }
            return substr($all_buffer, 4);
        }

    }

    class RpcClientHttp extends RpcClient
    {
        protected function callRpc($data)
        {
            self::$is_static = 0;

            $opts = ['http' => [
                'method'  => 'POST',
                'header' => [
                    'Content-type: application/rpc'
                ],
                'timeout' => 30,
                'content' => json_encode($data) //msgpack
            ]];
            $context = stream_context_create($opts);
            $result  = file_get_contents($this->getServer('http'), false, $context);
            $data    = json_decode($result, true);//msgpack
            if ($data === self::RPC_REMOTE_OBJ) {
                $this->need_close = 1;
                return $this;
            } else if (is_array($data) && isset($data['err'], $data['msg'])) {
                throw new \Exception($data['msg'], $data['err']);
            } else {
                return $data;
            }
        }

    }
}
