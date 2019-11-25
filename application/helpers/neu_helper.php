<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('number2alpha')) {
   function number2alpha($index) {
      --$index;
        if ($index >= 0 && $index < 26)
            return chr(ord('A') + $index);
        else if ($index > 25)
            return (number2alpha($index / 26)) . (number2alpha($index % 26 + 1));
        else
            show_error("Invalid Column # " . ($index + 1));
   }
}

if ( ! function_exists('array_date')) {
   function array_date($start, $end) {
	   $range = [];    
      if (is_valid_date($start))
         $start = strtotime($start);
      if (is_valid_date($end) ) 
         $end = strtotime($end);      
      if ($start > $end) 
         return array_date($end, $start);     
      do {
         $range[] = date('Y-m-d', $start);
         $start = strtotime("+ 1 day", $start);
      }
      while($start < $end);      
      return $range;
   }
}

if (!function_exists('recursive_list')) {
   function recursive_list($data) {
      $str = "";
      foreach ($data as $list) {
         $href = site_url('home/readmore/' . $list['post_id'] . '/' . $list['slug']);
         if (count($list['child']) > 0) {
            $href = '#';
         }
         $str .= "<li ".(count($list['child']) > 0 ? 'class="level2"' : '')."'><a href='".$href."'>" . strtoupper($list['post_title']) . "</a>";
         $subchild = recursive_list($list['child']);
         if ($subchild != '') {
            $str .= "<ul>" . $subchild . "</ul>";
         }
         $str .= "</li>";
      }
      return $str;
   }
}

if (!function_exists('recursive_table')) {
   function recursive_table($data,$level) {
      $str = "";
      foreach ($data as $list) {
		 $harga_satuan = $list['harga_satuan']*$list['volume'] == 0 ? '--' : number_format($list['harga_satuan'],2);
		 $total = $list['harga_satuan']*$list['volume'] == 0 ? '--' : number_format($list['harga_satuan']*$list['volume'],2);
		 $bobot = $list['harga_satuan']*$list['volume'] == 0 ? '--' : number_format(((($list['harga_satuan']*$list['volume'])/gval('project', 'project_id', 'nilai_kontrak', $list['project_id']))*100),2);
		 $satuan = $list['satuan'] == null ? '--' : $list['satuan'];
		 $volume = $list['volume'] == null ? '--' : $list['volume'];
         $str .= '<tr>';
         $str .= '<td style="padding-left:' . $level . 'em;">' . $list['pekerjaan'] . ' <button class="btn btn-warning btn-xs" onclick="add_sub_pek(' . $list['id'] . ')"><i class="glyphicon glyphicon-plus"></i></button></td>';
         $str .= '<td>' . $satuan . '</td>';
		 $str .= '<td>' . $volume . '</td>';
		 $str .= '<td>' . $harga_satuan . '</td>';
		 $str .= '<td>' . $total . '</td>';
		 $str .= '<td>' . $bobot . '</td>';
		 $str .= '<td> AKSI </td>';
		 $subchild = recursive_table($list['child'], $level + 1);
		 if ($subchild != false) {
            $str .= '</tr><tr>' . $subchild . '</tr>';
         } else {
            $str .= '</tr>';
         }
      }
	  
      return $str;
   }
}

if (!function_exists('display_child_nodes')) {
	function display_child_nodes($parent_id, $level)
	{
		global $data, $index;
		$parent_id = $parent_id === NULL ? "NULL" : $parent_id;
		if (isset($index[$parent_id])) {
			foreach ($index[$parent_id] as $id) {
				echo str_repeat("-", $level) . $data[$id]["pekerjaan"] . "\n";
				display_child_nodes($id, $level + 1);
			}
		}
	}
}

/**
 * Nested List
 * @param   Array
 * @return  string
 */
if (!function_exists('nested_list')) {
   function nested_list($data) {
      $str = "";
      foreach ($data as $list) {
         $str .= '<li class="dd-item" data-id="' . $list['post_id'] . '">';
         $str .= '<div class="dd-handle">' . strtoupper($list['post_title']) . '</div>';
         $subchild = nested_list($list['child']);
         if ($subchild != '') {
            $str .= '<ol class="dd-list">' . $subchild . '</ol>';
         } else {
            $str .= '</li>';
         }
      }
      return $str;
   }
}

if (!function_exists('alert')) {
   function alert($type, $content) {
		$alert = '<script type="text/javascript">';
		$alert .= 'notifikasi(\''.$type.'\',\''.$content.'\');';
		$alert .= '</script>';
		return $alert;
   }
}

