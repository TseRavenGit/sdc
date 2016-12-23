<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\User;
class MemberController extends Controller {


    protected function checkLogin(){
        $uid = session('uid');
        $nickname = session('nickname');
        $userinfo = array();
        if($uid && $nickname){
            $userinfo['id'] = $uid;
            $userinfo['nickname'] = $nickname;
            return $userinfo;
        }
    }

    public function memberInfo(){

        $userinfo = $this->checkLogin();
        if(empty($userinfo)){
            $this->error('您还没有登录，请先登录！',U('index/signin'));
        }

        $where['id'] = $userinfo['id'];
        $field = 'id,status,token_exptime,balance,balance_e';
        $userClass = new User();
        $user = $userClass->getUser($where,$field);
        if(empty($user)){
            //清楚所有session
            session(null);
            $this->error('用户已被注销！',U('index/signup'));
        }
        $userStatus = $user['status'];
        $tokenExptime = $user['token_exptime'];
        $balance = $user['balance'];
        $income = C('THINK_SDC.ANNUAL_INCOME');//年收益 
        $uid = $user['id'];

        //订单列表
        $map['user_id'] = $uid;
        $order  = M('order');
        $count = $order->where($map)->count();
        $Page  = new \Org\Raven\Page($count,5);
        $show  = $Page->show();
        $list  = $order->where($map)->order('add_time')->limit($Page->firstRow.','.$Page->listRows)->select();

        //重新发送邮件
        if(time() > $tokenExptime && $userStatus == 0 ){
            $emailGo = 1;
            $link = U('member/memberRestar');

            $this->assign('link',$link);
        }else if(time() < $tokenExptime && $userStatus == 0 ){
            $emailGo = 2;
        }

        //判断是否生成交割卷
        $canCreate = 1;
        $deliveryVal = C('THINK_SDC.DELIVERY_VAL');//余额达到该值生成交割卷
        if($balance > $deliveryVal){
            $canCreate = 2;
        }

        $this->assign('uid',$uid);
        $this->assign('emailGo',$emailGo);
        $this->assign('userStatus',$userStatus);
        $this->assign('balance',$balance);
        $this->assign('balance_e',$user['balance_e']);
        $this->assign('income',$income);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->assign('canCreate',$canCreate);
        $this->assign('active','info');
        $this->display('member-info');

    }

    public function memberPwd(){

        $userinfo = $this->checkLogin();
        if(empty($userinfo)){
            $this->error('您还没有登录，请先登录！',U('index/signin'));
        }

        if(IS_GET){

            $this->assign('userinfo',$userinfo);
            $this->assign('active','pwd');
            $this->display('member-pwd');
        }elseif(IS_POST){

            $rules = array(
                array('password','require','密码不能为空'), 
                array('password','6,20','密码长度不符！',1,'length'),
                array('confpassword','require','确认密码不能为空'), 
                array('confpassword','password','两次输入的密码不一致',0,'confirm'),
            );
            $id = I('post.id');
            if(!$id){
                $this->error('未知错误,请刷新网页,再提交！');
            }
            $user = M("member")->validate($rules)->create(); 

            if (!$user){
                $this->error($user->getError());
            }else{
                $where['id'] = $id;
                $data['password'] = md5($user['password']);
                $b = M("member")->where($where)->save($data);
                if($b){

                    $this->success('修改成功,下次请用新密码登录！', U('memberInfo'));
                }else{
                    $this->error('修改失败！');
                }
            }

        }else{
            exit("非法操作！");
        }
    }


    public function checkVolume(){
        if(IS_GET){
            $userinfo = $this->checkLogin();
            if(empty($userinfo)){
                $this->error('您还没有登录，请先登录！',U('index/signin'));
            }

            //交割卷列表
            $map['user_id'] = $userinfo['id'];
            $volume  = M('volume');
            $count = $volume->where($map)->count();
            $Page  = new \Org\Raven\Page($count,3);
            $show  = $Page->show();
            $list  = $volume->where($map)->order('add_time')->limit($Page->firstRow.','.$Page->listRows)->select();

            $this->assign('list',$list);
            $this->assign('page',$show);
            $this->assign('active','info');
            $this->display('check-volume');

        }else{
            exit('非法操作！');
        }

    }


