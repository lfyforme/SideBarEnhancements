<?php


namespace app\common\model;


use think\Model;
use app\common\validate\Scale as sc;
class Scale extends Model
{
    public function saveSacle($data,$scaleId){
        $validate = new sc($data);
        if(!$validate->scene('saveScle')->check($data)){
            return $validate->getError();
        }
        if($scaleId != '0'){
            $scaleInfo = \model('scale')->where('scaleId',$scaleId)->find();
            $scaleInfo->scale_type=$data['scale_type'];
            $scaleInfo->scaleRange=$data['scaleRange'];
            $scaleInfo->scaleStart=$data['scaleStart'];
            $scaleInfo->quesId=$data['quesId'];
            $result = $scaleInfo->save();
        }else{
            $result = $this->save($data);
        }
        if($result ){
            return "成功";
        }else{
            return '失败';
        }

    }
}