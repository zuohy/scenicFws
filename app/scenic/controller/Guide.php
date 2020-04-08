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
 * 讲解员用户管理
 * Class Guide
 * @package app\scenic\controller
 */
class Guide extends Controller
{

    /**
     * 绑定数据表
     * @var string
     */
    public $table = 'ScenicGuide';

    /**
     * 讲解员用户管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '讲解员管理';
        $query = $this->_query($this->table)->like('guide_name,phone,mail');
        $query->equal('status');
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
     * 添加讲解员用户 在系统用户界面同步信息 添加
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
    public function edit()
    {
        $this->_applyFormToken();
        $this->_form($this->table, 'form');
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

            // 用户账号重复检查
            if (isset($data['id'])) {
                unset($data['username']);
            }
            elseif ($this->app->db->name($this->table)->where(['username' => $data['username'], 'is_deleted' => '0'])->count() > 0) {
                $this->error("账号{$data['username']}已经存在，请使用其它账号！");
            }
        } else {

        }
    }

    /**
     * 修改讲解员状态
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function state()
    {

        $this->_applyFormToken();
        $this->_save($this->table, ['status' => intval(input('status'))]);
    }

    /**
     * 删除讲解员用户
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        $this->_applyFormToken();
        $this->_delete($this->table);
    }

}