    // 查看转入、出 记录
    public function checkListOut(){
        if(IS_GET){
            $userinfo = $this->checkLogin();
            if(empty($userinfo)){
                $this->error('您还没有登录，请先登录！',U('index/signin'));
            }

            $w['id'] = $userinfo['id'];
            $field = 'id,email,status';
            $userClass = new User();
            $user = $userClass->getUser($w,$field);
            if($user['status'] == 0){
                $this->error('您的账号还没有激活，请前往邮箱激活！');
            }
            $selfEmail = $user['email'];

            //转出/入列表
            $where['to']  = $selfEmail;
            $where['from']  = $selfEmail;
            $where['_logic'] = 'or';
            $map['_complex'] = $where;
            $volume  = M('transaction');
            $count = $volume->where($map)->count();
            $Page  = new \Org\Raven\Page($count,3);
            $show  = $Page->show();
            $list  = $volume->where($map)->order('add_time')->limit($Page->firstRow.','.$Page->listRows)->select();

            $this->assign('selfEmail',$selfEmail);
            $this->assign('list',$list);
            $this->assign('page',$show);
            $this->assign('active','info');
            $this->display('check-transaction');

        }else{
            exit('非法操作！');
        }

    }


    public function register(){

    	if(IS_POST){
			$User = D("Member");
			if (!$User->create()){
			    $this->error($User->getError());
			}else{

                $User->token_exptime = time()+60*60*24;//过期时间为24小时后
                $token = md5(time().'sdc'.$User->password.rand(1,9999));
                $User->token = $token;
                $email = $User->email;
                $nickname = $User->nickname;

				$lastId = $User->add();
				if($lastId){
                    // 存储session
                    session('uid', $lastId);
                    session('nickname', $nickname);

                    //发送邮件
					//$link = $_SERVER['HTTP_HOST']."/home/member/activation?token={$token}";
                    $link = U('member/activation@'.$_SERVER['HTTP_HOST'],array('token'=>$token));
			    	
                    $l = $this->sendEmail($email,$nickname,$link);
                    if($l){
                        $this->success('注册成功,正跳转至用户中心...', U('memberInfo'));
                    }else{
                        $this->success('注册成功,但是邮箱发送失败！请联系管理员解决...', U('memberInfo'));
                    }
				}else{
					$this->error('注册失败');
				}
				
			}
    	}else{
    		exit("非法操作！");
    	}
    }


    public function login(){
    	if(IS_POST){
    		$rules = array(
    			array('email', 'require', '帐号名称不能为空！'), 
    			array('email','email','邮箱格式不符合要求'),
			    array('password','require','密码不能为空'), 
    			array('password','6,20','密码长度不符！',1,'length'),
			);
			$data = array();
			$data['email'] = I('post.email');
			$data['password'] = I('post.password');
			$User = M("member"); 
			if (!$User->validate($rules)->create($data)){
			    $this->error($User->getError());
			}else{
 				$where = array();
	            $where['email'] = $data['email'];
	            $result = $User->where($where)->field('id,nickname,password,email,status')->find();
	            if(!$result){
	            	$this->error('登录失败,邮箱不存在！');
	            }
                /*if($result['status'] == 0){
                    $this->error('您的邮箱还未激活,请前往邮箱激活！');
                }*/

	            // 验证用户名 对比 密码
           		if (md5($data['password']) == $result['password']) {
	                // 存储session
	                session('uid', $result['id']); 
	                session('nickname', $result['nickname']);

	                // 更新用户登录信息
	                $where['id'] = $result['id'];
	                $data_save['ip'] = get_client_ip();
                    if($data_save['ip']){
                        $User->where($where)->save($data_save);
                    }
	                $this->success('登录成功,正跳转至用户中心...', U('memberInfo'));
				}else{
					$this->error('登录失败,密码错误！');
				}
			}

    	}else{
    		exit("非法操作！");
    	}

    }

    /**
     * 用户注销
     */
    public function logout()
    {
        //清楚所有session
        session(null);

        $this->success('正在退出登录...', U('Index/index'));
    }



