<?php


namespace app\common\validate;


use think\Validate;

class Feedback extends Validate
{
    protected $rule = [
      'userId'=>'require',
      'fBTopic'=>'require',
      'fBContent'=>'require'
    ];

    protected $scene = [
        'add'=>['userId','fBTopic','fBContent'],
        'edit'=>['userId','fBTopic','fBContent']
    ];
}