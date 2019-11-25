<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_neu extends CI_Model {

	private $db2;
	public function __construct() {
		date_default_timezone_set('Asia/Jakarta');
		$this->db2 = $this->load->database('mssql', TRUE);
		$connected = $this->db2->initialize();
		if (!$connected)
		{
			$this->db2 = $this->load->database('default', TRUE);
		} 
	}

	public function dropdown($key, $value, $table, $is_null = FALSE, $text_null) {
		$query = $this->db->get($table);
		if ($query->num_rows() > 0) {
			if ($is_null != FALSE) {
				$data[NULL] = $text_null;
			}
			foreach ($query->result() as $row) {
				$data[$row->$key] = $row->$value;
			}
			return $data;
		} 
		return [];
	}
	
	/**
	 * is_exist()
	 * Fungsi untuk mengecek ketersediaan record data
	 * @return boolean
	 */
	public function is_exist($field, $value, $table, $pk = '', $id = '')
	{
		$this->db->where($field, $value);

		if ($id != '')
		{
			$this->db->where($pk . ' != ', $id);
		}

		return $this->db->count_all_results($table) > 0 ? TRUE : FALSE;
	}
	
		/**
	 * find()
	 * Fungsi untuk mengambil record data
	 * @return array
	 */
	public function find($table, $field = '', $value = '', $order_by = '', $order_type = '') {
		if ($field != '' && $value != '') {
			$this->db->where($field, $value);
		}

		if ($order_by != '') {
			if ($order_type != '') {
				$this->db->order_by($order_by, $order_type);
			} else {
				$this->db->order_by($order_by, 'ASC');
			}
		}

		return $this->db->get($table);
	}
	
	public function jumlah_data_total($table)
	{
		return $this->db->count_all_results($table);
	}
	
	
	public function jumlah_data_berdasarkan($field,$value,$table)
	{
		if (is_array($field)){
			$where = array_combine($field,$value);
		} else {
			$where = array($field => $value);
		}		
		$this->db->where($where);
		return $this->db->count_all_results($table);
	}
	


	
	public function jumlah_data_unik($select,$field,$value,$table)
	{		
		$this->db->distinct();
		$this->db->select($select);
		if ($field!='')
		{
			if (is_array($field)){
			$where = array_combine($field,$value);
			} else {
				$where = array($field => $value);
			}
			$this->db->where($where);
		}
		return $this->db->count_all_results($table);
	}
	
	public function get_pengaturan() {
      $query = $this->db->select('variable, value')->get('seting');
      $pengaturan = [];
      foreach($query->result() as $row) {
      	$pengaturan[$row->variable] = $row->value;
      }
      return $pengaturan;
   }
	
	public function update_seting($where, $data)
    {
        $this->db->update('seting', $data, $where);
        return $this->db->affected_rows();
    }
	
	public function export_skpd($kd_urusan,$kd_bidang,$kd_unit,$tahun)
    {
		$where = array('a.Tahun' => $tahun, 'a.Kd_Urusan' => $kd_urusan, 'a.Kd_Bidang' => $kd_bidang, 'a.Kd_Unit' => $kd_unit);
		$this->db2->select('a.*', FALSE);
		$this->db2->select('b.Nm_Rek_1 AS Rek_1', FALSE);
		$this->db2->select('c.Nm_Rek_2 AS Rek_2', FALSE);
		$this->db2->select('d.Nm_Rek_3 AS Rek_3', FALSE);
		$this->db2->select('e.Nm_Rek_4 AS Rek_4', FALSE);
		$this->db2->select('f.Nm_Rek_5 AS Rek_5', FALSE);
		$this->db2->select('g.Nm_Urusan AS Urusan', FALSE);
		$this->db2->select('h.Nm_Bidang AS Bidang', FALSE);
		$this->db2->select('i.Nm_Unit AS Unit', FALSE);
		$this->db2->select('j.Ket_Program AS Program, j.Kd_Urusan1 AS Kode_Urusan_Belanja, j.Kd_Bidang1 AS Kode_Bidang_Belanja', FALSE);
		$this->db2->select('k.Nm_Urusan AS Urusan_Belanja', FALSE);
		$this->db2->select('l.Nm_Bidang AS Bidang_Belanja', FALSE);
		$this->db2->select('m.Kd_Fungsi AS Kode_Fungsi, m.Nm_Fungsi AS Fungsi', FALSE);
		$this->db2->select('n.Ket_Kegiatan AS Kegiatan', FALSE);
		$this->db2->from('ta_belanja as a');
		$this->db2->join('ref_rek_1 as b', 'b.Kd_Rek_1 = a.Kd_Rek_1', 'left');
		$this->db2->join('ref_rek_2 as c', 'c.Kd_Rek_1 = a.Kd_Rek_1 AND c.Kd_Rek_2 = a.Kd_Rek_2', 'left');
		$this->db2->join('ref_rek_3 as d', 'd.Kd_Rek_1 = a.Kd_Rek_1 AND d.Kd_Rek_2 = a.Kd_Rek_2 AND d.Kd_Rek_3 = a.Kd_Rek_3', 'left');
		$this->db2->join('ref_rek_4 as e', 'e.Kd_Rek_1 = a.Kd_Rek_1 AND e.Kd_Rek_2 = a.Kd_Rek_2 AND e.Kd_Rek_3 = a.Kd_Rek_3 AND e.Kd_Rek_4 = a.Kd_Rek_4', 'left');
		$this->db2->join('ref_rek_5 as f', 'f.Kd_Rek_1 = a.Kd_Rek_1 AND f.Kd_Rek_2 = a.Kd_Rek_2 AND f.Kd_Rek_3 = a.Kd_Rek_3 AND f.Kd_Rek_4 = a.Kd_Rek_4 AND f.Kd_Rek_5 = a.Kd_Rek_5', 'left');
		$this->db2->join('ref_urusan as g', 'g.Kd_Urusan = a.Kd_Urusan', 'left');
		$this->db2->join('ref_bidang as h', 'h.Kd_Urusan = a.Kd_Urusan AND h.Kd_Bidang = a.Kd_Bidang', 'left');
		$this->db2->join('ref_unit as i', 'i.Kd_Urusan = a.Kd_Urusan AND i.Kd_Bidang = a.Kd_Bidang AND i.Kd_Unit = a.Kd_Unit', 'left');
		$this->db2->join('ta_program as j', 'j.Tahun = a.Tahun  AND j.Kd_Urusan = a.Kd_Urusan AND j.Kd_Bidang = a.Kd_Bidang AND j.Kd_Unit = a.Kd_Unit AND j.Kd_Sub = a.Kd_Sub AND j.Kd_Prog = a.Kd_Prog AND j.ID_Prog = a.ID_Prog', 'left');
		$this->db2->join('ref_urusan as k', 'k.Kd_Urusan = j.Kd_Urusan1', 'left');
		$this->db2->join('ref_bidang as l', 'l.Kd_Urusan = j.Kd_Urusan1 AND l.Kd_Bidang = j.Kd_Bidang1', 'left');
		$this->db2->join('ref_fungsi as m', 'm.Kd_Fungsi = l.Kd_Fungsi', 'left');
		$this->db2->join('ta_kegiatan as n', 'n.Tahun = a.Tahun  AND n.Kd_Urusan = a.Kd_Urusan AND n.Kd_Bidang = a.Kd_Bidang AND n.Kd_Unit = a.Kd_Unit AND n.Kd_Sub = a.Kd_Sub AND n.Kd_Prog = a.Kd_Prog AND n.ID_Prog = a.ID_Prog AND n.Kd_Keg = a.Kd_Keg', 'left');
		$this->db2->where($where);
		$this->db2->order_by('a.Kd_Urusan','asc');
		$this->db2->order_by('a.Kd_Bidang','asc');
		$this->db2->order_by('a.Kd_Unit','asc');
		$this->db2->order_by('a.Kd_Sub','asc');
		$this->db2->order_by('a.Kd_Prog','asc');
		$this->db2->order_by('a.ID_Prog','asc');
		$this->db2->order_by('a.Kd_Keg','asc');
		$this->db2->order_by('a.Kd_Rek_1','asc');
		$this->db2->order_by('a.Kd_Rek_2','asc');
		$this->db2->order_by('a.Kd_Rek_3','asc');
		$this->db2->order_by('a.Kd_Rek_4','asc');
		$this->db2->order_by('a.Kd_Rek_5','asc');
		$query = $this->db2->get();
        return $query->result();
    }

    public function ambilsatu($cari) {
 //   	$where =array('Ket_Kegiatan'=>$cari);
    	$this->db2->like('Ket_Kegiatan',$cari);
    	return $this->db2->get('ref_kegiatan')->result_array();

//        $this->db->where('indo', $kata);
  //      return $this->db->get('kamus')->result_array();
    }
	
	public function export_all($tahun)
    {
		$where = array('a.Tahun' => $tahun);
		$this->db2->select('a.*', FALSE);
		$this->db2->select('b.Nm_Rek_1 AS Rek_1', FALSE);
		$this->db2->select('c.Nm_Rek_2 AS Rek_2', FALSE);
		$this->db2->select('d.Nm_Rek_3 AS Rek_3', FALSE);
		$this->db2->select('e.Nm_Rek_4 AS Rek_4', FALSE);
		$this->db2->select('f.Nm_Rek_5 AS Rek_5', FALSE);
		$this->db2->select('g.Nm_Urusan AS Urusan', FALSE);
		$this->db2->select('h.Nm_Bidang AS Bidang', FALSE);
		$this->db2->select('i.Nm_Unit AS Unit', FALSE);
		$this->db2->select('j.Ket_Program AS Program, j.Kd_Urusan1 AS Kode_Urusan_Belanja, j.Kd_Bidang1 AS Kode_Bidang_Belanja', FALSE);
		$this->db2->select('k.Nm_Urusan AS Urusan_Belanja', FALSE);
		$this->db2->select('l.Nm_Bidang AS Bidang_Belanja', FALSE);
		$this->db2->select('m.Kd_Fungsi AS Kode_Fungsi, m.Nm_Fungsi AS Fungsi', FALSE);
		$this->db2->select('n.Ket_Kegiatan AS Kegiatan', FALSE);
		$this->db2->from('ta_belanja as a');
		$this->db2->join('ref_rek_1 as b', 'b.Kd_Rek_1 = a.Kd_Rek_1', 'left');
		$this->db2->join('ref_rek_2 as c', 'c.Kd_Rek_1 = a.Kd_Rek_1 AND c.Kd_Rek_2 = a.Kd_Rek_2', 'left');
		$this->db2->join('ref_rek_3 as d', 'd.Kd_Rek_1 = a.Kd_Rek_1 AND d.Kd_Rek_2 = a.Kd_Rek_2 AND d.Kd_Rek_3 = a.Kd_Rek_3', 'left');
		$this->db2->join('ref_rek_4 as e', 'e.Kd_Rek_1 = a.Kd_Rek_1 AND e.Kd_Rek_2 = a.Kd_Rek_2 AND e.Kd_Rek_3 = a.Kd_Rek_3 AND e.Kd_Rek_4 = a.Kd_Rek_4', 'left');
		$this->db2->join('ref_rek_5 as f', 'f.Kd_Rek_1 = a.Kd_Rek_1 AND f.Kd_Rek_2 = a.Kd_Rek_2 AND f.Kd_Rek_3 = a.Kd_Rek_3 AND f.Kd_Rek_4 = a.Kd_Rek_4 AND f.Kd_Rek_5 = a.Kd_Rek_5', 'left');
		$this->db2->join('ref_urusan as g', 'g.Kd_Urusan = a.Kd_Urusan', 'left');
		$this->db2->join('ref_bidang as h', 'h.Kd_Urusan = a.Kd_Urusan AND h.Kd_Bidang = a.Kd_Bidang', 'left');
		$this->db2->join('ref_unit as i', 'i.Kd_Urusan = a.Kd_Urusan AND i.Kd_Bidang = a.Kd_Bidang AND i.Kd_Unit = a.Kd_Unit', 'left');
		$this->db2->join('ta_program as j', 'j.Tahun = a.Tahun  AND j.Kd_Urusan = a.Kd_Urusan AND j.Kd_Bidang = a.Kd_Bidang AND j.Kd_Unit = a.Kd_Unit AND j.Kd_Sub = a.Kd_Sub AND j.Kd_Prog = a.Kd_Prog AND j.ID_Prog = a.ID_Prog', 'left');
		$this->db2->join('ref_urusan as k', 'k.Kd_Urusan = j.Kd_Urusan1', 'left');
		$this->db2->join('ref_bidang as l', 'l.Kd_Urusan = j.Kd_Urusan1 AND l.Kd_Bidang = j.Kd_Bidang1', 'left');
		$this->db2->join('ref_fungsi as m', 'm.Kd_Fungsi = l.Kd_Fungsi', 'left');
		$this->db2->join('ta_kegiatan as n', 'n.Tahun = a.Tahun  AND n.Kd_Urusan = a.Kd_Urusan AND n.Kd_Bidang = a.Kd_Bidang AND n.Kd_Unit = a.Kd_Unit AND n.Kd_Sub = a.Kd_Sub AND n.Kd_Prog = a.Kd_Prog AND n.ID_Prog = a.ID_Prog AND n.Kd_Keg = a.Kd_Keg', 'left');
		$this->db2->where($where);
		$this->db2->order_by('a.Kd_Urusan','asc');
		$this->db2->order_by('a.Kd_Bidang','asc');
		$this->db2->order_by('a.Kd_Unit','asc');
		$this->db2->order_by('a.Kd_Sub','asc');
		$this->db2->order_by('a.Kd_Prog','asc');
		$this->db2->order_by('a.ID_Prog','asc');
		$this->db2->order_by('a.Kd_Keg','asc');
		$this->db2->order_by('a.Kd_Rek_1','asc');
		$this->db2->order_by('a.Kd_Rek_2','asc');
		$this->db2->order_by('a.Kd_Rek_3','asc');
		$this->db2->order_by('a.Kd_Rek_4','asc');
		$this->db2->order_by('a.Kd_Rek_5','asc');
		$query = $this->db2->get();
        return $query->result();
    }
	
	public function pagu_anggaran($kd_urusan,$kd_bidang,$kd_unit,$kd_sub,$kd_prog,$id_prog,$kd_keg,$rek_1,$rek_2,$rek_3,$rek_4,$rek_5)
	{
		$where = array('Kd_Urusan' => $kd_urusan, 'Kd_Bidang' => $kd_bidang, 'Kd_Unit' => $kd_unit, 'Kd_Sub' => $kd_sub, 'Kd_Prog' => $kd_prog, 'ID_Prog' => $id_prog, 'Kd_Keg' => $kd_keg, 'Kd_Rek_1' => $rek_1, 'Kd_Rek_2' => $rek_2, 'Kd_Rek_3' => $rek_3, 'Kd_Rek_4' => $rek_4, 'Kd_Rek_5' => $rek_5);
		$this->db2->select_sum('Total','pagu_anggaran');
		$this->db2->where($where);
		$query = $this->db2->get('ta_belanja_rinc_sub');
		return $query->row()->pagu_anggaran;
	}
	
	public function export_skpd_simda($kd_urusan,$kd_bidang,$kd_unit,$tahun)
    {
		$where = array('a.Tahun' => $tahun, 'a.Kd_Urusan' => $kd_urusan, 'a.Kd_Bidang' => $kd_bidang, 'a.Kd_Unit' => $kd_unit);
		$this->db2->select('a.*', FALSE);
		$this->db2->select('b.Nm_Rek_1 AS Rek_1', FALSE);
		$this->db2->select('c.Nm_Rek_2 AS Rek_2', FALSE);
		$this->db2->select('d.Nm_Rek_3 AS Rek_3', FALSE);
		$this->db2->select('e.Nm_Rek_4 AS Rek_4', FALSE);
		$this->db2->select('f.Nm_Rek_5 AS Rek_5', FALSE);
		$this->db2->select('g.Nm_Urusan AS Urusan', FALSE);
		$this->db2->select('h.Nm_Bidang AS Bidang', FALSE);
		$this->db2->select('i.Nm_Unit AS Unit', FALSE);
		$this->db2->select('j.Ket_Program AS Program, j.Kd_Urusan1 AS Kode_Urusan_Belanja, j.Kd_Bidang1 AS Kode_Bidang_Belanja', FALSE);
		$this->db2->select('k.Nm_Urusan AS Urusan_Belanja', FALSE);
		$this->db2->select('l.Nm_Bidang AS Bidang_Belanja', FALSE);
		$this->db2->select('m.Kd_Fungsi AS Kode_Fungsi, m.Nm_Fungsi AS Fungsi', FALSE);
		$this->db2->select('n.Ket_Kegiatan AS Kegiatan', FALSE);
		$this->db2->from('ta_belanja_rinc_sub as a');
		$this->db2->join('ref_rek_1 as b', 'b.Kd_Rek_1 = a.Kd_Rek_1', 'left');
		$this->db2->join('ref_rek_2 as c', 'c.Kd_Rek_1 = a.Kd_Rek_1 AND c.Kd_Rek_2 = a.Kd_Rek_2', 'left');
		$this->db2->join('ref_rek_3 as d', 'd.Kd_Rek_1 = a.Kd_Rek_1 AND d.Kd_Rek_2 = a.Kd_Rek_2 AND d.Kd_Rek_3 = a.Kd_Rek_3', 'left');
		$this->db2->join('ref_rek_4 as e', 'e.Kd_Rek_1 = a.Kd_Rek_1 AND e.Kd_Rek_2 = a.Kd_Rek_2 AND e.Kd_Rek_3 = a.Kd_Rek_3 AND e.Kd_Rek_4 = a.Kd_Rek_4', 'left');
		$this->db2->join('ref_rek_5 as f', 'f.Kd_Rek_1 = a.Kd_Rek_1 AND f.Kd_Rek_2 = a.Kd_Rek_2 AND f.Kd_Rek_3 = a.Kd_Rek_3 AND f.Kd_Rek_4 = a.Kd_Rek_4 AND f.Kd_Rek_5 = a.Kd_Rek_5', 'left');
		$this->db2->join('ref_urusan as g', 'g.Kd_Urusan = a.Kd_Urusan', 'left');
		$this->db2->join('ref_bidang as h', 'h.Kd_Urusan = a.Kd_Urusan AND h.Kd_Bidang = a.Kd_Bidang', 'left');
		$this->db2->join('ref_unit as i', 'i.Kd_Urusan = a.Kd_Urusan AND i.Kd_Bidang = a.Kd_Bidang AND i.Kd_Unit = a.Kd_Unit', 'left');
		$this->db2->join('ta_program as j', 'j.Tahun = a.Tahun  AND j.Kd_Urusan = a.Kd_Urusan AND j.Kd_Bidang = a.Kd_Bidang AND j.Kd_Unit = a.Kd_Unit AND j.Kd_Sub = a.Kd_Sub AND j.Kd_Prog = a.Kd_Prog AND j.ID_Prog = a.ID_Prog', 'left');
		$this->db2->join('ref_urusan as k', 'k.Kd_Urusan = j.Kd_Urusan1', 'left');
		$this->db2->join('ref_bidang as l', 'l.Kd_Urusan = j.Kd_Urusan1 AND l.Kd_Bidang = j.Kd_Bidang1', 'left');
		$this->db2->join('ref_fungsi as m', 'm.Kd_Fungsi = l.Kd_Fungsi', 'left');
		$this->db2->join('ta_kegiatan as n', 'n.Tahun = a.Tahun  AND n.Kd_Urusan = a.Kd_Urusan AND n.Kd_Bidang = a.Kd_Bidang AND n.Kd_Unit = a.Kd_Unit AND n.Kd_Sub = a.Kd_Sub AND n.Kd_Prog = a.Kd_Prog AND n.ID_Prog = a.ID_Prog AND n.Kd_Keg = a.Kd_Keg', 'left');
		$this->db2->where($where);
		$this->db2->order_by('a.Kd_Urusan','asc');
		$this->db2->order_by('a.Kd_Bidang','asc');
		$this->db2->order_by('a.Kd_Unit','asc');
		$this->db2->order_by('a.Kd_Sub','asc');
		$this->db2->order_by('a.Kd_Prog','asc');
		$this->db2->order_by('a.ID_Prog','asc');
		$this->db2->order_by('a.Kd_Keg','asc');
		$this->db2->order_by('a.Kd_Rek_1','asc');
		$this->db2->order_by('a.Kd_Rek_2','asc');
		$this->db2->order_by('a.Kd_Rek_3','asc');
		$this->db2->order_by('a.Kd_Rek_4','asc');
		$this->db2->order_by('a.Kd_Rek_5','asc');
		$this->db2->order_by('a.No_Rinc','asc');
		$this->db2->order_by('a.No_ID','asc');
		$query = $this->db2->get();
        return $query->result();
    }
	
	public function export_all_simda($tahun)
    {
		$where = array('a.Tahun' => $tahun);
		$this->db2->select('a.*', FALSE);
		$this->db2->select('b.Nm_Rek_1 AS Rek_1', FALSE);
		$this->db2->select('c.Nm_Rek_2 AS Rek_2', FALSE);
		$this->db2->select('d.Nm_Rek_3 AS Rek_3', FALSE);
		$this->db2->select('e.Nm_Rek_4 AS Rek_4', FALSE);
		$this->db2->select('f.Nm_Rek_5 AS Rek_5', FALSE);
		$this->db2->select('g.Nm_Urusan AS Urusan', FALSE);
		$this->db2->select('h.Nm_Bidang AS Bidang', FALSE);
		$this->db2->select('i.Nm_Unit AS Unit', FALSE);
		$this->db2->select('j.Ket_Program AS Program, j.Kd_Urusan1 AS Kode_Urusan_Belanja, j.Kd_Bidang1 AS Kode_Bidang_Belanja', FALSE);
		$this->db2->select('k.Nm_Urusan AS Urusan_Belanja', FALSE);
		$this->db2->select('l.Nm_Bidang AS Bidang_Belanja', FALSE);
		$this->db2->select('m.Kd_Fungsi AS Kode_Fungsi, m.Nm_Fungsi AS Fungsi', FALSE);
		$this->db2->select('n.Ket_Kegiatan AS Kegiatan', FALSE);
		$this->db2->select('o.Nm_Sub_Unit AS Sub_Unit', FALSE);
		$this->db2->select('p.Keterangan AS Rincian', FALSE);
		$this->db2->from('ta_belanja_rinc_sub as a');
		$this->db2->join('ref_rek_1 as b', 'b.Kd_Rek_1 = a.Kd_Rek_1', 'left');
		$this->db2->join('ref_rek_2 as c', 'c.Kd_Rek_1 = a.Kd_Rek_1 AND c.Kd_Rek_2 = a.Kd_Rek_2', 'left');
		$this->db2->join('ref_rek_3 as d', 'd.Kd_Rek_1 = a.Kd_Rek_1 AND d.Kd_Rek_2 = a.Kd_Rek_2 AND d.Kd_Rek_3 = a.Kd_Rek_3', 'left');
		$this->db2->join('ref_rek_4 as e', 'e.Kd_Rek_1 = a.Kd_Rek_1 AND e.Kd_Rek_2 = a.Kd_Rek_2 AND e.Kd_Rek_3 = a.Kd_Rek_3 AND e.Kd_Rek_4 = a.Kd_Rek_4', 'left');
		$this->db2->join('ref_rek_5 as f', 'f.Kd_Rek_1 = a.Kd_Rek_1 AND f.Kd_Rek_2 = a.Kd_Rek_2 AND f.Kd_Rek_3 = a.Kd_Rek_3 AND f.Kd_Rek_4 = a.Kd_Rek_4 AND f.Kd_Rek_5 = a.Kd_Rek_5', 'left');
		$this->db2->join('ref_urusan as g', 'g.Kd_Urusan = a.Kd_Urusan', 'left');
		$this->db2->join('ref_bidang as h', 'h.Kd_Urusan = a.Kd_Urusan AND h.Kd_Bidang = a.Kd_Bidang', 'left');
		$this->db2->join('ref_unit as i', 'i.Kd_Urusan = a.Kd_Urusan AND i.Kd_Bidang = a.Kd_Bidang AND i.Kd_Unit = a.Kd_Unit', 'left');
		$this->db2->join('ta_program as j', 'j.Tahun = a.Tahun  AND j.Kd_Urusan = a.Kd_Urusan AND j.Kd_Bidang = a.Kd_Bidang AND j.Kd_Unit = a.Kd_Unit AND j.Kd_Sub = a.Kd_Sub AND j.Kd_Prog = a.Kd_Prog AND j.ID_Prog = a.ID_Prog', 'left');
		$this->db2->join('ref_urusan as k', 'k.Kd_Urusan = j.Kd_Urusan1', 'left');
		$this->db2->join('ref_bidang as l', 'l.Kd_Urusan = j.Kd_Urusan1 AND l.Kd_Bidang = j.Kd_Bidang1', 'left');
		$this->db2->join('ref_fungsi as m', 'm.Kd_Fungsi = l.Kd_Fungsi', 'left');
		$this->db2->join('ta_kegiatan as n', 'n.Tahun = a.Tahun  AND n.Kd_Urusan = a.Kd_Urusan AND n.Kd_Bidang = a.Kd_Bidang AND n.Kd_Unit = a.Kd_Unit AND n.Kd_Sub = a.Kd_Sub AND n.Kd_Prog = a.Kd_Prog AND n.ID_Prog = a.ID_Prog AND n.Kd_Keg = a.Kd_Keg', 'left');
		$this->db2->join('ref_sub_unit as o', 'o.Kd_Urusan = a.Kd_Urusan AND o.Kd_Bidang = a.Kd_Bidang AND o.Kd_Unit = a.Kd_Unit AND o.Kd_Sub = a.Kd_Sub', 'left');
		$this->db2->join('ta_belanja_rinc as p', 'p.Tahun = a.Tahun  AND p.Kd_Urusan = a.Kd_Urusan AND p.Kd_Bidang = a.Kd_Bidang AND p.Kd_Unit = a.Kd_Unit AND p.Kd_Sub = a.Kd_Sub AND p.Kd_Prog = a.Kd_Prog AND p.ID_Prog = a.ID_Prog AND p.Kd_Keg = a.Kd_Keg AND p.Kd_Rek_1 = a.Kd_Rek_1 AND p.Kd_Rek_2 = a.Kd_Rek_2 AND p.Kd_Rek_3 = a.Kd_Rek_3 AND p.Kd_Rek_4 = a.Kd_Rek_4 AND p.Kd_Rek_5 = a.Kd_Rek_5 AND p.No_Rinc = a.No_Rinc', 'left');
		$this->db2->where($where);
		$this->db2->order_by('a.Kd_Urusan','asc');
		$this->db2->order_by('a.Kd_Bidang','asc');
		$this->db2->order_by('a.Kd_Unit','asc');
		$this->db2->order_by('a.Kd_Sub','asc');
		$this->db2->order_by('a.Kd_Prog','asc');
		$this->db2->order_by('a.ID_Prog','asc');
		$this->db2->order_by('a.Kd_Keg','asc');
		$this->db2->order_by('a.Kd_Rek_1','asc');
		$this->db2->order_by('a.Kd_Rek_2','asc');
		$this->db2->order_by('a.Kd_Rek_3','asc');
		$this->db2->order_by('a.Kd_Rek_4','asc');
		$this->db2->order_by('a.Kd_Rek_5','asc');
		$this->db2->order_by('a.No_Rinc','asc');
		$this->db2->order_by('a.No_ID','asc');
		$query = $this->db2->get();
        return $query->result();
    }
	
	public function export_to_pendapatan($tahun)
    {
		$where = array('a.Tahun' => $tahun);
		$this->db2->select('a.*', FALSE);
		$this->db2->select('b.Nm_Rek_1 AS Rek_1', FALSE);
		$this->db2->select('c.Nm_Rek_2 AS Rek_2', FALSE);
		$this->db2->select('d.Nm_Rek_3 AS Rek_3', FALSE);
		$this->db2->select('e.Nm_Rek_4 AS Rek_4', FALSE);
		$this->db2->select('f.Nm_Rek_5 AS Rek_5', FALSE);
		$this->db2->select('g.Nm_Urusan AS Urusan', FALSE);
		$this->db2->select('h.Nm_Bidang AS Bidang', FALSE);
		$this->db2->select('i.Nm_Unit AS Unit', FALSE);
		$this->db2->select('j.Ket_Program AS Program, j.Kd_Urusan1 AS Kode_Urusan_Belanja, j.Kd_Bidang1 AS Kode_Bidang_Belanja', FALSE);
		$this->db2->select('k.Nm_Urusan AS Urusan_Belanja', FALSE);
		$this->db2->select('l.Nm_Bidang AS Bidang_Belanja', FALSE);
		$this->db2->select('m.Kd_Fungsi AS Kode_Fungsi, m.Nm_Fungsi AS Fungsi', FALSE);
		$this->db2->select('n.Ket_Kegiatan AS Kegiatan', FALSE);
		$this->db2->select('o.Nm_Sub_Unit AS Sub_Unit', FALSE);
		$this->db2->from('ta_pendapatan_rinc as a');
		$this->db2->join('ref_rek_1 as b', 'b.Kd_Rek_1 = a.Kd_Rek_1', 'left');
		$this->db2->join('ref_rek_2 as c', 'c.Kd_Rek_1 = a.Kd_Rek_1 AND c.Kd_Rek_2 = a.Kd_Rek_2', 'left');
		$this->db2->join('ref_rek_3 as d', 'd.Kd_Rek_1 = a.Kd_Rek_1 AND d.Kd_Rek_2 = a.Kd_Rek_2 AND d.Kd_Rek_3 = a.Kd_Rek_3', 'left');
		$this->db2->join('ref_rek_4 as e', 'e.Kd_Rek_1 = a.Kd_Rek_1 AND e.Kd_Rek_2 = a.Kd_Rek_2 AND e.Kd_Rek_3 = a.Kd_Rek_3 AND e.Kd_Rek_4 = a.Kd_Rek_4', 'left');
		$this->db2->join('ref_rek_5 as f', 'f.Kd_Rek_1 = a.Kd_Rek_1 AND f.Kd_Rek_2 = a.Kd_Rek_2 AND f.Kd_Rek_3 = a.Kd_Rek_3 AND f.Kd_Rek_4 = a.Kd_Rek_4 AND f.Kd_Rek_5 = a.Kd_Rek_5', 'left');
		$this->db2->join('ref_urusan as g', 'g.Kd_Urusan = a.Kd_Urusan', 'left');
		$this->db2->join('ref_bidang as h', 'h.Kd_Urusan = a.Kd_Urusan AND h.Kd_Bidang = a.Kd_Bidang', 'left');
		$this->db2->join('ref_unit as i', 'i.Kd_Urusan = a.Kd_Urusan AND i.Kd_Bidang = a.Kd_Bidang AND i.Kd_Unit = a.Kd_Unit', 'left');
		$this->db2->join('ta_program as j', 'j.Tahun = a.Tahun  AND j.Kd_Urusan = a.Kd_Urusan AND j.Kd_Bidang = a.Kd_Bidang AND j.Kd_Unit = a.Kd_Unit AND j.Kd_Sub = a.Kd_Sub AND j.Kd_Prog = a.Kd_Prog AND j.ID_Prog = a.ID_Prog', 'left');
		$this->db2->join('ref_urusan as k', 'k.Kd_Urusan = j.Kd_Urusan1', 'left');
		$this->db2->join('ref_bidang as l', 'l.Kd_Urusan = j.Kd_Urusan1 AND l.Kd_Bidang = j.Kd_Bidang1', 'left');
		$this->db2->join('ref_fungsi as m', 'm.Kd_Fungsi = l.Kd_Fungsi', 'left');
		$this->db2->join('ta_kegiatan as n', 'n.Tahun = a.Tahun  AND n.Kd_Urusan = a.Kd_Urusan AND n.Kd_Bidang = a.Kd_Bidang AND n.Kd_Unit = a.Kd_Unit AND n.Kd_Sub = a.Kd_Sub AND n.Kd_Prog = a.Kd_Prog AND n.ID_Prog = a.ID_Prog AND n.Kd_Keg = a.Kd_Keg', 'left');
		$this->db2->join('ref_sub_unit as o', 'o.Kd_Urusan = a.Kd_Urusan AND o.Kd_Bidang = a.Kd_Bidang AND o.Kd_Unit = a.Kd_Unit AND o.Kd_Sub = a.Kd_Sub', 'left');
		$this->db2->join('ta_belanja_rinc as p', 'p.Tahun = a.Tahun  AND p.Kd_Urusan = a.Kd_Urusan AND p.Kd_Bidang = a.Kd_Bidang AND p.Kd_Unit = a.Kd_Unit AND p.Kd_Sub = a.Kd_Sub AND p.Kd_Prog = a.Kd_Prog AND p.ID_Prog = a.ID_Prog AND p.Kd_Keg = a.Kd_Keg AND p.Kd_Rek_1 = a.Kd_Rek_1 AND p.Kd_Rek_2 = a.Kd_Rek_2 AND p.Kd_Rek_3 = a.Kd_Rek_3 AND p.Kd_Rek_4 = a.Kd_Rek_4 AND p.Kd_Rek_5 = a.Kd_Rek_5', 'left');
		$this->db2->where($where);
		$this->db2->order_by('a.Kd_Urusan','asc');
		$this->db2->order_by('a.Kd_Bidang','asc');
		$this->db2->order_by('a.Kd_Unit','asc');
		$this->db2->order_by('a.Kd_Sub','asc');
		$this->db2->order_by('a.Kd_Prog','asc');
		$this->db2->order_by('a.ID_Prog','asc');
		$this->db2->order_by('a.Kd_Keg','asc');
		$this->db2->order_by('a.Kd_Rek_1','asc');
		$this->db2->order_by('a.Kd_Rek_2','asc');
		$this->db2->order_by('a.Kd_Rek_3','asc');
		$this->db2->order_by('a.Kd_Rek_4','asc');
		$this->db2->order_by('a.Kd_Rek_5','asc');
		$this->db2->order_by('a.No_ID','asc');
		$query = $this->db2->get();
        return $query->result();
    }	
	public function export_to_gabung($tahun)
    {
		$where = array('b.Tahun' => $tahun);
		$this->db2->select('a.*', FALSE);
		$this->db2->select('b.Keterangan AS Rincian', FALSE);
		$this->db2->from('ref_rek_1 as a');
		$this->db2->join('ta_pendapatan_rinc as b', 'b.Kd_Rek_1 = a.Kd_Rek_1', 'left');
		$this->db2->where($where);
		$this->db2->order_by('a.Kd_Rek_1','asc');
		$query = $this->db2->get();
        return $query->result();
    }	    
}