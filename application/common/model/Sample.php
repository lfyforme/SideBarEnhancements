<?php


namespace app\common\model;


use think\Model;
use traits\model\SoftDelete;

class Sample extends Model
{

    use SoftDelete;
    protected $createTime = 'sam_addTime';
    protected $updateTime = 'sam_updateTime';
    protected $deleteTime = 'sam_deleteTime';

    public function question(){
        return $this->hasMany('question','samId','samId');
    }
    public function samSum()
    {
        return $this->hasOne('samsum', 'samId', 'samId');
    }
}
