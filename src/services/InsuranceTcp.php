<?php
/**** 5 Classes, 24 Methods ****/
/*********************************************************************************************************/

namespace OneRpcClient\Tcp\App\Rpc {

   /**

 * 评估推荐商品 MatchGoodsRpc 
------------------------------------------------------------------------------


    * @method  __construct()

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

    * @method array getList(array $filter,$page,$limit)

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

 * 保险产品 ProductRpc 
------------------------------------------------------------------------------


    * @method  __construct()

------------------------------------------------------------------------------

     * 通过一组产品uuid获取对应产品列表
     * @param $uuid_list
     * @return array

    * @method array getListByUuidList(array $uuid_list)

------------------------------------------------------------------------------

     * 通过uuid获取一条记录
     * @param $uuid
     * @return array|null

    * @method array|null getByUuid(string $uuid)

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

 * 预约 BookingRpc 
------------------------------------------------------------------------------


    * @method  __construct()

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

    * @method array create(array $data,array $source_data,array $log_data)

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

    * @method array|null getListByUserId(string $user_id,$limit)

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

 * 评估申请 MatchApplicationRpc 
------------------------------------------------------------------------------


    * @method  __construct()

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

    * @method array create(array $data,array $source_data,array $log_data)

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

    * @method array|null getListByUserId(string $user_id,$limit)

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

 * 用户 UserRpc 
------------------------------------------------------------------------------


    * @method  __construct()

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