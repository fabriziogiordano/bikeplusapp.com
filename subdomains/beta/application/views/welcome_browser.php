<!DOCTYPE html>
<!--[if IEMobile 7 ]>  <html class="no-js iem7"> <![endif]-->
<!--[if (gt IEMobile 7)|!(IEMobile)]><!--> <html class="no-js"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <title><?php echo lang('head_title');?></title>
  <meta name="description" content="">
  <meta name="HandheldFriendly" content="True">
  <meta name="MobileOptimized" content="320">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
  <meta http-equiv="cleartype" content="on">
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/assets/mobile/img/touch/apple-touch-icon-144x144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/assets/mobile/img/touch/apple-touch-icon-114x114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/assets/mobile/img/touch/apple-touch-icon-72x72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="/assets/mobile/img/touch/apple-touch-icon-57x57-precomposed.png">

  <!-- <link rel="shortcut icon" href="/assets/mobile/img/touch/apple-touch-icon.png"> -->

  <link href='http://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900' rel='stylesheet' type='text/css'>
  <link href='/assets/css/style.desktop.css?v=<?= $version['css'] ?>' rel='stylesheet' type='text/css'>
  <style type="text/css">
    html {
      background: url('/assets/img/bg-<?php echo lang('site');?>.jpg') no-repeat center center fixed;
    }
  </style>
</head>
<body>
  <div id="header"><h1><span class="icon-bicycle"></span> <?php echo lang('web_title');?></h1></div>
  <div id="content">
    <div id="phone"><img src="/assets/img/mobile.png" alt="<?php echo lang('web_title');?> WEBAPP"></div>
    <h2><?php echo lang('web_summary');?></h2>
    <p><?php echo lang('web_url');?></p>
  </div>
</body>
</html>