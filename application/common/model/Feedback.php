<?php


namespace app\common\model;


use think\Model;
use app\common\validate\Feedback as feed;
class Feedback extends Model
{
    protected $createTime = 'fB_addTime';
    protected $updateTime = 'fB_updateTime';
    protected $deleteTime = 'fB_deleteTime';

    //关联用户
    public function user(){
        return $this->belongsTo('User','userId','userId');
    }

    public function add($data){
        $validate = new feed();
        if(!$validate->scene('add')->check($data)){
            return $validate->getError();
        }
        $result = $this->allowField(true)->save($data);
        if($result){
            return 1;
        }else{
            return "反馈失败,请稍后再试？";
        }
     }

     public function edit($data){
         $validate = new feed();
         if(!$validate->scene('edit')->check($data)){
             return $validate->getError();
         }
         $feedInfo = $this->find($data['fBId']);
         $feedInfo->fBTopic = $data['fBTopic'];
         $feedInfo->fBContent = $data['fBContent'];
         $result = $feedInfo->save();
         if($result){
             return 1;
         }else{
             return '修改失败，请稍后再试';
         }
     }
}