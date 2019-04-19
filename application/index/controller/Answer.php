<?php


namespace app\index\controller;


use think\Controller;

class Answer extends Controller
{
    public function saveAnswer(){
        if(request()->isAjax()){
            $all = input('post.');//获取所有的post方式传递的值
            $checkbox = input('post.checkbox/a');
            $a = input('post.tempMulInner3');

            var_dump($all['tempMulInner3']);
            $data = array();
            for($i =1;$i <= input('post.singleCount');$i++){
                $str = "single".$i;
                $data[$i-1] = $str;
            }
            $dataPull = array();
            for($i =1;$i <= input('post.pullCount');$i++){
                $str = "pull".$i;
                $dataPull[$i-1] = $str;
            }

            //获取矩形单选题内容
            $dataTempInner = array();
            $dataSingleInner = array();
            $dataRecSingle = array();
            for($i = 1;$i <= input('post.recSingleCount');$i++){
                $str = "tempInner".$i;
                $dataTempInner[$i-1] = $str;
            }
            for($i = 1;$i <= input('post.recSingleCount');$i++){
                for($j = 1 ;$j <= $all[$dataTempInner[$i-1]];$j++){
                    $str = "singleInner".$i.$j;
                    $dataSingleInner[$i-1][$j-1] = $str;
                    $str = "recSingle".$i.$j;
                    $dataRecSingle[$i-1][$j-1] = $str;
                }
            }

            //获取矩形多选题内容
            $dataTempMulInner = array();
            $dataMulInner = array();
            $dataRecMul = array();
            for($i = 1;$i <= input('post.recMulCount');$i++){
                $str = "tempMulInner".$i;
                $dataTempMulInner[$i-1] = $str;
                var_dump( $dataTempMulInner[$i-1]);
                var_dump( $all[$dataTempInner[$i-1]]);

            }
//            var_dump($dataTempMulInner);
//            var_dump( $all[$dataTempInner[1]]);
            for($i = 1;$i <= input('post.recMulCount');$i++){
                for($j = 1 ;$j <= $all[$dataTempInner[$i-1]];$j++){
                    $str = "mulInner".$i.$j;
                    $dataMulInner[$i-1][$j-1] = $str;
                    $str = "recMul".$i.$j.'/a';
                    $dataRecMul[$i-1][$j-1] = input($str);
//                    var_dump( $dataRecMul[$i-1]);
                }
            }
//            var_dump($dataMulInner);
            var_dump($dataRecMul);
            $resultRecMul = model('Innernum')->countRecMul($all,input('post.recMulCount'),$dataMulInner,$dataRecMul,$dataTempInner);

//            var_dump($all[$dataRecSingle[1]]);
//            $resultSingle = model('answer')->countSingle($all,$data);
//            $resultMul = model('answer')->countMul($checkbox);
//            $resultPull = model('answer')->countPull($all,$dataPull);
//            $resultRecSingle = model('Innernum')->countRecSingle($all,input('post.recSingleCount'),$dataSingleInner,$dataRecSingle,$dataTempInner);
//            var_dump($resultSingle);
//            var_dump($resultMul);
//            var_dump($resultPull);
//            var_dump($resultRecSingle);
            var_dump($resultRecMul);
        }

    }
}