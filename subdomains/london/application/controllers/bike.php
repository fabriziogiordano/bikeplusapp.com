<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bike extends CI_Controller {
  public function index(){
    echo 'Bikes are somewhere else :)';
  }

  public function ride($uuid = false, $status = false, $dockid = false, $lat = false, $lng = false){
    $activitydatapoint = array();
    $activitydatapoint = $this->Apis->ActivityDataPoint(array(
      'uuid' => $uuid,
      'status' => $status,
      'dockid' => $dockid,
      'lat' => $lat,
      'lng' => $lng
    ));

    $template['meta'] = array(
      'app_id' => $this->config->item('facebook_appid'),
      'type' => 'fitness.course',
      'url' => 'http://nyc.bikeplusapp.com/bike/ride/'.$uuid,
      'title' => 'Biking in New York City!',
      'description' => 'I am riding ‪#‎CityBikeNYC‬ in New York City! Send me cheers along the way by liking or commenting on this post.',
      'image' => 'http://nycbikeplus.com/assets/img/logos/logo.opengraph.png?v=1',
      'live_text' => 'I am riding ‪#‎CityBikeNYC‬ in New York City! Send me cheers along the way by liking or commenting on this post.'
    );

    $template['activitydatapoint'] = $activitydatapoint;
    $this->load->view('bike', $template);
  }
}