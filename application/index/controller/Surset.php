<?php


namespace app\index\controller;


use think\Controller;

class Surset extends Controller
{
    public function set(){
        $surId = input('surId');
        $data = model('surset')->find($surId);
        $this->assign('data',$data);
        return view();
    }

    //设置开始答题时间
    public function startTime(){
        if(request()->isAjax()){
            $data = [
                'surBeginTime'=>input('post.time'),
                'surId'=>input('post.surId'),
            ];
            $result = model('surset')->startTime($data);
            if($result == 1){
                $this->success('保存完成');
            }else{
                $this->error($result);
            }
        }
    }

    //设置结束答题时间
    public function endTime(){
        if(request()->isAjax()){
            $data = [
                'surEndTime'=>input('post.time'),
                'surId'=>input('post.surId'),
            ];
            $result = model('surset')->endTime($data);
            if($result == 1){
                $this->success('保存完成');
            }else{
                $this->error($result);
            }
        }
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

    //设置回答问卷人数
    public function setNum(){
        if(request()->isAjax()){
            $data = [
                'surNum' => input('post.surNum'),
                'surId'=>input('post.surId')
            ];
            $result = model('surset')->setNum($data);
            if($result == 1){
                $this->success('保存完成');
            }else{
                $this->error($result);
            }
        }
    }

    public function setPer(){
        if(request()->isAjax()){
            $login = input('post.surIsLogin');
            $data = [
                'surPerNum' => input('post.surPerNum'),
                'surId'=>input('post.surId')
            ];
            if($login == 1){
                $data['surIsLogin'] = $login;
            }
            $result = model('surset')->setPer($data,$login);
            if($result == 1){
                $this->success('保存完成');
            }else{
                $this->error($result);
            }
        }
    }

}