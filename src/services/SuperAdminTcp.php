<?php

/***************************************************************************************************/

namespace OneRpcClient\Tcp\App\Rpc {

   /**

 * 管理员
---------------------------------------------------------------
    * @method mixed __construct()

---------------------------------------------------------------
     * 创建一条记录
     * @param $data
    * @method mixed create($data)

---------------------------------------------------------------
     * 更新一条记录
    * @method mixed update($where)

---------------------------------------------------------------
     * 管理员登录口令判断
     * @param $sysid,系统标识符(haifang:海房,insurance:保险,operate:运营)
     * @param $username,用户名
     * @param $pass,密码
     * @return array 本地用户表数据
    * @method array checkUser(string $sysid,string $username,string $pass)

---------------------------------------------------------------
     * 获得角色列表, 包括所有系统
     * @param string $sysid
     * @return mixed
     * @throws \Exception
    * @method mixed roleList(string $sysid)

---------------------------------------------------------------
     * 获得角色列表组, 包括所有系统
     * @return mixed
     * @throws \Exception
    * @method mixed roleGroup()

    */
    class AdminRpc extends \OneRpcClient\RpcClientTcp { 
        protected $service_name = 'super-admin';
        protected $remote_class_name = 'App\Rpc\AdminRpc';
    } 
} 