<?php


namespace app\index\controller;


use think\Controller;

class Preview extends Controller
{
    public function viewSur(){
        $data = [
            'samId'=>input('samId')
        ];
        $samInfo = model('sample')->with('question,question.answer')->where('samId',$data['samId'])->select();
        $this->assign('samInfo',$samInfo[0]);
        return view();
    }
    public function view_sur1(){
        $data = [
            'surId'=>input('surId')
        ];
        $survey = model('survey')->with('question,question.answer')->where('surId',$data['surId'])->select();
        $this->assign('sur',$survey[0]);
        return view();
    }
    public function submitSur(){

    }
}