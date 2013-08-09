<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
  public function index(){
    $this->lang->load('web', $this->config->item('bikeplus_language'));
    $this->load->helper('file');

    if(!$this->agent->is_mobile()) {
      $template['version'] = array(
        'css' => filemtime(BASEPATH.'../assets/css/style.desktop.css'),
      );
      $this->load->view('welcome_browser', $template);
    }
    else {
      $template['json'] = json_encode($this->Apis->latest());
      $template['version'] = array(
        'css' => filemtime(BASEPATH.'../assets/css/style.css'),
        'js'  => filemtime(BASEPATH.'../assets/js/app.js')
      );
      $this->load->view('welcome', $template);
    }

  }
}