<?php

namespace app\index\controller;
use think\Controller;

class Sample extends Controller
{
    public function samList(){
        $result = model('Sample')->with('samSum')->order('sam_addTime','asc')->paginate(5);
        $this->assign('sample',$result);
        return view();
    }
}