<?php
namespace app\index\controller;
class UserAction extends Action
{
    public function lists()
    {
        $m = M('Admin');
        import('ORG.Util.Page');
        $where = '1=1';
        if (!empty($_GET[name])) {
            $data['name'] = " and name like '%{$_GET[name]}%'";
        } else {
            $data['name'] = '';
        }
        if (!empty($_GET['name'])) {
            $where .= $data['name'];
        }
        $count = M('Admin')->where($where)->count();
        $pageSize = 20;
        $p = isset($_GET['p']) ? $_GET['p'] : 1;
        $page = new Page($count, $pageSize);
        $limit = $page->firstRow . ',' . $page->listRows;
        $arr = M('admin')->where($where)->limit($limit)->select();
        $limit = $page->firstRow . ',' . $page->listRows;
        $page = $page->show();
        $this->assign('arr', $arr);
        $this->assign('page', $page);
        $this->display();
    }
    public function addUser()
    {
        $data['account'] = I('post.account');
        $data['password'] = I('post.password');
        $data['phone'] = I('post.phone');
        $data['email'] = I('post.email');
        $data['level'] = I('post.level');
        $mid = M('Admin')->data($data)->add();
        if ($mid) {
            $member = M('Admin')->order('id desc')->select();
            $tab = "<table border='0' class='tab table-striped table-bordered table-hover table-responsive' style='width:90%;margin:0px auto;' id='table'><tr>";
            $tab .= "<td width='7%' height='45' align='center' valign='middle' bgcolor='#CCCCFF'>编号</td>";
            $tab .= "<td width='8%' height='45' align='center' valign='middle' bgcolor='#CCCCFF'>用户名</td>";
            $tab .= "<td width='13%' height='45' align='center' valign='middle' bgcolor='#CCCCFF'>用户密码</td>";
            $tab .= "<td width='9%' height='45' align='center' valign='middle' bgcolor='#CCCCFF'>用户级别</td>";
            $tab .= "<td width='11%' height='45' align='center' valign='middle' bgcolor='#CCCCFF'>用户邮箱</td>";
            $tab .= "<td width='11%' height='45' align='center' valign='middle' bgcolor='#CCCCFF'>手机号码</td>";
            $tab .= "<td width='11%' height='45' align='center' valign='middle' bgcolor='#CCCCFF'>用户IP地址</td>";
            $tab .= "<td width='13%' height='45' align='center' valign='middle' bgcolor='#CCCCFF'>最近登陆时间</td>";
            $tab .= "<td width='17%' height='45' align='center' valign='middle' bgcolor='#CCCCFF'>操作</td></tr>";
            if ($member) {
                foreach ($member as $m) {
                    $tab .= "<tr><td height='45' align='center' valign='middle'>" . $m['id'] . "</td>";
                    $tab .= "<td height='45' align='center' valign='middle'>" . $m['name'] . "</td>";
                    $tab .= "<td height='45' align='center' valign='middle'>" . $m['password'] . "</td>";
                    $tab .= "<td height='45' align='center' valign='middle'>" . $this->getLeveName($m['level']) . "</td>";
                    $tab .= "<td height='45' align='center' valign='middle'>" . $m['email'] . "</td>";
                    $tab .= "<td height='45' align='center' valign='middle'>" . $m['phone'] . "</td>";
                    $tab .= "<td height='45' align='center' valign='middle'>" . $m['loginip'] . "</td>";
                    $tab .= "<td height='45' align='center' valign='middle'>" . date('Y-m-d H:i:s', $m['logintime']) . "</td>";
                    $tab .= "<td height='45' align='center' valign='middle'><a href='javascript:void(0)' title='" . $m['id'] . "' class='update'>修改用户</a> &nbsp; &nbsp;<a href='javascript:void(0)' class='delete' title='" . $m['id'] . "' onclick='return confirm(\'确定删除吗？\');'>删除用户</a></td></tr>";
                }
            }
            $tab .= "</table>";
            echo $tab;
        } else {
            echo 2;
        }
    }
    public function changeUser()
    {
        $id = I('post.id');
        $member = M('Admin')->find($id);
        if ($member) {
            $tab = "<table class='tab table-striped table-bordered table-hover table-responed' style='width:90%;margin:5px auto;'><tr><td height='45' colspan='2'  align='center'>更新用户</td></tr>";
            $tab .= "<tr><td width='332' height='45' align='right'>编号：</td><td width='634' height='45'><input type='hidden' name='id' value='" . $member['id'] . "' id='mid'/></td></tr>";
            $tab .= "<tr><td width='332' height='45' align='right'>用户名：</td><td width='634' height='45'><input type='text' name='account' value='" . $member['name'] . "'  id='mname'/></td></tr>";
            $tab .= "<tr><td height='45' align='right'>密码：</td><td height='45'><input type='password' name='password' value='" . $member['password'] . "' id='mpassword'/></td></tr>";
            $tab .= "<tr><td height='45' align='right'>手机号：</td><td height='45'><input type='text' name='phone' value='" . $member['phone'] . "'  id='mphone'/></td></tr>";
            $tab .= "<tr><td height='45' align='right'>电子邮箱：</td><td height='45'><input type='text' name='email' value='" . $member['email'] . "' id='memail'/></td></tr>";
            $tab .= "<tr><td height='45' align='right'>用户级别：</td><td height='45'><select name='level' id='mlevel'><option value=''>请选择</option><option value='1' " . $this->getLevel($member['level'], 1) . ">超级管理员</option><option value='2' " . $this->getLevel($member['level'], 2) . ">高级管理员</option><option value='3' " . $this->getLevel($member['level'], 3) . ">中级管理员</option><option value='4' " . $this->getLevel($member['level'], 4) . ">初级管理员</option></select></td></tr>";
            $tab .= "<tr><td height='45' colspan='2' align='center'><input type='button' name='' value='更新用户' id='changeUser'/></td></tr></table>";
            echo $tab;
        }
    }
    public function changeUserInfo()
    {
        $id = I('post.id');
        $data['name'] = I('post.name');
        $data['password'] = I('post.password');
        $data['phone'] = I('post.phone');
        $data['email'] = I('post.email');
        $data['level'] = I('post.level');
        $ids = M('Admin')->where(array('id' => $id))->save($data);
        if ($ids) {
            $mb = M('Admin')->select();
            $ta = "<table border='0' class='tab table-striped table-bordered table-hover table-responsive' style='width:98%;margin:0px auto;' id='table'><tr><td width='7%' height='45' align='center' valign='middle' bgcolor='#CCCCFF'>编号</td><td width='8%' height='45' align='center' valign='middle' bgcolor='#CCCCFF'>用户名</td><td width='13%' height='45' align='center' valign='middle' bgcolor='#CCCCFF'>用户密码</td><td width='9%' height='45' align='center' valign='middle' bgcolor='#CCCCFF'>用户级别</td><td width='11%' height='45' align='center' valign='middle' bgcolor='#CCCCFF'>用户邮箱</td><td width='11%' height='45' align='center' valign='middle' bgcolor='#CCCCFF'>手机号码</td><td width='11%' height='45' align='center' valign='middle' bgcolor='#CCCCFF'>用户IP地址</td><td width='13%' height='45' align='center' valign='middle' bgcolor='#CCCCFF'>最近登陆时间</td><td width='17%' height='45' align='center' valign='middle' bgcolor='#CCCCFF'>操作</td></tr>";
            if ($mb) {
                foreach ($mb as $mc) {
                    $ta .= "<tr class='user_" . $mc['id'] . "'><td height='45' align='center' valign='middle'>" . $mc['id'] . "</td>";
                    $ta .= "<td height='45' align='center' valign='middle'>" . $mc['name'] . "</td>";
                    $ta .= "<td height='45' align='center' valign='middle'>" . $mc['password'] . "</td>";
                    $ta .= "<td height='45' align='center' valign='middle'>" . $this->getLeveName($mc['level']) . "</td>";
                    $ta .= "<td height='45' align='center' valign='middle'>" . $mc['email'] . "</td>";
                    $ta .= "<td height='45' align='center' valign='middle'>" . $mc['phone'] . "</td>";
                    $ta .= "<td height='45' align='center' valign='middle'>" . $mc['loginip'] . "</td>";
                    $ta .= "<td height='45' align='center' valign='middle'>" . date('Y-m-d H:i:s', $mc['logintime']) . "</td>";
                    $ta .= "<td height='45' align='center' valign='middle'><a href='javascript:void(0)' title='" . $mc['id'] . "' class='update'>修改</a> &nbsp; &nbsp;<a href='javascript:void(0)' class='delete' title='" . $mc['id'] . "' onclick='return confirm(\'确定删除吗？\');'>删除</a></td></tr>";
                }
            }
            $ta .= "</table>";
            echo $ta;
        }
    }
    public function deleteUser()
    {
        $id = I('post.id');
        $ids = M('Admin')->where(array('id' => $id))->delete();
        if ($ids) {
            echo 1;
        }
    }
    /*
    * 通过级别来判断是否选中。
    * $level 级别
    * $num 与级别进行相比的数字。
    */
    public function getLevel($level, $num)
    {
        if ($level == $num) {
            $selected = 'selected';
        } else {
            $selected = '';
        }
        return $selected;
    }
    /*
    * 通过级别获得相应的等级名称
    *
    */
    public function getLeveName($level)
    {
        if ($level == '1') {
            $l = '超级管理员';
        } else if ($level == '2') {
            $l = '高级管理员';
        } else if ($level == '3') {
            $l = '中级管理员';
        } else if ($level == '4') {
            $l = '初级管理员';
        }
        return $l;
    }
}
?>