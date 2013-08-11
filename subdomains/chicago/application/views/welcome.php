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
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="//<?= $assets['path'] ?>assets.bikeplusapp.com/img/touch/apple-touch-icon-144x144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="//<?= $assets['path'] ?>assets.bikeplusapp.com/img/touch/apple-touch-icon-114x114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="//<?= $assets['path'] ?>assets.bikeplusapp.com/img/touch/apple-touch-icon-72x72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="//<?= $assets['path'] ?>assets.bikeplusapp.com/mobile/img/touch/apple-touch-icon-57x57-precomposed.png">
  <!-- <link rel="shortcut icon" href="//<?= $assets['path'] ?>assets.bikeplusapp.com/mobile/img/touch/apple-touch-icon.png"> -->

  <meta name="apple-mobile-web-app-capable" content="no">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">

  <link href='//<?= $assets['path'] ?>assets.bikeplusapp.com/css/style.css?v=<?= $assets['css'] ?>' rel='stylesheet' type='text/css'>

</head>
<body>
<div id="portrait">
  <div id="search"><span><?php echo lang('mobile_cancel');?></span><input id="targetinput" type="text" value="" /></div>
  <div id="searchcontent">Adding more point of interest</div>
  <header><h1><i><?php echo lang('mobile_city');?></i><span class="icon-bicycle"></span><strong>+</strong></h1></header>
  <div id="menu"><img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"><span class="icon-list"></span></div>
  <div id="menulist"></div>
  <div id="timer"><strong class="time"></strong><span class="icon-stopwatch"></span><span class="icon-cycle"></span></div>
  <div id="timerlist"></div>
  <div id="parseTime"><?php echo lang('mobile_loading');?></div>
  <div id="resetlocation"><span class="icon-location-2"></span></div>
  <div id="bookmarks"><span class="icon-bookmark"></span></div>
  <div id="bookmarkscontent"></div>
  <div id="mapbikes"></div>
  <div id="dock"></div>
</div>
<div id="landscape">
  <h1><span class="icon-bicycle"></span> <?php echo lang('mobile_title');?> </h1>
  <div id="timing">00 : 00</div>
</div>
<div id="fb-root"></div>

<script src="//<?= $assets['path'] ?>assets.bikeplusapp.com/js/vendor/concatenate.doT.promise.moment.min.js?v=<?= $assets['js'] ?>"></script>
<script>
bikeplusoptions = {};
bikeplusoptions.lang     = {
  mobile_js_logout     : '<?php echo lang('mobile_js_logout'); ?>',
  mobile_js_ride_start : '<?php echo lang('mobile_js_ride_start'); ?>',
  mobile_js_ride_starting : '<?php echo lang('mobile_js_ride_starting'); ?>',
  mobile_js_ride_finish : '<?php echo lang('mobile_js_ride_finish'); ?>',
  mobile_dockdistanceratio : <?php echo lang('mobile_dockdistanceratio'); ?>,
  mobile_js_bookmarks_added : '<?php echo lang('mobile_js_bookmarks_added'); ?>',
  mobile_js_global_lat : <?php echo lang('mobile_js_global_lat'); ?>,
  mobile_js_global_lng : <?php echo lang('mobile_js_global_lng'); ?>,

};
bikeplusoptions.shareurl = '<?php echo lang('site'); ?>'+'.bikeplusapp.com';
bikeplusoptions.fbappid  = '<?php echo $this->config->item('facebook_appid'); ?>';
bikeplusoptions.data            = <?php echo $json; ?>;
bikeplusoptions.data.fetched    = Date.now();
</script>
<?php if($assets['path']) : ?>
<script src="//<?= $assets['path'] ?>assets.bikeplusapp.com/js/tmpl.js?v=<?= $assets['js'] ?>"></script>
<script src="//<?= $assets['path'] ?>assets.bikeplusapp.com/js/app.js?v=<?= $assets['js'] ?>"></script>
<?php else: ?>
<script src="//<?= $assets['path'] ?>assets.bikeplusapp.com/js/app.min.js?v=<?= $assets['js'] ?>"></script>
<?php endif ?>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $this->config->item('google_map_key'); ?>&v=3.exp&sensor=false&callback=BikePlus.mapInit&libraries=places"></script>

<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', '<?php echo $this->config->item('google_analytics_ua'); ?>', '<?php echo $this->config->item('google_analytics_domain'); ?>');
ga('send', 'pageview');
</script>

</body>
</html>