<?php
class Apis extends CI_Model {
  function __construct() {
    parent::__construct();
  }

  function latest($site) {
    $js = array();
    $json = array();

    $parseTimeMax = $this->db
                      ->select_max('parseTime')
                      ->from('stations'.$site)
                      ->get()
                      ->row()
                      ->parseTime;

    $q            = $this->db
                     //->select('parseTime, id, latitude, longitude, availableBikes, availableDocks, totalDocks, statusKey, statusValue, testStation, lastCommunicationTime')
                     //->select()
                     ->select('id, latitude, longitude, availableBikes, availableDocks, stationName')
                     ->from('stations'.$site)
                     ->where('parseTime', $parseTimeMax)
                     ->where('statusValue', 1)
                     //->where('availableBikes >', 0)
                     ->get();

    foreach ($q->result() as $r) {
      //var_dump($r);
      $js[] = array(
        'id' => $r->id,
        'la' => $r->latitude,
        'lo' => $r->longitude,
        'ab' => $r->availableBikes,
        'ad' => $r->availableDocks,
        'sn' => $r->stationName
      );
    }
    $json['parseTime'] = date('D M j, \<\s\p\a\n\>H:i a\<\/\s\p\a\n\>', $parseTimeMax - 21600); //- 14400
    $json['timestamp'] = $parseTimeMax - 21600; //- 14400
    $json['stations'] = $js;

    return $json;
  }

  function dock($site, $id){
    $js = array();
    $json = array();

    $parseTimeMax = $this->db
                      ->select_max('parseTime')
                      ->from('stations'.$site)
                      ->get()
                      ->row()
                      ->parseTime;

    $q            = $this->db
                     //->select('parseTime, id, latitude, longitude, availableBikes, availableDocks, totalDocks, statusKey, statusValue, testStation, lastCommunicationTime')
                     ->select()
                     //->select('id, latitude, longitude, availableBikes, availableDocks, stationName')
                     ->from('stations')
                     ->where('parseTime', $parseTimeMax)
                     ->where('id', $id)
                     ->get()
                     ->row();
    return $q;
  }

