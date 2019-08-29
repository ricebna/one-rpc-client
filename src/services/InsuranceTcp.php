<?php
/**** 9 Classes, 64 Methods ****/
/*********************************************************************************************************/

namespace OneRpcClient\Tcp\App\Rpc {

   /**
 * MatchGoodsRpc 
 * 评估推荐商品 
------------------------------------------------------------------------------

     * 创建一条记录
     * @param $data
     * @return array 插入后的完整数据
     * $data = [
        'people' => 'adult', //人群(参见枚举列表)
        'income' => 300, //收入(参见枚举列表)
        'gender' => ['male','female'], //性别,数组类型(参见枚举列表)
        'age_min' => 12, //年龄最小值
        'age_max' => 20, //年龄最大值
        'product_uuid' => '2LGQ4NHPZLWGELXQ', //产品uuid
        'insure_amount' => 500, //建议保额
        'premium' => 30, //保费估算
        'desc' => 'recommend description', //评估语
        ]

    * @method array create(array $data)

------------------------------------------------------------------------------

     * 更新一条记录
     * @param $data,商品全部信息,必须带有uuid
     * @return int 影响数据库行数(1/0)
     * $data = [
        'people' => 'old',
        'income' => 500,
        'gender' => ['male'],
        'age_min' => 12,
        'age_max' => 20,
        'product_uuid' => '2LGQ4NHPZLWGELXQ',
        'insure_amount' => 500,
        'premium' => 30,
        'desc' => 'recommend description',
        'uuid' => '2M2EXLCQJZ1J8B4Y',
        ]

    * @method int update(array $data)

------------------------------------------------------------------------------

     * 获取智能评估结果列表
     * @param $condition,评估条件
     * @return array
     * $condition = [
        'people' => 'old',
        'income' => 500,
        'gender' => 'male',
        'age' => 55,
        ];

    * @method array recommendList(array $condition)

------------------------------------------------------------------------------

     * 获取总记录数
     * @param $filter,过滤条件
     * @return int
     * $filter = [
        'people' => 'old',
        'income' => 500,
        'keywords' => '安心',//产品关键词
        ];

    * @method int getTotal(array $filter)

------------------------------------------------------------------------------

     * 获取列表
     * @param $filter,过滤条件
     * @param int $page, //页码
     * @param int $limit //每页数量
     * @return array
     * $filter = [
        'people' => 'old',
        'income' => 500,
        'keywords' => '安心',
        ];

    * @method array getList(array $filter, $page, $limit, $sort)

------------------------------------------------------------------------------

     * 删除一条记录
     * @param $uuid
     * @return int

    * @method int delete(string $uuid)

------------------------------------------------------------------------------

     * 获取预定义枚举列表
     * @return array

    * @method array getEnumList()

------------------------------------------------------------------------------

     * 通过uuid获取一条记录
     * @param $uuid
     * @return array|null

    * @method array|null getByUuid(string $uuid)

------------------------------------------------------------------------------

    */
    class MatchGoodsRpc extends \OneRpcClient\RpcClientTcp { 
        protected $secret = 'bcc7fece0b442b2a2fa53d17a637a3e6';
        protected $service_name = 'insurance';
        protected $remote_class_name = 'App\Rpc\MatchGoodsRpc';
    } 
} 

/*********************************************************************************************************/

namespace OneRpcClient\Tcp\App\Rpc {

   /**
 * ProductRpc 
 * 保险产品 
------------------------------------------------------------------------------

     * 创建一条记录
     * @param $data
     * @return array 插入后的完整数据

    * @method array create(array $data)

------------------------------------------------------------------------------

     * 更新一条记录
     * @param $data,商品全部信息,必须带有uuid
     * @return int 影响数据库行数(1/0)

    * @method int update(array $data)

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

     * 删除一条记录
     * @param $uuid
     * @return int

    * @method int delete(string $uuid)

------------------------------------------------------------------------------

     * 通过一组产品uuid获取对应产品列表
     * @param $uuid_list
     * @return array

    * @method array getListByUuidList(array $uuid_list)

------------------------------------------------------------------------------


    * @method  getCheckedTagGroup($goods_uuid, $category)

------------------------------------------------------------------------------

     * 通过uuid获取一条记录
     * @param $uuid
     * @return array|null

    * @method array|null getByUuid(string $uuid)

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
    class ProductRpc extends \OneRpcClient\RpcClientTcp { 
        protected $secret = 'bcc7fece0b442b2a2fa53d17a637a3e6';
        protected $service_name = 'insurance';
        protected $remote_class_name = 'App\Rpc\ProductRpc';
    } 
} 

/*********************************************************************************************************/

namespace OneRpcClient\Tcp\App\Rpc {