    /**
     *  重发邮件，激活账号
	 * protected  
     */
    public function memberRestar(){
        $userinfo = $this->checkLogin();
        if(empty($userinfo)){
            $this->error('您还没有登录，请先登录！',U('index/signin'));
        }

        $where['id'] = $userinfo['id'];
        $field = 'id,nickname,status,email,password';
        $userClass = new User();
        $user = $userClass->getUser($where,$field);
        if($user['status'] == 1){
            $this->error('操作失败,已经激活过了！');
        }

        if(empty($data['token'])){
            $this->error('操作失败，未知错误！');
        }
        //$link = $_SERVER['HTTP_HOST']."/home/member/activation?token={$token}";
        $link = U('member/activation@'.$_SERVER['HTTP_HOST'],array('token'=>$data['token']));

        $l = $this->sendEmail($user['email'],$user['nickname'],$link); //发送邮件
        if($l){
            //储存token 更新token激活时间
            $data['token'] = md5(time().'sdc'.$user['password'].rand(1,9999));
            $data['token_exptime'] = time()+60*60*24;//过期时间为24小时后
            M('member')->where($where)->save($data);
            $this->success('已经发送了激活邮件，请尽快前往邮箱激活！',U('memberInfo'));
        }else{
            $this->error('操作失败，未知错误！');
        }
        
	    
    }


    /**
     * 激活账户
     *
     */
    public function activation(){
        if(IS_GET){
            $urlToken = I('get.token');
            if(!$urlToken){
                exit("非法操作！");
            }

            $where['token'] = $urlToken;
            $field = 'id,token_exptime,status';
            $userClass = new User();
            $user = $userClass->getUser($where,$field);
            if(!$user){
                $this->error('未知错误，激活失败！');
            }
            if($user['status'] == 1){
                $this->success('已经激活成功了！',U('Index/signin'));
            }
            $nowTime = time();

            if($nowTime > $user['token_exptime']){
                $this->error('激活时间已过，请登录邮箱重新发送激活邮件', U('Index/signin'));
            }else{
                $data['status'] = 1;
                $n = M('member')->where('id='.$user['id'])->save($data);
                if($n){
                    $this->success('激活成功！',U('Index/index'));
                }else{
                    $this->error('未知错误，激活失败！');
                }
                
            }
            
        }else{
            exit("非法操作！");
        }
    }


    /**
     * SDC转出
     *
     */
    public function turnOut(){
        $userinfo = $this->checkLogin();
        if(empty($userinfo)){
            $this->error('您还没有登录，请先登录！',U('index/signin'));
        }
        $uid = $userinfo['id'];
        if(IS_GET){
            $where['id'] = $uid;
            $field = 'id,balance,status';
            $userClass = new User();
            $user = $userClass->getUser($where,$field);
            if($user['status'] == 0){
                $this->error('您的账号还没有激活，请前往邮箱激活！');
            }
            $this->assign('user',$user);
            $this->assign('active','info');
            $this->display('member-out');

        }else if(IS_POST){

            $amount = number_format(I('post.amount'), 2, '.', '');
            $to = I('post.to');
            $user_id = I('post.id');

            if(empty($to)){
                $this->error('帐号名称不能为空！');
            }
            $pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
            if (!preg_match($pattern, $to)){
                $this->error('帐号名称格式不正确！');
            }
            if(empty($amount)){
                $this->error('转出数量不能为空！');
            }

            $where['id'] = $user_id;
            $field = 'id,balance,email,balance_e';
            $userClass = new User();
            $fromUser = $userClass->getUser($where,$field);

            $map['email'] = $to;
            $toUser = $userClass->getUser($map,$field);
            if(empty($toUser)){
                $this->error('不存在该账户！');
            }
            if($amount > $fromUser['balance']){
                $this->error('转出的数量超过可用额');
            }
            if($fromUser['email'] == $to){
                $this->error('不能自己给自己转账');
            }

            $data = array();
            $User = M("member"); 
            $transaction = M('transaction');
            $User->startTrans();
            if (!$transaction->validate($rules)->create()){
                $this->error($transaction->getError());
            }
            $formBalance = $fromUser['balance'];
            $toBalance_e = $toUser['balance_e'];
            //添加交易记录 transaction表
            $transactionData['from_uid'] = $user_id;
            $transactionData['to_uid'] = $toUser['id'];
            $transactionData['to'] = $to;
            $transactionData['from'] = $fromUser['email'];
            $transactionData['amount'] = $amount;
            $transactionData['add_time'] = time();
            $transactionId = $transaction->add($transactionData);

            $b = false;
            if($transactionId){
                //修改转入/转出 账户 余额
                $toData['balance_e'] = $toBalance_e + $amount;
                $fromData['balance'] = $formBalance - $amount;
                $toSave = $User->where('id='.$toUser['id'])->save($toData);
                $fromSave = $User->where('id='.$user_id)->save($fromData);
                if($toSave && $fromSave){
                    $b = true;
                }
            }

            if ($b){
                // 提交事务
                $User->commit();
                $this->success('转出成功！',U('member/memberInfo'));
            }else{
                // 事务回滚
                $User->rollback();
                $this->error('转出失败！');
            }
        }else{
            exit('非法操作！');
        }
    }


