<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\User;
class PayController extends Controller {

	public function _initialize() {

        Vendor('MobPay.MobaoPayClass');
    }

    private function getMobSetting(){
        //获取参数
        $mp['mobaopay_apiname_pay'] = C('MOBPAY.API_NAME_PAY');
		$mp['mobaopay_api_version'] = C('MOBPAY.API_VERSION');
		$mp['platform_id']		    = C('MOBPAY.PLATFORM_ID');
		$mp['merchant_acc']		    = C('MOBPAY.MERCHANT_ACC');
		$mp['merchant_notify_url']  = C('MOBPAY.NOTTIFY_URL');
		$mp['mbp_key']			    = C('MOBPAY.MBP_KEY');
		$mp['mobaopay_gateway']	    = C('MOBPAY.MBP_GATEWAY');
		return $mp;
    }


    public function pay(){

        $mp = $this->getMobSetting();
    	// 请求数据赋值
		$data = "";
		// 商户APINMAE，WEB渠道一般支付
		$data['apiName'] = $mp['mobaopay_apiname_pay'];
		// 商户API版本
		$data['apiVersion'] = $mp['mobaopay_api_version'];
		// 商户在Mo宝支付的平台号
		$data['platformID'] = $mp['platform_id'];
		// Mo宝支付分配给商户的账号
		$data['merchNo'] = $mp['merchant_acc'];
		// 商户通知地址
		$data['merchUrl'] = $mp['merchant_notify_url'];
		// 银行代码，不传输此参数则跳转Mo宝收银台
		$data['bankCode'] = 'Mobaopay';
		
		//商户订单号
		$data['orderNo'] = '20161220034109';//$_POST["orderNo"];
		// 商户订单日期
		$data['tradeDate'] = '20161222';//$_POST["tradeDate"];
		// 商户交易金额
		$data['amt'] = 0.01;//$_POST["amt"];
		// 商户参数
		$data['merchParam'] = 'SDCforver';//$_POST["merchParam"];
		// 商户交易摘要
		$data['tradeSummary'] = '购买sdc';//$_POST["tradeSummary"];
		
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
		
		//$cMbPay->mobaopayOrder($data);
    }



    /*public function callback(){

        $mp = $this->getMobSetting();
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

		//print_r( $data);
		// 初始化
		$cMbPay = new MbPay($mp['mbp_key'], $mp['mobaopay_gateway']);
		// 准备准备验签数据
		$str_to_sign = $cMbPay->prepareSign($data);
		// 验证签名
		$resultVerify = $cMbPay->verify($str_to_sign, $data['signMsg']);
		//var_dump($data);
		if ($resultVerify) 
		{
			if ('1' == $_REQUEST["notifyType"]) {
				$url = "notify.php";
				Header("Location: $url");
				return true;
			}
			// 签名验证通过
			echo "支付成功".'<br>';
			echo "商户订单号 ".$data['orderNo'].'<br>';
			echo "商户订单日期 ".$data['tradeDate'].'<br>';
			echo "商户参数 ".$data['merchParam'].'<br>';
			echo "Mo宝支付订单号 ".$data['accNo'].'<br>';
			echo "Mo宝支付账务日期 ".$data['accDate'].'<br>';
			echo "支付金额 ".$data['tradeAmt']."元".'<br>';
			echo "订单状态 ";
			
			if ($data['orderStatus'] == '0')
				echo "未处理[".$data['orderStatus']."]";
			else if ($data['orderStatus'] == '1')// 需更新商户系统订单状态
				echo "成功[".$data['orderStatus']."]";
			else if ($data['orderStatus'] == '2')// 需更新商户系统订单状态
				echo "失败[".$data['orderStatus']."]";
			else if ($data['orderStatus'] == '4')// 需更新商户系统订单状态
				echo "部分退货[".$data['orderStatus']."]";
			else if ($data['orderStatus'] == '5')// 需更新商户系统订单状态
				echo "全部退货[".$data['orderStatus']."]";
			else if ($data['orderStatus'] == '9')// 需更新商户系统订单状态
				echo "退款处理中[".$data['orderStatus']."]";
			else if ($data['orderStatus'] == '11')
				echo "订单过期[".$data['orderStatus']."]";
			else
				echo "其他[".$data['orderStatus']."]";

			/*商户需要在此处判定通知中的订单状态做后续处理*/
			/*由于页面跳转同步通知和异步通知均发到当前页面，所以此处还需要判定商户自己系统中的订单状态，避免重复处理。*/
	/*		
			return true;
		}
		else
		{
			// 签名验证失败
			echo "验证签名失败";
			return false;
		}
    }*/



}