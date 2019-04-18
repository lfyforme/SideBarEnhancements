<?php

namespace app\admin\controller;

use think\Cookie;

class Index extends Base
{
//    //重复登录
//    public function _initialize()
//    {
//        //检验数据是否存在
//
//        if(session('?admin.id')){
//            $this->redirect('admin/home/index');
//        }
//    }
    /**
     * 后台登录
     *
     * @return \think\Response
     */
    public function login()
    {
        if(request()->isAjax()) {
            $rempsw = input('post.rempsw');
            if($rempsw == 'on'){
                $rempsw = 1;
            }else{
                $rempsw = 0;
            }
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password'),
                'verify' =>input('post.verify'),
                'is_rem' => input('post.is_rem'),
                'last_ip'=>request()->ip(),
                'rempsw'=>$rempsw
            ];
            $result = model('Admin')->login($data);
            if ($result==1) {
                if($data['rempsw'] == 1){
                    \cookie('adminName',trim($data['username']),3600*24*30);
                    \cookie('adminPass',trim($data['password']),3600*24*30);
                }else{
                    //删除cookie、
                    Cookie::delete('adminName');
                    Cookie::delete("adminPass");
                }
                $this->success('登录成功', 'admin/home/index');
            } else{
                $this->error($result);
            }
        }else {
            $username = Cookie::get('adminName');
            $password = Cookie::get('adminPass');
            if($username && $password) {
                $this->assign('username',$username);
                $this->assign('password',$password);
            }else{
                $this->assign('username',"");
                $this->assign('password',"");
            }
            return $this->fetch("login");
        }
        return view();
    }

    public function register(){
        if(request()->isAjax()){
            $data = [
                'username' => input('post.username'),
                'password' =>input('post.password'),
                'conpass' =>input('post.conpass'),
                'nickname' =>input('post.nickname'),
                'email' => input('post.email'),
            ];
            $result = model('Admin1')->register($data);
            if($result == 1){
                $this->success('注册成功','admin/index/login');
            }else{
                $this->error($result);
            }
        }
        return view();
    }

    public function forget(){
        if(request()->isAjax()){
            $memberInfo = model('Admin1')->where(input('post.email'));
            $code = mt_rand(1000,9999);
            session('code',$code);
            mailto(input('post.email'),'重置密码验证','你的验证码是'+$code);
        }
        return view();
    }

}
