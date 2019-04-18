<?php


namespace app\common\model;


use think\Model;
use app\common\validate\Surset as sur;
class Surset extends Model
{
    public function isLogin($data){
        $validate = new sur();
        if(!$validate->scene('isLogin')->check($data)){
            return $validate->getError();
        }
        $surInfo = $this->where('surId',$data['surId'])->find();
        if($surInfo){
            $surInfo->surIsLogin = $data['surIsLogin'];
            $result = $surInfo->save();
        }else{
            $result = $this->save($data);
        }
        if($result){
            return 1;
        }else{
            return '保存失败';
        }
    }
}