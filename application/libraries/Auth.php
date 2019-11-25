<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth {

	/**
	 * The CodeIgniter super object
	 *
	 * @var object
	 * @access public
	 */
	public $CI;

	/**
	 * Class constructor
	 */
	public function __construct() {
		$this->CI = &get_instance();
	}

	/**
	 * login()
	 * Fungsi untuk mengecek ketersediaan account users dalam proses login
	 * @access     public
	 * @param    string
	 * @return     bool
	 */
	public function login($username, $password) {
		$where = "username='$username' AND status=1 AND (level='super-admin' OR level='admin' OR level='konsultan' OR level='camat')";
		$result = $this->CI
							->db
							->where($where)
							->limit(1)
							->get('users');
		if ($result->num_rows() == 0) {
			return false;
		} else {
			$data = $result->row();
			if (password_verify($password, $data->password)) {
				$session_data = [];
				$session_data['id'] = $data->id;
				$session_data['username'] = $data->username;
				$session_data['level'] = $data->level;
				$session_data['is_logged_in'] = true;
				$session_data['display_name'] = $data->display_name;
				$session_data['foto'] = $data->foto;
				if ($data->level == 'konsultan') {
					$session_data['project_id'] = $data->project_id;
				}
				if ($data->level == 'camat') {
					$session_data['kec_id'] = $data->id_kec;
				}
				$this->CI->session->set_userdata($session_data);
				$this->last_logged_in();
				return true;
			}
			return false;
		}
	}

	private function last_logged_in() {
		$data = [
			'last_logged_in' => date('Y-m-d H:i:s'),
			'ip_address' => $_SERVER['REMOTE_ADDR'],
		];
		$this->CI->db
			->where('username', $this->CI->session->userdata('username'))
			->update('users', $data);
	}

	/**
	 * is_logged_in()
	 * Fungsi untuk mengecek apakah data session user id kosong / tidak
	 * @access   public
	 * @return   bool
	 */
	public function is_logged_in() {
		return $this->CI->session->userdata('is_logged_in');
	}

	/**
	 * restrict()
	 * Fungsi untuk memvalidasi status login
	 * @access   public
	 * @return   bool
	 */
	public function restrict() {
		if (!$this->is_logged_in()) {
			redirect(base_url());
		}
	}

	/**
	 * logout()
	 * Fungsi untuk menghapus data session user
	 * @return   void
	 */
	public function logout() {
		$this->CI->session->sess_destroy();
	}
}