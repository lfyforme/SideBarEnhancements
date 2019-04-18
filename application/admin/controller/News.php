<?php


namespace app\admin\controller;


class News extends Base
{
    public function newsList()
    {
        $newsInfo = model('News')->with('admin')->order('news_addTime', 'asc')->paginate(5);
        $newsData = [
            'newsInfo' => $newsInfo
        ];
        $this->assign($newsData);
        return view();
    }

    public function newsAdd()
    {
        if (session('?admin.id'))
            if (request()->isAjax()) {
                $data = [
                    'newsTopic' => input('post.newsTopic'),
                    'newsContent' => input('post.newsContent'),
                    'id' => session('admin.id'),
                ];
                $result = model('News')->add($data);
                if ($result == 1) {
                    $this->success('添加成功');
                } else {
                    $this->error($result);
                }
            }
        return view();
    }

    public function newsEdit()
    {
        if(request()->isAjax()){
            $data = [
                'newsId'=>input('post.newsId'),
                'newsTopic'=>input('post.newsTopic'),
                'newsContent'=>input('post.newsContent')
            ];
            $result = \model('News')->edit($data);
            if($result == 1){
                $this->success('修改成功');
            }else{
                $this->error($result);
            }
        }
        $newsInfo = model('news')->where('newsId', input('newsId'))->find();
        $newsData = [
           'newsInfo'=>$newsInfo,
        ];
        $this->assign($newsData);
        return view();

    }

    public function newsDelete()
    {
        $newsInfo = model('news')->where('newsId', input('post.id'))->find();
        $result = $newsInfo->delete();
        if ($result) {
            $this->success('删除成功','admin/news/newsList');
        } else
            $this->error('删除失败');
    }


}