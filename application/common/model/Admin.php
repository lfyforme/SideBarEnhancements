<?php

namespace app\common\model;

use think\Model;
use traits\model\SoftDelete;

class admin extends Model
{
    //
    use SoftDelete;

    protected $readonly = ['email'];

    //登录校验
    public function login($data){
        $validate = new \app\common\validate\Admin();

        if (!$validate->scene('login')->check($data)) {
            return $validate->getError();
        }
        $result = $this->where('username',$data['username'])->find();
        if ($result) {
            //1表示有这个用户
            if ($result['status'] == 0) {
                return '此账户被禁用';
            }
            session('admin',$result->toArray());
            $result->last_ip = $data['last_ip'];
            $result->last_time = time();
            $info = $result->save();
            return 1;
        } else {
            return "用户名或密码错误";
        }
    }

    public function register($data){
        $validate = new \app\common\validate\Admin();
        if (!$validate->scene('register')->check($data)) {
            return $validate->getError();
        }

        $result = $this->allowField(true)->save($data);

        if ($result) {
            return 1;
        } else {
            return "注册失败";
        }
    }

    public function add($data){
        $validate = new \app\common\validate\Admin();
        if(!$validate->scene('add')->check($data)){
            return $validate->getError();
        }
        $result = $this->allowField(true)->save($data);
        if($result){
            return 1;
        }else{
            return '添加管理员失败';
        }
    }

    public function edit($data){
        $validate = new \app\common\validate\Admin();
        if(!$validate->scene('edit')->check($data)){
            return $validate->getError();
        }
        $adminInfo = $this->find($data['id']);
        if($adminInfo->password != $data['oldpass'])
            return '原密码不正确';
        $adminInfo->password = $data['newpass'];
        $adminInfo->nickname = $data['nickname'];
        $result = $adminInfo->save();
        if($result){
            return 1;
        }else{
            return '添加管理员失败';
        }
    }
}
