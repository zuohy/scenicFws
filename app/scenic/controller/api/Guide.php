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

namespace app\scenic\controller\api;

use think\admin\Controller;
use app\scenic\controller\Config;
use think\helper\Str;
/**
 * 讲解员数据接口
 * Class ApiGuide
 * @package app\admin\controller\api
 */
class Guide extends Controller
{
    /**
     * 讲解员预约状态
     * @var array
     */
    private $orderStat = [
        '1'     => '未确认',
        '2'     => '已确认',
        '3'     => '已完成',
        '4'     => '已过期',
        '5'     => '已取消',
    ];

    /**
     * 讲解员预约状态
     * @var array
     */
    private $estimateStat = [
        '1'     => '不满意',
        '2'     => '一般',
        '3'     => '满意',
        '4'     => '非常满意',
    ];

    /**
     * 获取讲解员信息
     */
    public function get()
    {
        $paramAry = $this->request->get();
        $userName = isset($paramAry['username']) ? $paramAry['username'] : '';

        $where = ['username'=>$userName];
        $where1 = ['is_deleted' => '0', 'status' => '1'];
        $guideData = $this->app->db->name('ScenicGuide')
            ->where($where)
            ->where($where1)
            ->find();

        if ($guideData) {
            $this->success('读取数据成功！',$guideData);
        } else {
            $this->error('没有数据！');
        }
    }

    /**
     * 获取讲解员列表信息
     */
    public function lists()
    {
        $paramAry = $this->request->get();
        $userName = isset($paramAry['username']) ? $paramAry['username'] : '';

        //username 参数支持多个，用逗号分隔
        $nameAry = explode(',',$userName);

        if( $userName == '' ){
            //获取全部数据
            $guideData = $this->app->db->name('ScenicGuide')
                //->field('username,level,nickname,score,headimg,contact_phone')
                ->where(['is_deleted' => '0', 'status' => '1'])
                //->page(true, true, false, 0);
                ->order('sort desc,id desc')
                ->select();
        }else{
            $guideData = $this->app->db->name('ScenicGuide')
                //->field('username,level,nickname,score,headimg,contact_phone')
                ->where('username','in',$nameAry)
                ->where(['is_deleted' => '0', 'status' => '1'])
                //->page(true, true, false, 0);
                ->order('sort desc,id desc')
                ->select();
        }


        if ( !empty($guideData) ) {
            $this->success('读取数据成功！',$guideData);
        } else {
            $this->error('没有数据！');
        }
    }



    /**
     * 获取讲解员预约列表信息
     */
    public function order()
    {
        $paramAry = $this->request->get();
        $userName = isset($paramAry['username']) ? $paramAry['username'] : '';
        //username 参数支持多个，用逗号分隔
        $nameAry = explode(',',$userName);

        //预约状态 默认为空
        $orderStat = isset($paramAry['stat']) ? $paramAry['stat'] : '';
        $statAry = array();
        if( empty($orderStat) ){
            foreach($this->orderStat as $key => $value){
                $statAry[] = $key;
            }
        }else{
            //$statAry 参数支持多个，用逗号分隔
            $statAry = explode(',',$orderStat);
        }

        $orderData = $this->app->db->name('ScenicOrder')
            //->field('username,level,nickname,score,headimg,contact_phone')
            ->where('guide_id','in',$nameAry)
            ->where('order_stat','in',$statAry)
            ->select();

        if ( $orderData ) {
            $this->success('读取数据成功！',$orderData);
        } else {
            $this->error('没有数据！');
        }
    }


    /**
     * 获取讲解员评价列表信息
     */
    public function estimate()
    {
        $paramAry = $this->request->get();
        $userName = isset($paramAry['username']) ? $paramAry['username'] : '';
        //username 参数支持多个，用逗号分隔
        $nameAry = explode(',',$userName);

        //评价状态 默认为空
        $visitEstimate = isset($paramAry['estimate']) ? $paramAry['estimate'] : '';
        $statAry = array();
        if( empty($visitEstimate) ){
            foreach($this->estimateStat as $key => $value){
                $statAry[] = $key;
            }
        }else{
            //$statAry 参数支持多个，用逗号分隔
            $statAry = explode(',',$visitEstimate);
        }

        $orderData = $this->app->db->name('ScenicEstimate')
            //->field('username,level,nickname,score,headimg,contact_phone')
            ->where('guide_id','in',$nameAry)
            ->where('visit_estimate','in',$statAry)
            ->select();

        if ( $orderData ) {
            $this->success('读取数据成功！',$orderData);
        } else {
            $this->error('没有数据！');
        }
    }


