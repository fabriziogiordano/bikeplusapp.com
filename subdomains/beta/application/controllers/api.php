<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {
  public function latest($next = 0){
    $this->load->model('Apis');
    echo json_encode($this->Apis->latest());
  }

  public function user(){
  }
}