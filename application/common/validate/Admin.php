<?php


namespace app\common\validate;


use think\Validate;

class Admin extends Validate
{
    protected $rule = [
        'username|管理员名字'=>'require',
        'password|密码'=>'require',
        'conpass' =>'require|confirm:password',
        'nickname|昵称' => 'require',
        'email'=>'email|require|unique:admin',
        'oldpass'=>'require',
        'newpass'=>'require',
        'verify|验证码'=>'require|captcha',
        'last_ip'=>'require',
        'rempsw'=>'require',
        'is_rem'=>'require'
    ];

    protected $scene = [
        'login' => ['username','password','verify','last_ip','rempsw','is_rem'],
        'register' => ['username','password','conpass','nickname','email'],
        'add'=>['username|unique:admin','password','conpass','nickname','email'],
        'edit'=>['newpass','nickname','oldpass'] ,
    ];


}