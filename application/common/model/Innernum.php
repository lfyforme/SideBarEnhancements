<?php


namespace app\common\model;


use think\Model;

class Innernum extends Model
{
    /*
   * $recSingle保存的为整个矩形单选题的数据
     * $dataInner保存为小问题的数据
     * $dataSingle保存为选项的数据
     * $dataTempInner保存为问题中的小问题数量的name数组
   * */
    public function countRecSingle($recSingle, $singleCount, $dataInner, $dataSingle, $dataTempInner){
        $single = array();
        $k = 0;
        for ($i = 0; $i < $singleCount; $i++) {
            for ($j = 0; $j < $recSingle[$dataTempInner[$i]]; $j++) {
                    $result = $this->where(['innerId' => $recSingle[$dataInner[$i][$j]], 'answerId' => $recSingle[$dataSingle[$i][$j]]])->find();
                    if ($result == null) {
                        var_dump('asa');
                        $single[$k]['innerId'] =$recSingle[$dataInner[$i][$j]];
                        $single[$k]['answerId'] =$recSingle[$dataSingle[$i][$j]];
                        $single[$k][ 'answerSum'] = 1;
                    } else {
                        $result->answerSum = $result->answerSum + 1;
                        $result = $result->save();
                        var_dump($result);
                    }
            }
        }
        $result = $this->saveAll($single);
        var_dump($result);
        return '矩形单选题人数增加成功';
    }
    /*
   * $recMul保存的为整个矩形多选题的数据
     * $dataInner保存为小问题的数据
     * $dataMul保存为选项的数据
     * $dataTempInner保存为问题中的小问题数量的name数组
     * $dataTempRecMul保存为问题的选项数量的name数组
   * */
    public function countRecMul($recMul, $mulCount, $dataInner, $dataMul, $dataTempInner,$dataTempRecMul){
        $mul = array();
        $m = 0;
        for ($i = 0; $i < $mulCount; $i++) {
            //获取每个大的问题中有几个小问题
            for ($j = 0; $j < $recMul[$dataTempInner[$i]]; $j++) {
                //获取每个小问题有有几个选项
                for($k = 0; $k < $recMul[$dataTempRecMul[$i][$j]] ;$k++){
                    //判断数组中某个下标是否存在
                    if(isset($dataMul[$i][$j][$k])){
                        $result =  $this->where('answerId',$dataMul[$i][$j][$k])->where('innerId',$recMul[$dataInner[$i][$j]])->find();
                        if ($result == null) {
                            $mul[$m]['innerId'] =$recMul[$dataInner[$i][$j]];
                            $mul[$m]['answerId'] =$dataMul[$i][$j][$k];
                            $mul[$m]['answerSum'] = 1;
                            $m = $m+1;
                        } else {
                            $result->answerSum = $result->answerSum + 1;
                            $result = $result->save();
                        }
                    }
                }
            }
        }
        $result = $this->saveAll($mul);
        return '矩形多选题人数增加成功';
    }
}