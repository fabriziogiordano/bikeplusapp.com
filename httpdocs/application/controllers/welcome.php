<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
  public function index(){
    redirect('http://nyc.bikeplusapp.com', 'location', 301);
    die;
    $this->lang->load('web', $this->config->item('bikeplus_language'));
    $this->load->helper('file');

    if(!$this->agent->is_mobile()) {
      $template['assets'] = array(
        'path' => lang('assets'),
        'css' => filemtime(APPPATH.'../../subdomains/assets/css/style.desktop.css'),
      );
      $this->load->view('welcome_browser', $template);
    }
    else {
      $template['json'] = json_encode($this->Apis->latest(lang('site')));
      $template['assets'] = array(
        'path' => lang('assets'),
        'css'  => filemtime(APPPATH.'../../subdomains/assets/css/style.css'),
        'js'   => filemtime(APPPATH.'../../subdomains/assets/js/app.js')
      );
      $this->load->view('welcome', $template);
    }

  }
}