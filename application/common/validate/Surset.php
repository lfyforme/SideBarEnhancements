<?php


namespace app\common\validate;


use think\Validate;

class Surset extends Validate
{
    protected $rule = [
        'surId' => 'require',
        'surIsLogin' => 'require'
    ];

    protected $scene = [
        'isLogin'=>['surId','surIsLogin']
    ];
}