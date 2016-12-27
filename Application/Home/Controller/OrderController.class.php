<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\User;
class OrderController extends Controller {
    protected $userinfo;
    public function __construct(){
            parent::__construct();
            Vendor('MobPay.MobaoPayClass');
            
            $this->checkLogin();
    }

    protected function checkLogin(){
        $uid = session('uid');
        $nickname = session('nickname');
        if($uid && $nickname){
            $this->userinfo['id'] = $uid;
            $this->userinfo['nickname'] = $nickname;
            return $this->userinfo;
        }
    }


    public function buy(){

        if(empty($this->userinfo)){
            $this->error('您还没有登录，请先登录！',U('index/signin'));
        }
        $num = I('post.shop_num'); //购买数量
        $price = I('post.shop_price');//单价
        $payable = I('post.payable');//应付金额
        
        if(empty($num) || empty($price) || empty($payable)){
            $this->error('未知错误，请重新购买！');
        }
        if($num < 100 || $num == 0){
            $this->error('数量错误，请重新购买！');
        }


        $where['id'] = $this->userinfo['id'];
        $field = 'id,balance,balance_e,status';
        $userClass = new User();
        $user = $userClass->getUser($where,$field);
        if($user['status'] == 0){
            $this->error('您的账号还没有激活，请前往邮箱激活！');
        }

        $total = $price*$num;
        if($num > 10000){
          $total = $total*0.95;
        }else if($num > 50000){
          $total = $total*0.92;
        }else if($num > 100000){
          $total = $total*0.88;
        }
        $total = number_format($total, 2, '.', '');


        $order = D('order');
        //开启事物
        $order->startTrans();
        if (!$order->create()){
            $this->error($order->getError());
        }

        $balance_e = $user['balance_e'];
        $order->shop_name = 'SDC星钻币';
        $order->shop_type = 'SDC'; //最大五个字符 可修改数据库
        $order->shop_total = $total;
        $order->user_id = $user['id'];
        $order->status = 1;
        $order->add_time = time();
        $order->update_time = time();
        $order->order_no = $this->build_order_no();

        $lastId = $order->add();
        if($lastId){
            // 修改用户余额
            $hadBalance = $user['balance'];
            $balance = number_format($num, 2, '.', '');
            $balance += $hadBalance;
            //检查待用余额balance_e
            if($balance_e < $balance || $balance_e == $balance){
                $balance += $balance_e;
                $data_e['balance_e'] = 0;
                $userClass->changeMemberData($user['id'],$data_e);
            }
            $data['balance'] = $balance;
            $b = $userClass->changeMemberData($user['id'],$data);
        }

        if ($b){
            // 提交事务
            $this->success('购买成功！',U('member/memberInfo'));
            $order->commit();
        }else{
            // 事务回滚
            $this->error('购买失败！');
            $order->rollback();
        }

    }


      /**
     * 生成唯一订单号
     */
    private function build_order_no(){
        $no = date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        //检测是否存在
        $db = M('order');
        $info = $db->where(array('order_no'=>$no))->find();
        if(!empty($info)){
            $no = $this->build_order_no();
        }
        return $no;
        
    }

}