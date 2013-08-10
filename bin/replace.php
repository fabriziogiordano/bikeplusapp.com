<?php
$index = file_get_contents('httpdocs/index.php');
$index = str_replace('../../', '../', $index);
file_put_contents('httpdocs/index.php', $index);