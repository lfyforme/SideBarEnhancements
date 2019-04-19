<?php


namespace app\common\model;


use think\Model;
use traits\model\SoftDelete;

class Answer extends Model
{
    use SoftDelete;

    //计算选择该选项的人数
    public function countSingle($radio,$data){
        for($i = 0;$i < count($data);$i++){
            $result = $this->find($radio[$data[$i]]);
            $result->answerNum =  $result->answerNum+1 ;
            $result->save();
            var_dump($result['answerNum']);
        }
        return '成功';
    }

    public function countMul($data){
        for($i = 0;$i < count($data);$i++){
            $result = $this->find($data[$i]);
            $result->answerNum =  $result->answerNum+1 ;
            $result->save();
            var_dump($result['answerNum']);
        }
        return '多选题人数增加成功';
    }

    public function countPull($pull,$data){
       for($i = 0;$i < count($data);$i++){
            $result = $this->find($pull[$data[$i]]);
            $result->answerNum =  $result->answerNum+1 ;
            $result->save();
            var_dump($result['answerNum']);
        }
        return '下拉题人数增加成功';
    }


}