<?php

/***************************************************************************************************/

namespace OneRpcClient\Tcp\App\Rpc {

   /**

 * 评估推荐商品
------------------------------------------------------------------------------


    * @method mixed __construct()

------------------------------------------------------------------------------

     * 创建一条记录
     * @param $data
     * @return int
     * $data = [
        'people' => 'adult', //人群(参见枚举列表)
        'income' => 300, //收入(参见枚举列表)
        'is_male' => 1, //是否适用男性
        'is_female' => 0, //是否适用女性
        'age_min' => 12, //年龄最小值
        'age_max' => 20, //年龄最大值
        'product_uuid' => '2LGQ4NHPZLWGELXQ', //产品uuid
        'insure_amount' => 500, //建议保额
        'premium' => 30, //保费估算
        'desc' => 'recommend description', //评估语
        ]

    * @method int create(array $data)

------------------------------------------------------------------------------

     * 更新一条记录
     * @param $data,商品全部信息,必须带有uuid
     * @return int
     * $data = [
        'people' => 'old',
        'income' => 500,
        'is_male' => 1,
        'is_female' => 0,
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
        'gender' => 'male', //性别(参见枚举列表)
        'age' => 55,
        ];

    * @method array recommendList(array $condition)

------------------------------------------------------------------------------

     * 获取总记录数
     * @param $filter,过滤条件
     * @return int
     * $condition = [
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
     * $condition = [
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

    */
    class MatchGoodsRpc extends \OneRpcClient\RpcClientTcp { 
        protected $service_name = 'insurance';
        protected $remote_class_name = 'App\Rpc\MatchGoodsRpc';
    } 
} 

/***************************************************************************************************/

namespace OneRpcClient\Tcp\App\Rpc {

   /**

 * 保险产品
------------------------------------------------------------------------------


    * @method mixed __construct()

------------------------------------------------------------------------------

     * 通过一组产品uuid获取对应产品列表
     * @param $uuid_list
     * @return array

    * @method array getListByUuidList(array $uuid_list)

------------------------------------------------------------------------------

    */
    class ProductRpc extends \OneRpcClient\RpcClientTcp { 
        protected $service_name = 'insurance';
        protected $remote_class_name = 'App\Rpc\ProductRpc';
    } 
} 

/***************************************************************************************************/

namespace OneRpcClient\Tcp\App\Rpc {

   /**

 * 预约
------------------------------------------------------------------------------


    * @method mixed __construct()

------------------------------------------------------------------------------

     * 通过手机号查询一条记录
     * @param $mobile,手机号
     * @return array

    * @method array getOneByMobile(string $mobile)

------------------------------------------------------------------------------

     * 创建一条记录
     * @param $data,预约信息
     * @return bool|array 当手机号已存在时返回false,成功预约后返回某个咨询顾问的信息
     * $data = [
        'mobile' => '132233322',
        'note' => '--备注信息--',
        'call_name' => '称呼',
        'insure_for' => 'self',//为谁投保(参见枚举列表)
        ]

    * @method bool create($data)

------------------------------------------------------------------------------

     * 获取预定义枚举列表
     * @return array

    * @method array getEnumList()

------------------------------------------------------------------------------

    */
    class BookingRpc extends \OneRpcClient\RpcClientTcp { 
        protected $service_name = 'insurance';
        protected $remote_class_name = 'App\Rpc\BookingRpc';
    } 
} 