   /**
 * BookingRpc 
 * 预约 
------------------------------------------------------------------------------

     * 创建一条记录,一个手机号仅能成功创建一次
     * @param $data
     * @param $source_data,用户来源信息,f_uid,f_action,f_ctime不需要传
     * @param $log_data,日志信息,f_uid,f_content,f_action,f_ctime不需要传
     * @return array 成功预约后返回某个咨询顾问的信息
     * $data = [
        'mobile' => '13211111122',
        'note' => '--备注信息--',
        'call_name' => '陈陈',
        'insure_for' => ['self','parents'],
        ]

    * @method array create(array $data, array $source_data, array $log_data)

------------------------------------------------------------------------------

     * 通过手机号查询是否预约过, 如果预约过则返回专家信息
     * @param $mobile
     * @return array|null

    * @method array|null getExpert(string $mobile)

------------------------------------------------------------------------------

     * 通过手机号获取一条记录
     * @param $mobile
     * @return array|null

    * @method array|null getByMobile(string $mobile)

------------------------------------------------------------------------------

     * 通过用户id获取最近记录列表
     * @param $user_id
     * @param $limit,记录数,默认1条,最多10条
     * @return array|null

    * @method array|null getListByUserId(string $user_id, $limit)

------------------------------------------------------------------------------

     * 创建一条重复预约日志
     * @param $data,f_content,f_action,f_ctime不需要传,f_uid必传
     * @return array
     * $data = [
        'f_uid' => '100011'
        ]

    * @method array crateAgainLog(array $data)

------------------------------------------------------------------------------

     * 获取预定义枚举列表
     * @return array

    * @method array getEnumList()

------------------------------------------------------------------------------

     * 通过uuid获取一条记录
     * @param $uuid
     * @return array|null

    * @method array|null getByUuid(string $uuid)

------------------------------------------------------------------------------

    */
    class BookingRpc extends \OneRpcClient\RpcClientTcp { 
        protected $secret = 'bcc7fece0b442b2a2fa53d17a637a3e6';
        protected $service_name = 'insurance';
        protected $remote_class_name = 'App\Rpc\BookingRpc';
    } 
} 

/*********************************************************************************************************/

namespace OneRpcClient\Tcp\App\Rpc {

   /**
 * MatchApplicationRpc 
 * 评估申请 
------------------------------------------------------------------------------

     * 创建一条记录
     * @param $data
     * @param $source_data,用户来源信息,f_uid,f_action,f_ctime不需要传
     * @param $log_data,日志信息,f_uid,f_content,f_action,f_ctime不需要传
     * @return array 插入后的完整数据
     * $data = [
        'insured_list' => [ //所有被保人信息,数组类型
            'spouse' => ['age' =>25, 'gender' => 'male', 'relation' => 'spouse'],
            'self' => ['age' =>25, 'gender' => 'female', 'relation' => 'self'],
            'children' => ['age' =>25, 'relation' => 'children'],
            'parents' => ['age' =>25, 'relation' => 'parents'],
        ],
        'income' => 300, //收入
        'ever_bought' => ['人寿', '健康'], //之前购买过的产品,数组类型
        'mobile' => '13211111111', //手机号
        'gender' => 'male', //本人性别
        ];

    * @method array create(array $data, array $source_data, array $log_data)

------------------------------------------------------------------------------

     * 通过手机号获取一条记录
     * @param $mobile
     * @return array|null

    * @method array|null getByMobile(string $mobile)

------------------------------------------------------------------------------

     * 通过用户id获取最近记录列表
     * @param $user_id
     * @param $limit,记录数,默认1条,最多10条
     * @return array|null

    * @method array|null getListByUserId(string $user_id, $limit)

------------------------------------------------------------------------------

     * 获取预定义枚举列表
     * @return array

    * @method array getEnumList()

------------------------------------------------------------------------------

     * 通过uuid获取一条记录
     * @param $uuid
     * @return array|null

    * @method array|null getByUuid(string $uuid)

------------------------------------------------------------------------------

    */
    class MatchApplicationRpc extends \OneRpcClient\RpcClientTcp { 
        protected $secret = 'bcc7fece0b442b2a2fa53d17a637a3e6';
        protected $service_name = 'insurance';
        protected $remote_class_name = 'App\Rpc\MatchApplicationRpc';
    } 
} 

/*********************************************************************************************************/

namespace OneRpcClient\Tcp\App\Rpc {

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
        protected $secret = 'bcc7fece0b442b2a2fa53d17a637a3e6';
        protected $service_name = 'insurance';
        protected $remote_class_name = 'App\Rpc\UserRpc';
    } 
} 

