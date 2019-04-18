<?php


namespace app\admin\controller;


class Feedback extends Base
{
    public function feedList(){
        $feedInfo = model('Feedback')->with('user')->order('fB_addTime','asc')->paginate(5);
        $result = ['feedInfo'=>$feedInfo];
        $this->assign($result);
        return view();
    }
    public function feedInfo(){
        $feedInfo = model('Feedback')->find(input('fBId'));
        $result = ['feedInfo'=>$feedInfo];
        $this->assign($result);
        return view();
    }
    public function feedAdd(){

    }

    public function feedEdit(){

    }

    public function feedDelete(){

    }
}