if (!function_exists('status')) {
   function status($key = '') {
      $message = '';
      switch ($key) {
      case 'tersimpan':
         $message = 'Data sudah tersimpan !';
         break;
      case 'gagal_tersimpan':
         $message = 'Data tidak tersimpan !';
         break;
      case 'terupdate':
         $message = 'Data sudah diperbaharui !';
         break;
      case '404':
         $message = 'Halaman tidak ditemukan !';
         break;
      case 'terhapus':
         $message = 'Data sudah dihapus !';
         break;
      case 'gagal_terhapus':
         $message = 'Data tidak terhapus !';
         break;
      case 'terpilih':
         $message = 'Tidak ada data yang terpilih !';
         break;
      case 'sudah_ada':
         $message = 'Data sudah ada !';
         break;
      }
      return $message;
   }
}

if (!function_exists('config_data')) {
	function config_data() {
      $config = file_get_contents('./application/views/config.json');
      return json_decode($config, true);
   }
}

if (!function_exists('indo_date')) {
   function indo_date($str) {
      if (!is_valid_date($str)) return NULL;
      $exp = explode("-", $str);
      return $exp[2] . ' ' . bulan($exp[1]) . ' ' . $exp[0];
   }
}

if (!function_exists('indo_date_min')) {
   function indo_date_min($str) {
      if (!is_valid_date($str)) return NULL;
      $exp = explode("-", $str);
      return $exp[2] . ' ' . bulan($exp[1],'P') . ' ' . $exp[0];
   }
}

if (!function_exists('bulan')) {
   function bulan($kode, $type = 'L') {
      $bulan = '';
      switch ($kode) {
         case '01':
            $bulan = 'Januari';
            break;
         case '02':
            $bulan = 'Februari';
            break;
         case '03':
            $bulan = 'Maret';
            break;
         case '04':
            $bulan = 'April';
            break;
         case '05':
            $bulan = 'Mei';
            break;
         case '06':
            $bulan = 'Juni';
            break;
         case '07':
            $bulan = 'Juli';
            break;
         case '08':
            $bulan = 'Agustus';
            break;
         case '09':
            $bulan = 'September';
            break;
         case '10':
            $bulan = 'Oktober';
            break;
         case '11':
            $bulan = 'Nopember';
            break;
         case '12':
            $bulan = 'Desember';
            break;
      }
      if ($type != 'L') {
         return substr($bulan, 0, 3);
      }
      return $bulan;
   }
}

if (!function_exists('encode_url')) {
   function encode_url($key = '') {
      $CI = &get_instance();
      $CI->load->library('encrypt_url');
      return $CI->encrypt_url->encode($key);
   }
}

if (!function_exists('decode_url')) {
   function decode_url($key = '') {
      $CI = &get_instance();
      $CI->load->library('encrypt_url');
      return $CI->encrypt_url->decode($key);
   }
}

if (!function_exists('is_valid_date')) {
   function is_valid_date($str) {
      $split = [];
      if (preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $str, $split)) {
         return checkdate($split[2], $split[3], $split[1]);
      }
      return false;
   }
}

if (!function_exists('create_dir')) {
   function create_dir($dir) {
      if (!is_dir($dir)) {
         if (!mkdir($dir, 0777, true)) {
            die('Failed to create directory : ' . $dir);
         }
      }
   }
}

if (!function_exists('gval')) {
	function gval($tabel, $field_kunci, $diambil, $where) {
		if (is_array($field_kunci)){
			$dimana = array_combine($field_kunci,$where);
		} else {
			$dimana = array($field_kunci => $where);
		}
		
		
		$CI =& get_instance();		
		$CI->db->from($tabel);
        $CI->db->where($dimana);
        $query = $CI->db->get();
		$nama = $query->row();
 
        return $nama->$diambil;
	}
}

if (!function_exists('gval_mssql')) {
	function gval_mssql($tabel, $field_kunci, $diambil, $where) {
		if (is_array($field_kunci)){
			$dimana = array_combine($field_kunci,$where);
		} else {
			$dimana = array($field_kunci => $where);
		}
		
		
		$CI =& get_instance();
		$CI->mssql = $CI->load->database('mssql', TRUE);
		$CI->mssql->from($tabel);
        $CI->mssql->where($dimana);
        $query = $CI->mssql->get();
		$nama = $query->row();
 
        return $nama->$diambil;
	}
}

if (!function_exists('cek_jumlah_data')) {
	function cek_jumlah_data($field,$value,$table)
	{
		if (is_array($field)){
			$where = array_combine($field,$value);
		} else {
			$where = array($field => $value);
		}
		$CI =& get_instance();
		$CI->db->where($where);
		return $CI->db->count_all_results($table);
	}
}

