<?php

/***************************************************************************************************/

namespace OneRpcClient\Tcp\App\Rpc {

   /**

 * 类注释
---------------------------------------------------------------
     * 测试插入两个不同数据库的表的事务表现
     * @param $age,年龄 b
     * @param $name,姓名 必须
     * @return int 自增ID
    * @method int insert(int $age,string $name)

    */
    class AbcRpc extends \OneRpcClient\RpcClientTcp { 
        protected $service_name = 'super-admin';
        protected $_remote_class_name = 'App\Rpc\AbcRpc';
    } 
} 

/***************************************************************************************************/

namespace OneRpcClient\Tcp\App\Rpc {

   /**

 * 类注释
---------------------------------------------------------------
     * 测试插入两个不同数据库的表的事务表现
     * @param $age,年龄 b
     * @param $name,姓名 必须
     * @return int 自增ID
    * @method int insert(int $age,string $name)

    */
    class HelloRpc extends \OneRpcClient\RpcClientTcp { 
        protected $service_name = 'super-admin';
        protected $_remote_class_name = 'App\Rpc\HelloRpc';
    } 
} 