    ////////////////////////分析函数 开始///////////////////////////////////////
    /**
     * 获取预约状态分析统计
     */
    public function alysOrder()
    {
        $paramAry = $this->request->get();
        $userName = isset($paramAry['username']) ? $paramAry['username'] : '';
        //username 参数支持多个，用逗号分隔
        $nameAry = explode(',',$userName);

        //分析时间， 为空没有时间限制
        $alysTime = isset($paramAry['alystime']) ? $paramAry['alystime'] : '';
        if( $alysTime == '' ){
            //查询所有时间
            $alysTime = time();
        }

        //SELECT order_stat, COUNT(order_stat) from scenic_order where guide_id in ('xiaoming', 'xiaozuo') and create_at <= '2020-04-30 23:59:59' GROUP BY order_stat
        //预约状态统计
        $this->total = [
            'run' => 0, //未确认 已确认 (未完成)
            'run_ok' => 0, //已确认 (未完成)
            'yes' => 0, //已完成
            'out' => 0, //已过期
            'cos' => 0  //已取消
        ];

        if($userName == ''){
            //查询 所有讲解员的 预约状态分析
            $orderData = $this->app->db->name('ScenicOrder')
                ->field('order_stat,COUNT(order_stat) as count')
                ->where('create_at','<=',$alysTime)
                ->group('order_stat')
                ->select()
                ->each(function ($item) {
                    if ($item['order_stat'] === 1) $this->total['run'] = $item['count'];
                    if ($item['order_stat'] === 2) $this->total['run_ok'] = $item['count'];
                    if ($item['order_stat'] === 3) $this->total['yes'] = $item['count'];
                    if ($item['order_stat'] === 4) $this->total['out'] = $item['count'];
                    if ($item['order_stat'] === 4) $this->total['cos'] = $item['count'];
                });
        }else{
            //查询 指定讲解员的 预约状态分析
            $orderData = $this->app->db->name('ScenicOrder')
                ->field('order_stat,COUNT(order_stat) as count')
                ->where('guide_id','in',$nameAry)
                ->where('create_at','<=',$alysTime)
                ->group('order_stat')
                ->select()
                ->each(function ($item) {
                    if ($item['order_stat'] === 1) $this->total['run'] = $item['count'];
                    if ($item['order_stat'] === 2) $this->total['run_ok'] = $item['count'];
                    if ($item['order_stat'] === 3) $this->total['yes'] = $item['count'];
                    if ($item['order_stat'] === 4) $this->total['out'] = $item['count'];
                    if ($item['order_stat'] === 4) $this->total['cos'] = $item['count'];
                });
        } //if($userName == ''){
        $this->total['run'] = $this->total['run'] + $this->total['run_ok'];
        unset($this->total['run_ok']);  //合并未确认和已确认的数据，去除run_ok 已确认值

        if ( $this->total ) {
            $this->success('读取数据成功！',$this->total);
        } else {
            $this->error('没有数据！');
        }
    }


