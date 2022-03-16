<?php
	class ConfigModel extends CI_Model{
		public function __construct(){
			parent::__construct();
			error_reporting(E_ALL & ~E_NOTICE);
		}
		
		public function getConfigVals(){
			$headerparams = array(
						'CLIENT_NAME' => $this->getParamvalue(array('param_name'=>'CLIENT_NAME')),
						'SENDING_EMAIL' => $this->getParamvalue(array('param_name'=>'SENDING_EMAIL')),
						'WEBSITE_URL' => $this->getParamvalue(array('param_name'=>'WEBSITE_URL')),
						'RECEIVING_EMAIL' => $this->getParamvalue(array('param_name'=>'RECEIVING_EMAIL')),
						'BUSINESS_ADDRESS' => $this->getParamvalue(array('param_name'=>'BUSINESS_ADDRESS')),
						'BUSINESS_NAME' => $this->getParamvalue(array('param_name'=>'BUSINESS_NAME')),
						'CLIENT_CONTACT' => $this->getParamvalue(array('param_name'=>'CLIENT_CONTACT')),
						'CURRENCY_SYMBOL' => $this->getParamvalue(array('param_name'=>'CURRENCY_SYMBOL')),
						'RECORDS_PER_LIST' => $this->getParamvalue(array('param_name'=>'RECORDS_PER_LIST')),
						'SUBFOLDER_NAME' => $this->getParamvalue(array('param_name'=>'SUBFOLDER_NAME')),
						'FACEBOOK_LINK' => $this->getParamvalue(array('param_name'=>'FACEBOOK_LINK')),
						'TWITTER_LINK' => $this->getParamvalue(array('param_name'=>'TWITTER_LINK')),
						'YOUTUBE_LINK' => $this->getParamvalue(array('param_name'=>'YOUTUBE_LINK')),
						'LINKEDIN_LINK' => $this->getParamvalue(array('param_name'=>'LINKEDIN_LINK')),
						'SKYPE_LINK' => $this->getParamvalue(array('param_name'=>'SKYPE_LINK')),
						'GOOLGEPLUS_LINK' => $this->getParamvalue(array('param_name'=>'GOOLGEPLUS_LINK')),
						'PINTRUST_LINK' => $this->getParamvalue(array('param_name'=>'PINTRUST_LINK')),
						'INSTAGRAM_LINK' => $this->getParamvalue(array('param_name'=>'INSTAGRAM_LINK')),
						'OPENING_HOURS' => $this->getParamvalue(array('param_name'=>'OPENING_HOURS')),
						'DELIVERY_CHARGES' => $this->getParamvalue(array('param_name'=>'DELIVERY_CHARGES'))
						);
			return $headerparams;
		}
		
		public function getParamvalue($data){
			$query = $this->db->select('param_value');
			$query = $this->db->where('param_name',$data['param_name']);
			$query = $this->db->limit('500');
			$query = $this->db->get('config_params');
			//echo $this->db->last_query();  
			$res = $query->result();
			foreach($res as $prmval){
				$param_value = $prmval->param_value;
			}
			return $param_value;
		}
		
		
	}
		