if (!function_exists('penjumlahan_data')) {
	function penjumlahan_data($select,$table,$field,$value)
	{
		if (is_array($field)){
			$where = array_combine($field,$value);
		} else {
			$where = array($field => $value);
		}
		$CI =& get_instance();
		$CI->db->select_sum($select);
		$CI->db->where($where);
		$query = $CI->db->get($table);
		return $query->row()->$select;
	}
}

if (!function_exists('penjumlahan_data_database')) {
	function penjumlahan_data_database($select,$as,$table)
	{
		$CI =& get_instance();
		$CI->db->select_sum($select,$as);
		$query = $CI->db->get($table);
		return $query->row()->$as;
	}
}

if (!function_exists('penjumlahan_data_as')) {
	function penjumlahan_data_as($select,$as,$table,$field,$value)
	{
		if (is_array($field)){
			$where = array_combine($field,$value);
		} else {
			$where = array($field => $value);
		}
		$CI =& get_instance();
		$CI->db->select_sum($select,$as);
		$CI->db->where($where);
		$query = $CI->db->get($table);
		return $query->row()->$as;
	}
}

if (!function_exists('penjumlahan_data_as_mssql')) {
	function penjumlahan_data_as_mssql($select,$as,$table,$field,$value)
	{
		if (is_array($field)){
			$where = array_combine($field,$value);
		} else {
			$where = array($field => $value);
		}
		$CI =& get_instance();
		$CI->mssql = $CI->load->database('mssql', TRUE);
		$CI->mssql->select_sum($select,$as);
		$CI->mssql->where($where);
		$query = $CI->mssql->get($table);
		return $query->row()->$as;
	}
}

if (!function_exists('penjumlahan_data_as_kec')) {
	function penjumlahan_data_as_kec($select,$as,$id_kec)
	{
		$CI =& get_instance();
		$CI->db->select_sum($select,$as);
		$CI->db->from('report');
		$CI->db->join('project', 'report.id_project = project.project_id');
		$CI->db->where('project.id_kec', $id_kec);
		$query = $CI->db->get();
		return $query->row()->$as;
	}
}

if (!function_exists('penjumlahan_data_as_admin')) {
	function penjumlahan_data_as_admin($select,$as,$id_admin)
	{
		$CI =& get_instance();
		$CI->db->select_sum($select,$as);
		$CI->db->from('report');
		$CI->db->join('project', 'report.id_project = project.project_id');
		$CI->db->where('project.admin', $id_admin);
		$query = $CI->db->get();
		return $query->row()->$as;
	}
}

if ( ! function_exists('rp1'))
{
	function rp1($nilaiUang) {
		$nilaiRupiah = "";
		$jumlahAngka = strlen($nilaiUang);
		while($jumlahAngka > 3){
			$nilaiRupiah = "." . substr($nilaiUang,-3) . $nilaiRupiah;
			$sisaNilai = strlen($nilaiUang) - 3;
			$nilaiUang = substr($nilaiUang,0,$sisaNilai);
			$jumlahAngka = strlen($nilaiUang);
		}
	 
		$nilaiRupiah = "Rp " . $nilaiUang . $nilaiRupiah;
		return $nilaiRupiah;
	}
}

if ( ! function_exists('replace_key'))
{
	function replace_key($find, $replace, $array) {
	 $arr = array();
	 foreach ($array as $key => $value) {
	  if ($key == $find) {
	   $arr[$replace] = $value;
	  } else {
	   $arr[$key] = $value;
	  }
	 }
	 return $arr;
	}
}

if ( ! function_exists('jumlah_hari_kerja'))
{
	function jumlah_hari_kerja($dari,$sampai) {
		$datetime1 = new DateTime($dari);
		$datetime2 = new DateTime($sampai);
		$interval = $datetime1->diff($datetime2);
		$result = $interval->format('%d');
		return $result+1;
	}
}

if ( ! function_exists('satu_hari_sebelum'))
{
	function satu_hari_sebelum($tanggal) {
		$date=date_create($tanggal);
		date_add($date,date_interval_create_from_date_string("-1 days"));
		return date_format($date,"Y-m-d");
	}
}

if ( ! function_exists('satu_minggu_sebelum'))
{
	function satu_minggu_sebelum($tanggal) {
		$date=date_create($tanggal);
		date_add($date,date_interval_create_from_date_string("-7 days"));
		return date_format($date,"Y-m-d");
	}
}

