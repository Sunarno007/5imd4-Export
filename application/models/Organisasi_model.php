<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Organisasi_model extends CI_Model {
 
    var $table = 'ref_unit';
    var $column_order = array('Kd_Urusan','Kd_Bidang','Kd_Unit','Nm_Unit',null); //set column field database for datatable orderable
    var $column_search = array('Nm_Unit'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('Nm_Unit' => 'asc'); // default order 
	private $mssql;
 
    public function __construct()
    {
        parent::__construct();
		$this->cek_db = $this->load->database('mssql', TRUE);
		$connected = $this->cek_db->initialize();
		if (!$connected)
		{
			$this->mssql = $this->load->database('default', TRUE);
		} else
		{
			$this->mssql = $this->load->database('mssql', TRUE);
		}
    }
 
    private function _get_datatables_query()
    {
         
        $this->mssql->from($this->table);
 
        $i = 0;
     
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->mssql->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->mssql->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->mssql->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->mssql->group_end(); //close bracket
            }
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->mssql->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->mssql->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->mssql->limit($_POST['length'], $_POST['start']);
        $query = $this->mssql->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->mssql->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->mssql->from($this->table);
        return $this->mssql->count_all_results();
    } 
}