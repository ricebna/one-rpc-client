<?php
namespace OneRpcClient{
    class RpcUserException extends \ErrorException
    {

    }
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

        //public function __construct(...$args)
        public function __construct()
        {
            $this->id    = self::$call_id ? self::$call_id : $this->uuid();
            $this->ip    = $this->_getIp();
            $this->class = $this->remote_class_name ? $this->remote_class_name : get_called_class();
            //$this->args  = $args;
            $this->args  = [];
        }

        private function _getIp(){
            if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
                $ip = getenv("HTTP_CLIENT_IP");
            else
                if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
                    $ip = getenv("HTTP_X_FORWARDED_FOR");
                else
                    if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
                        $ip = getenv("REMOTE_ADDR");
                    else
                        if (isset ($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
                            $ip = $_SERVER['REMOTE_ADDR'];
                        else
                            $ip = "unknown";
            return ($ip);
        }

        public function setServerHost($host, $port){
            $this->consul_host = $host;
            $this->consul_port = $port;
        }

        public function setSecret($secret){
            $this->secret = $secret;
        }

        protected function getToken($param_str){
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
            if(!$result){$t=self::mstime();
//                $sf = new \SensioLabs\Consul\ServiceFactory(["base_uri"=>"http://$this->consul_host:$this->consul_port/"]);
//                $helth = $sf->get(\SensioLabs\Consul\Services\HealthInterface::class);
//                $param = ["passing" => true];
//                $param['tag'] = "rpc_$type";
                $i = 10000;
                while($i--){
//                    $result = $helth->service($this->service_name,$param)->json();
                    try{
                        $url = "http://$this->consul_host:$this->consul_port/v1/health/service/$this->service_name?passing=1&tag=rpc_$type";
                        $result = file_get_contents($url);
                        $result = json_decode($result, true);
                    }catch (\Exception $e){
                        if(!$i){
                            throw new \Exception("The service $this->service_name is unavailable,". $e->getMessage());
                        }
                    }
                    if($result){
                        break;
                    }
                    if(!$i){
                        throw new \Exception("The service $this->service_name is unavailable");
                    }
                }
                if(function_exists('cache')){
                    cache("consul_{$type}_{$this->service_name}", serialize($result), 600);
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
            $data = [
                'i' => $this->id,
                'ip' => $this->ip,
                'c' => $this->class,
                'f' => $name,
                'a' => $arguments,
                't' => $this->args,
                's' => self::$is_static,
                'o' => $this->getToken(json_encode([$this->id, $this->ip, $this->class, $name, $arguments, $this->args])),
            ];
            $ret = $this->callRpc(json_encode($data));//msgpack
            $result    = json_decode($ret, true);//msgpack
            if ($result === self::RPC_REMOTE_OBJ) {
                $this->need_close = 1;
                return $this;
            } else if (is_array($result) && isset($result['err'], $result['msg'])) {
                if($result['err'] > 600){
                    throw new RpcUserException($result['msg'], $result['err']);
                }
                throw new \Exception($result['msg']."[{$result['id']}]", $result['err']);
            } else {
                $time = sprintf('%01.2f',round(self::mstime() - $begin, 2));
                self::$last_called['time'] = $time;
                self::$called_list["$this->class:$name"] = self::$last_called;
                return $result;
            }
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
            //return (new static)->{$name}(...$arguments);
            return (new static)->{$name}();
        }

    }

    class RpcClientTcp extends RpcClient
    {

        private static $_connection = null;

        protected $time_out = 30;

        //public function __construct(...$args)
        public function __construct()
        {
            //parent::__construct($args);
            parent::__construct();
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
            $buffer = pack('N', 4 + strlen($data)) . $data;
            $len    = fwrite(self::$_connection, $buffer);

            if ($len !== strlen($buffer)) {
                throw new \Exception('writeToRemote fail', 11);
            }
            return $this->read();
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
                'content' => $data
            ]];
            $context = stream_context_create($opts);
            return file_get_contents($this->getServer('http'), false, $context);
        }

    }
}
