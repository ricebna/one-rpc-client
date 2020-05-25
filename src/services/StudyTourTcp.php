<?php
/**** 4 Classes, 11 Methods ****/
/*********************************************************************************************************/

namespace OneRpcClient\Tcp\App\Rpc\StudyTour {

   /**
 * UserRpc 
 * 用户 
------------------------------------------------------------------------------

     * 通过手机号获取一条记录
     * @param $mobile
     * @return array|null

    * @method array|null getByMobile(string $mobile)

------------------------------------------------------------------------------

     * 通过uuid(f_id)获取一条记录
     * @param $uuid
     * @return array|null

    * @method array|null getByUuid(string $uuid)

------------------------------------------------------------------------------

    */
    class UserRpc extends \OneRpcClient\RpcClientTcp { 
        protected $secret = '3dg50a63bcc57a9bm7fe442e3e6fk62a';
        protected $service_name = 'study_tour';
        protected $remote_class_name = 'App\Rpc\UserRpc';
    } 
} 

/*********************************************************************************************************/

namespace OneRpcClient\Tcp\App\Rpc\StudyTour {

   /**
 * CacheStrategyRpc 
 * 缓存更新策略
 * 用法:
    $data = cache('api-goods-list');
    //使用 isCacheKeyValid 判断'api-goods-list'缓存键是否有效(该缓存归属goods_list分组)
    if(!$data || !$client->isCacheKeyValid('goods_list', 'api-goods-list')){
        $data = getlist();
        cache('api-goods-list', $data);
        //使用用 updateCacheKey 更新缓存键为有效
        $client->updateCacheKey('goods_list', 'api-goods-list');
    }
    return $data; 
------------------------------------------------------------------------------

     * 判断缓存是否有效
     * @param $group,缓存分组标识符
     * @param $key
     * @return bool
     * @throws \Exception

    * @method bool isCacheKeyValid(string $group, $key)

------------------------------------------------------------------------------

     * 更新缓存键为有效
     * @param $group,缓存分组标识符
     * @param $key
     * @return bool

    * @method bool updateCacheKey(string $group, $key)

------------------------------------------------------------------------------

     * 更新缓存分组
     * @param $group
     * @return bool
     * @throws \Exception

    * @method bool updateCacheGroup(string $group)

------------------------------------------------------------------------------

    */
    class CacheStrategyRpc extends \OneRpcClient\RpcClientTcp { 
        protected $secret = '3dg50a63bcc57a9bm7fe442e3e6fk62a';
        protected $service_name = 'study_tour';
        protected $remote_class_name = 'App\Rpc\CacheStrategyRpc';
    } 
} 

/*********************************************************************************************************/

namespace OneRpcClient\Tcp\App\Rpc\StudyTour {

   /**
 * WeixinRpc 
 * 微信API(解决跨项目间的Accesstoken一致性问题) 
------------------------------------------------------------------------------

     * 获取Accesstoken
     * @param $app_code, jz_official
     * @return bool|mixed

    * @method bool|mixed getAccessToken($app_code)

------------------------------------------------------------------------------

     * js调用api前需获取的授权码
     * @param $app_code, jz_official
     * @return bool|mixed|string

    * @method bool|mixed|string getJsTicket($app_code)

------------------------------------------------------------------------------

    */
    class WeixinRpc extends \OneRpcClient\RpcClientTcp { 
        protected $secret = '3dg50a63bcc57a9bm7fe442e3e6fk62a';
        protected $service_name = 'study_tour';
        protected $remote_class_name = 'App\Rpc\WeixinRpc';
    } 
} 

/*********************************************************************************************************/

namespace OneRpcClient\Tcp\App\Rpc\StudyTour {

   /**
 * ProjectRpc 
 * 游学项目 
------------------------------------------------------------------------------

     * 获取总记录数
     * @param $filter,过滤条件
     * @return int

    * @method int getTotal(array $filter)

------------------------------------------------------------------------------

     * 获取列表
     * @param $filter,过滤条件
     * @param int $page, //页码
     * @param int $limit //每页数量
     * @return array

    * @method array getList(array $filter, $page, $limit, $sort)

------------------------------------------------------------------------------

     * 排序
     * @param $list 列表数据
     * @param $query 排序条件
     * @return array

    * @method array sort($list, $query)

------------------------------------------------------------------------------

     * 通过uuid获取一条记录
     * @param $uuid
     * @return array|null

    * @method array|null getByUuid(string $uuid)

------------------------------------------------------------------------------

    */
    class ProjectRpc extends \OneRpcClient\RpcClientTcp { 
        protected $secret = '3dg50a63bcc57a9bm7fe442e3e6fk62a';
        protected $service_name = 'study_tour';
        protected $remote_class_name = 'App\Rpc\ProjectRpc';
    } 
} 