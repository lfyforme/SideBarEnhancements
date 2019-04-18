<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +-------------------------------------------------------------------
use think\Route;

//前台路由

Route::rule('Base','index/index/Base','get|post');
Route::rule('register','index/index/register','get|post');
Route::rule('login','index/index/login','get|post');
Route::rule('loginout','index/index/loginout','get|post');
Route::rule('forget','index/index/forget','get|post');
Route::rule('create','index/question/create','get|post');
Route::rule('textEdit','index/question/textEdit','get|post');
Route::rule('home','index/question/home','get|post');
Route::rule('select','index/question/select','get|post');
Route::rule('data_view','index/statistics/dataView','get|post');
Route::rule('data_recycle','index/statistics/dataRecycle','get|post');
Route::rule('data_chart','index/statistics/dataChart','get|post');
Route::rule('data_ca','index/statistics/dataCa','get|post');
Route::rule('person_infomation','index/index/personInfomation','get|post');
Route::rule('change_infomation','index/index/changeInfomation','get|post');
Route::rule('create_sur/[:surId]','index/survey/createSur','get|post');
Route::rule('s_list/[:id]','index/Survey/s_list','get|post');
Route::rule('stop','index/survey/stop','post');
Route::rule('start','index/survey/start','post');
Route::rule('delete_sur/[:id]','index/Survey/deleteSur','post');
Route::rule('recycleSur','index/survey/recycleSur','get|post');
Route::rule('clear','index/survey/clear','get|post');
Route::rule('search','index/survey/search','get|post');
Route::rule('share','index/index/share','get|post');
Route::rule('apply','index/survey/apply','get|post');
Route::rule('samList','index/Sample/samList','get|post');
Route::rule('create_ques','index/question/createQues','get|post');
//后台路由php
Route::group('admin',function (){
    Route::rule('login','admin/index/login','get|post');
    Route::rule('register','admin/index/register','get|post');
    Route::rule('forget','admin/index/forget','get|post');
    Route::rule('index','admin/home/index','get|post');
    Route::rule('loginout','admin/home/loginout','get|post');
    Route::rule('catelist','admin/cate/catelist','get|post');
    Route::rule('add','admin/cate/add','get|post');
    Route::rule('sort','admin/cate/sort','get|post');
    Route::rule('cateedit/[:id]','admin/cate/cateedit','get|post');
    Route::rule('delete/[:id]','admin/cate/delete','get|post');
    Route::rule('articlelist','admin/article/articlelist','get');
    Route::rule('articleadd','admin/article/articleadd','get|post');
    Route::rule('articletop','admin/article/articletop','get|post');
    Route::rule('articleedit/[:id]','admin/article/articleedit','get|post');
    Route::rule('articledelete','admin/article/articledelete','get|post');
    Route::rule('userList','admin/user/userList','get|post');
    Route::rule('userAdd','admin/user/userAdd','get|post');
    Route::rule('userEdit/[:userId]','admin/user/userEdit','get|post');
    Route::rule('userDelete','admin/user/userDelete','get|post');
    Route::rule('adminlist','admin/admin1/adminlist','get|post');
    Route::rule('adminadd','admin/admin1/adminadd','get|post');
    Route::rule('adminedit/[:id]','admin/admin1/adminedit','get|post');
    Route::rule('adminstatus','admin/admin1/adminstatus','get|post');
    Route::rule('admindelete','admin/admin1/admindelete','get|post');
    Route::rule('comment','admin/comment/all','get');
    Route::rule('del','admin/comment/del','get|post');
    Route::rule('set','admin/system/set','get|post');
});

//return [
//    '__pattern__' => [
//        'name' => '\w+',
//    ],
//    '[hello]'     => [
//        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//        ':name' => ['index/hello', ['method' => 'post']],
//    ],
//
//];


