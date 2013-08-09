<?php
class User extends CI_Model {
  function __construct(){
    parent::__construct();
  }

  function signin() {
    $this->email    = strtolower($this->input->post('email', TRUE) );
    $this->password = $this->input->post('password', TRUE);
    $this->xrsd     = $this->input->post('xrsd', TRUE);

    //$this->email    = 'fabrizio.giordano@gmail.com';
    //$this->password = 'sempreio';
    //$this->xrsd     = '';

    // Email empty
    if(empty($this->email) || strlen($this->email)<5) {
      return array('error' => array('code'=>'1002', 'descr'=>'Email not correct'));
    }
    // Password empty
    if(empty($this->password) || strlen($this->password)<5) {
      return array('error' => array('code'=>'1003', 'descr'=>'Password not correct'));
    }

    // Select user email
    $query = $this->db->select('id, email, password')->from('users')->where('email', $this->email)->get();
    if($query->num_rows() == 0) {
      //return array('error' => array('code'=>'1001', 'descr'=>'no email'));
      $this->db->insert('users', array(
        'nick'       		=> $this->_nick($this->email),
        'email'         => $this->email,
        'password'      => md5($this->password)
      ));
      $id = $this->db->insert_id();
      return $id;
    }
    elseif($query->num_rows() == 1) {
      $row = $query->row_array();
      if( $row['password'] == md5($this->password)) {
        $id = $row['id'];
        return $id;
      }
      else {
        return array('error' => array('code'=>'1004', 'descr'=>'wrong password'));
      }

    }
    else {
      log_message('error', '1236: ERRORE COLOSSALE DA LOOGARE');
    }
  }

  function signinfb() {
    $id = FALSE;
    $this->fb_id         = $this->input->post('fb_id',TRUE);
    $this->fb_email      = $this->input->post('fb_email',TRUE);
    $this->fb_name       = $this->input->post('fb_name',TRUE);
    $this->fb_first_name = $this->input->post('fb_first_name',TRUE);
    $this->fb_last_name  = $this->input->post('fb_last_name',TRUE);
    $this->fb_gender     = $this->input->post('fb_gender',TRUE);
    $this->fb_link       = $this->input->post('fb_link',TRUE);
    $this->fb_username   = $this->input->post('fb_username',TRUE);
    $this->fb_verified   = $this->input->post('fb_verified',TRUE);

    $query = $this->db->select('id, email, password, fb_id, fb_email')->from('users')->where('fb_id', $this->fb_id)->get();

    //User not added facebook
    if($query->num_rows() == 0) {

      //We check if there is an email that match facebook
      $match = $this->db->select('id, email, fb_id, fb_email')->from('users')->where('email', $this->fb_email)->get();

      //No emails than we register as new user
      if($match->num_rows() == 0) {
        $this->db->insert('users', array(
          'email'         => $this->fb_email,
          'password'      => md5(rand(1,111111)),
          'nick'       		=> $this->fb_first_name,
          'avatar'        => $this->_avatar($this->fb_id),

          'fb_id'         => $this->fb_id,
          'fb_email'      => $this->fb_email,
          'fb_name'       => $this->fb_name,
          'fb_first_name' => $this->fb_first_name,
          'fb_last_name'  => $this->fb_last_name,
          'fb_gender'     => $this->fb_gender,
          'fb_link'       => $this->fb_link,
          'fb_username'   => $this->fb_username,
          'fb_verified'   => $this->fb_verified
        ));
        $id = $this->db->insert_id();
      }

      //Una email combacia con un utente già iscritto quindi fa l'update/merging
      elseif($match->num_rows() == 1) {
        $row = $match->row_array();
        $id = $row['id'];
        $this->db->update('users', array(
          'fb_id'         => $this->fb_id,
          'fb_email'      => $this->fb_email,
          'fb_name'       => $this->fb_name,
          'fb_first_name' => $this->fb_first_name,
          'fb_last_name'  => $this->fb_last_name,
          'fb_gender'     => $this->fb_gender,
          'fb_link'       => $this->fb_link,
          'fb_username'   => $this->fb_username,
          'fb_verified'   => $this->fb_verified
          ),
          array('id' => $id)
        );
        $id = $this->db->insert_id();
      }
      else {
        log_message('error', '1234: ERRORE COLOSSALE DA LOOGARE');
      }
    }
    //User added facebook
    elseif($query->num_rows() == 1){
      $row = $query->row_array();
      if($row['email'] == $row['password']) {
        $this->db->update('users', array(
            'email'         => $this->fb_email,
            'password'      => md5(rand(1,111111)),
            'nick'       		=> $this->fb_first_name,
            'avatar'        => $this->_avatar($this->fb_id),

            'fb_id'         => $this->fb_id,
            'fb_email'      => $this->fb_email,
            'fb_name'       => $this->fb_name,
            'fb_first_name' => $this->fb_first_name,
            'fb_last_name'  => $this->fb_last_name,
            'fb_gender'     => $this->fb_gender,
            'fb_link'       => $this->fb_link,
            'fb_username'   => $this->fb_username,
            'fb_verified'   => $this->fb_verified
          ),
          array('id' => $this->fb_id)
        );
      }
      $id = $row['id'];
    }
    else {
      log_message('error', '1235: ERRORE COLOSSALE DA LOOGARE');
    }

    return $id;
  }

  function signout() {
    $this->session->set_userdata('logged', FALSE);
    $this->session->set_userdata('userid', FALSE);
    return TRUE;
  }

  function get($user_id=FALSE, $logged=FALSE) {
    $query = $this->db->select('id, nick, avatar, notification_lastid')->from('users')->where('id', $user_id)->get();
    if($query->num_rows() == 1) {
      $row = $query->row_array();
      $return = array(
        'id'                  => $row['id'],
        'logged'              => $logged,
        'nick'                => $row['nick'],
        'avatar'              => $row['avatar'],
        'notification_lastid' => $row['notification_lastid']
      );
    }
    elseif($query->num_rows() == 0) {
      $return = array(
        'id' => '',
        'logged' => $logged,
        'nick' => '',
        'avatar' => ''
      );
    }
    else{
      log_message('error', '1237: ERRORE COLOSSALE DA LOOGARE');
    }

    return $return;
  }

  function isLogged() {
    if($this->session->userdata('logged')) {
      return $this->session->userdata('userid');
    }
    else {
      return FALSE;
    }
  }

  function _nick($email='') {
    $email_at   = explode('@', $email, 2);
    $email_dot  = explode('.', $email_at[0], 2);
    $email_dash = explode('-', $email_dot[0], 2);
    if(strlen($email_dash[0])<1) $email_dash[0] = $email_at[0];
    return $email_dash[0];
  }

	function _avatar($fbid) {
		if(!empty($fbid)) {
			return 'https://graph.facebook.com/'.$fbid.'/picture?type=square';
		}
		$rand_keys = array_rand($names, 1);
		return '/assets/mobile/img/icons/profile/avatar.png';
	}

}