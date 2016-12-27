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

    private function getMobSetting(){
        //获取参数
        $mp['mobaopay_apiname_pay'] = C('MOBPAY.API_NAME_PAY');
        $mp['mobaopay_api_version'] = C('MOBPAY.API_VERSION');
        $mp['platform_id']          = C('MOBPAY.PLATFORM_ID');
        $mp['merchant_acc']         = C('MOBPAY.MERCHANT_ACC');
        $mp['merchant_notify_url']  = C('MOBPAY.NOTTIFY_URL');
        $mp['mbp_key']              = C('MOBPAY.MBP_KEY');
        $mp['mobaopay_gateway']     = C('MOBPAY.MBP_GATEWAY');
        return $mp;
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

        $order = M('order');

        $order->shop_name = 'SDC星钻币';
        $order->shop_type = 'SDC'; //最大五个字符 可修改数据库
        $order->shop_num = $num;
        $order->shop_price = $price;
        $order->shop_total = $total;
        $order->user_id = $user['id'];
        $order->status = 1;
        $order->add_time = time();
        $order->update_time = time();
        $order->order_no = $this->build_order_no();


        // 请求数据赋值
        $data = "";
        //商户订单号
        $data['orderNo'] = $order->order_no;
        // 商户订单日期
        $data['tradeDate'] = date('Ymd',$order->add_time);
        // 商户交易金额
        $data['amt'] = 0.01;//0.01为测试  实际 $order->shop_total
        // 商户参数
        $data['merchParam'] = 'SDCforver';//$_POST["merchParam"];
        // 商户交易摘要
        $data['tradeSummary'] = 'SDC星钻币';//$_POST["tradeSummary"];

        $lastId = $order->add();
        if($lastId){
            $mp = $this->getMobSetting();

            // 商户APINMAE，WEB渠道一般支付
            $data['apiName'] = $mp['mobaopay_apiname_pay'];
            // 商户API版本
            $data['apiVersion'] = $mp['mobaopay_api_version'];
            // 商户在Mo宝支付的平台号
            $data['platformID'] = $mp['platform_id'];
            // Mo宝支付分配给商户的账号
            $data['merchNo'] = $mp['merchant_acc'];
            // 商户通知地址
            $data['merchUrl'] = U('order/callback@'.$_SERVER['HTTP_HOST']);//$mp['merchant_notify_url'];
            // 银行代码，不传输此参数则跳转Mo宝收银台
            $data['bankCode'] = 'Mobaopay';
            
            // 对含有中文的参数进行UTF-8编码
            // 将中文转换为UTF-8
            if(!preg_match("/[\xe0-\xef][\x80-\xbf]{2}/", $data['merchUrl']))
            {
            $data['merchUrl'] = iconv("GBK","UTF-8", $data['merchUrl']);
            }
            
            if(!preg_match("/[\xe0-\xef][\x80-\xbf]{2}/", $data['merchParam']))
            {

            $data['merchParam'] = iconv("GBK","UTF-8", $data['merchParam']);
            }

            if(!preg_match("/[\xe0-\xef][\x80-\xbf]{2}/", $data['tradeSummary']))
            {
            $data['tradeSummary'] = iconv("GBK","UTF-8", $data['tradeSummary']);
            }
            
            // 初始化
            $cMbPay = new \MbPay($mp['mbp_key'], $mp['mobaopay_gateway']);
            // 准备待签名数据
            $str_to_sign = $cMbPay->prepareSign($data);
            // 数据签名
            $sign = $cMbPay->sign($str_to_sign);
            $data['signMsg'] = $sign;

            // 生成表单数据
            echo $cMbPay->buildForm($data, $mp['mobaopay_gateway']);

        }
    }


    //支付的回调
    public function callback(){
        // 请求数据赋值
        $data = "";
        $data['apiName'] = $_REQUEST["apiName"];
        // 通知时间
        $data['notifyTime'] = $_REQUEST["notifyTime"];
        // 支付金额(单位元，显示用)
        $data['tradeAmt'] = $_REQUEST["tradeAmt"];
        // 商户号
        $data['merchNo'] = $_REQUEST["merchNo"];
        // 商户参数，支付平台返回商户上传的参数，可以为空
        $data['merchParam'] = $_REQUEST["merchParam"];
        // 商户订单号
        $data['orderNo'] = $_REQUEST["orderNo"];
        // 商户订单日期
        $data['tradeDate'] = $_REQUEST["tradeDate"];
        // Mo宝支付订单号
        $data['accNo'] = $_REQUEST["accNo"];
        // Mo宝支付账务日期
        $data['accDate'] = $_REQUEST["accDate"];
        // 订单状态，0-未支付，1-支付成功，2-失败，4-部分退款，5-退款，9-退款处理中
        $data['orderStatus'] = $_REQUEST["orderStatus"];
        // 签名数据
        $data['signMsg'] = $_REQUEST["signMsg"];

        if(empty($data)){
            exit('警告，非法入侵！');
        }

        if(empty($this->userinfo)){
            $this->error('您还没有登录，请先登录！',U('index/signin'));
        }
        $where['id'] = $this->userinfo['id'];
        $field = 'id,balance,balance_e,status';
        $userClass = new User();
        $user = $userClass->getUser($where,$field);
        if($user['status'] == 0){
            $this->error('您的账号还没有激活，请前往邮箱激活！');
        }

        $mp = $this->getMobSetting();

        $field = 'id,status,user_id,shop_num';
        $map['user_id'] = $user['id'];
        $map['order_no'] = $data['orderNo'];
        $userClass = new User();
        $order = $userClass->getOrder($map, $field);
        if(empty($order)){
            $this->error('该订单已不存在！');
        }
        if($order['status'] > 1){
            $this->success('该商品已经付过款了！',U('member/memberInfo'));
        }
        // 初始化
        $cMbPay = new \MbPay($mp['mbp_key'], $mp['mobaopay_gateway']);
        // 准备准备验签数据
        $str_to_sign = $cMbPay->prepareSign($data);
        // 验证签名
        $resultVerify = $cMbPay->verify($str_to_sign, $data['signMsg']);
        //var_dump($data);
        if ($resultVerify) 
        {
            if ('1' == $_REQUEST["notifyType"]) {
                //$url = "notify.php";
                //Header("Location: $url");
                return true;
            }
            
            if ($data['orderStatus'] == '0')
            {
                exit('支付失败。状态：['.$data['orderStatus'].']'); //echo "未处理[".$data['orderStatus']."]";
            }
            else if ($data['orderStatus'] == '1')// 需更新商户系统订单状态
            {   
                $rd['status'] = 2;
                $orderM = M('order');
                $orderM->startTrans();
                //修改订单状态
                $s = $orderM->where($map)->save($rd);
                if($s){
                    $num = $order['shop_num'];
                    $balance_e = $user['balance_e'];
                    // 修改用户余额balance
                    $hadBalance = $user['balance'];
                    $balance = number_format($num, 2, '.', '');
                    $balance += $hadBalance;
                    // 检查待用余额[购买大于待用余额的数量 将把待用余额加入可用余额并将待用清空] balance_e 
                    if($balance_e < $balance || $balance_e == $balance){
                        $balance += $balance_e;
                        $data_e['balance_e'] = 0;
                        $userClass->changeMemberData($user['id'],$data_e);
                    }
                    $data['balance'] = $balance;
                    $b = $userClass->changeMemberData($user['id'],$data);
                    if($b){
                        $orderM->commit();
                        $this->success('支付成功，请核对您的可用余额！',U('member/memberInfo'));
                    }else{
                        $orderM->rollback();
                        exit('支付成功，但发生不可预期的错误，请联系网站管理员！');
                    }
                }
                
            }
            else if ($data['orderStatus'] == '2')// 需更新商户系统订单状态
            {
                //echo "失败[".$data['orderStatus']."]";
                $this->error('支付失败，请重新购买！',U('index/buy'));

            }
            else if ($data['orderStatus'] == '4')// 需更新商户系统订单状态
            {
                exit('支付失败。状态：['.$data['orderStatus'].']'); //echo "部分退货[".$data['orderStatus']."]";
            }
            else if ($data['orderStatus'] == '5')// 需更新商户系统订单状态
            {
                exit('支付失败。状态：['.$data['orderStatus'].']'); //echo "全部退货[".$data['orderStatus']."]";
            }
            else if ($data['orderStatus'] == '9')// 需更新商户系统订单状态
            {
                exit('支付失败。状态：['.$data['orderStatus'].']'); //echo "退款处理中[".$data['orderStatus']."]";
            }
            else if ($data['orderStatus'] == '11')
            {
                exit('支付失败。状态：['.$data['orderStatus'].']'); //echo "订单过期[".$data['orderStatus']."]";
            }
            else
            {
                exit('支付失败。状态：['.$data['orderStatus'].']'); //echo "其他[".$data['orderStatus']."]";
            }

            /*商户需要在此处判定通知中的订单状态做后续处理*/
            /*由于页面跳转同步通知和异步通知均发到当前页面，所以此处还需要判定商户自己系统中的订单状态，避免重复处理。*/
            
            return true;
        }
        else
        {
            // 签名验证失败
            exit("验证签名失败");
            return false;
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