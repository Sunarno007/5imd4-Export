<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Organisasi extends CI_Controller {
 private $db2;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('organisasi_model','organisasi');
		$this->pengaturan = $this->m_neu->get_pengaturan();
		$this->db2 = $this->load->database('mssql', TRUE);
    }
 
    public function index()
    {
		if ($this->session->userdata('level') != 'super-admin') {
			redirect('login');
        } else {
			ini_set('max_execution_time', 0);
			ini_set('memory_limit','-1');
			$this->breadcrumbs->push('Home', '/');
			$this->breadcrumbs->push('Simda<i class="fa fa-chevron-right"></i>Organisasi', 'organisasi');
			$data['breadcrumb'] = $this->breadcrumbs->show();
			$data['title'] = 'DAFTAR ORGANISASI';
			$data['simda'] = $data['organisasi'] = true;
			$data['alert'] = $this->session->flashdata('alert');
			$data['content'] = 'organisasi';
			$data['export_all_simda'] = $this->organisasi->count_all() == 0 ? '' : '<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Export to SIRUP" onclick="return loadUrl(\'organisasi/export_simda_all\');">EXPORT TO SIRUP</a>';
			$data['export_all_sikd'] = $this->organisasi->count_all() == 0 ? '' : '<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Export All" onclick="return loadUrl(\'organisasi/export_sikd_all\');">EXPORT FORMAT SIKD</a>';
			$data['export_to_pendapatan'] = $this->organisasi->count_all() == 0 ? '' : '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Export to Pendapatan" onclick="return loadUrl(\'organisasi/export_to_pendapatan\');">EXPORT to PENDAPATAN</a>';
			$data['export_to_gabung'] = $this->organisasi->count_all() == 0 ? '' : '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Export to Gabung" onclick="return loadUrl(\'organisasi/export_to_gabung\');">EXPORT to Gabung</a>';
			$data['ambilsatu'] = $this->organisasi->count_all() == 0 ? '' : '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Export to Gabung" onclick="return loadUrl(\'organisasi/ambilsatu\');">JJSON</a>';
			$this->load->view('index',$data);
		}
    }

    public function ajax_list()
    {
        if ($this->session->userdata('level') != 'super-admin') {
			redirect('login');
        } else {
			$list = $this->organisasi->get_datatables();
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $organisasi) {
				$no++;
				$row = array();
				$row[] = $no;
				$row[] = $organisasi->Nm_Unit;
				$row[] = '';
				$row[] = '';
	 
				$data[] = $row;
				
				
				
			}
	 
			$output = array(
							"draw" => $_POST['draw'],
							"recordsTotal" => $this->organisasi->count_all(),
							"recordsFiltered" => $this->organisasi->count_filtered(),
							"data" => $data,
					);
			echo json_encode($output);
		}
    }
	
	public function export_simda_skpd($kd_urusan,$kd_bidang,$kd_unit)
    {
        if ($this->session->userdata('level') != 'super-admin') {
			redirect('login');
        } else {
			ini_set('max_execution_time', 0);
			ini_set('memory_limit','-1');
			$Tahun_Anggaran = $this->pengaturan['tahun_anggaran'];
			$Satker_Pemda = $this->pengaturan['satker_pemda'];
			$Kode_Pemda = $this->pengaturan['kode_pemda'];
			$Kode_Data = '1';
			$list = $this->m_neu->export_skpd_simda($kd_urusan,$kd_bidang,$kd_unit,$Tahun_Anggaran);
			$data = array();
			foreach ($list as $result) {
				$row = array();
				$pagu_anggaran = str_replace('.0000','.00',$result->Total);			
				if(empty($pagu_anggaran) || $pagu_anggaran==0){ continue;}
				$row[] = $Tahun_Anggaran;
				$row[] = '"'.$Satker_Pemda.'"';
				$row[] = '"'.$Kode_Pemda.'"';
				$row[] = '"'.two_digits($Kode_Data).'"';
				$row[] = $result->Kd_Rek_1;
				$row[] = '"'.trim($result->Rek_1).'"';
				$row[] = $result->Kd_Rek_2;
				$row[] = '"'.trim($result->Rek_2).'"';
				$row[] = $result->Kd_Rek_3;
				$row[] = '"'.trim($result->Rek_3).'"';
				$row[] = '"'.two_digits($result->Kd_Rek_4).'"';
				$row[] = '"'.trim($result->Rek_4).'"';
				$row[] = '"'.two_digits($result->Kd_Rek_5).'"';
				$row[] = '"'.trim($result->Rek_5).'"';
				$row[] = '"'.two_digits($result->Kd_Urusan).'"';
				$row[] = '"'.trim($result->Urusan).'"';
				$row[] = '"'.two_digits($result->Kd_Bidang).'"';
				$row[] = '"'.trim($result->Bidang).'"';
				$row[] = '"'.two_digits($result->Kd_Unit).'"';
				$row[] = '"'.trim($result->Unit).'"';
				$row[] = '"'.two_digits($result->Kd_Prog).'"';
				$row[] = '"'.trim($result->Program).'"';
				$row[] = '"'.three_digits($result->Kd_Keg).'"';
				$row[] = '"'.trim($result->Kegiatan).'"';
				$row[] = $result->No_ID;
				$row[] = '"'.str_replace(array(PHP_EOL,"\r","\n",'"'), array('','','',''),trim($result->Keterangan)).'"';				
				$row[] = '"'.two_digits($result->Kode_Fungsi).'"';
				$row[] = '"'.trim($result->Fungsi).'"';
				$row[] = '"'.two_digits($result->Kode_Urusan_Belanja).'"';
				$row[] = '"'.trim($result->Urusan_Belanja).'"';
				$row[] = '"'.two_digits($result->Kode_Bidang_Belanja).'"';
				$row[] = '"'.trim($result->Bidang_Belanja).'"';
				$row[] = $pagu_anggaran;			
				$data[] = $row;
			}
	 
			download_send_headers(str_replace(array(' ',','),array('_',''),trim(gval_mssql('ref_unit',array('Kd_Urusan','Kd_Bidang','Kd_Unit'),'Nm_Unit',array($kd_urusan,$kd_bidang,$kd_unit))))."_SIMDA.csv");
			echo array2csv($data);
			die();	
		}
    }

    public function ambilsatu() {

        $cari = $this->input->post('cari');
        echo $cari;
        $json = array();
        $json['ket_kegiatan'] ="";
        $json['kd_keg']="";
   //     if (!empty($cari)) {
            $kata = $this->m_neu->ambilsatu($cari);
            if (!empty($kata)) {
                foreach ($kata as $kolom) {
                    $json[] = $kolom['Kd_Keg'];
                    $json[] = $kolom['Ket_Kegiatan'];
                }
            } else {
                $json = "";
            }
            echo json_encode($json);
 //       } else {
 //           echo "masuk22sda";
 //           $json = array();
 //           echo json_encode($json);
 //       }
    }
	
	public function export_simda_all()
    {
        if ($this->session->userdata('level') != 'super-admin') {
			redirect('login');
        } else {
			ini_set('max_execution_time', 0);
			ini_set('memory_limit','-1');
			$Tahun_Anggaran = $this->pengaturan['tahun_anggaran'];
			$Satker_Pemda = $this->pengaturan['satker_pemda'];
			$Kode_Pemda = $this->pengaturan['kode_pemda'];
			$Kode_Data = '2';
			$list = $this->m_neu->export_all_simda($Tahun_Anggaran);
			$data = array();
			foreach ($list as $result) {
				$row = array();
				$pagu_anggaran = str_replace('.0000','.00',$result->Total);
				if(empty($pagu_anggaran) || $pagu_anggaran==0){ continue;}
				$row[] = $Tahun_Anggaran;
				$row[] = $Satker_Pemda;
				$row[] = $Kode_Pemda;
				$row[] = $Kode_Data;
				$row[] = $result->Kd_Rek_1;
				$row[] = trim($result->Rek_1);
				$row[] = $result->Kd_Rek_2;
				$row[] = trim($result->Rek_2);
				$row[] = $result->Kd_Rek_3;
				$row[] = trim($result->Rek_3);
				$row[] = two_digits($result->Kd_Rek_4);
				$row[] = trim($result->Rek_4);
				$row[] = two_digits($result->Kd_Rek_5);
				$row[] = trim($result->Rek_5);
				$row[] = two_digits($result->Kd_Urusan);
				$row[] = trim($result->Urusan);
				$row[] = two_digits($result->Kd_Bidang);
				$row[] = trim($result->Bidang);
				$row[] = two_digits($result->Kd_Unit);
				$row[] = trim($result->Unit);
				$row[] = two_digits($result->Kd_Sub);
				$row[] = trim($result->Sub_Unit);
				$row[] = two_digits($result->Kd_Prog);
				$row[] = trim($result->Program);
				$row[] = three_digits($result->Kd_Keg);
				$row[] = trim($result->Kegiatan);
				$row[] = three_digits($result->No_Rinc);
				$row[] = str_replace(array(PHP_EOL,"\r","\n",'"'), array('','','',''),trim($result->Rincian));
				$row[] = three_digits($result->No_ID);
				$row[] = str_replace(array(PHP_EOL,"\r","\n",'"'), array('','','',''),trim($result->Keterangan));
				$row[] = $result->Jml_Satuan;
				$row[] = $result->Satuan123;
				$row[] = $result->Nilai_Rp;
				$row[] = two_digits($result->Kode_Fungsi);
				$row[] = trim($result->Fungsi);
				$row[] = two_digits($result->Kode_Urusan_Belanja);
				$row[] = trim($result->Urusan_Belanja);
				$row[] = two_digits($result->Kode_Bidang_Belanja);
				$row[] = trim($result->Bidang_Belanja);
				$row[] = $pagu_anggaran;			
				$data[] = $row;
			}
			
			$filename = $Tahun_Anggaran.$Satker_Pemda.two_digits($Kode_Data).'SiRUP.csv';
			header('Content-type: application/csv');
			header('Content-Disposition: attachment; filename='.$filename);
			 

			$fp = fopen('php://output', 'w');
			foreach ($data as $hasil) {
				//$fp = fopen('php://output', 'a');
				fputcsv($fp, $hasil);
                         
            }
			
			fclose($fp);
            exit;
			#download_send_headers($Tahun_Anggaran.$Satker_Pemda.two_digits($Kode_Data).'SiRUP.csv');
			#echo array2csv($data);
			#die();	
		}
    }
	
	public function export_sikd_skpd($kd_urusan,$kd_bidang,$kd_unit)
    {
        if ($this->session->userdata('level') != 'super-admin') {
			redirect('login');
        } else {
			ini_set('max_execution_time', 0);
			ini_set('memory_limit','-1');
			$Tahun_Anggaran = $this->pengaturan['tahun_anggaran'];
			$Satker_Pemda = $this->pengaturan['satker_pemda'];
			$Kode_Pemda = $this->pengaturan['kode_pemda'];
			$Kode_Data = '2';
			$list = $this->m_neu->export_skpd($kd_urusan,$kd_bidang,$kd_unit,$Tahun_Anggaran);
			$data = array();
			foreach ($list as $result) {
				$row = array();
				$pagu_anggaran = str_replace('.0000','.00',$this->m_neu->pagu_anggaran($result->Kd_Urusan,$result->Kd_Bidang,$result->Kd_Unit,$result->Kd_Sub,$result->Kd_Prog,$result->ID_Prog,$result->Kd_Keg,$result->Kd_Rek_1,$result->Kd_Rek_2,$result->Kd_Rek_3,$result->Kd_Rek_4,$result->Kd_Rek_5));			
				if(empty($pagu_anggaran) || $pagu_anggaran==0){ continue;}
				$row[] = $Tahun_Anggaran;
				$row[] = '"'.$Satker_Pemda.'"';
				$row[] = '"'.$Kode_Pemda.'"';
				$row[] = '"'.two_digits($Kode_Data).'"';
				$row[] = $result->Kd_Rek_1;
				$row[] = '"'.trim($result->Rek_1).'"';
				$row[] = $result->Kd_Rek_2;
				$row[] = '"'.trim($result->Rek_2).'"';
				$row[] = $result->Kd_Rek_3;
				$row[] = '"'.trim($result->Rek_3).'"';
				$row[] = '"'.two_digits($result->Kd_Rek_4).'"';
				$row[] = '"'.trim($result->Rek_4).'"';
				$row[] = '"'.two_digits($result->Kd_Rek_5).'"';
				$row[] = '"'.trim($result->Rek_5).'"';
				$row[] = '"'.two_digits($result->Kd_Urusan).'"';
				$row[] = '"'.trim($result->Urusan).'"';
				$row[] = '"'.two_digits($result->Kd_Bidang).'"';
				$row[] = '"'.trim($result->Bidang).'"';
				$row[] = '"'.two_digits($result->Kd_Unit).'"';
				$row[] = '"'.trim($result->Unit).'"';
				$row[] = '"'.two_digits($result->Kd_Prog).'"';
				$row[] = '"'.trim($result->Program).'"';
				$row[] = '"'.three_digits($result->Kd_Keg).'"';
				$row[] = '"'.trim($result->Kegiatan).'"';
				$row[] = '"'.two_digits($result->Kode_Fungsi).'"';
				$row[] = '"'.trim($result->Fungsi).'"';
				$row[] = '"'.two_digits($result->Kode_Urusan_Belanja).'"';
				$row[] = '"'.trim($result->Urusan_Belanja).'"';
				$row[] = '"'.two_digits($result->Kode_Bidang_Belanja).'"';
				$row[] = '"'.trim($result->Bidang_Belanja).'"';
				$row[] = $pagu_anggaran;			
				$data[] = $row;
			}
	 
			download_send_headers(str_replace(array(' ',','),array('_',''),trim(gval_mssql('ref_unit',array('Kd_Urusan','Kd_Bidang','Kd_Unit'),'Nm_Unit',array($kd_urusan,$kd_bidang,$kd_unit))))."_SIKD.csv");
			echo array2csv2($data);
			die();	
		}
    }
	
	public function export_sikd_all()
    {
        if ($this->session->userdata('level') != 'super-admin') {
			redirect('login');
        } else {
			ini_set('max_execution_time', 0);
			ini_set('memory_limit','-1');
			$Tahun_Anggaran = $this->pengaturan['tahun_anggaran'];
			$Satker_Pemda = $this->pengaturan['satker_pemda'];
			$Kode_Pemda = $this->pengaturan['kode_pemda'];
			$Kode_Data = '2';
			$list = $this->m_neu->export_all($Tahun_Anggaran);
			$data = array();
			foreach ($list as $result) {
				$row = array();
				$pagu_anggaran = str_replace('.0000','.00',$this->m_neu->pagu_anggaran($result->Kd_Urusan,$result->Kd_Bidang,$result->Kd_Unit,$result->Kd_Sub,$result->Kd_Prog,$result->ID_Prog,$result->Kd_Keg,$result->Kd_Rek_1,$result->Kd_Rek_2,$result->Kd_Rek_3,$result->Kd_Rek_4,$result->Kd_Rek_5));			
				if(empty($pagu_anggaran) || $pagu_anggaran==0){ continue;}
				$row[] = $Tahun_Anggaran;
				$row[] = '"'.$Satker_Pemda.'"';
				$row[] = '"'.$Kode_Pemda.'"';
				$row[] = '"'.two_digits($Kode_Data).'"';
				$row[] = $result->Kd_Rek_1;
				$row[] = '"'.trim($result->Rek_1).'"';
				$row[] = $result->Kd_Rek_2;
				$row[] = '"'.trim($result->Rek_2).'"';
				$row[] = $result->Kd_Rek_3;
				$row[] = '"'.trim($result->Rek_3).'"';
				$row[] = '"'.two_digits($result->Kd_Rek_4).'"';
				$row[] = '"'.trim($result->Rek_4).'"';
				$row[] = '"'.two_digits($result->Kd_Rek_5).'"';
				$row[] = '"'.trim($result->Rek_5).'"';
				$row[] = '"'.two_digits($result->Kd_Urusan).'"';
				$row[] = '"'.trim($result->Urusan).'"';
				$row[] = '"'.two_digits($result->Kd_Bidang).'"';
				$row[] = '"'.trim($result->Bidang).'"';
				$row[] = '"'.two_digits($result->Kd_Unit).'"';
				$row[] = '"'.trim($result->Unit).'"';
				$row[] = '"'.two_digits($result->Kd_Prog).'"';
				$row[] = '"'.trim($result->Program).'"';
				$row[] = '"'.three_digits($result->Kd_Keg).'"';
				$row[] = '"'.trim($result->Kegiatan).'"';
				$row[] = '"'.two_digits($result->Kode_Fungsi).'"';
				$row[] = '"'.trim($result->Fungsi).'"';
				$row[] = '"'.two_digits($result->Kode_Urusan_Belanja).'"';
				$row[] = '"'.trim($result->Urusan_Belanja).'"';
				$row[] = '"'.two_digits($result->Kode_Bidang_Belanja).'"';
				$row[] = '"'.trim($result->Bidang_Belanja).'"';
				$row[] = $pagu_anggaran;			
				$data[] = $row;
			}
	 
			download_send_headers("KABUPATEN_KOTABARU_SIKD.csv");
			echo array2csv2($data);
			die();	
		}
    }

	public function export_to_pendapatan()
    {
        if ($this->session->userdata('level') != 'super-admin') {
			redirect('login');
        } else {
			ini_set('max_execution_time', 0);
			ini_set('memory_limit','-1');
			$Tahun_Anggaran = $this->pengaturan['tahun_anggaran'];
			$Satker_Pemda = $this->pengaturan['satker_pemda'];
			$Kode_Pemda = $this->pengaturan['kode_pemda'];
			$Kode_Data = '2';
			$list = $this->m_neu->export_to_pendapatan($Tahun_Anggaran);
			$data = array();
			foreach ($list as $result) {
				$row = array();
				$pagu_anggaran = str_replace('.0000','.00',$result->Total);
				if(empty($pagu_anggaran) || $pagu_anggaran==0){ continue;}
				$row[] = $Tahun_Anggaran;
				$row[] = $Satker_Pemda;
				$row[] = $Kode_Pemda;
				$row[] = $Kode_Data;
				$row[] = $result->Kd_Rek_1;
				$row[] = trim($result->Rek_1);
				$row[] = $result->Kd_Rek_2;
				$row[] = trim($result->Rek_2);
				$row[] = $result->Kd_Rek_3;
				$row[] = trim($result->Rek_3);
				$row[] = two_digits($result->Kd_Rek_4);
				$row[] = trim($result->Rek_4);
				$row[] = two_digits($result->Kd_Rek_5);
				$row[] = trim($result->Rek_5);
				$row[] = two_digits($result->Kd_Urusan);
				$row[] = trim($result->Urusan);
				$row[] = two_digits($result->Kd_Bidang);
				$row[] = trim($result->Bidang);
				$row[] = two_digits($result->Kd_Unit);
				$row[] = trim($result->Unit);
				$row[] = two_digits($result->Kd_Sub);
				$row[] = trim($result->Sub_Unit);
				$row[] = two_digits($result->Kd_Prog);
				$row[] = trim($result->Program);
				$row[] = three_digits($result->Kd_Keg);
				$row[] = trim($result->Kegiatan);
				$row[] = str_replace(array(PHP_EOL,"\r","\n",'"'), array('','','',''),trim($result->Keterangan));
				$row[] = three_digits($result->No_ID);
				$row[] = $result->Jml_Satuan;
				$row[] = $result->Satuan123;
				$row[] = $result->Nilai_Rp;
				$row[] = two_digits($result->Kode_Fungsi);
				$row[] = trim($result->Fungsi);
				$row[] = two_digits($result->Kode_Urusan_Belanja);
				$row[] = trim($result->Urusan_Belanja);
				$row[] = two_digits($result->Kode_Bidang_Belanja);
				$row[] = trim($result->Bidang_Belanja);
				$row[] = $result->Total;
				$row[] = $pagu_anggaran;			
				$data[] = $row;
			}
			
			$filename = $Tahun_Anggaran.$Satker_Pemda.two_digits($Kode_Data).'-Pendapatan.csv';
			header('Content-type: application/csv');
			header('Content-Disposition: attachment; filename='.$filename);
			 

			$fp = fopen('php://output', 'w');
			foreach ($data as $hasil) {
				//$fp = fopen('php://output', 'a');
				fputcsv($fp, $hasil);
                         
            }
			
			fclose($fp);
            exit;
			#download_send_headers($Tahun_Anggaran.$Satker_Pemda.two_digits($Kode_Data).'SiRUP.csv');
			#echo array2csv($data);
			#die();	
		}
    }

	public function export_to_gabung()
    {
        if ($this->session->userdata('level') != 'super-admin') {
			redirect('login');
        } else {
			ini_set('max_execution_time', 0);
			ini_set('memory_limit','-1');
			$Tahun_Anggaran = $this->pengaturan['tahun_anggaran'];
			$Satker_Pemda = $this->pengaturan['satker_pemda'];
			$Kode_Pemda = $this->pengaturan['kode_pemda'];
			$Kode_Data = '2';
			$list = $this->m_neu->export_to_gabung($Tahun_Anggaran);
			$data = array();
			foreach ($list as $result) {
				$row = array();
				if(empty($pagu_anggaran) || $pagu_anggaran==0){ continue;}
				$row[] = $Tahun_Anggaran;
				$row[] = $Satker_Pemda;
				$row[] = $Kode_Pemda;
				$row[] = $Kode_Data;
				$row[] = $result->Kd_Rek_1;
				$row[] = trim($result->Rek_1);
				$row[] = str_replace(array(PHP_EOL,"\r","\n",'"'), array('','','',''),trim($result->Rincian));
				$data[] = $row;
			}
			
			$filename = $Tahun_Anggaran.$Satker_Pemda.two_digits($Kode_Data).'Gabung.csv';
			header('Content-type: application/csv');
			header('Content-Disposition: attachment; filename='.$filename);
			 

			$fp = fopen('php://output', 'w');
			foreach ($data as $hasil) {
				//$fp = fopen('php://output', 'a');
				fputcsv($fp, $hasil);
                         
            }
			
			fclose($fp);
            exit;
			#download_send_headers($Tahun_Anggaran.$Satker_Pemda.two_digits($Kode_Data).'SiRUP.csv');
			#echo array2csv($data);
			#die();	
		}
    }    
}