<?php

namespace app\admin\controller;

use think\Controller;

class Admin extends Base
{
    //
    public function adminlist(){
        $adminInfo = model('Admin')->order(['is_super'=>'desc','status'=>'desc'])->paginate(1);

        $this->assign('list',$adminInfo);
        return view();
    }

    public function adminadd(){
        if(request()->isAjax()){
            $data = [
                'username' => input('post.username'),
                'password' =>input('post.password'),
                'conpass' =>input('post.conpass'),
                'nickname' =>input('post.nickname'),
                'email' => input('post.email'),
            ];
            $result = model('Admin')->add($data);
            if($result == 1){
                $this->success('管理员添加成功','admin/admin/adminlist');
            }else{
                $this->error($result);
            }
        }
        return view();
    }

    public function status(){
        $data = [
            'id' => input('post.id'),
            'status' => input('post.status')? 0:1
        ];
        $adminInfo = model('Admin')->find($data['id']);
        $adminInfo->status = $data['status'];
        $result = $adminInfo->save();
        if($result){
            $this->success('管理员状态修改成功','admin/admin/adminlist');
        }else{
            $this->error('操作失败');
        }
    }

    public function  adminedit(){
        if(request()->isAjax()){
            $data = [
                'id' =>input('post.id'),
                'oldpass' =>input('post.oldpass'),
                'newpass' =>input('post.newpass'),
                'nickname' =>input('post.nickname'),
            ];
            $result = model('Admin')->edit($data);
            if($result == 1){
                $this->success('管理员修改成功','admin/admin/adminlist');
            }else{
                $this->error($result);
            }
        }
        $adminInfo = model('Admin')->find(input('id'));
        $this->assign('adminInfo',$adminInfo);
        return view();
    }

    public function admindelete(){
        $adminInfo = model('Admin')->find(input('post.id'));
        $result = $adminInfo->delete();
        if($result){
            $this->success('删除成功','admin/admin/adminlist');
        }else{
            $this->error('删除失败');
        }
    }
}
