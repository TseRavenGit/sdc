<?php
namespace Home\Model;
use Think\Model;
class MemberModel extends Model{

  protected $_validate = array(
    array('nickname', 'require', '帐号名称不能为空！'), 
    array('nickname','','帐号名称已经存在！',0,'unique',3), // 在新增的时候验证name字段是否唯一
    array('email', 'require', '邮箱不能为空！'),
    array('email','','邮箱已经存在！',0,'unique',3),
    array('email','email','邮箱格式不符合要求',3),
    array('password', 'require', '密码不能为空！'),
    array('password','6,20','密码长度不符！',3,'length'),
  );

  protected $_auto = array ( 
	    array('password','md5',3,'function') , // 对password字段在新增和编辑的时候使md5函数处理
	    array('add_time','time',1,'function'), // 对add_time字段在新增的时候写入当前时间戳
	    array('update_time','time',3,'function'), // 对update_time字段在更新的时候写入当前时间戳
	    array('ip','getIp',3,'callback'), 
	);

  protected function getIp(){
   	 	$ip  = get_client_ip();
   	 	return $ip;
  }




}



?>