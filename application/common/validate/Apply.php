<?php


namespace app\common\validate;


use think\Validate;

class Apply extends Validate
{
    protected $rule = [
        'surId|调查问卷'=>'require',
        'id|管理员'=>'require',
    ];

    protected $scene = [
        'refuse'=>['surId','id'],
        'agree'=>['surId','id']
    ];
}