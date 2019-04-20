<?php


namespace app\index\controller;


use think\Controller;

class Answer extends Controller
{
    /*
     * 该方法通过在元素中设置不同的name来获取元素的值，
     * 每个name通过该类型题目中为第几个，通过在后台获得该类型题目有多少个来循环遍历处每个不同的name，
     * 有的input元素的值为answerId，有的input元素值计算有多少个相同类型题中小题目和选项的
     * */
    public function saveAnswer(){
        if(request()->isAjax()){
            $all = input('post.');//获取所有的post方式传递的值
            $checkbox = input('post.checkbox/a');
            //            $resultMul = model('answer')->countMul($checkbox);
            $data = array();
            for($i =1;$i <= input('post.singleCount');$i++){
                $str = "single".$i;
                $data[$i-1] = $str;
            }
            //            $resultSingle = model('answer')->countSingle($all,$data);
            $dataPull = array();
            for($i =1;$i <= input('post.pullCount');$i++){
                $str = "pull".$i;
                $dataPull[$i-1] = $str;
            }
//            $resultPull = model('answer')->countPull($all,$dataPull);
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
//            $resultRecSingle = model('Innernum')->countRecSingle($all,input('post.recSingleCount'),$dataSingleInner,$dataRecSingle,$dataTempInner);
            //获取矩形多选题内容
            $dataTempMulInner = array();
            $dataTempRecMul = array();
            $dataMulInner = array();
            $dataRecMul = array();
            //获取有多少个大的问题
            for($i = 1;$i <= input('post.recMulCount');$i++){
                $str = "tempMulInner".$i;
                $dataTempMulInner[$i-1] = $str;
            }
            /*
             *   $all[$dataTempMulInner[$i-1]]保存小问题的数量
             *  $dataMulInner保存小问题的id的name数组
             * $dataRecMul保存问题中的id的name数组
             * $dataTempRecMul保存小问题数量的name数组
             * */
            for($i = 1;$i <= input('post.recMulCount');$i++){
                for($j = 1 ;$j <= $all[$dataTempMulInner[$i-1]];$j++){
                    $str = "mulInner".$i.$j;
                    $dataMulInner[$i-1][$j-1] = $str;
                    $str = "recMul".$i.$j.'/a';
                    $dataRecMul[$i-1][$j-1] = input($str);
                    $str = 'tempRecMel'.$i.$j;
                    $dataTempRecMul[$i-1][$j-1] = $str;
                }
            }
//            $resultRecMul = model('Innernum')->countRecMul($all,input('post.recMulCount'),$dataMulInner,$dataRecMul,$dataTempMulInner,$dataTempRecMul);

//            var_dump($resultSingle);
//            var_dump($resultMul);
//            var_dump($resultPull);
//            var_dump($resultRecSingle);
//            var_dump($resultRecMul);
        }

    }
}