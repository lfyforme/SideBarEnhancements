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

    public function startTime($data){
        $validate = new sur();
        if(!$validate->scene('startTime')->check($data)){
            return $validate->getError();
        }
        $surInfo = $this->where('surId',$data['surId'])->find();
        if($surInfo){
            if($data['surBeginTime'] != "1900-01-01 00:00:00" &&
                strtotime($data['surBeginTime'])<time()){
                return '开始时间不能早于现在的时间';
            }
            $surInfo->surBeginTime = $data['surBeginTime'];
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

    public function endTime($data){
        $validate = new sur();
        if(!$validate->scene('endTime')->check($data)){
            return $validate->getError();
        }
        $surInfo = $this->where('surId',$data['surId'])->find();
        if($surInfo){
            if($data['surEndTime'] != "1900-01-01 00:00:00" &&
                strtotime($data['surEndTime'])<time()){
                return '开始时间不能早于现在的时间';
            }
            if($data['surBeginTime'] != "1900-01-01 00:00:00")
                if($surInfo->surBeginTime > $data['surEndTime'] ){
                    return '结束时间不能低于开始时间';
                }
            $surInfo->surEndTime = $data['surEndTime'];
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

    public function setNum($data){
        $validate = new sur();
        if(!$validate->scene('setNum')->check($data)){
            return $validate->getError();
        }
        $surInfo = $this->where('surId',$data['surId'])->find();
        if($surInfo){
            $surInfo->surNum = $data['surNum'];
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

    public function setPer($data,$login){
        $validate = new sur();
        if(!$validate->scene('setPer')->check($data)){
            return $validate->getError();
        }
        $surInfo = $this->where('surId',$data['surId'])->find();
        if($surInfo){
            $surInfo->surPerNum = $data['surPerNum'];
            if( $login == 1){
                $surInfo->surIsLogin = $data['surIsLogin'];
            }
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