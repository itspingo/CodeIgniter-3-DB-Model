<?php
class DBModel extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		error_reporting(E_ALL & ~E_NOTICE);
	}


	public function getCondData($table, $condition, $orderby = "'id ASC'")
	{
		$this->db->where($condition);
		$this->db->order_by($orderby);
		$query = $this->db->get($table);
		//echo $this->db->last_query();  
		return $query->result();
	}

	public function getAllData($table, $orderby = "'id ASC'")
	{
		$this->db->order_by($orderby);
		$query = $this->db->get($table);
		return $query->result();
	}

	public function getListData($table, $colname, $listarray)
	{
		$this->db->where_in($colname, $listarray);

		$query = $this->db->get($table);
		//echo $this->db->last_query(); 
		return $query->result();
	}

	public function getActiveData($table, $orderby = "'id ASC'")
	{
		$this->db->where('active="Y"');
		$query = $this->db->get($table);
		//echo $this->db->last_query();  
		return $query->result();
	}

	public function insertData($table, $data)
	{
		//print_r($data);
		if ($this->db->insert($table, $data)) {
			//echo $this->db->last_query();  
			return $this->db->insert_id();
		} else {
			return false;
		}
	}


	public function updateData($table, $data, $where_cond)
	{
		$query = $this->db->where($where_cond);
		$query = $this->db->update($table, $data);
		//echo $this->db->last_query();  
		if ($query) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteData($table, $where_cond)
	{
		$this->db->where($where_cond);
		$query = $this->db->delete($table);
		//echo $this->db->last_query();  
		if ($query) {
			return true;
		} else {
			return false;
		}
	}


	public function rowsCount($table)
	{
		$nrows = $this->db->get($table)->num_rows();
		//echo $this->db->last_query();
		return $nrows;
	}

	public function rowsCondCount($table, $cond)
	{
		$this->db->where($cond);
		return $this->db->get($table)->num_rows();
	}


	public function fetch_records($tablnam, $srchcond = '', $pagconfg = '', $orderby = "'id DESC'")
	{
		//print_r($srchcond);
		$query = $this->db->from($tablnam);
		//$this->db->where('active="Y"');

		if ($srchcond != '') {
			if (count($srchcond) > 0) {
				$query = $this->db->like($srchcond);
			}
		}

		if ($pagconfg != '') {
			if ($pagconfg['srtcol'] != '') {
				$query = $this->db->order_by($pagconfg['srtcol'], ' ' . $pagconfg['srtord']);
			} else {
				$query = $this->db->order_by($orderby);
			}
		}

		if ($pagconfg != '') {
			if (count($pagconfg) > 0) {
				$query = $this->db->limit($pagconfg['per_page'], $pagconfg['per_page'] * $pagconfg['curpage']);
			}
		}
		$query = $this->db->get();

		//echo $this->db->last_query();
		return $query->result();
	}

	public function userQuery($dbquery, $result_return = true, $result_type = 'result')
	{
		if ($result_return == true) {
			$query = $this->db->query($dbquery);
			if ($result_type == 'result') {
				return $query->result();
			} elseif ($result_type == 'array') {
				return $query->result('array');
			} else {
				return ($this->db->error());
			}
		} else {
			if ($this->db->query($dbquery)) {
				return true;
			} else {
				return  $this->db->error();
			}
		}
	}

	public function getRow($table, $condition)
	{
		$this->db->where($condition);
		$query = $this->db->get($table);
		//echo $this->db->last_query();
		$row = $query->row();
		if ($row)
			return $row;
		else
			return false;
	}
}