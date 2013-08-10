<?php
include 'bin/clicolor.php';
$colors = new Colors();
echo $colors->getColoredString("Publishing: $lang", "green", "light_green") . "\n";

$csv = 'https://docs.google.com/spreadsheet/pub?key=0AoVR4wFeDQrYdDU4WlN2TmhSeXhCY1M0ZVpIcVVyYnc&single=true&gid=0&output=csv';

$row = -1;
$lang = array();
$translations = array();

file_put_contents('bin/langimporter.txt', file_get_contents($csv));
if(($handle = fopen('bin/langimporter.txt', 'r')) !== FALSE) {
  while(($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
    $row++;
    $num = count($data);

    if($row == 0) {
      for($c = 0; $c < $num; $c++) {
        if($c == 0) continue;
        $lang[$c]['handle'] = fopen('subdomains/dev/application/language/'.$data[$c].'/web_lang.php', 'w');
        fwrite($lang[$c]['handle'], "<?php\n");
      }
      continue;
    }

    for($c = 0; $c < $num; $c++) {
      if($c == 0) continue;
      fwrite($lang[$c]['handle'], '$lang[\''.$data[0].'\'] = \''.$data[$c].'\';'."\n");
    }


  }
  fclose($handle);
}