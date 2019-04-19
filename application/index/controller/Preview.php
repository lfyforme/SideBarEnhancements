<?php


namespace app\index\controller;


use think\Controller;

class Preview extends Controller
{
    public function viewSur()
    {
        $data = [
            'samId' => input('samId')
        ];
        $samInfo = model('sample')->with('question,question.answer')->where('samId', $data['samId'])->select();
        $this->assign('samInfo', $samInfo[0]);
        return view();
    }

    public function view_sur1()
    {
        $data = [
            'surId' => input('surId')
        ];
        $survey = model('survey')->with('question,question.answer')->where('surId', $data['surId'])->select();
        $count = model('Question')->where(['surId' => input('surId'), 'quesType' => '单选题'])->count();
        $countPull = model('Question')->where(['surId' => input('surId'), 'quesType' => '下拉题'])->count();
        $countRecSingle = model('Question')->where(['surId' => input('surId'), 'quesType' => '矩形单选题'])->count();

        $countRecMul = model('Question')->where(['surId' => input('surId'), 'quesType' => '矩形多选题'])->count();
        $viewData = [
            'sur' => $survey[0],
            'count' => $count,
            'countPull' => $countPull,
            'countRecSingle' => $countRecSingle,
            'countRecMul' => $countRecMul
        ];
//        dump($count);
        $this->assign($viewData);
        return view();
    }

    public function submitSur()
    {

    }
}