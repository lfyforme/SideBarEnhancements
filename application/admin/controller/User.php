<?php


namespace app\admin\controller;

class User extends Base
{
    public function userList(){
        $result = model('User')->order('add_time','asc')->paginate(5);
        $this->assign('list',$result);
        return view();
    }

    public function forbid(){
        if(request()->isAjax()){
            $data = [
                'userId'=>input('post.id'),
                'status'=>input('post.status'),
            ];
            $result = model('User')->forbid($data);
            if($result == 1){
                $this->success('禁用成功');
            }else{
                $this->error($result);
            }
        }
    }

    public function enable(){
        if(request()->isAjax()){
            $data = [
                'userId'=>input('post.id'),
                'status'=>input('post.status'),
            ];
            $result = model('User')->enable($data);
            if($result == 1){
                $this->success('启用成功');
            }else{
                $this->error($result);
            }
        }
    }
}