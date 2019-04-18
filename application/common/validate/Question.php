<?php


namespace app\common\validate;


use think\Validate;

class Question extends Validate
{
    protected $rule = [
        'quesTitle' => 'require',
        'quesDesc' => 'require',
        'quesType' => 'require',
        'quesReq' => 'require',
        'surId'=>'require'
    ];

    protected $scene = [
        'saveInfo' => ['quesTitle', 'quesType', 'quesReq','surId'],
    ];
}