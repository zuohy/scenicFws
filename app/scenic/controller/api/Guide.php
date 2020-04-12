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
        '5'     => '已过期',
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
        $paramStr = $this->request->get('param');
        $paramObj = json_decode($paramStr);

        $userName = isset($paramObj->username) ? $paramObj->username : '';

        $where = ['username'=>$userName];
        $guideData = $this->app->db->name('ScenicGuide')->where($where)->find();

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
        $paramStr = $this->request->get('param');
        $paramObj = json_decode($paramStr);

        $userName = isset($paramObj->username) ? $paramObj->username : '';

        //username 参数支持多个，用逗号分隔
        $nameAry = explode(',',$userName);

        $guideData = $this->app->db->name('ScenicGuide')
            //->field('username,level,nickname,score,headimg,contact_phone')
            ->where('username','in',$nameAry)
            ->select();

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
        $paramStr = $this->request->get('param');
        $paramObj = json_decode($paramStr);

        $userName = isset($paramObj->username) ? $paramObj->username : '';
        //username 参数支持多个，用逗号分隔
        $nameAry = explode(',',$userName);

        //预约状态 默认为空
        $orderStat = isset($paramObj->stat) ? $paramObj->stat : '';
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
        $paramStr = $this->request->get('param');
        $paramObj = json_decode($paramStr);

        $userName = isset($paramObj->username) ? $paramObj->username : '';
        //username 参数支持多个，用逗号分隔
        $nameAry = explode(',',$userName);

        //评价状态 默认为空
        $visitEstimate = isset($paramObj->estimate) ? $paramObj->estimate : '';
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



    /**
     * 游客预约讲解员 提交
     */
    public function orderSubmit()
    {
        $paramStr = $this->request->post('param');
        $paramObj = json_decode($paramStr);

        //讲解员ID 名称
        $userName = isset($paramObj->username) ? $paramObj->username : '';

        //游客id
        $visitId = isset($paramObj->visitid) ? $paramObj->visitid : '';
        if( empty($visitId) ){
            $visitId = Str::random(3); //默认ID 随机生成
        }

        //游客姓名
        $visitName = isset($paramObj->visitname) ? $paramObj->visitname : '';
        if( empty($visitName) ){
            $this->error('游客姓名为空！');
        }

        //游客人数
        $visitNum = isset($paramObj->visitnum) ? $paramObj->visitnum : '';
        if( empty($visitNum) ){
            $this->error('游客人数为空！');
        }
        //游客到馆时间
        $visitTime = isset($paramObj->visittime) ? $paramObj->visittime : '';
        if( empty($visitTime) ){
            $this->error('游客到馆时间为空！');
        }

        //游客电话
        $visitPhone = isset($paramObj->visitphone) ? $paramObj->visitphone : '';
        if( empty($visitPhone) ){
            $this->error('游客联系电话为空！');
        }


        //预约描述 备注
        $visitMark = isset($paramObj->mark) ? $paramObj->mark : '';

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
        $paramStr = $this->request->post('param');
        $paramObj = json_decode($paramStr);

        $userName = isset($paramObj->username) ? $paramObj->username : '';

        //评价状态 默认为空
        $visitEstimate = isset($paramObj->estimate) ? $paramObj->estimate : '';
        if( empty($visitEstimate) ){
            $visitEstimate = '2'; //一般
        }

        //评价描述 备注
        $visitMark = isset($paramObj->mark) ? $paramObj->mark : '';

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
