<?php


namespace app\common\model;


use think\Model;

class Innernum extends Model
{
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
    public function countRecMul($recMul, $mulCount, $dataInner, $dataMul, $dataTempInner){
        $mul = array();
        $k = 0;
        for ($i = 0; $i < $mulCount; $i++) {
            $data  = $dataMul[$i];
//            var_dump($data);
            for ($j = 0; $j < $recMul[$dataTempInner[$i]]; $j++) {
//                var_dump($recMul[$dataInner[$i][$j]]);
//                $result = $this->where('innerId',$recMul[$dataInner[$i][$j]])->select();
                $str = $dataMul[$i][$j];
                $result =  $this->where('answerId',$data[$i][$j])->where('innerId',$recMul[$dataInner[$i][$j]])->find();
//               var_dump($j);
//                var_dump($data[$i][$j]);
                var_dump('kkkk');

                if ($result == null) {
                    var_dump('asa');
                    $mul[$k]['innerId'] =$recMul[$dataInner[$i][$j]];
                    $mul[$k]['answerId'] =$data[$i][$j];
                    $mul[$k]['answerSum'] = 1;
                } else {
//                    var_dump($result);
//                    $result = $result->toArray();
                    $result->answerSum = $result->answerSum + 1;
                    $result = $result->save();
//                    var_dump($result);
                }
                $result = $this->saveAll($mul);
//                var_dump($result);
            }
        }

        return '矩形单选题人数增加成功';
    }
}