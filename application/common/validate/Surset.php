<?php


namespace app\common\validate;


use think\Validate;

class Surset extends Validate
{
    protected $rule = [
        'surId' => 'require',
        'surIsLogin' => 'require',
        'surBeginTime'=>'require',
        'surEndTime'=>'require'
        ,'surNum'=>'require|number'
        ,'surPerNum'=>'require|number'
    ];

    protected $scene = [
        'isLogin'=>['surId','surIsLogin'],
        'startTime'=>['surId','surBeginTime'],
         'endTime'=>['surId','surEndTime'],
        'setNum'=>['surId','surNum'],
        'setPer'=>['surId','surPerNum']
    ];
}