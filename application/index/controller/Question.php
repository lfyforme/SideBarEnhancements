<?php


namespace app\index\controller;


use think\Controller;

class Question extends Controller
{
    //创建问卷标题
    public function create()
    {
        $result = model('Survey')->find(input('surId'));
        $quesInfo = model('Question')->with('answer')->where('surId', input('surId'))->select();
        $viewData = [
            'sur' => $result,
            'quesInfo' => $quesInfo
        ];
        $this->assign($viewData);
        return view();
    }

    // 保存题目
    public function saveInfo()
    {
        if (request()->isAjax()) {
            $quesId = input('post.quesId');
            $surId = input('post.surId');
            if (input('post.question_check') == 'on') {
                $req = 0;
            } else {
                $req = 1;
            }
            $datas = [
                'quesTitle' => input('post.quesTitle'),
                'quesDesc' => input('post.quesDesc'),
                'quesType' => input('post.question_type'),
                'quesReq' => $req,
                'surId' => $surId
            ];

            $quesData = model('question')->saveInfo($datas, $quesId);
            if ($quesData != 0) {
                $options = json_decode(input('post.options'), true);
                $optionId = json_decode(input('post.listId'), true);
                $inners = json_decode(input('post.inners'), true);
                $listInId = json_decode(input('post.listInId'), true);
                $dataScale = [
                    'scale_type' => input('post.scale_type'),
                    'scaleRange' => input('post.scaleRange'),
                    'scaleStart' => input('post.scaleStart'),
                    'quesId' => $quesData
                ];
                $data = array();
                $dataIn = array();
                if(input('post.scaleId') != "")
                     $scaleInfo = model('scale')->saveSacle($dataScale,input('post.scaleId'));
                //存储答案
                if (count($optionId) > 0) {
                    for ($i = 0; $i < count($optionId); $i++) {
                        trim($options[$i]);
                        if ($optionId[$i] != 1) {
                            $answer = [
                                'answer' => $options[$i],
                                'quesId' => $quesData
                            ];
                            $answerInfo = model('answer')->find($optionId[$i]);
                            $answerInfo->save($answer);
                        } else {
                            $data[$i]['answer'] = $options[$i];
                            $data[$i]['quesId'] = $quesData;
                        }
                    }
                    model('answer')->saveAll($data);
                }
                //存储矩形题中的内置问题
                if (count($listInId) > 0) {
                    for ($i = 0; $i < count($listInId); $i++) {
                        trim($inners[$i]);
                        if ($listInId[$i] != 1) {
                            $inner = [
                                'quesInner' => $inners[$i],
                                'quesId' => $quesData
                            ];
                            $innerInfo = model('inner')->find($listInId[$i]);
                            $innerInfo->save($inner);
                        } else {
                            $dataIn[$i]['quesInner'] = $inners[$i];
                            $dataIn[$i]['quesId'] = $quesData;
                        }
                    }
                    model('inner')->saveAll($dataIn);
                }
                $data = model('question')->with('answer,inner,scale')->where('quesId', $quesData)->select();
                $this->success('成功', '{:url("index/question/create")}', $data);
            } else {
                $this->error($quesData);
            }
        }
    }

    //删除问题
    public function deleteQues()
    {
        if (request()->isAjax()) {
            $quesId = input('post.quesId');
            $quesInfo = model('question')->find($quesId);
            $result = $quesInfo->delete();
            if ($result) {
                $this->success('删除成功，可在回收站内将问题恢复');
            } else {
                $this->error('删除失败，请稍后再试');
            }
        }
    }

    //收藏问题
    public function collect()
    {
        if (request()->isAjax()) {
            $quesId = input('post.quesId');
            $quesInfo = model('question')->find($quesId);
            $quesInfo->quesCollect = 1;
            $result = $quesInfo->save();
            if ($result) {
                $this->success('收藏成功，请到我的题库中进行查看');
            } else {
                $this->error('收藏失败,请稍后再试');
            }
        }
    }

    public function link()
    {
        dump(input('id'));
        $data = [
            'quesId' => input('id'),
        ];
        $result = model('question')->find($data);
        $this->assign('ques', $result);
        return view();
    }

    public function ques_logic()
    {
        return view();
    }


    //单选
    public function single()
    {
        $this->common();
        return view();
    }

    //多选
    public function multiple()
    {
        $this->common();
        return view();
    }

    //下拉
    public function pull()
    {
        $this->common();
        return view();
    }

    //矩形单选
    public function rectangleSig()
    {
        $this->commonRec();
        return view();
    }

    //矩形多选
    public function rectangleMul()
    {
        $this->commonRec();
        return view();
    }

    //排序
    public function sort()
    {
        $this->common();
        return view();
    }

    //量表
    public function scale()
    {
        $quesId = input('id');
        $surId = input('surId');
        $reqult = model('question')->with('scale')->where('quesId', $quesId)->find();
        $this->assign('ques', $reqult);
        $this->assign('surId', $surId);
        $this->assign('quesId', $quesId);
        return view();
    }

    //单选、多选、排序、下拉题共用
    public function common()
    {
        $quesId = input('id');
        $surId = input('surId');
        $reqult = model('question')->with('answer')->where('quesId', $quesId)->find();
        $this->assign('ques', $reqult);
        $this->assign('surId', $surId);
        $this->assign('quesId', $quesId);
    }

    //矩形题共用
    public function commonRec()
    {
        $quesId = input('id');
        $surId = input('surId');
        $reqult = model('question')->with('answer,inner')->where('quesId', $quesId)->find();
        $this->assign('ques', $reqult);
        $this->assign('surId', $surId);
        $this->assign('quesId', $quesId);
    }

    public function textEdit()
    {
        return view();
    }

    public function select()
    {
        return view();
    }

}