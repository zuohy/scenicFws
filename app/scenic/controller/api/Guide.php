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

        var_dump($guideData);
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
        $vistEstimate = isset($paramObj->estimate) ? $paramObj->estimate : '';
        $statAry = array();
        if( empty($vistEstimate) ){
            foreach($this->estimateStat as $key => $value){
                $statAry[] = $key;
            }
        }else{
            //$statAry 参数支持多个，用逗号分隔
            $statAry = explode(',',$vistEstimate);
        }

        $orderData = $this->app->db->name('ScenicEstimate')
            //->field('username,level,nickname,score,headimg,contact_phone')
            ->where('guide_id','in',$nameAry)
            ->where('vist_estimate','in',$statAry)
            ->select();

        if ( $orderData ) {
            $this->success('读取数据成功！',$orderData);
        } else {
            $this->error('没有数据！');
        }
    }


}
