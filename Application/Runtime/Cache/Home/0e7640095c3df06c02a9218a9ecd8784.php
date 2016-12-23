<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<!--[if IE 9 ]>    <html class="ie9"> <![endif]-->
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SDC-FOREVER</title>
<meta name="description" content="Archer - Responsive Landing Page">

<!--Favicon-->
<link rel="apple-touch-icon" sizes="57x57" href="/Public/Home/img/favicons/apple-touch-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/Public/Home/img/favicons/apple-touch-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/Public/Home/img/favicons/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/Public/Home/img/favicons/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/Public/Home/img/favicons/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/Public/Home/img/favicons/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/Public/Home/img/favicons/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/Public/Home/img/favicons/apple-touch-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/Public/Home/img/favicons/apple-touch-icon-180x180.png">
<link rel="icon" type="image/png" href="/Public/Home/img/favicons/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="/Public/Home/img/favicons/android-chrome-192x192.png" sizes="192x192">
<link rel="icon" type="image/png" href="/Public/Home/img/favicons/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="image/png" href="/Public/Home/img/favicons/favicon-16x16.png" sizes="16x16">
<link rel="manifest" href="/Public/Home/img/favicons/manifest.json">
<link rel="shortcut icon" href="/Public/Home/img/favicons/favicon.ico">
<meta name="msapplication-TileColor" content="#2b5797">
<meta name="msapplication-TileImage" content="/Public/Home/img/favicons/mstile-144x144.png">
<meta name="msapplication-config" content="/Public/Home/img/favicons/browserconfig.xml">
<meta name="theme-color" content="#ffffff">

<!--Favicon end-->

