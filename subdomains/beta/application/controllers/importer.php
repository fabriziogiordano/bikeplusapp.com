<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*

#!/usr/bin/php
<?php
date_default_timezone_set('UTC');

$date = time().'-'.date("Y-m-d-H-i-s");
$url  = 'http://citibikenyc.com/stations/json';
$path = '/home/fabrizio/Dropbox/Debian/CityBike/'.$date.'.json';

$fp = fopen($path, 'w');
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch,CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:21.0) Gecko/20100101 Firefox/21.0');
$data = curl_exec($ch);
curl_close($ch);
fclose($fp);

$ch = curl_init('http://localhost:90/importer');
curl_exec($ch);
curl_close($ch);

*/

class Importer extends CI_Controller {
  public function index() {
    $this->load->helper('directory');
    $this->load->library('zip');

    $this->db->save_queries = FALSE;
    $this->_parsed = null;
    if($_SERVER["DOCUMENT_ROOT"] == '/var/www/nycbikeforecast.com') {
        $citibikejsons = '/home/fabrizio/Dropbox/Debian/CityBike/';
    }
    else {
        $citibikejsons = '/Users/fabriziogiordano/Dropbox/Debian/CityBike/';
    }

    $citibikejsonsmap = directory_map($citibikejsons);
    $citibikejsonsmap = array_filter($citibikejsonsmap, function($js){
      if(!is_string($js)) return;
      return (substr($js, -4, 4) == 'json') ? true : false;
    });
    asort($citibikejsonsmap);
    echo "
<html>
<head>
  <title>Importer</title>
</head>
<body>
<script>
function toBottom() {
  window.scrollTo(0, document.body.scrollHeight);
}
</script>
";
    $i=0;
    $tot = count($citibikejsonsmap);
    //$this->db->truncate('stationBeanList');
    $data = array();
    foreach ($citibikejsonsmap as $citibikejson) {
      //if($i == 10) break;
      $i++;
      $json_raw = file_get_contents($citibikejsons.$citibikejson);
      $json = json_decode($json_raw, true);
      $parseTime = explode('-', $citibikejson, 2);
      $parseTime = $parseTime[0];

      echo $i.'/'.$tot. ' ' .count($json['stationBeanList']). ' : '.$parseTime.' : Memory: '. memory_get_usage() .'<br><script>toBottom(); document.title="'.$i.'/'.$tot.'"</script>';

      //Zip and archive file
      $this->_storefiles($citibikejsons, $citibikejson, $json_raw);

      //Check if the file has been already parsed once
      if($this->_checkfiles($parseTime)) {
        echo $parseTime. ' already parsed<br>';
        continue;
      }

      if(!is_array($json) || empty($json['executionTime']) || !is_array($json['stationBeanList']) ) {
        echo $i.'/'.$tot.' : <strong>ERRORE: '.$citibikejson.'</strong> <br><script>toBottom(); document.title="'.$i.'/'.$tot.'"</script>';
        continue;
      }

      $executionTime = human_to_unix($json['executionTime']) + 14400;
      $data = array();
      foreach ($json['stationBeanList'] as $value) {
        $data[] = array(
          'parseTime'             => $parseTime,
          'executionTime'         => $executionTime,
          'id'                    => $value['id'],
          'stationName'           => $value['stationName'],
          'availableDocks'        => $value['availableDocks'],
          'totalDocks'            => $value['totalDocks'],
          'latitude'              => $value['latitude'],
          'longitude'             => $value['longitude'],
          'statusValue'           => $value['statusValue'],
          'statusKey'             => $value['statusKey'],
          'availableBikes'        => $value['availableBikes'],
          'stAddress1'            => $value['stAddress1'],
          'stAddress2'            => $value['stAddress2'],
          'city'                  => $value['city'],
          'postalCode'            => $value['postalCode'],
          'location'              => $value['location'],
          'altitude'              => $value['altitude'],
          'testStation'           => $value['testStation'],
          'lastCommunicationTime' => $value['lastCommunicationTime'],
          'landMark'              => $value['landMark']
        );
      }
      $this->db->insert_batch('stationBeanList', $data);

      unset($data);
      unset($json);

      flush();

      if(json_last_error()) {
        switch (json_last_error()) {
          case JSON_ERROR_NONE:
              echo ' - No errors';
          break;
          case JSON_ERROR_DEPTH:
              echo ' - Maximum stack depth exceeded';
          break;
          case JSON_ERROR_STATE_MISMATCH:
              echo ' - Underflow or the modes mismatch';
          break;
          case JSON_ERROR_CTRL_CHAR:
              echo ' - Unexpected control character found';
          break;
          case JSON_ERROR_SYNTAX:
              echo ' - Syntax error, malformed JSON';
          break;
          case JSON_ERROR_UTF8:
              echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
          break;
          default:
              echo ' - Unknown error';
          break;
        }
      }
    }
    $count = $this->db->query('SELECT COUNT(*) as count FROM stationBeanList')->row()->count;
    echo '<h1>'.$count.'</h1>';

  }

  private function _checkfiles($name) {
    if(!is_array($this->_parsed)) {
      $query = $this->db->distinct()->select('parseTime')->from('stationBeanList')->get();
      foreach ($query->result() as $row) {
         $this->_parsed[] = $row->parseTime;
      }
      $query->free_result();
    }

    return (is_array($this->_parsed) && in_array($name, $this->_parsed)) ? TRUE : FALSE;
  }

  private function _storefiles($path, $filename, $content) {
    $folder = substr($filename, 11, 10).'/';
    if(!is_dir($path.$folder)) {
      mkdir($path.$folder);
    }
    $this->zip->add_data($filename, $content);
    $this->zip->archive($path . $folder . $filename . '.zip');
    $this->zip->clear_data();
    unlink($path . $filename);
  }
}
