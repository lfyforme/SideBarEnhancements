<?php

namespace app\index\controller;

use think\Controller;
use think\Request;

class Base extends Controller
{
    /**
     * 使用共享视图
     */
    public function _initialize()
    {
        if(!session('?user')){
            $this->redirect('index/index/login');
        }
    }

}