/*********************************************************************************************************/

namespace OneRpcClient\Tcp\App\Rpc {

   /**
 * GoodsRpc 
 * 商品 
------------------------------------------------------------------------------

     * 创建一条记录
     * @param $data
     * @return array 插入后的完整数据

    * @method array create(array $data)

------------------------------------------------------------------------------

     * 更新一条记录
     * @param $data,商品全部信息,必须带有uuid
     * @return int 影响数据库行数(1/0)

    * @method int update(array $data)

------------------------------------------------------------------------------

     * 保存列表排序
     * @param $data
     * @return bool

    * @method bool addSort($data)

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

     * 删除一条记录
     * @param $uuid
     * @return int

    * @method int delete(string $uuid)

------------------------------------------------------------------------------

     * 商品排序, 每一组查询条件的排序都可能不同, 查询条件根据键名升序排列.
     * @param $goods_list
     * @param $query
     * @return array

    * @method array sort($goods_list, $query)

------------------------------------------------------------------------------


    * @method  getCheckedTagGroup($goods_uuid, $category)

------------------------------------------------------------------------------

     * 获取一级导航列表
     * @return array

    * @method array getExGoodsNaviList()

------------------------------------------------------------------------------

     * 根据一级导航获取二级导航列表
     * @param $navi_tag_uuid,一级导航uuid
     * @return array

    * @method array getExGoodsSecondNaviList(string $navi_tag_uuid)

------------------------------------------------------------------------------

     * 通过uuid获取一条记录
     * @param $uuid
     * @return array|null

    * @method array|null getByUuid(string $uuid)

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
    class GoodsRpc extends \OneRpcClient\RpcClientTcp { 
        protected $secret = 'bcc7fece0b442b2a2fa53d17a637a3e6';
        protected $service_name = 'insurance';
        protected $remote_class_name = 'App\Rpc\GoodsRpc';
    } 
} 

/*********************************************************************************************************/

namespace OneRpcClient\Tcp\App\Rpc {

   /**
 * GoodsTagRpc 
 * 商品标签 
------------------------------------------------------------------------------


    * @method  saveNavi($data, $cache_data)

------------------------------------------------------------------------------

     * 通过code获取一条标签记录
     * @param $category,分类标识符
     * @param $code
     * @return array|null

    * @method array|null getByCode(string $category, $code)

------------------------------------------------------------------------------


    * @method  getByName(string $category, $name)

------------------------------------------------------------------------------


    * @method  getChildrenByName($name)

------------------------------------------------------------------------------


    * @method  getGroup($category)

------------------------------------------------------------------------------

     * 通过uuid获取一条记录
     * @param $uuid
     * @return array|null

    * @method array|null getByUuid(string $uuid)

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
    class GoodsTagRpc extends \OneRpcClient\RpcClientTcp { 
        protected $secret = 'bcc7fece0b442b2a2fa53d17a637a3e6';
        protected $service_name = 'insurance';
        protected $remote_class_name = 'App\Rpc\GoodsTagRpc';
    } 
} 

/*********************************************************************************************************/

namespace OneRpcClient\Tcp\App\Rpc {

   /**
 * ProductTagRpc 
 * 产品标签 
------------------------------------------------------------------------------

     * 通过code获取一条标签记录
     * @param $category,分类标识符
     * @param $code
     * @return array|null

    * @method array|null getByCode(string $category, $code)

------------------------------------------------------------------------------


    * @method  getByName(string $category, $name)

------------------------------------------------------------------------------


    * @method  getChildrenByName($name)

------------------------------------------------------------------------------


    * @method  getGroup($category)

------------------------------------------------------------------------------

     * 通过uuid获取一条记录
     * @param $uuid
     * @return array|null

    * @method array|null getByUuid(string $uuid)

------------------------------------------------------------------------------

    */
    class ProductTagRpc extends \OneRpcClient\RpcClientTcp { 
        protected $secret = 'bcc7fece0b442b2a2fa53d17a637a3e6';
        protected $service_name = 'insurance';
        protected $remote_class_name = 'App\Rpc\ProductTagRpc';
    } 
} 

/*********************************************************************************************************/

namespace OneRpcClient\Tcp\App\Rpc {

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
        protected $secret = 'bcc7fece0b442b2a2fa53d17a637a3e6';
        protected $service_name = 'insurance';
        protected $remote_class_name = 'App\Rpc\CacheStrategyRpc';
    } 
} 