<?php

/***************************************************************************************************/

namespace OneRpcClient\Tcp\App\Rpc {

   /**

 * 评估推荐商品
------------------------------------------------------------------------------


    * @method mixed __construct()

------------------------------------------------------------------------------

     * 创建评估商品
     * @param $data,商品全部信息

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
     * 成功返回: ["code" => "ok", "msg" => "成功", "data" => ["username" => "chen6"]]
     * 失败返回: ["code" => "错误码", "msg => "错误信息", "data" => []]
     * 错误码: ok:成功, pass-error:密码错误, disabled:账号已禁用, user-nx:账号不存在

    * @method array verify(string $sysid,string $username,string $pass)

------------------------------------------------------------------------------

     * 获得角色列表组, 包括所有系统
     * @return array

    * @method array roleGroup()

    */
    class MatchGoodsRpc extends \OneRpcClient\RpcClientTcp { 
        protected $service_name = 'insurance';
        protected $remote_class_name = 'App\Rpc\MatchGoodsRpc';
    } 
} 