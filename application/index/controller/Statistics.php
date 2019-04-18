<?php


namespace app\index\controller;

use think\Controller;

class Statistics extends Controller
{

    public function dataView(){
        $ip = '223.104.10.137';
        $url='http://ip.360.cn/IPQuery/ipquery?ip='.$ip;
        $result = file_get_contents($url);  //打开文件，向其他地址请求
        $result = json_decode($result,true);
        $sur = model('survey')->where('surId',input('surId'))->find();
        $this->assign('ip',$result);
//        $this->assign('sur',$sur);
        return view();
    }

    public function dataChart(){
        return view();
    }

    public function dataRecycle(){
        return view();
    }

    public function dataCa(){
        return view();
    }
}