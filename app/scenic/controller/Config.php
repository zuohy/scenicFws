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
 * @package app\admin\controller
 */
class Config extends Controller
{

    /**
     * 绑定数据表
     * @var string
     */
    protected $table = 'ScenicConfig';

    /**
     * 阿里数据中心
     * @var array
     */
    protected $points = [

    ];

    /**
     * 系统参数配置
     * @auth true
     * @menu true
     */
    public function index()
    {
        $this->title = '系统参数配置';
        $this->fetch();
    }



}
