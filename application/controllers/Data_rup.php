<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Data_rup extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('data_rup_model','data_rup');
    }
 
    public function index()
    {
		redirect('login');
    }
 
    public function data_rup_edit()
    {
        if ( $this->auth->is_logged_in() == TRUE) {
			$tahun_anggaran = $this->data_rup->get_data('tahun_anggaran');	
			$satker_pemda = $this->data_rup->get_data('satker_pemda');
			$kode_pemda = $this->data_rup->get_data('kode_pemda');
			$data = array(  "tahun_anggaran" => $tahun_anggaran,
							"satker_pemda" => $satker_pemda,
							"kode_pemda" => $kode_pemda,
							);
			echo json_encode($data);
        } else {
			redirect('login');
		}
    }
 
    public function data_rup_update()
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
			$this->session->set_flashdata('alert', alert('success', 'Setting Data RUP berhasil diupdate.'));
         } else {
            redirect('login');
         }
    }
 
	private function field_data() {
      $data['tahun_anggaran'] = $this->input->post('tahun_anggaran');
      $data['satker_pemda'] = $this->input->post('satker_pemda');
      $data['kode_pemda'] = $this->input->post('kode_pemda');
      return $data;
   }
	
	
	private function _validate_update()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('tahun_anggaran') == '')
        {
            $data['inputerror'][] = 'tahun_anggaran';
            $data['error_string'][] = 'Tahun Anggaran is required';
            $data['status'] = FALSE;
        }
		
		if($this->input->post('satker_pemda') == '')
        {
            $data['inputerror'][] = 'satker_pemda';
            $data['error_string'][] = 'Kode Satker Pemda is required';
            $data['status'] = FALSE;
        }
		
		if($this->input->post('kode_pemda') == '')
        {
            $data['inputerror'][] = 'kode_pemda';
            $data['error_string'][] = 'Kode Pemda is required';
            $data['status'] = FALSE;
        }
		 
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
		 
}