  function ActivityDataPoint($data){
    //'uuid' => $uuid,
    //'status' => $status,
    //'dockid' => $dockid,
    //'lat' => $lat,
    //'lng' => $lng
    //echo $this->_distance(40.70530954,-74.00712572,40.70530954,-74.02712572);

    if(empty($data['uuid'])) {
      return false;
    }

    $uuid = $this->db
                 ->select('uuid, stop_dockid, start_lat, start_lng, start_fitness_metrics_timestamp')
                 ->from('opengraph')
                 ->where('uuid', $data['uuid'])
                 ->get()
                 ->row_array();

    //No data then we store the info
    if( count($uuid) == 0 && $data['status'] == 'start' && !empty($data['dockid']) && !empty($data['lat']) && !empty($data['lng'])) {
      $insert = array(
        'uuid'         => $data['uuid'],

        'start_dockid' => $data['dockid'],
        'start_lat'    => $data['lat'],
        'start_lng'    => $data['lng'],

        'start_fitness_metrics_calories'              => '0',
        //'start_fitness_metrics_custom_quantity_units' => 'NycBikePlus'
        //'start_fitness_metrics_custom_quantity_value' => '0',
        'start_fitness_metrics_distance_units'        => 'mi',
        'start_fitness_metrics_distance_value'        => '0',
        'start_fitness_metrics_location_altitude'     => '10',
        'start_fitness_metrics_location_latitude'     => $data['lat'],
        'start_fitness_metrics_location_longitude'    => $data['lng'],
        'start_fitness_metrics_pace_units'            => 'mi/s',
        'start_fitness_metrics_pace_value'            => '0',
        'start_fitness_metrics_timestamp'             => time(),
      );
      $this->db->insert('opengraph', $insert);
    }

    if( count($uuid) > 0 && $data['status'] == 'stop' && !empty($data['dockid']) && !empty($data['lat']) && !empty($data['lng'])) {
      if($uuid['stop_dockid'] == '') {
        if($data['lat'] == 'undefined') {
          $data['lat'] = $uuid['start_lat'];
          $data['lng'] = $uuid['start_lng'];
        }
        $distance = $this->_distance($uuid['start_lat'], $uuid['start_lng'], $data['lat'], $data['lng']);

        $googlemapraw = $this->gmapdistances($uuid['start_lat'], $uuid['start_lng'], $data['lat'], $data['lng']);

        if($distance > 25) $distance = 25;
        $update = array(
          'stop_dockid' => $data['dockid'],
          'stop_lat'    => $data['lat'],
          'stop_lng'    => $data['lng'],

          'googlemap'    => $googlemapraw,

          'stop_fitness_metrics_calories'               => round($distance*200),
          //'stop_fitness_metrics_custom_quantity_units'  => 'NycBikePlus'
          //'stop_fitness_metrics_custom_quantity_value'  => round($distance*10),
          'stop_fitness_metrics_distance_units'         => 'mi',
          'stop_fitness_metrics_distance_value'         => $distance,
          'stop_fitness_metrics_location_altitude'      => '10',
          'stop_fitness_metrics_location_latitude'      => $data['lat'],
          'stop_fitness_metrics_location_longitude'     => $data['lng'],
          'stop_fitness_metrics_pace_units'             => 'mi/s',
          'stop_fitness_metrics_pace_value'             => round($distance/(time() - $uuid['start_fitness_metrics_timestamp'])),
          'stop_fitness_metrics_timestamp'              => time(),
        );
        $this->db->update('opengraph', $update, array('uuid' => $data['uuid']));
      }
    }

    $uuid = $this->db
                 ->select()
                 ->from('opengraph')
                 ->where('uuid', $data['uuid'])
                 ->get()
                 ->row_array();

    $uuid['fitness_calories']                 = $uuid['stop_fitness_metrics_calories'];
    //$uuid['fitness_custom_unit_energy_value'] = $uuid['stop_fitness_metrics_custom_quantity_value'];
    //$uuid['fitness_custom_unit_energy_units'] = 'NycBikePlus';
    $uuid['fitness_distance_units']           = $uuid['stop_fitness_metrics_distance_units'];
    $uuid['fitness_distance_value']           = $uuid['stop_fitness_metrics_distance_value'];
    $uuid['fitness_duration_units']           = 's';
    $uuid['fitness_duration_value']           = $uuid['stop_fitness_metrics_timestamp'] - $uuid['start_fitness_metrics_timestamp'];
    $uuid['fitness_pace_units']               = $uuid['stop_fitness_metrics_pace_units'];
    $uuid['fitness_pace_value']               = $uuid['stop_fitness_metrics_pace_value'];
    $uuid['fitness_speed_units']              = $uuid['stop_fitness_metrics_pace_units'];
    $uuid['fitness_speed_value']              = $uuid['stop_fitness_metrics_pace_value'];

    //var_dump($uuid['googlemap']);
    $uuid['googlemap']                        = unserialize($uuid['googlemap']);
    //var_dump($uuid['googlemap']);

    return $uuid;
  }

  function gmapdistances($lat1,$lng1,$lat2,$lng2){
    $url  = 'http://maps.googleapis.com/maps/api/directions/json?';
    $url .= 'origin='.$lat1.','.$lng1.'&';
    $url .= 'destination='.$lat2.','.$lng2.'&';
    $url .= 'sensor=false&';
    $url .= 'mode=bicycling';
    $route = $this->_disguise_curl($url);
    $getroute = json_decode($route, true);

    if($getroute['status'] == 'OK') {
      return serialize($getroute);
    }
    return '';
  }

  private function _disguise_curl($url) {
    $curl = curl_init();
    $header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
    $header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
    $header[] = "Cache-Control: max-age=0";
    $header[] = "Connection: keep-alive";
    $header[] = "Keep-Alive: 300";
    $header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
    $header[] = "Accept-Language: en-us,en;q=0.5";
    $header[] = "Pragma: "; // browsers keep this blank.
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.32 Safari/537.36');
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    //curl_setopt($curl, CURLOPT_REFERER, 'http://www.yahoo.com');
    curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
    curl_setopt($curl, CURLOPT_AUTOREFERER, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    $html = curl_exec($curl);
    curl_close($curl);

    return $html; // and finally, return $html
  }

  private function _distance($lat1,$lon1,$lat2,$lon2) {
    $R = 3958.7558657440545; //6371;
    $lat1 = $lat1 * M_PI / 180;
    $lon1 = $lon1 * M_PI / 180;

    $lat2 = $lat2 * M_PI / 180;
    $lon2 = $lon2 * M_PI / 180;

    $dLat = $lat2 - $lat1;
    $dLon = $lon2 - $lon1;

    $a = sin($dLat/2) * sin($dLat/2) +
         cos($lat1) * cos($lat2) *
         sin($dLon/2) * sin($dLon/2);
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    $d = $R * $c;
  return round($d, 3);
  }
}
