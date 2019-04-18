<?php


namespace app\admin\controller;

class Apply extends Base
{
    public function all(){
        $applies = model('Apply')->with('users,survey')->order('create_time','asc')->paginate(5);
        $this->assign('applies',$applies);
        return view();
    }

    public function no(){
        $applies = model('Apply')->withTrashed()->where('applyStatus',3)->with('users,survey')->order('create_time','asc')->paginate(5);
        $this->assign('applies',$applies);
        return view();
    }
    public function yes(){
        $applies = model('Apply')->withTrashed()->where('applyStatus',2)->with('users,survey')->order('create_time','asc')->paginate(5);
        $this->assign('applies',$applies);
        return view();
    }

    public function refuse(){
        if (request()->isAjax()){
            $data = [
                'surId' => input('post.id'),
            ];
            $result = model('Apply')->refuse($data);
            if($result == 1){
                $this->success('已不同意该申请');
            }else{
                $this->error($result);
            }
        }
    }

    public function agree(){
        if (request()->isAjax()){
            $data = [
                'surId' => input('post.id'),
            ];
            $result = model('Apply')->agree($data);
            if($result == 1){
                $this->success('已同意该申请');
            }else{
                $this->error($result);
            }
        }
    }
}