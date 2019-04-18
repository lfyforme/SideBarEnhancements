<?php


namespace app\index\controller;


use think\Controller;

class Surset extends Controller
{
    public function set(){
        $surId = input('surId');
        $this->assign('surId',$surId);
        return view();
    }

    //设置开始答题时间
    public function startTime(){

    }

    //设置结束答题时间
    public function endTime(){

    }

    //设置是否需要登录
    public function setLogin(){
        if(request()->isAjax()){
            $data = [
                'surIsLogin'=>input('post.login'),
                'surId'=>input('post.surId'),
            ];
            $result = model('surset')->isLogin($data);
            if($result == 1){
                $this->success('保存完成');
            }else{
                $this->error($result);
            }
        }
    }

}