    /**
     * 创建交割卷
     *
     */
    public function createVolume(){
        if(IS_AJAX){
            $uid = I('post.uid');
            $return = array();
            $return['code'] = 0;
            $userinfo = $this->checkLogin();
            if($userinfo['id'] != $uid || empty($userinfo)){
                $return['msg'] = '该账户未登录!';
                $this->ajaxReturn($return,'json');
                exit;
            }
            $where['uid'] = $uid;
            $field = 'id,email,status,balance,balance_e';
            $userClass = new User();
            $user = $userClass->getUser($where,$field);
            if(empty($user)){
                $return['msg'] = '不存在该账户!';
                $this->ajaxReturn($return,'json');
                exit;
            }
            if($user['status'] == 0){
                $this->error('您的账号还没有激活，请前往邮箱激活！');
            }
            
            //判断是否生成交割卷
            $deliveryVal = C('THINK_SDC.DELIVERY_VAL');//余额达到该值生成交割卷
            $balance = $user['balance'];
            if($balance < $deliveryVal || $balance < 1){
                $return['msg'] = '无法达到生成交割卷的条件!';
                $this->ajaxReturn($return,'json');
                exit;
            }
            $cutBalance = $balance/2;
            $halfBalance = number_format($cutBalance, 2, '.', '');
            //页面显示的总额
            $m_balance_t = $halfBalance+$user['balance_e'];
            $m_balance_t = number_format($m_balance_t, 2, '.', '');
            //修改余额
            $data['balance'] = $halfBalance;
            $volumeModel = M('volume');
            $volumeModel->startTrans();
            $change = User::changeMemberData($uid,$data);
            //创建交割卷
            if($change){
                $volumeStr = mt_rand(10, 99).date("is").'?v='.$halfBalance;
                $volume = base64_encode($volumeStr); //加密   base64_decode解密
                $val['value'] = $halfBalance;
                $val['add_time'] = time();
                $val['user_id'] = $uid;
                $val['volume'] = $volume;
                $b = $volumeModel->add($val);
            }
            if($b){
               $volumeModel->commit();
                $return['msg'] = '交割卷已生成!';
                $return['code'] = 1;
                $return['data']['balance'] = $halfBalance; 
                $return['data']['m_balance_t'] = $m_balance_t;
                $return['data']['volume'] = $volume; 
                $this->ajaxReturn($return,'json');
                exit;
            }else{
                $volumeModel->rollback();
                $return['msg'] = '生成交割卷失败!';
                $this->ajaxReturn($return,'json');
                exit;
            }

        }else{
            exit('非法操作！');
        }
    }


    /**
     *  发送邮件
     *
     */
    protected function sendEmail($email,$nickname,$link){
        
        //$link = $_SERVER['HTTP_HOST']."/home/member/activation?token={$token}";
        $str =  '<p>您好！</p>'.
                '<p>感谢您注册帐户！</p>'.
                '<p>帐户需要激活才能使用，赶紧激活成为SDC的正式一员吧:)</p>'.
                '<p>点击下面的链接立即激活帐户(或将网址复制到浏览器中打开):</p>'.
                '<a href="'.$link.'">'.$link.'</a>';
        
        $subject = 'SDC-激活邮件';
        $fromName = 'SDC官网';
        $result = send_email($email,$subject,$str,$fromName);//新方法
        return $result;

    }
    

}