<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

   public function __construct() {
      parent::__construct();
   }

   public function index() {
	  if ($this->auth->is_logged_in() == TRUE) {
         redirect('organisasi');
      }
      if ($_POST) {
         sleep(1);
         if ($this->validation()) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            echo $this->auth->login($username, $password) ? 1 : 0;
         } else {
            echo 0;
         }
      } else {
		 $data['title'] = 'USER LOGIN';
         $data['action'] = site_url(uri_string());
         $this->load->view('login', $data);
      }
   }

   private function validation() {
      $this->load->library('form_validation');
      $this->form_validation->set_rules('username', 'Nama Akun', 'trim|required');
      $this->form_validation->set_rules('password', 'Kata Sandi', 'trim|required');
      $this->form_validation->set_error_delimiters('<i class="icon-remove-sign"></i> ', '<br>');
      return $this->form_validation->run();
   }
	
	public function logout() {
	  if ($this->auth->is_logged_in()) {
		 $this->auth->logout();
	  }
	  redirect('login');
	}
}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */