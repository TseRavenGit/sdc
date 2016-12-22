<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!--[if IE 9 ]>    <html class="ie9"> <![endif]-->
<html class="sl-page">
<head>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,700italic,800,800italic,300italic,300" rel="stylesheet">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SDCFORVER</title>
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
</head>
<body class="sl-page">

<!--content wrapper-->
<div class="content-wrapper"> 
  
  <!--logo-->
  
  <div class="logo-sl-page text-center"> <a href=""><img src="/Public/Home/img/logo.svg" alt="logo"></a> </div>
  
  <!--logo end--> 
  
  <!--cta signup form-->
  
  <section class="cta-form cta-light section-spacing">
    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-md-5 center-block">
          <form id="cta-signup-form" action="<?php echo U('member/register');?>" method="post" class="cta-signup-form">
            <header class="section-header text-center">
              <h2>注册用户</h2>
            </header>
            <div class="form-group">
              <input type="text" class="form-control input-lg" id="input-name" name="nickname" placeholder="昵称" required>
              <label for="input-name"><span class="required">*</span>输入的您的昵称或者姓名</label>
            </div>
            <div class="form-group">
              <input type="email" class="form-control input-lg" id="input-email" name="email" placeholder="邮箱地址" required>
              <label for="input-email"><span class="required">*</span>我们将会往改邮箱发送激活邮件</label>
            </div>
            <div class="form-group">
              <input type="password" class="form-control input-lg" id="input-password" name="password" placeholder="密码" pattern=".{6,20}" required>
              <label for="input-password"><span class="required">*</span>6-20个字符</label>
            </div>
            <!-- <div class="checkbox text-right">
              <label>
                <input type="checkbox">
                Signup to our newletter </label>
            </div> -->
            <div class="form-btn">
              <button type="submit" class="btn">确定注册</button>
              <!-- <p class="form-terms">By clicking sign up you agree to our <a href="" data-toggle="modal" data-target="#modal-terms">Terms</a> and read our <a href="" data-toggle="modal" data-target="#modal-terms">Privacy Policy</a>.</p> -->
            </div>
            <h3 class="text-center">您已经有账户了？请点击 <a href="<?php echo U('signin');?>">登录</a></h3>
          </form>
        </div>
      </div>
    </div>
  </section>
  
  <!--cta signup form end--> 
  
  <!--Copyright terms-->
  
  <footer class="copyright-terms">
  <div class="container">
    <div class="row">
      <!-- <small> &copy; 2016 Archer. All rights reserved.</small>  -->
      
    </div>
  </div>
</footer>
  
  <!--Copyright terms end--> 
  
</div>

<!--content wrapper end--> 


<script src="/Public/Home/js/jquery-2.2.1.min.js"></script> 
<script src="/Public/Home/js/bootstrap.min.js"></script> 
<script src="/Public/Home/js/jquery.magnific-popup.min.js"></script> 
<script src="/Public/Home/js/owl.carousel.min.js"></script> 
<script src="/Public/Home/js/jquery.waypoints.min.js"></script> 
<script src="/Public/Home/js/jquery.animateNumber.min.js"></script> 
<script src="/Public/Home/js/jquery.ajaxchimp.min.js"></script> 
<!-- <script src="/Public/Home/js/tweetie.min.js"></script>  -->
<!--[if IE 9]>
<script src="/Public/Home/js/placeholders.min.js"></script>
<![endif]--> 
<script src="/Public/Home/js/main.js"></script> 
<script src="/Public/Home/js/retina.min.js"></script>
</body>
</html>