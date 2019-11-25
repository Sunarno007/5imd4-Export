<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Data_simda extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('data_simda_model','data_simda');
    }
 
    public function index()
    {
		redirect('login');
    }
 
    public function data_simda_edit()
    {
        if ( $this->auth->is_logged_in() == TRUE) {
			$hostname = $this->data_simda->get_data('hostname');	
			$username = $this->data_simda->get_data('username');
			$password = $this->data_simda->get_data('password');
			$database = $this->data_simda->get_data('database');
			$data = array(  "hostname" => $hostname,
							"username" => $username,
							"passwordx" => $password,
							"database" => $database,
							);
			echo json_encode($data);
        } else {
			redirect('login');
		}
    }
 
    public function data_simda_update()
    {
        if ( $this->auth->is_logged_in() == TRUE) {
            $this->_validate_update();
			$data = $this->field_data();
            foreach($data as $key => $value) {
               $check = $this->db->where('variable', $key)->count_all_results('seting');
               if ($check == 0) {
                  $this->db->insert('seting', ['variable' => $key, 'value' => $value]);
               } else {
                  $this->db->where('variable', $key)->update('seting', ['value' => $value]);
               }
            }
            echo json_encode(array("status" => TRUE));
			$this->session->set_flashdata('alert', alert('success', 'Setting Data SIMDA berhasil diupdate.'));
         } else {
            redirect('login');
         }
    }
 
	private function field_data() {
      $data['hostname'] = $this->input->post('hostname');
      $data['username'] = $this->input->post('username');
      $data['password'] = $this->input->post('password');
      $data['database'] = $this->input->post('database');
      return $data;
   }
	
	
	private function _validate_update()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('hostname') == '')
        {
            $data['inputerror'][] = 'hostname';
            $data['error_string'][] = 'Required';
            $data['status'] = FALSE;
        }
		
		if($this->input->post('username') == '')
        {
            $data['inputerror'][] = 'username';
            $data['error_string'][] = 'Required';
            $data['status'] = FALSE;
        }
		
		if($this->input->post('database') == '')
        {
            $data['inputerror'][] = 'database';
            $data['error_string'][] = 'Required';
            $data['status'] = FALSE;
        }
 
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
		 
}