<?php


namespace app\common\validate;


use think\Validate;

class Survey extends Validate
{
    protected $rule =[
        'surId' =>'require',
        'surName|问卷名'=>'require',
        'userId'=>'require'
    ];
    protected $scene = [
        'rename'=>['surId','surName'],
        'stop'=>['surId'],
        'start'=>['surId'],
        'apply'=>['surId','userId'],
    ];
}