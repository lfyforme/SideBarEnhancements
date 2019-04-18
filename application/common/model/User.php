<?php

namespace app\common\model;

use think\Model;
use app\common\validate\User as u;
use think\Session;
use traits\model\SoftDelete;

class User extends Model
{
    use SoftDelete;
    public function surveies(){
        return $this->hasMany('survey','surId','surId');
    }

   public function login($data){
        $validate = new u();
        if(!$validate->scene('login')->check($data)){
            return $validate->getError();
        }
//        if(data['is_rem'] != 1){
//            md5($data['password']);
//        }
        $userInfo = $this->where('username',$data['username'])->find();
        if($userInfo){
            if($userInfo['password'] == $data['password']){
                Session::set('user',$userInfo);
                return 1;
            }else{
                return '密码错误';
            }
        }else{
            return '当前用户不存在或者用户名错误';
        }
   }

   public function register($data){
       $validate = new u();
       if(!$validate->scene('register')->check($data)){
           return $validate->getError();
       }
       $result = $this->allowField(true)->save($data);
       if($result){
           return 1;
       }else{
           return "注册失败";
       }
   }

   public function forget($data){
       $validate = new u();
       if(!$validate->scene('forget')->check($data)){
           return $validate->getError();
       }
       $userInfo = $this->where(['username'=>$data['username'],'nickname'=>$data['nickname'],'email'=>$data['email']])->find();
       $userInfo['password']= $data['password'];
       $result = $userInfo->save();
       if($result){
           return 1;
       }else{
           return "输入信息错误";
       }
   }

   public function forbid($data){
        $validata = new u();
        if(!$validata->scene('forbid')->check($data)){
            return $validata->getError();
        }
        $userInfo = $this->find($data['userId']);
        $userInfo->status = 0;
        $result = $userInfo->save();
        if($result){
            return 1;
        }else{
            return '禁用失败';
        }
   }

    public function enable($data){
        $validata = new u();
        if(!$validata->scene('enable')->check($data)){
            return $validata->getError();
        }
        $userInfo = $this->find($data['userId']);
        $userInfo->status = 0;
        $result = $userInfo->save();
        if($result){
            return 1;
        }else{
            return '启用失败';
        }
    }

}