if ( ! function_exists('tanggal_mingguan'))
{
	function tanggal_mingguan($dari,$sampai) {
		$hasil_mingguan = '';
		$tanggal = [];
		$awal = strtotime($dari);
		$akhir = strtotime($sampai);
		for($i=$awal+604800;$i<=$akhir;$i+=604800)
		{
			$tanggal[]=[
			'tgl_laporan'	=> satu_hari_sebelum(date('Y-m-d', $i)),
			'dari_tanggal'	=> satu_minggu_sebelum(date('Y-m-d', $i)),
			'sampai_tanggal'	=> satu_hari_sebelum(date('Y-m-d', $i))
			];
			

		}
		$arr   = end($tanggal);
		$minggu_akhir = $arr['tgl_laporan'];
		$hari_kerja = jumlah_hari_kerja($dari,$sampai);
		$cek		= $hari_kerja % 7;
		$akhir_kontrak = [];
//		$ubah_data = [];
		if ($cek != 0){
//			unset($tanggal[count($tanggal)-1]);
//			$ubah_data[] = [
//			'tgl_laporan' => $arr['sampai_tanggal'],
//			'dari_tanggal' => $arr['dari_tanggal'],
//			'sampai_tanggal' => $arr['sampai_tanggal']
//			];
			$akhir_kontrak[] = [
			'tgl_laporan' => $sampai,
			'dari_tanggal' => $minggu_akhir,
			'sampai_tanggal' => $sampai
			];
		
//			$hasil_mingguan = array_merge($tanggal,$ubah_data,$akhir_kontrak);
			$hasil_mingguan = array_merge($tanggal,$akhir_kontrak);
		} else {
			$hasil_mingguan = $tanggal;		
		}
		
		
		
		return $hasil_mingguan;
	}
}

if ( ! function_exists('harga_total'))
{
	function harga_total($hs,$vol) {
		return $hs*$vol;
	}
}

if ( ! function_exists('hitung_bobot'))
{
	function hitung_bobot($hs,$vol,$nilai) {
		return (harga_total($hs,$vol)/$nilai)*100;
	}
}

if ( ! function_exists('two_digits'))
{
	function two_digits($numb) {
		return sprintf("%02d", $numb);
	}
}

if ( ! function_exists('three_digits'))
{
	function three_digits($numb) {
		return sprintf("%03d", $numb);
	}
}

if (!function_exists('fputcsvx')) {
    function fputcsvx($filePointer,$dataArray,$delimiter)
	  {
	  // Write a line to a file
	  // $filePointer = the file resource to write to
	  // $dataArray = the data to write out
	  // $delimeter = the field separator
	 
	  // Build the string
	  $string = "";
	 
	  // No leading delimiter
	  $writeDelimiter = FALSE;
	  foreach($dataArray as $dataElement)
	   {
		// Replaces a double quote with two double quotes
		//$dataElement=str_replace("\"", "\"\"", $dataElement);
	   
		// Adds a delimiter before each field (except the first)
		if($writeDelimiter) $string .= $delimiter;
	   
		// Encloses each field with $enclosure and adds it to the string
		$string .= $dataElement;
	   
		// Delimiters are used every time except the first.
		$writeDelimiter = TRUE;
	   } // end foreach($dataArray as $dataElement)
	 
	  // Append new line
	  $string .= "\n";
	 
	  // Write the string to the file
	  fwrite($filePointer,$string);
	  }
}

if ( ! function_exists('array2csv'))
{
	function array2csv(array &$array)
	{
	   if (count($array) == 0) {
		 return null;
	   }
	   ob_start();
	   $df = fopen("php://output", 'w');
	   //fputcsv($df, array_keys(reset($array)));
	   foreach ($array as $row) {
		  fputcsvx($df, $row, ',');
	   }
	   fclose($df);
	   return ob_get_clean();
	}
}

if ( ! function_exists('array2csv2'))
{
	function array2csv2(array &$array)
	{
	   if (count($array) == 0) {
		 return null;
	   }
	   ob_start();
	   $df = fopen("php://output", 'w');
	   //fputcsv($df, array_keys(reset($array)));
	   foreach ($array as $row) {
		  fputcsvx($df, $row, ';');
	   }
	   fclose($df);
	   return ob_get_clean();

	}
}

if ( ! function_exists('download_send_headers'))
{
	function download_send_headers($filename) {
		// disable caching
		$now = gmdate("D, d M Y H:i:s");
		header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
		header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
		header("Last-Modified: {$now} GMT");

		// force download  
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");

		// disposition / encoding on response body
		header("Content-Disposition: attachment;filename={$filename}");
		header("Content-Transfer-Encoding: binary");
	}
}