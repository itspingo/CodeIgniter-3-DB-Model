<?php
	class UsersModel extends CI_Model{
		public function __construct(){
			parent::__construct();
			error_reporting(E_ALL & ~E_NOTICE);
		}
		
		public function verifyUser($table,$data){
			$this->db->where($data);
			$this->db->where('isverified','Y');
			$query = $this->db->get($table);
			//echo $this->db->last_query();  
			return $query->result();
		}
		
		public function validateKey($table, $data){
			$where_condition = 'verifkey="'.$data['verifkey'].'" and isverified = "N" ';
			$this->db->where($where_condition);
			$query = $this->db->get($table);
			$row = $query->result();
			$data = array(
						'isverified'=>'Y'
					  );
			$cond = array(
						'id'=>$row['id']
					  );		  
			if($this->db->updateData($table,$data,$cond)){
				
				return(true);
			}else{
				return(false);
			}
			//echo $this->db->last_query();
		}
		
		public function getData($table,$condition){
			$this->db->where($condition);
			$query = $this->db->get($table);
			//echo $this->db->last_query();  
			return $query->result();
		}
		
		public function getUsersData($table,$userid){
			$this->db->where('id',$userid);
			$query = $this->db->get($table);
			//echo $this->db->last_query();  
			return $query->result();
		}
		
		public function getAllRecs($table){
			$query = $this->db->get($table);
			return $query->result();
		}
		
		public function getActiveRecs($table){
			$this->db->where('active="Y"');
			$query = $this->db->get($table);
			//echo $this->db->last_query();  
			return $query->result();
		}
		
		public function insertData($table,$data){
			//print_r($data);
			if($this->db->insert($table,$data)){
				
				//$this->session->set_flashdata('success','Your account is created, please '.anchor(base_url().'login', 'Login', 'class="link-class"'));
				//echo $this->db->last_query();  
				return $this->db->insert_id();
			}else{
				//$this->session->set_flashdata('failure','Unable to insert the record');
				return false;
			}
		}
		
		
		
		
		public function updateData($table, $data,$where_cond){
			$query = $this->db->where($where_cond);
			$query = $this->db->update($table,$data);
			//echo $this->db->last_query();  
			if($query){
				//$this->session->set_flashdata('success','Record is update successfuly');
				return true;
			}else{
				//$this->session->set_flashdata('failure','Record is NOT udpated');
				return false;
			}
		}
		
		public function deleteRecs($table,$where_cond){
			$this->db->where($where_cond);
			$query = $this->db->delete($table);
			//echo $this->db->last_query();  
			if($query){
				//$this->session->set_flashdata('success','Record is update successfuly');
				return true;
			}else{
				//$this->session->set_flashdata('failure','Record is NOT udpated');
				return false;
			}
		}
		
		public function userExist($table,$data){
			$where_condition = 'user_name="'.$data['user_name'].'" OR '.'email_address="'.$data['email_address'].'"';
			$this->db->where($where_condition);
			$query = $this->db->get($table);
			//echo $this->db->last_query();  
			foreach ($query->result() as $row){
				$fullname = $row->full_name;
			}

			if($fullname != ''){
				//$this->session->set_flashdata('failure','User Name or Email address is already registered.');
				return(false);
			}else{
				return(true);
			}
		}
		
		public function records_count($table){
			return $this->db->get($table)->num_rows();
		}
		
		
		
	}
		