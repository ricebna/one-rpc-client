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
     * @param $sysid,系统标识符(haifang:海房,insurance:保险,operate:运营,yimin:移民)
     * @param $username,用户名
     * @param $pass,密码
     * @return array
     * 成功返回: ["code" => "ok", "data" => ["username" => "chen6"]]
     * 失败返回: ["code" => "错误码", "data" => []]
     * 错误码: ok:成功, pass-error:密码错误, disabled:账号已禁用, user-nx:账号不存在

    * @method array verify(string $sysid,string $username,string $pass)

------------------------------------------------------------------------------

     * 获得角色列表组, 包括所有系统
     * @return array

    * @method array roleGroup()

    */
    class AdminRpc extends \OneRpcClient\RpcClientTcp { 
        protected $service_name = 'super-admin';
        protected $remote_class_name = 'App\Rpc\AdminRpc';
    } 
} 