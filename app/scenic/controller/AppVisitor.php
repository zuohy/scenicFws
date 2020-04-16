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
 * 游客手机端
 * Class Appguide
 * @package app\scenic\controller
 */
class Appvisitor extends Controller
{

    /**
     * 绑定数据表
     * @var string
     */
    public $table = 'ScenicGuide';

    /**
     * 讲解员用户主页
     * @auth false
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '讲解员用户管理';
        /*$query = $this->_query($this->table)->like('guide_name,phone,mail');
        $query->equal('status')->dateBetween('login_at,create_at');
        // 加载对应数据列表
        $this->template = $this->request->get('type', 'index');
        if ($this->template === 'index') {
            $query->where(['is_deleted' => '0', 'status' => '1']);
        } elseif ($this->template === 'recycle') {
            $query->where(['is_deleted' => '0', 'status' => '0']);
        } else {
            $this->error("无法加载{$this->template}数据列表！");
        }
        // 列表排序并显示
        $query->order('sort desc,id desc')->page(true, true, false, 0, $this->template);*/

        $userName = $this->app->session->get('user.username');
        $this->assign('username',$userName);
        //echo 'username='.$userName;
        $this->template = 'index';
        $this->fetch();
    }


    /*
     *讲解员列表
     */
    public function guidelist()
    {
        $this->title = '讲解员列表';
        $this->template = 'guidelist';
        $this->fetch();
    }

    public function order()
    {
        $this->title = '预约讲解员';
        $this->template = 'order';

        $this->fetch();
    }

    public function evaluate()
    {
        $paramAry = $this->request->get();
        $userName = isset($paramAry['username']) ? $paramAry['username'] : '';
        $this->title = '评价讲解员';
        $this->template = 'evaluate';
        $this->assign('username',$userName);
        $this->fetch();
    }

    /**
     * 讲解员预约提醒
     * @auth false
     * @login false
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function reminder()
    {
        $userName = $this->app->session->get('user.username');
        //exit($userName);
        $this->title = '预约提醒';
        $this->template = 'reminder';
        $this->assign('username',$userName);
        $this->fetch();
    }

    /**
     * 讲解员预约详情
     * @auth false
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function details()
    {
        $userName = $this->app->session->get('user.username');
        $this->title = '预约详情';
        $this->template = 'details';
        $this->assign('username',$userName);
        $this->fetch();
    }

    /**
     * 评分详情
     * @auth false
     * @login false
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function detailscode(){
        $userName = $this->app->session->get('user.username');
        $this->title = '评分详情';
        $this->template = 'detailscode';
        $this->assign('username',$userName);
        $this->fetch();
    }


}
