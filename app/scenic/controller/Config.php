<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\scenic\controller;

use think\admin\Controller;

/**
 * 系统参数配置
 * Class Config
 * @package app\scenic\controller
 */
class Config extends Controller
{

    /**
     * 绑定数据表
     * @var string
     */
    protected $table = 'ScenicConfig';

    /**
     * 讲解员预约状态
     * @var array
     */
    protected $orderStat = [
        '1'     => '未确认',
        '2'     => '已确认',
        '3'     => '已完成',
        '4'     => '已过期',
        '5'     => '已过期',
    ];

    /**
     * 讲解员预约状态
     * @var array
     */
    protected $orderWarn = [
        '1'     => '不提醒',
        '2'     => '临期一天提醒',
        '3'     => '过期提醒',
    ];


    /**
     * 讲解员预约状态
     * @var array
     */
    protected $estimateStat = [
        '1'     => '不满意',
        '2'     => '一般',
        '3'     => '满意',
        '4'     => '非常满意',
    ];



    /**
     * 评价系统配置
     * @auth true
     * @menu true
     */
    public function index()
    {
        $this->title = '评价系统配置';
        $this->fetch();
    }



}
