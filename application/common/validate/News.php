<?php


namespace app\common\validate;


use think\Validate;

class News extends Validate
{
    protected $rule = [
      'newsTopic'=>'require',
        'newsContent'=>'require',
        'id'=>'require'
    ];
    protected $scene = [
        'add'=>['newsTopic','newsContent','id'],
        'edit'=>['newsTopic','newsContent']
    ];
}