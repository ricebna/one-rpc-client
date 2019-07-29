<?php
namespace OneRpcClient{
    class RpcClient
    {
        const RPC_REMOTE_OBJ = '#RpcRemoteObj#';

        public static $is_static = 0;

        public static $call_id = '';

        protected $need_close = 0;

        protected $remote_class_name = '';

        protected $token = '';

        public $consul_host = 'consul-client';
        public $consul_port = '8520';
        
        protected $service_name = '';

        public function __construct(...$args)
        {
            $this->id    = self::$call_id ? self::$call_id : $this->uuid();
            $this->calss = $this->_remote_class_name ? $this->_remote_class_name : get_called_class();
            $this->args  = $args;
        }

        protected function getServer(){
            if(!$this->consul_service_name){
                throw new \Exception("The service name is not set");
            }
            $sf = new \SensioLabs\Consul\ServiceFactory(["base_uri"=>"http://$this->consul_host:$this->consul_port/"]);
            $helth = $sf->get(\SensioLabs\Consul\Services\HealthInterface::class);
            $param = ["passing" => true];
            if($tag){
                $param['tag'] = $tag;
            }
            $result = $helth->service($service_name,$param)->json();
            if(!$result){
                throw new \Exception("The service $service_name is unavailable");
            }
            $service = $result[mt_rand(0, count($result) - 1)]["Service"];
            return "{$service['Address']}:{$service['Port']}";
        }

        public function __call($name, $arguments)
        {
            return $this->_callRpc([
                'i' => $this->id,
                'c' => $this->calss,
                'f' => $name,
                'a' => $arguments,
                't' => $this->args,
                's' => self::$is_static,
                'o' => $this->_token,
            ]);
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

        protected $connection = null;

        protected $time_out = 1;

        protected function getConnection(){
            if (!$this->connection) {
                $this->connection = stream_socket_client('tcp://'.$this->getServer(), $code, $msg, 3);
                if (!$this->connection) {
                    throw new \Exception($msg,3);
                }
                stream_set_timeout($this->connection, $this->_time_out);
            }
            return $this->connection;
        }

        protected function _callRpc($data, $retry = false)
        {
            self::$is_static = 0;

            $buffer = msgpack_pack($data);
            $buffer = pack('N', 4 + strlen($buffer)) . $buffer;
            $len    = fwrite($this->getConnection(), $buffer);
        
            if ($len !== strlen($buffer)) {
                throw new \Exception('writeToRemote fail', 11);
            }
            $data = msgpack_unpack($this->read());
            if ($data === self::RPC_REMOTE_OBJ) {
                $this->_need_close = 1;
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
            while (1) {
                $buffer = fread($this->getConnection(), 8192);
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
        protected function _callRpc($data)
        {
            self::$is_static = 0;

            $opts = ['http' => [
                'method'  => 'POST',
                'header'  => 'Content-type: application/rpc',
                'timeout' => 3,
                'content' => msgpack_pack($data)
            ]];
            $context = stream_context_create($opts);
            $result  = file_get_contents('http://'.$this->getServer(), false, $context);
            $data    = msgpack_unpack($result);
            if ($data === self::RPC_REMOTE_OBJ) {
                $this->_need_close = 1;
                return $this;
            } else if (is_array($data) && isset($data['err'], $data['msg'])) {
                throw new \Exception($data['msg'], $data['err']);
            } else {
                return $data;
            }
        }
        
    }
}
