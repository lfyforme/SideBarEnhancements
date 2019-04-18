<?php


namespace app\common\validate;


use think\Validate;

class Scale extends Validate
{
    protected $rule = [
        'scale_type'=>'require',
        'scaleRange'=>'require',
        'scaleStart'=>'require',
        'quesId'=>'require'
    ];

    protected $scene = [
        'saveScale'=>[ 'scale_type', 'scaleRange','scaleStart','quesId']
    ];

}