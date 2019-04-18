<?php


namespace app\common\model;


use think\Model;
use app\common\validate\Survey as sur;
use traits\model\SoftDelete;

class Survey extends Model
{
    use SoftDelete;
    protected $createTime = 'sur_addTime';
    protected $updateTime = 'sur_updateTime';
    protected $deleteTime = 'sur_deleteTime';

    public function question(){
        return $this->hasMany('question','surId','surId');
    }
    //重命名
    public function rename($data){
        $validate = new sur();
        if(!$validate->scene('rename')->check($data)){
            return $validate->getError();
        }
        $surInfo = $this->where('surId',$data['surId'])->find();
        $surInfo->surName = $data['surName'];
        $result = $surInfo->save();
        if($result){
            return 1;
        }else{
            return '重命名失败';
        }
    }

    public function apply($data){
        $validate = new sur();
        if(!$validate->scene('apply')->check($data)){
            return $validate->getError();
        }
        $applyInfo = \model('apply')->where('surId',$data['surId'])->find();
        if(!$applyInfo){
            $data['applyStatus'] = 0;
            $result = \model('apply')->allowField(true)->save($data);
            if($result){
                return 1;
            }else{
                return '您申请失败，请稍后再试';
            }
        }else{
            return '您已经申请，请勿重新申请';
        }


    }

    //停止发布
    public function stop($data){
        $validate = new sur();
        if(!$validate->scene('stop')->check($data)){
            return $validate->getError();
        }
        $surInfo = $this->where('surId',$data['surId'])->find();
        $surInfo->surStatus = 2;
        $result = $surInfo->save();
        if($result){
            return 1;
        }else{
            return '停止发布失败';
        }
    }

    //开始发布
    public function start($data){
        $validate = new sur();
        if(!$validate->scene('start')->check($data)){
            return $validate->getError();
        }
        $surInfo = $this->where('surId',$data['surId'])->find();
        $surInfo->surStatus = 1;
        $result = $surInfo->save();
        if($result){
            return 1;
        }else{
            return '发布失败';
        }
    }

}