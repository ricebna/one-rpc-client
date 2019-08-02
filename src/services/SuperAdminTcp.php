<?php

/***************************************************************************************************/

namespace OneRpcClient\Tcp\App\Rpc {

   /**

 * 统一后台账号管理
------------------------------------------------------------------------------

     * 同步创建各系统用户信息
     * @param $data,统表信息
    * @method mixed create(array $data)

------------------------------------------------------------------------------

     * 同步更新各系统用户信息
     * @param $data,统表信息
    * @method mixed update(array $data)

------------------------------------------------------------------------------

     * 登录校验
     * @param $sysid,系统标识符(haifang:海房,insurance:保险,operate:运营)
     * @param $username,用户名
     * @param $pass,密码
     * @return string 本地系统用户名
    * @method string verify(string $sysid,string $username,string $pass)

------------------------------------------------------------------------------

     * 获得角色列表组, 包括所有系统
     * @return mixed
    * @method mixed roleGroup()

    */
    class AdminRpc extends \OneRpcClient\RpcClientTcp { 
        protected $service_name = 'super-admin';
        protected $remote_class_name = 'App\Rpc\AdminRpc';
    } 
} 