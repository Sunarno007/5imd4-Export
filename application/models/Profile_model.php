<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Profile_model extends CI_Model {
 
	var $table = 'users';
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    public function get_by_id($id)
    {
        $this->db->from($this->table);
        $this->db->where('id',$id);
        $query = $this->db->get();
 
        return $query->row();
    }
 
    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }
 
}