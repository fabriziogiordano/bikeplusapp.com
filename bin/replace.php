<?php
$index = file_get_contents('httpdocs/index.php');
$index = str_replace('../../', '../', $index);
file_put_contents('httpdocs/index.php', $index);

$welcome = file_get_contents('httpdocs/application/controllers/welcome.php');
$welcome = str_replace('../../', '../../subdomains/', $welcome);
file_put_contents('httpdocs/application/controllers/welcome.php', $welcome);