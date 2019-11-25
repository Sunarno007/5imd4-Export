<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Data_simda_model extends CI_Model {
 
	var $table = 'seting';
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    public function get_data($variable)
    {
        $this->db->from($this->table);
        $this->db->where('variable',$variable);
        $query = $this->db->get();
		$nama = $query->row();
 
        return $nama->value;
    }
 
    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }
 
}