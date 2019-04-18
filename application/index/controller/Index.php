<?php

namespace app\index\controller;

use think\Controller;
//use think\Image;
use think\Request;
use think\Session;
use think\Cookie;

class Index extends Controller
{
    public function Base()
    {
        return view();
    }

    public function share()
    {
        $text = "http://www.baidu.com";
        $name = code($text);
        $this->assign('iSrc', $name);
        return view();
    }

    //问卷设置
    public function setting()
    {
        return view();
    }

    //个人信息
    public function personInfomation()
    {
        $result = model('user')->find(\session('user.userId'));
        $this->assign('userInfo',$result);
        return view();
    }

    //编辑个人信息
    public function changeInfomation()
    {
        if(\request()->isAjax()){
            $data = [
                'user_name' => input('post.username'),
                'newpass' => input('post.password'),
                'oldpass' => input('post.conpass'),
                'nickname' => input('post.nickname'),
            ];
        }
        $result = model('user')->find(\session('user.userId'));
        $this->assign('userInfo',$result);
        return view();
    }

    //注册
    public function register()
    {
        if (request()->isAjax()) {
            $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
            if (!empty($browser)) {
                if ((strpos($agent, 'windows nt'))) {
                    $equip = "pc";
                } else if ((strpos($agent, 'iphone'))) {
                    $equip = "iphone";
                } else if ((strpos($agent, 'ipad'))) {
                    $equip = "ipad";
                } else if ((strpos($agent, 'android'))) {
                    $equip = "android";
                }
            } else {
                $equip = 'unknow';
            }
            $data = [
                'user_name' => input('post.username'),
                'password' => input('post.password'),
                'conpass' => input('post.conpass'),
                'nickname' => input('post.nickname'),
                'email' => input('post.email'),
                'verify' => input('post.verify'),
                'user_equipment' => $equip,
                "add_time" => time(),
                'updata_time' => time()
            ];
            $result = model('User')->register($data);
            if ($result == 1) {
                $this->success('用户注册成功', 'index/index/login');
            } else {
                $this->error($result);
            }
        }
        return view();
    }

    //重置密码
    public function forget()
    {
        if (request()->isAjax()) {
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password'),
                'nickname' => input('post.nickname'),
                'email' => input('post.email'),
                'verify' => input('post.verify'),
                'updata_time' => time()
            ];
            $result = model('User')->forget($data);
            if ($result == 1) {
                $this->success('重置密码成功', 'index/index/login');
            } else {
                $this->error($result);
            }
        }
        return view();
    }

    //登录
    public function login()
    {
        //判断是session中是否有值
        if (Session::has('user')) {
            $this->redirect('index/index/Base');
        } else {
            if (request()->isAjax()) {
                if (input('post.rempsw') == 'on') {
                    $rempsw = 1;
                } else {
                    $rempsw = 0;
                }
                $data = [
                    'username' => input('post.username'),
                    'password' => input('post.password'),
                    'is_rem' => input('post.is_rem'),
                    'verify' => input('post.verify'),
                    'rempsw' => $rempsw,
                ];
                $result = model('User')->login($data);
                if ($result == 1) {
                    //判断用户是否记住密码
                    if ($data['rempsw'] == 1) {
                        //记住密码   存cookie中
                        \cookie('cu', trim($data['username']), 3600 * 24 * 30);
                        \cookie('CSDFDSA', trim($data['password']), 3600 * 24 * 30);
                    } else {
                        //删除cookie、
                        Cookie::delete('cu');
                        Cookie::delete("CSDFDSA");
                    }

                    $this->success('登录成功', 'index/index/Base');
                } else {
                    $this->error($result);
                }
//                $name=input("name");
//                $pwd=input("pwd");
//                $is_rem=input("is_rem");
//                if ($is_rem!=1){
//                    $pwd=pswCrypt($pwd);
//                }
//                $captcha=input("captcha");
//                $rempsw=input("rempsw");
//                //验证用户是否填写
//                if (empty($name)||empty($pwd)||empty($pwd)){
//                    $this->error('用户名或密码,验证码不可为空');
//                }
//                $userInfo=Db::name("admin")->where(array("names"=>$name))->find();
//                //验证用户是否存在
//                if(empty($userInfo)){
//                    $this->error('当前用户不存在或者用户名错误');
//                }
//                //验证密码
//                if($pwd!=$userInfo["password"]){
//                    $this->error('密码错误请从新输入');
//                }
//                //验证吗
//                if (!captcha_check($captcha)){
//                    $this->error('验证码错误');
//                }
//                //验证用户的状图
//                if ($userInfo["status"]==2){
//                    $this->error('当前用户已经被冻结，请联系管理员');
//                }

                //存sessiopn
//                Session::set('user',$name);
//                //判断用户是否记住密码
//                if ($rempsw==1){
//                    //记住密码   存cookie中
//                    \cookie('cu',trim($name),3600*24*30);
//                    \cookie('CSDFDSA',trim($pwd),3600*24*30);
//                }else{
//                    //删除cookie、
//                    Cookie::delete('cu');
//                    Cookie::delete("CSDFDSA");
//                }
                //记录时间及ip
//                Db::name('admin')->where(array('id'=>$userInfo['id']))->update(['last_login'=>date('Y-m-d H:i:s', time()), 'last_ip'=>request()->ip(),"num"=>$userInfo["num"]+1]);
            } else {
                $username = Cookie::get('cu');
                $password = Cookie::get('CSDFDSA');
                if ($username && $password) {
                    $this->assign('username', $username);
                    $this->assign('password', $password);
                } else {
                    $this->assign('username', "");
                    $this->assign('password', "");
                }
                return $this->fetch("login");
            }

        }
    }

    //退出登录
    public function loginout()
    {
        \session(null);
        if (session('?user.id')) {
            $this->error('退出失败');
        } else
            $this->success('退出成功', 'index/index/login');

    }

    function upload_img()
    {
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move('upload/');
        if ($info) {
            $path = 'upload/' . $info->getSaveName();
            $userInfo = model('user')->find(input('post.userId'));

            $userInfo->user_logo = $path;
            $result = $userInfo->allowField(true)->save();
            Session::set('user',$userInfo);
            if ($result)
                $this->success($path);
        }

    }
//    public function search(){
//        $catename = input('keyword');
//        $articles = model('Article')->where('title','like','%'.input('keyword').'%')->paginate(5);
//        $viewData = [
//            'articles'=>$articles,
//            'catename'=>$catename
//        ];
//        $this->assign($viewData);
//        return view('index');
//    }
//
//    public function comment(){
//        $data=[
//            'article_id'=>input('post.article_id'),
//            'member_id'=>input('post.member_id'),
//            'content'=>input('post.content'),
//        ];
//        $result = model('Comment')->comm($data);
//        if($result == 1){
//            $this->success('评论成功');
//        }else{
//            $this->error($result);
//        }
//    }
}
