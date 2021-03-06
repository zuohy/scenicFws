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
 * 讲解员用户手机端
 * Class Appguide
 * @package app\scenic\controller
 */
class Appguide extends Controller
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
        $userInfo  = $this->app->session->get('user');
        $userName = $this->app->session->get('user.username');
        $userNick = $this->app->session->get('user.nickname');
        $this->assign('username',$userName);
        $this->assign('nickname',$userNick);
        $this->assign('user',$userInfo);
        //echo 'user ='. json_encode($userInfo);exit;  //预约电话：0854—2781118

        $this->template = 'index';
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
        $this->title = '评价详情';
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

        $this->title = '评分详情';
        $this->template = 'detailscode';

        $userName = $this->app->session->get('user.username');
        $userNick = $this->app->session->get('user.nickname');
        $userHeadimg = $this->app->session->get('user.headimg');
        $userDescribe = $this->app->session->get('user.describe');


        //获取讲解员二维码
        $map = ['username' => $userName, 'is_deleted' => '0'];
        //检查 讲解员
        $guideUser = $this->app->db->name('ScenicGuide')->where($map)->order('id desc')->find();
        $userCodeUrl = $guideUser['evaluate_url'];

        $this->assign('username',$userName);
        $this->assign('nickname',$userNick);
        $this->assign('headimg',$userHeadimg);
        $this->assign('describe',$userDescribe);
        $this->assign('codeurl',$userCodeUrl);
		$this->fetch();
	}
	
    /**
     * 添加系统用户
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    /*public function add()
    {
        $this->_applyFormToken();
        $this->_form($this->table, 'form');
    }*/

    /**
     * 编辑系统用户
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    /*public function edit()
    {
        $this->_applyFormToken();
        $this->_form($this->table, 'form');
    }*/

    /**
     * 修改用户密码
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    /*public function pass()
    {
        $this->_applyFormToken();
        if ($this->request->isGet()) {
            $this->verify = false;
            $this->_form($this->table, 'pass');
        } else {
            $post = $this->request->post();
            if ($post['password'] !== $post['repassword']) {
                $this->error('两次输入的密码不一致！');
            }
            if (data_save($this->table, ['id' => $post['id'], 'password' => md5($post['password'])], 'id')) {
                $this->success('密码修改成功，下次请使用新密码登录！', '');
            } else {
                $this->error('密码修改失败，请稍候再试！');
            }
        }
    }*/

    /**
     * 表单数据处理
     * @param array $data
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    /*protected function _form_filter(&$data)
    {
        if ($this->request->isPost()) {
            // 用户权限处理
            $data['authorize'] = (isset($data['authorize']) && is_array($data['authorize'])) ? join(',', $data['authorize']) : '';
            // 用户账号重复检查
            if (isset($data['id'])) unset($data['username']);
            elseif ($this->app->db->name($this->table)->where(['username' => $data['username'], 'is_deleted' => '0'])->count() > 0) {
                $this->error("账号{$data['username']}已经存在，请使用其它账号！");
            }
        } else {
            $data['authorize'] = explode(',', isset($data['authorize']) ? $data['authorize'] : '');
            $this->authorizes = $this->app->db->name('SystemAuth')->where(['status' => '1'])->order('sort desc,id desc')->select();
        }
    }*/
    /**
     * 修改用户状态
     * @auth true
     * @throws \think\db\exception\DbException
     */
    /*public function state()
    {
        if (in_array('10000', explode(',', $this->request->post('id')))) {
            $this->error('系统超级账号禁止操作！');
        }
        $this->_applyFormToken();
        $this->_save($this->table, ['status' => intval(input('status'))]);
    }*/

    /**
     * 删除系统用户
     * @auth true
     * @throws \think\db\exception\DbException
     */
    /*public function remove()
    {
        if (in_array('10000', explode(',', $this->request->post('id')))) {
            $this->error('系统超级账号禁止删除！');
        }
        $this->_applyFormToken();
        $this->_delete($this->table);
    }*/

}
