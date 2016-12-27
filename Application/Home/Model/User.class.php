<?php
namespace Home\Model;
use Think\Model;
class User{


	/*
	 * 获取用户数据
     * @param array  $where 查询条件
     * @param string $field 查询字段
	 */
	public function getUser($where,$field){
	    $user = M('member')->field($field)->where($where)->find();
	    return $user;
	}

	/*
	 * 根据id修改用户数据
     * @param array $data  保存的数据
     * @param array $where 条件
	 */
	public function changeMemberData($uid,$data){
		$where['id'] = $uid;
	    $status = M('member')->where($where)->save($data);
	    return $status;
	}

	
	/*
	 * 获取订单列表
     * @param int $uid  用户id
     * @param string $field 查询字段
	 */
	public function getOrderList($uid,$field){
		$where['user_id'] = $uid;
	    $list = M('order')->field($field)->where($where)->order('add_time desc')->limit(10)->select();
	    return $list;
	}

	/*
	 * 查询订单
     * @param array $where  组合条件
     * @param string $field 查询字段
	 */
	public function getOrder($where,$field){
		
	    $info = M('order')->field($field)->where($where)->find();
	    return $info;
	}


}



?>