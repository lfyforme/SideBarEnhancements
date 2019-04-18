<?php

namespace app\admin\controller;

use think\Controller;

class Base extends Controller
{
    public function _initialize()
    {
        //检验数据是否存在
//        if(!session('?admin.username')){
//            $this->redirect('admin/index/login');
//        }
        $apply = model('Apply')->select();
        $viewData = [
            'apply'=>$apply
        ];
        $this->view->share($viewData);
//        $this->assign('applyList',$result);

    }

}
