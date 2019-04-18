<?php


namespace app\common\model;


use think\Model;
use traits\model\SoftDelete;
use app\common\validate\Apply as app;
class Apply extends Model
{
    use SoftDelete;
    //关联管理员
    public function admins(){

    }
    //关联用户
    public function users(){
        return $this->belongsTo('user','userId','userId');
    }
    //关联问卷
    public function survey(){
        return $this->belongsTo('survey','surId','surId');
    }
    public function refuse($data){
        $validate = new app();
        $data['id'] = session('admin.id');
        if(!$validate->scene('refuse')->check($data)){
            return $validate->getError();
        }
        $applyInfo = $this->where('surId',$data['surId'])->find();
        $applyInfo->id= $data['id'];
        $applyInfo->applyStatus = 3;
        $result = $applyInfo->save();
        $applyInfo->delete();
        if($result){
            return 1;
        }else{
            return '取消失败，请稍后再试';
        }
    }

    public function agree($data){
        $validate = new app();
        $data['id'] = session('admin.id');
        if(!$validate->scene('agree')->check($data)){
            return $validate->getError();
        }
        $applyInfo = $this->where('surId',$data['surId'])->find();
        $applyInfo->id=$data['id'] ;
        $applyInfo->applyStatus = 1;
        $result = $applyInfo->save();
        $applyInfo->delete();
        if($result){
            $sam = \model('Sample');
            $info = \model('Survey')->where('surId',$data['surId'])->find();
            $sam->samName = $info['surName'];
            $sam->samDesc =$info['surDesc'] ;
            $sam->userId =$info['userId'];
            $sam->samType=$info['surType'];
            $res = $sam->save();
            if($res){
                return 1;
            }else{
                return '同意失败1，请稍后再试';
            }

        }else{
            $applyInfo->applyStatus = 1;
            $applyInfo->save();
            return '同意失败，请稍后再试';
        }
    }
}