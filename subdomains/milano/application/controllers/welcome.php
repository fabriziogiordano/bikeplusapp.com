<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
  public function index(){
    $this->lang->load('web', $this->config->item('bikeplus_language'));
    $this->load->helper('file');

    if(!$this->agent->is_mobile()) {
      $template['assets'] = array(
        'path' => lang('assets'),
        'css' => filemtime(APPPATH.'../../assets/css/style.desktop.css'),
      );
      $this->load->view('welcome_browser', $template);
    }
    else {
      $template['json'] = json_encode($this->Apis->latest(lang('site')));
      $template['assets'] = array(
        'path' => lang('assets'),
        'css'  => filemtime(APPPATH.'../../assets/css/style.css'),
        'js'   => filemtime(APPPATH.'../../assets/js/app.js')
      );
      $this->load->view('welcome', $template);
    }

  }
}