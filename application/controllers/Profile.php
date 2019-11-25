<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Profile extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('profile_model','profile');
    }
 
    public function index()
    {
		redirect('login');
    }
 
    public function profile_edit($id)
    {
        if ( $this->auth->is_logged_in() == TRUE) {
			$data = $this->profile->get_by_id($id);
			echo json_encode($data);			
        } else {
			redirect('login');
		}
    }
 
    public function profile_update()
    {
        if ( $this->auth->is_logged_in() == TRUE) {
			$this->_validate_update();
			if (empty($_FILES['foto_profile']['name'])) {
				if ($this->input->post('password_profile')==''){
					
					$data = array(
							'username' => $this->input->post('username_profile'),
							'display_name' => $this->input->post('display_name_profile'),
							'email' => $this->input->post('email_profile'),
						);
				} else {
					$data = array(
							'username' => $this->input->post('username_profile'),
							'password' => password_hash($this->input->post('password_profile'), PASSWORD_BCRYPT),
							'display_name' => $this->input->post('display_name_profile'),
							'email' => $this->input->post('email_profile'),
						);		
				}
				
				$this->profile->update(array('id' => $this->input->post('id_profile')), $data);
				echo json_encode(array("status" => TRUE));
				$this->session->set_flashdata('alert', alert('success', 'Profile berhasil diupdate.'));
			} else {
				$file = $this->upload_profile();
				if ($file['status'] == 'success') {
					$query = $this->m_neu->find('users', 'id', $this->input->post('id_profile'))->row_array();
					if ($this->input->post('password_profile')==''){
					
						$data = array(
								'username' => $this->input->post('username_profile'),
								'display_name' => $this->input->post('display_name_profile'),
								'email' => $this->input->post('email_profile'),
								'foto' => $file['data']['file_name'],
							);
					} else {
						$data = array(
								'username' => $this->input->post('username_profile'),
								'password' => password_hash($this->input->post('password_profile'), PASSWORD_BCRYPT),
								'display_name' => $this->input->post('display_name_profile'),
								'email' => $this->input->post('email_profile'),
								'foto' => $file['data']['file_name'],
							);		
					}
					if ($query['foto'] != null){
						@unlink('./assets/img/' . $query['foto']);
					}					
					$this->profile->update(array('id' => $this->input->post('id_profile')), $data);
				    echo json_encode(array("status" => TRUE));
					$this->session->set_flashdata('alert', alert('success', 'Profile berhasil diupdate.'));
				   } else {
                  echo json_encode(array("status" => TRUE, "ntype" => "error", "ncontent" => "Profile gagal diperbaharui"));
               }
				
			}
        } else {
			redirect('login');
		}
    }
 
	private function _validate_update()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('username_profile') == '')
        {
            $data['inputerror'][] = 'username_profile';
            $data['error_string'][] = 'Username is required';
            $data['status'] = FALSE;
        }
		
		if($this->input->post('display_name_profile') == '')
        {
            $data['inputerror'][] = 'display_name_profile';
            $data['error_string'][] = 'Nama Lengkap is required';
            $data['status'] = FALSE;
        }
		
		if($this->input->post('email_profile') == '')
        {
            $data['inputerror'][] = 'email_profile';
            $data['error_string'][] = 'E-Mail is required';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('c_password_profile') != $this->input->post('password_profile'))
        {
            $data['inputerror'][] = 'c_password_profile';
            $data['error_string'][] = 'Konfirmasi Password salah!';
            $data['status'] = FALSE;
        }
 
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
	
	private function upload_profile() {
      create_dir('./assets/img/');
      $config['upload_path'] = './assets/img/';
      $config['allowed_types'] = 'jpg|png|gif';
      $config['max_size'] = 0;
      $config['encrypt_name'] = TRUE;
      $this->load->library('upload', $config);
      if (!$this->upload->do_upload('foto_profile')) {
         return [
            'status' => 'error',
            'data' => $this->upload->display_errors(),
         ];
      } else {
         $data = $this->upload->data();
         $resize['image_library'] = 'gd2';
         $resize['source_image'] = './assets/img/' . $data['file_name'];
         $resize['maintain_ratio'] = TRUE;
         $resize['width'] = 90;
         $resize['height'] = 90;
         $this->load->library('image_lib', $resize);
         $this->image_lib->resize();
         return [
            'status' => 'success',
            'data' => $this->upload->data(),
         ];
      }
   }
	 
}