<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

date_default_timezone_set('UTC');

class Fetch extends CI_Controller {
  public function __construct() {
    parent::__construct();
    $this->db->save_queries = FALSE;
    $this->_parsed = null;
    $this->parseTime = time();
    $this->logFile = APPPATH.'../../../logs/fetch/fetch.txt';
  }

  public function index() {
    //echo preg_replace('|^[\d -]*|', '', '04- Lanza alt. Teatro Strehler');
    echo 'nothing here';
  }

  public function nyc($table = '') {
    //Fetch data
    $url  = 'http://citibikenyc.com/stations/json';
    $table = (empty($table)) ? 'stationsnyc' : $table;
    $html = $this->fetch($url);
    $json = json_decode($html, true);

    //Check if data are valid
    if(is_array($json) && !empty($json['executionTime']) && is_array($json['stationBeanList']) ) {
      $this->db->trans_start();

      //Trucate DB
      $this->db->empty_table($table);
      $this->db->truncate($table);

      //Insert data in DB
      $executionTime = human_to_unix($json['executionTime']) + 14400;
      $data = array();

      foreach ($json['stationBeanList'] as $value) {
        $data[] = array(
          'parseTime'             => $this->parseTime,
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
      $this->db->insert_batch($table, $data);
      $this->db->trans_complete();

      //file_put_contents($this->logFile, date("Y-m-d H:i:s").' :: NYC - done', FILE_APPEND | LOCK_EX);
    }
    else {
      file_put_contents($this->logFile, date("Y-m-d H:i:s").' :: NYC - ERROR', FILE_APPEND | LOCK_EX);
    }
  }

  public function mi($table = '') {
    //Fetch data
    $url  = 'http://www.bikemi.com/localizaciones/localizaciones.php';
    $html = $this->fetch($url);
    $table = (empty($table)) ? 'stationsmi' : $table;

    preg_match('|<\?xml(.*)</kml>|ismU', $html, $matches);

    $xml = simplexml_load_string(utf8_encode($matches[0]), 'SimpleXMLElement', LIBXML_NOCDATA);

    if(count($xml->Document->Placemark)) {
      $this->db->trans_start();

      //Trucate DB
      $this->db->empty_table($table);
      $this->db->truncate($table);

      //Insert data in DB
      $executionTime = human_to_unix($this->parseTime) + 14400;
      $data = array();

      foreach($xml->Document->Placemark as $placemark) {
        $m = '<div style="margin:10px"><div style="font:bold 11px verdana;color:#ED1B24;margin-bottom:10px">(.*)</div><div style="text-align:right;float:left;font:bold 11px verdana">Biciclette<br />Stalli</div><div style="margin-left:5px;float:left;font:bold 11px verdana;color:green">(.*)<br />(.*)<br /></div></div>';
        preg_match('|'.$m.'|ismU', $placemark->description, $title);

        //list($id, $name) = explode('- ', $title[1], 2);
        $id = substr(md5($title[1]), 0, 6);
        list($name, ) = explode(',', trim($title[1]), -1);
        $name = preg_replace('|^[\d -]*|', '', $name);

        list($lng, $lat, ) = explode(',', $placemark->Point->coordinates);

        $data[] = array(
          'parseTime'             => $this->parseTime,
          'executionTime'         => $executionTime,
          'id'                    => $id,
          'stationName'           => $name,
          'availableDocks'        => $title[3],
          'totalDocks'            => '',
          'latitude'              => $lat,
          'longitude'             => $lng,
          'statusValue'           => 'In Service', //Forced to be compliant to NYC API
          'statusKey'             => '',
          'availableBikes'        => $title[2],
          'stAddress1'            => '',
          'stAddress2'            => '',
          'city'                  => '',
          'postalCode'            => '',
          'location'              => '',
          'altitude'              => '',
          'testStation'           => '',
          'lastCommunicationTime' => '',
          'landMark'              => ''
        );
      }
      $this->db->insert_batch($table, $data);
      $this->db->trans_complete();

      //file_put_contents($this->logFile, date("Y-m-d H:i:s").' :: Milano - done', FILE_APPEND | LOCK_EX);
    }
    else {
      file_put_contents($this->logFile, date("Y-m-d H:i:s").' :: Milano - ERROR', FILE_APPEND | LOCK_EX);
    }
  }

  public function dev($site = 'nyc') {
    $this->$site('stationsdev');
  }


  private function fetch($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERAGENT        , 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:21.0) Gecko/20100101 Firefox/21.0');
    curl_setopt($ch, CURLOPT_HEADER           , FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER   , TRUE);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT   , 30);
    $return = curl_exec($ch);
    curl_close($ch);
    return $return;
  }
}