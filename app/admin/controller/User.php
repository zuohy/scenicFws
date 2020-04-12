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

namespace app\admin\controller;

use think\admin\Controller;

/**
 * 系统用户管理
 * Class User
 * @package app\admin\controller
 */
class User extends Controller
{

    /**
     * 绑定数据表
     * @var string
     */
    public $table = 'SystemUser';

    /**
     * 系统用户管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '系统用户管理';
        $query = $this->_query($this->table)->like('username,phone,mail');
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
        $query->order('sort desc,id desc')->page(true, true, false, 0, $this->template);
    }

    /**
     * 添加系统用户
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function add()
    {
        $this->_applyFormToken();
        $this->_form($this->table, 'form');
    }

    /**
     * 编辑系统用户
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function edit()
    {
        $this->_applyFormToken();
        $this->_form($this->table, 'form');
    }

    /**
     * 修改用户密码
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function pass()
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
    }

    /**
     * 表单数据处理
     * @param array $data
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _form_filter(&$data)
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
    }

    /**
     * 修改用户状态
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function state()
    {
        if (in_array('10000', explode(',', $this->request->post('id')))) {
            $this->error('系统超级账号禁止操作！');
        }
        $this->_applyFormToken();
        $this->_save($this->table, ['status' => intval(input('status'))]);
    }

    /**
     * 删除系统用户
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        if (in_array('10000', explode(',', $this->request->post('id')))) {
            $this->error('系统超级账号禁止删除！');
        }
        $this->_applyFormToken();
        $this->_delete($this->table);
    }


    /**
     * 新增讲解员基础信息
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function scenic()
    {
        $post = $this->request->post();

        //判断是否为讲解员 账号 is_scenic=1
        //用户账号为讲解员 新增讲解员数据
        $userId = isset($post['id']) ? $post['id'] : '';
        $where = ['id'=>$userId];
        $userData = $this->app->db->name($this->table)->where($where)->find();
        if( empty($userData) ){
            //不是用户账号 返回
            $this->error('用户账号不存在，请稍候再试！');
            return;
        }

        //查询讲解员信息表是否已经存在相同的username
        $userName = isset($userData['username']) ? $userData['username'] : ''; //echo ' name=' . $userName;
        $nickName = isset($userData['nickname']) ? $userData['nickname'] : '';
        $where = ['username'=>$userName];
        $guideData = $this->app->db->name('ScenicGuide')->where($where)->find(); //var_dump($guideData);
        if( !empty($guideData) ){
            //已经存在讲解员信息
            $this->error('讲解员已存在！');
            return;
        }

        //新增讲解员基础信息
        $newData = ['username' => $userName, 'nickname' => $nickName];
        $ret = $this->app->db->name('ScenicGuide')->insert($newData);

        if( $ret == '1'){
            //更新用户表状态
            $this->_save($this->table, ['is_scenic' => '1']);
        }else{
            $this->error('讲解员创建失败！');
        }

    }

    /**
     * 新增讲解员基础信息
     * @auth true
     * @throws \think\db\exception\DbException
     */
    private function createScenic($data)
    {
        //判断是否为讲解员 账号 is_scenic=1
        //用户账号为讲解员 新增讲解员数据
        $userName = isset($data['username']) ? $data['username'] : '';
        $isScenic = isset($data['is_scenic']) ? $data['is_scenic'] : '';
        if( empty($isScenic) ){
            //不是讲解员账号 返回
            return;
        }

        //查询讲解员信息表是否已经存在相同的username
        $where = ['username'=>$userName];
        $guideData = $this->app->db->name('ScenicGuide')->where($where)->find();
        if( !empty($guideData) ){
            //已经存在讲解员信息
            return;
        }

        //新增讲解员基础信息
        //['username' => $userName, 'nickname' => $userName, ]
        $this->_save('ScenicGuide', $data);
    }


}
