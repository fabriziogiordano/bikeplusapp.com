#!/usr/bin/php
<?php
$url = 'http://nycbikeplus.com/fetch';
$ch = curl_init($url);
curl_exec($ch);
curl_close($ch);