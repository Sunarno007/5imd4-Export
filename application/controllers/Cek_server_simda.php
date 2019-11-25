<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Cek_server_simda extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
    }
 
    public function index()
    {
		if ( $this->auth->is_logged_in() == TRUE) {
			$this->db2 = $this->load->database('mssql', TRUE);
			$connected = $this->db2->initialize();
			if (!$connected)
			{
				$status = 'DC';
			} else
			{
				$status = 'OK';
			}
			$data = array(  "status" => true,
							"pesan"	 => $status
							);
			echo json_encode($data);
        } else {
			redirect('login');
		}
    }
		 
}