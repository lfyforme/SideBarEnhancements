<?php


namespace app\index\controller;


use think\Controller;

class Feedback extends Controller
{
    //反馈信息
    public function feedback()
    {
        if(request()->isAjax()){
            $data = [
                'fBTopic'=>input('post.fBTopic'),
                'fBContent'=>input('post.fBContent'),
                'userId'=>session('user.userId')
            ];
            $result = model('Feedback')->add($data);
            if($result == 1){
                $this->success('反馈成功');
            }else{
                $this->error($result);
            }
        }else
            return view();
    }

    public function feedList(){
        $result = model('Feedback')->order('fB_addTime')->paginate(5);
        $feedData = [
            'list'=>$result
        ];
        $this->assign($feedData);
        return view();
    }

    public function feedEdit(){
        if(request()->isAjax()){
            $data = [
                'fBTopic'=>input('post.fBTopic'),
                'fBContent'=>input('post.fBContent'),
                'userId'=>session('user.userId'),
                'fBId'=>input('fBId')
            ];
            $result = model('Feedback')->edit($data);
            if($result == 1){
                $this->success('修改成功');
            }else{
                $this->error($result);
            }
        }
        $result = model('feedback')->find(input('fBId'));
        $this->assign('feedInfo',$result);
        return view();
    }

    public function feedDel(){
        $feedInfo = model('feedback')->find(input('post.id'));
        $result = $feedInfo->delete();
        dump('sda');
        if($result){
            $this->success('删除成功','index/feedback/feedList');
        }else{
            $this->error('删除失败');
        }
    }
}