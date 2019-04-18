<?php


namespace app\common\model;


use think\Model;
use app\common\validate\News as news1;
class News extends Model
{
    protected $createTime = 'news_addTime';
    protected $updateTime = 'news_updateTime';
    protected $deleteTime = 'news_deleteTime';

    public function admin(){
        return $this->belongsTo('admin','id','id');
    }

    public function add($data){
        $validate = new news1();
        if(!$validate->scene('add')->check($data)){
            return $validate->getError();
        }
        $result = $this->allowField(true)->save($data);
        if($result){
            return 1;
        }else{
            return '添加失败';
        }
    }

    public function edit($data){
       $validate = new news1();
       if(!$validate->scene('edit')->check($data)){
            return $validate->getError();
       }
       $newsInfo = $this->where('newsId', $data['newsId'])->find();
        $newsInfo->newsId = $data['newsId'];
       $newsInfo->newsTopic = $data['newsTopic'];
       $newsInfo->newsContent = $data['newsContent'];
       $result = $newsInfo->allowField(true)->save();
       if($result){
           return 1;
       }else{
           return '修改失败';
       }
    }
}