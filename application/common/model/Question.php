<?php


namespace app\common\model;


use think\Model;
use app\common\validate\Question as qu;

class Question extends Model
{
    //关联答案
    public function answer(){
        return $this->hasMany('answer','quesId','quesId');
    }
    //关联内置问题
    public function inner(){
        return $this->hasMany('inner','quesId','quesId');
    }
    //关联量表题
    public function scale(){
        return $this->hasOne('scale','quesId','quesId');
    }

    public function saveInfo($data, $quesId)
    {
        $validate = new qu();
        if (!$validate->scene('saveInfo')->check($data)) {
            return $validate->getError();
        }
        if($quesId != 0){
            $quesInfo = model('question')->find($quesId);
            $quesInfo->quesTitle = $data['quesTitle'];
            $quesInfo->quesDesc = $data['quesDesc'];
            $quesInfo->quesType = $data['quesType'];
            $quesInfo->quesReq = $data['quesReq'];
            $quesInfo->surId = $data['surId'];
            $result = $quesInfo->save();
        }else{
            $result = $this->save($data);
        }

        if ($result) {
            if($quesId == 0)
                 return $this->getLastInsID();
            else
                return $quesId;
        } else {
            return 0;
        }
    }
}