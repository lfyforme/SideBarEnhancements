<?php

namespace app\index\controller;

use think\Controller;

class Survey extends Controller
{
    //创建问卷
    public function createSur()
    {
        $data = [
            'surName' => '标题',
            'surDesc' => '欢迎您本次的调查',
            'userId' => session('user.userId')
        ];
        $result = model('survey')->allowField(true)->save($data);
        $this->redirect('index/question/create', ['surId' => model('survey')->getLastInsID()]);
    }

    //保存修改的标题
    public function saveTitle()
    {
        if (request()->isAjax()) {
            $data = [
                'surName' => input('post.title')
            ];
            $surInfo = model('survey')->where('surId', input('post.surId'))->find();
            $surInfo->surName = $data['surName'];
            $result = $surInfo->save();
            if ($result) {
                $this->success('保存完成', '');
            } else {
                $this->error('保存失败');
            }
        }
    }

    //复制问卷
    public function copy(){
        if(request()->isAjax()){
            $data = [
                'surId' => input('post.surId'),
            ];
            $surInfo = model('survey')->find(input('post.surId'));

        }
    }
    //保存修改的概述
    public function saveDesc()
    {
        if (request()->isAjax()) {
            $data = [
                'surDesc' => input('post.desc')
            ];
            $surInfo = model('survey')->where('surId', input('post.surId'))->find();
            $surInfo->surDesc = $data['surDesc'];
            $result = $surInfo->save();
            if ($result) {
                $this->success('保存完成', '');
            } else {
                $this->error('保存失败');
            }
        }
    }

    //删除没有使用的问卷
    public function delSur()
    {
        if (request()->isAjax()) {
            $surInfo = model('survey')->where('surId', input('post.surId'))->find();
            $quesInfo = model('question')->where('surId', input('post.surId'))->find();
            if ($quesInfo) {
                $this->success('有问题', '');
            } else {
                $result = $surInfo->delete(true);
                if ($result) {
                    $this->success('删除成功');
                }
            }
        }
    }

    //用户问卷列表
    public function s_list()
    {
        $id = session('user.userId');
        $list = model('Survey')->where('userId', $id)->order('surId', 'desc')->paginate(5);
        $this->assign('surStatus', '4');
        $this->assign('surName', '');
        $this->assign('surList', $list);
        return view();
    }

    //重命名
    public function rename()
    {
        if (request()->isAjax()) {
            $data = [
                'surId' => input('post.id'),
                'surName' => input('post.surName')
            ];
            $result = model('Survey')->rename($data);
            if ($result == 1) {
                $this->success('重命名成功');
            } else {
                $this->error($result);
            }
        }
    }

    //停止发布
    public function stop()
    {
        if (request()->isAjax()) {
            $data = [
                'surId' => input('post.id'),
                'surStatus' => input('post.status')
            ];
            $result = model('Survey')->stop($data);
            if ($result == 1) {
                $this->success('停止成功');
            } else {
                $this->error('停止失败');
            }
        }
    }

    //开始发布
    public function start()
    {
        if (request()->isAjax()) {
            $data = [
                'surId' => input('post.id'),
                'surStatus' => input('post.status')
            ];
            $result = model('Survey')->start($data);
            if ($result == 1) {
                $this->success('发布成功');
            } else {
                $this->error('发布失败');
            }
        }
    }

    //根据问卷状态搜索问卷
    public function searchStatus()
    {
        $status = input('get.surStatus');
        if ($status == 4)
            $status = '%';
        $surList = model('Survey')->where('surStatus', 'like', $status)->order('')->paginate(5, false, ['query' => request()->param()]);
        $this->assign('surList', $surList);
        $this->assign('surName', '');
        $this->assign('surStatus', $status);
        return view("s_list");
    }

    //根据问卷名搜索问卷
    public function searchName(){
        $name = input('get.sName');
        dump($name);
        $surList = model('Survey')->where('surName', 'like', '%'.$name.'%')->paginate(5, false, ['query' => request()->param()]);
        $this->assign('surList', $surList);
        $this->assign('surName', $name);
        $this->assign('surStatus', '4');
        return view("s_list");
    }

        //问卷回收站
    public function recycleSur()
    {
        $surList = model('Survey')->withTrashed()->where(['surStatus' => 3, 'userId' => session('user.userId')])->order('surId', 'asc')->paginate(5);

    //        $visitor_count = model('Sursub')->where(['userId'=>session('user.userId')])->count();   //该问卷游客回答的总数
    //        $user_count = model('Survisitor')->where(['userId'=>session('user.userId')])->count();  //该问卷用户回答的总数
        $this->assign('surList', $surList);
        return view();
    }

    public function apply()
    {
        if (request()->isAjax()) {
            $data = [
                'surId' => input('post.id'),
                'userId' => session('user.userId')
            ];
            $result = model('survey')->apply($data);
            if ($result == 1) {
                $this->success('申请请求成功，请等待管理员进行审批');
            } else {
                $this->error($result);
            }
        }
    }

    //软删除问卷
    public function deleteSur()
    {
        $surInfo = model('Survey')->find(input('post.id'));
        $result = $surInfo->delete();
        if ($result) {
            $surInfo->surStatus = 3;
            $result = $surInfo->save();
            if ($result) {
                $this->success('删除成功');
            }
        } else {
            $this->error('删除失败');
        }
    }

    //彻底删除问卷
    public function comDelete()
    {
        $surInfo = model('Survey')->withTrashed()->find(input('post.id'));
        if ($surInfo) {
            $result = $surInfo->delete(true);
            if ($result) {
                $this->success('删除成功');
            }
        } else {
            $this->error('删除失败');
        }
    }
    //恢复删除的问卷
    public function recover()
    {
        $surInfo = model('Survey')->withTrashed()->find(input('post.id'));
        if (!empty($surInfo)) {
            $surInfo->sur_deleteTime = null;
            $surInfo->surStatus = 0;
            $result = $surInfo->save();
            if ($result) {
                $this->success('恢复数据成功');
            }
        } else {
            $this->error('恢复数据失败');
        }
    }

    //清空回收站
    public function clear()
    {
        $surInfo = model('Survey')->onlyTrashed()->where('userId', session('user.userId'))->delete();
        if (!$surInfo) {
            $this->error('清空回收站失败');
        } else {
            $this->success('已清空回收站');
        }
    }
}