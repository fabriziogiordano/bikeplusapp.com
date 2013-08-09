<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if($_SERVER['SERVER_NAME'] == 'nycbikeplus.com' || $_SERVER['SERVER_NAME'] == 'www.nycbikeplus.com' || $_SERVER['SERVER_NAME'] == 'beta.nycbikeplus.com') {
	$config['env']                      = 'prod';
	$config['language']                 = 'nycbikeplus';
	$config['facebook_appid']           = '177446295767523';
	$config['bikeplus_shareurl']        = 'nycbikeplus.com';
	$config['google_map_key']           = 'AIzaSyBFATtfUwn9atJCxlIzp_b8s9r4FCMUSj8';
	$config['google_analytics_ua']      = 'UA-137286-31';
	$config['google_analytics_domain']  = 'nycbikeplus.com';
}
elseif($_SERVER['SERVER_NAME'] == 'dev.nycbikeplus.com') {
	$config['env']                      = 'dev';
	$config['language']                 = 'nycbikeplus';
	$config['facebook_appid']           = '177446295767523';
	$config['bikeplus_shareurl']        = 'nycbikeplus.com';
	$config['google_map_key']           = 'AIzaSyBFATtfUwn9atJCxlIzp_b8s9r4FCMUSj8';
  $config['google_analytics_ua']      = 'UA-137286-31';
  $config['google_analytics_domain']  = 'nycbikeplus.com';
}
elseif($_SERVER['SERVER_NAME'] == 'mibikeplus.com' || $_SERVER['SERVER_NAME'] == 'www.mibikeplus.com') {
	$config['env']                      = 'prod';
	$config['language']                 = 'mibikeplus';
	$config['facebook_appid']           = '563983106993340';
	$config['bikeplus_shareurl']        = 'mibikeplus.com';
	$config['google_map_key']           = 'AIzaSyA4kN6SMApuWPa896eb4CmQnFlUTEhm6_M';
  $config['google_analytics_ua']      = 'UA-137286-32';
  $config['google_analytics_domain']  = 'mibikeplus.com';
}
elseif($_SERVER['SERVER_NAME'] == 'dev.mibikeplus.com') {
	$config['env']                      = 'dev';
	$config['language']                 = 'mibikeplus';
	$config['facebook_appid']           = '563983106993340';
	$config['bikeplus_shareurl']        = 'mibikeplus.com';
  $config['google_map_key']           = 'AIzaSyA4kN6SMApuWPa896eb4CmQnFlUTEhm6_M';
  $config['google_analytics_ua']      = 'UA-137286-32';
  $config['google_analytics_domain']  = 'mibikeplus.com';
}
else {
	die('No config loaded');
}