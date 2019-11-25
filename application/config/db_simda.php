<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function seting($variable)
{
	$CI =& get_instance();
	$CI->db = $CI->load->database('default', TRUE);
	$query = $CI->db->select('variable, value')->get('seting');
	$pengaturan = [];
	foreach($query->result() as $row)
	{
		$pengaturan[$row->variable] = $row->value;
	}
	return $pengaturan[$variable];
}

$config['hostname_simda'] = seting('hostname');
$config['username_simda'] = seting('username');
$config['password_simda'] = seting('password');
$config['database_simda'] = seting('database');