    /**
     * 获取评价分析统计
     */
    public function alysEstimate()
    {
        $paramAry = $this->request->get();
        $userName = isset($paramAry['username']) ? $paramAry['username'] : '';
        //username 参数支持多个，用逗号分隔
        $nameAry = explode(',',$userName);

        //分析时间， 为空没有时间限制
        $alysTime = isset($paramAry['alystime']) ? $paramAry['alystime'] : '';
        if( $alysTime == '' ){
            //查询所有时间
            $alysTime = time();
        }

        //SELECT visit_estimate, COUNT(visit_estimate) as count from Scenic_estimate where guide_id in ('xiaoming', 'xiaozuo') and create_at <= '2020-04-30 23:59:59' GROUP BY visit_estimate

        //评价状态统计
        $this->total = [
            'unk' => 0, //不满意
            'nol' => 0, //一般
            'oka' => 0, //满意
            'okb' => 0  //非常满意
        ];

        if($userName == ''){
            //查询 所有讲解员的 评价状态分析
            $orderData = $this->app->db->name('ScenicEstimate')
                ->field('visit_estimate,COUNT(visit_estimate) as count')
                ->where('create_at','<=',$alysTime)
                ->group('visit_estimate')
                ->select()
                ->each(function ($item) {
                    if ($item['visit_estimate'] === 1) $this->total['unk'] = $item['count'];
                    if ($item['visit_estimate'] === 2) $this->total['nol'] = $item['count'];
                    if ($item['visit_estimate'] === 3) $this->total['oka'] = $item['count'];
                    if ($item['visit_estimate'] === 4) $this->total['okb'] = $item['count'];
                });
        }else{
            //查询 指定讲解员的 评价状态分析
            $orderData = $this->app->db->name('ScenicEstimate')
                ->field('visit_estimate,COUNT(visit_estimate) as count')
                ->where('guide_id','in',$nameAry)
                ->where('create_at','<=',$alysTime)
                ->group('visit_estimate')
                ->select()
                ->each(function ($item) {
                    if ($item['visit_estimate'] === 1) $this->total['unk'] = $item['count'];
                    if ($item['visit_estimate'] === 2) $this->total['nol'] = $item['count'];
                    if ($item['visit_estimate'] === 3) $this->total['oka'] = $item['count'];
                    if ($item['visit_estimate'] === 4) $this->total['okb'] = $item['count'];
                });
        } //if($userName == ''){

        if ( $this->total ) {
            $this->success('读取数据成功！',$this->total);
        } else {
            $this->error('没有数据！');
        }
    }
    /////////////////////////分析函数 结束////////////////////////////////


    /**
     * 游客预约讲解员 提交
     */
    public function orderSubmit()
    {
        $paramAry = $this->request->post();
        //讲解员ID 名称
        $userName = isset($paramAry['username']) ? $paramAry['username'] : '';

        //游客id
        $visitId = isset($paramAry['visitid']) ? $paramAry['visitid'] : '';
        if( empty($visitId) ){
            $visitId = Str::random(3); //默认ID 随机生成
        }

        //游客姓名
        $visitName = isset($paramAry['visitname']) ? $paramAry['visitname'] : '';
        if( empty($visitName) ){
            $this->error('游客姓名为空！');
        }

        //游客人数
        $visitNum = isset($paramAry['visitnum']) ? $paramAry['visitnum'] : '';
        if( empty($visitNum) ){
            $this->error('游客人数为空！');
        }
        //游客到馆时间
        $visitTime = isset($paramAry['visittime']) ? $paramAry['visittime'] : '';
        if( empty($visitTime) ){
            $this->error('游客到馆时间为空！');
        }

        //游客电话
        $visitPhone = isset($paramAry['visitphone']) ? $paramAry['visitphone'] : '';
        if( empty($visitPhone) ){
            $this->error('游客联系电话为空！');
        }


        //预约描述 备注
        $visitMark = isset($paramAry['mark']) ? $paramAry['mark'] : '';

        $newData = ['guide_id' => $userName,
            'visit_id' => $visitId,
            'visit_name' => $visitName,
            'visit_t' => $visitTime,
            'visit_phone' => $visitPhone,
            'visit_num' => $visitNum,
            'mark' => $visitMark];
        $ret = $this->app->db->name('ScenicOrder')
            ->insert($newData);

        if ( $ret ) {
            $this->success('提交数据成功！',$ret);
        } else {
            $this->error('提交数据失败！');
        }
    }


    /**
     * 游客评价讲解员 提交
     */
    public function visitSubmit()
    {
        $paramAry = $this->request->post();
        //讲解员ID 名称
        $userName = isset($paramAry['username']) ? $paramAry['username'] : '';

        //评价状态 默认为空
        $visitEstimate = isset($paramAry['estimate']) ? $paramAry['estimate'] : '';
        if( empty($visitEstimate) ){
            $visitEstimate = '2'; //一般
        }

        //评价描述 备注
        $visitMark = isset($paramAry['mark']) ? $paramAry['mark'] : '';

        $newData = ['guide_id' => $userName,
            'visit_id' => '11',
            'visit_name' => '匿名',
            'visit_estimate' => $visitEstimate,
            'mark' => $visitMark];
        $ret = $this->app->db->name('ScenicEstimate')
            ->insert($newData);

        if ( $ret ) {
            $this->success('提交数据成功！',$ret);
        } else {
            $this->error('提交数据失败！');
        }
    }


}
