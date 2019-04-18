<?php


namespace app\common\validate;


use think\Validate;

class User extends Validate
{
    protected $rule = [
        'username|用户名'=>'require|unique:user',
        'password|密码'=>'require',
        'conpass|确认密码'=>'require|confirm:password',
        'nickname|昵称'=>'require',
        'email'=>'require|email|unique:user',
        'verify|验证码'=>'require|captcha',
        'status'=>'require'
    ];

    protected $scene = [
        'login'=>['username|remove:unique','password','verify'] ,
        'register'=>['username','password','verify','conpass','nickname','email'] ,
        'forget'=>['username|remove:unique','password','verify','nickname','email|remove:unique'] ,
        'forbid'=>['status'],
        'enable'=>['status'],
    ];
}