<link href="/Public/Home/css/bootstrap.min.css" rel="stylesheet">
<link href="/Public/Home/css/font-awesome.min.css" rel="stylesheet">
<link href="/Public/Home/css/magnific-popup.css" rel="stylesheet">
<link href="/Public/Home/css/owl.carousel.css" rel="stylesheet">
<link href="/Public/Home/css/main.css" rel="stylesheet">
<style type="text/css" media="screen">
  *{font-family: "微软雅黑"}
  .font-fff{color: #ffffff}
</style>
</head>
<body>

<!--hero section-->

<header class="hero-section"> 
  
  <!--navigation-->
  
  <nav class="navbar navbar-default" data-spy="affix" data-offset-top="450">
    <div class="container">
      <div class="navbar-header"> <a class="navbar-brand" href=""><img class="logo" alt="logo" src="/Public/Home/img/logo.svg"><img class="logo-nav" alt="logo-nav" src="/Public/Home/img/logo-nav.svg"></a> </div>
      <ul class="nav navbar-nav navbar-right">
        <li class="hidden-xs hidden-sm"><a href="<?php echo U('/');?>#company">公司简介</a></li>
        <li class="hidden-xs hidden-sm"><a href="<?php echo U('/');?>#introduction">产品概述</a></li>
        <li class="hidden-xs hidden-sm"><a href="<?php echo U('/');?>#sdc">SDC</a></li>
        <li class="hidden-xs hidden-sm"><a href="<?php echo U('index/buy');?>">购买</a></li>
        <li class="hidden-xs hidden-sm"><a href="<?php echo U('member/memberInfo');?>">用户中心</a></li>
        <?php if(session('uid')): ?><li><a href="javascript:"><?php echo session('nickname');?></a></li>
        <li class="hidden-xs"><a href="<?php echo U('member/logout');?>"  class="btn btn-nav">退出</a></li>
        <?php else: ?>
        <li class="hidden-xs"><a href="<?php echo U('index/signin');?>">登录</a></li>
        <li><a href="<?php echo U('index/signup');?>" class="btn btn-nav">注册</a></li><?php endif; ?>
        <li class="hidden-md hidden-lg"><a id="toggle"><i class="fa fa-bars fa-2x"></i><i class="fa fa-times fa-2x"></i></a></li>
      </ul>
    </div>
  </nav>
  
  <!--navigation end--> 
  
  <!--mobile navigation-->
  
  <div class="mobile-nav-overlay hidden-md hidden-lg" id="mobile-nav-overlay">
    <nav class="mobile-nav">
      <ul>
        <li><a href="<?php echo U('/');?>#company">公司简介</a></li>
        <li><a href="<?php echo U('/');?>#introduction">产品概述</a></li>
        <li><a href="<?php echo U('/');?>#sdc">SDC</a></li>
        <li><a href="<?php echo U('index/buy');?>">购买</a></li>
        <li><a href="<?php echo U('member/memberInfo');?>">用户中心</a></li>
        <?php if(session('uid')): ?><li class="hidden-xs"><a href="javascript:"><?php echo session('nickname');?></a></li>
        <li><a href="<?php echo U('member/logout');?>">退出</a></li>
        <?php else: ?>
        <li class="hidden-xs"><a href="<?php echo U('index/signin');?>">登录</a></li><?php endif; ?>
      </ul>
    </nav>
  </div>
  
  <!--mobile navigation end--> 
  
  
  <!--welcome message-->
  
  <section class="container text-center welcome-message welcome-message-imp" id="home">
    <!-- <div class="row">
      <div class="col-md-12" style="height: 200px">
        <h1>Do you like diamonds?</h1>
        <h2 style="font-style:italic;font-weight: normal;">Welome to NSDC</h2>
        <a href="signup.html" class="btn btn-cta-hero">EXPLORE MORE...</a>
      </div>
    </div> -->
  </section>
  
  <!--welcome message end--> 

</header>

<!--hero section end <?php ?> -->


<!--learn more-->

<div class="learn-more section-spacing section-spacing2">
  <div class="container">
    <div class="row">
      <div class="col-md-6 sdc-user-left">
        <div>
            
          <ul>
            <li class="user-left-li"><a href="<?php echo U(memberInfo);?>" <?php if($active == 'info'): ?>class="li-choose"<?php endif; ?>>我的账户</a></li>
            <li class="user-left-li"><a href="<?php echo U(memberPwd);?>" <?php if($active == 'pwd'): ?>class="li-choose"<?php endif; ?>>修改密码</a></li>
          </ul>
        </div>

      </div>
      <div class="col-md-6 sdc-user-right">

        <div class="sdc-email-notice">
          <?php if($emailGo == 2): ?><div class="alert alert-warning alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                &times;
              </button>
              您的邮箱还未激活，请前往邮箱激活！
            </div>
          <?php elseif($emailGo == 1): ?>

            <div class="alert alert-warning alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                &times;
              </button>
              <a href="<?php echo ($link); ?>" class="alert-link">激活时间已过，点击重新发送激活邮件！</a>
            </div>

          <?php else: endif; ?>
        </div>
        <div class="user-right-top">
            <div class="yue pull-left">
                <p>总资产</p>
                <span id="m_balance_t"><?php echo number_format($balance+$balance_e, 2, '.', '');?></span>
                <a class="btn-out" href="<?php echo U('member/turnOut');?>">转出</a>
            </div>
            <div class="niansy pull-left">
                <p>年收益</p>
                <h2><?php echo ($income*100); ?>%</h2>
            </div>
            <?php if($canCreate == 2): ?><div class="jgj pull-left" id="create">
                  <p>交割卷</p>
                  <h2>立即生成</h2>
              </div>
            <?php else: ?>
              <div class="jgj-hide pull-left">
                  <p>交割卷</p>
                  <h2>立即生成</h2>
              </div><?php endif; ?>
        </div>
        <div style="width: 100%;clear: both"></div>

        <div class="user-right-mid">
          <p>可用资产：<span class="font_red" id="m_balance"><?php echo ($balance); ?></span></p>
        </div>

        <div class="user-daiyong">
          <p class="ssp-p">待用资产：<span class="font_red" id="m_balance_e"><?php echo ($balance_e); ?></span>
            <a class="btn user-balance-buy" href="<?php echo U('index/buy');?>">购买</a>
            <a href="<?php echo U('member/checkListOut');?>">转出/入记录</a>
          </p>
          <p class="ssp-p2">(待用资产指别人转入到您账户上的资产，若您想启用这笔资产，请在官网购买同等数量的资产)</p>
        </div>

        <div class="user-right-mid user-jgj-small">
          <p>交割卷：<span id="m_volume"></span><a href="<?php echo U('member/checkVolume');?>">查看</a></p>
        </div>

        <div class="user-right-bot">
          <p>购买记录</p>
          <table>
            <tr align="center" class="table-header">
              <td>时间</td>
              <td>资产类型</td>
              <td>价格(元)</td>
              <td>数量</td>
              <td>金额(元)</td>
              <td>状态</td>
            </tr>
            <?php if(is_array($list)): foreach($list as $key=>$var): ?><tr align="center">
              <td><?php echo date('Y/m/d',$var['add_time']);?></td>
              <td><?php echo ($var['shop_type']); ?></td>
              <td><?php echo ($var['shop_price']); ?></td>
              <td><?php echo ($var['shop_num']); ?></td>
              <td><?php echo ($var['shop_total']); ?></td>
              <td><?php if($var['status'] == 1): ?>未付款<?php elseif($var['status'] == 2): ?>交易成功<?php endif; ?></td>
            </tr><?php endforeach; endif; ?>
            <tr>
              <td align="center" colspan="6"><?php echo ($page); ?></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!--learn more end--> 

<!--Copyright terms-->

<footer class="copyright-terms">
  <div class="container">
    <div class="row">
      <!-- <small> &copy; 2016 Archer. All rights reserved.</small>  -->
      
    </div>
  </div>
</footer>

<!--Copyright terms end--> 

<script src="/Public/Home/js/jquery-2.2.1.min.js"></script> 
<script src="/Public/Home/js/bootstrap.min.js"></script> 
<script src="/Public/Home/js/jquery.magnific-popup.min.js"></script> 
<script src="/Public/Home/js/owl.carousel.min.js"></script> 
<script src="/Public/Home/js/jquery.waypoints.min.js"></script> 
<script src="/Public/Home/js/jquery.animateNumber.min.js"></script> 
<script src="/Public/Home/js/jquery.ajaxchimp.min.js"></script> 
<script src="/Public/Home/js/tweetie.min.js"></script> 
<!--[if IE 9]>
<script src="js/placeholders.min.js"></script>
<![endif]--> 
<script src="/Public/Home/js/main.js"></script> 
<!-- 
<script async src="http://platform.twitter.com/widgets.js"></script> 
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script> 

<script src="/Public/Home/js/gmap.js"></script> -->

<script src="/Public/Home/js/retina.min.js"></script>
</body>

<script type="text/javascript">
  function checkInt(o){ 
    var theV,theP;
    var num = document.getElementById('num');
    var onePrice = document.getElementById('onePrice');
    var payable = document.getElementById('payable');
    theV = isNaN(parseInt(o.value))?0:parseInt(o.value); 
    if(theV != o.value){
      o.value = theV;
    } 
    theP = num.value*onePrice.innerHTML;
    payable.value = theP.toFixed(2);
  } 


  $(function(){
    $('#create').click(function(){
        var purl = "<?php echo U('member/createVolume');?>";
        $.ajax({
           type: "POST",
           url: purl,
           data: "uid=<?php echo ($uid); ?>",
           success: function(result){
              if(result.code == 1){
                $("#m_balance_t").text(result.data.m_balance_t);
                $("#m_balance").text(result.data.balance);
                $("#m_volume").text(result.data.volume);
              }
              alert(result.msg);
           }
        });
    });
    
  });
</script>
</html>