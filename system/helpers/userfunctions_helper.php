<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// ------------------------------------------------------------------------
//$this->load->Model('DBModel' , 'db');

if ( ! function_exists('order_amount')){
	function order_amount($that, $orderid){
		if($orderid != '' ){
			$that->load->Model('DBModel');
			$cond = array(
						'orderid' => $orderid
					);
					
			$that->db->from('cart');
			$that->db->where($cond);
			
			$query = $that->db->get();
			$order_total_amount = 0;
			foreach ($query->result() as $row){
				$order_total_amount += $row->unitprice * $row->orderqty;
			}
			return($order_total_amount);
		}
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('added_tocart')){
	function added_tocart($that, $userid, $itemid, $item_type){
		
			$that->load->Model('DBModel');
			$cond = array(
						'orderid' => '',
						'userid' => $userid,
						'itemid' => $itemid,
						'item_type' => $item_type
					);
					
			$recs = $that->DBModel->getCondData('cart', $cond);
			if(count($recs)>0){
				return true;
			}else{
				return false;
			}
		
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('translate')){
	function translate($string) {
		global $dbcon;
		$ci = & get_instance();
		$lang = $ci->session->userdata('preflang');
		$cond = array(
				'en'=>$string
				);
		$ci->load->model('DBModel');
		$artrnsldata = $ci->DBModel->getCondData('translations',$cond);
		
		if(count($artrnsldata)>0){
			foreach($artrnsldata as $trasnlstr){
				
				$retval = $trasnlstr->$lang;
				if($retval != ''){
					break;
				}
			}
		}else{
			$retval = $string;
		} 
		return $retval;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('translate_content')){
	function translate_content($type) {
		global $dbcon;
		$ci = & get_instance();
		$lang = $ci->session->userdata('preflang');
		$cond = array(
				'type'=>$type
				);
		$ci->load->model('DBModel');
		$artrnsldata = $ci->DBModel->getCondData('static_contents',$cond);
		
		if(count($artrnsldata)>0){
			foreach($artrnsldata as $trasnlstr){
				
				$retval = $trasnlstr->$lang;
				if($retval != ''){
					break;
				}
			}
		}else{
			$retval = $string;
		} 
		return $retval;
	}
}


// ------------------------------------------------------------------------

if ( ! function_exists('generateRandomString')){
	function generateRandomString($length = 10) {
		$characters = '123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return trim($randomString);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('getipaddr')){
	function getipaddr(){
		/*$js = file_get_contents( 'http://www.whatsmyip.us/showipsimple.php');
		$nonreq=array('document.write("', '");');
		$ipval=str_replace($nonreq,"",$js);
		return $ipval;*/
		
		return (empty($_SERVER['HTTP_CLIENT_IP'])?(empty($_SERVER['HTTP_X_FORWARDED_FOR'])?
		$_SERVER['REMOTE_ADDR']:$_SERVER['HTTP_X_FORWARDED_FOR']):$_SERVER['HTTP_CLIENT_IP']);
	 
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('getfieldval')){
	function getfieldval($that, $recid,$tablename,$fieldname){
		if($recid != ''){
			
			$that->db->select($fieldname);
			$that->db->from($tablename);
			$that->db->where('id',$recid);
			
			
			$query = $that->db->get();
			foreach ($query->result() as $row){
				$fieldval = $row->$fieldname;
			}

			return($fieldval);
		}
	}
}

// ------------------------------------------------------------------------



if ( ! function_exists('getnumfieldval')){
	function getnumfieldval($that, $tablename,$fieldname, $valtype='max'){
		if($tablename != '' and $fieldname != ''){
			
			if($valtype == 'max'){
				$that->db->select_max($fieldname);
			}else if($valtype == 'min'){
				$that->db->select_min($fieldname);
			}
			$that->db->from($tablename);
			$query = $that->db->get();
			foreach ($query->result() as $row){
				$fieldval = $row->$fieldname;
			}
			return($fieldval);
			
		}
	}
}

// ------------------------------------------------------------------------


if ( ! function_exists('write_mail')){
	function write_mail($mailto,$mailsubj, $mailbody){
		$fh = fopen('write_mail.txt','a');
		$str2write = "To: ".$mailto."\r\n";
		$str2write .= "Subject: ".$mailsubj."\r\n";
		$str2write .= "Body: ".$mailbody."\r\n"."\r\n"."\r\n"."\r\n"."\r\n";
		fwrite($fh,$str2write);
		fclose($fh);
		return true;
	}
}


// ------------------------------------------------------------------------

if ( ! function_exists('isexists')){
	function isexists($that, $tablename, $condition){
			
			//$that->db->select($fieldname);
			$that->db->from($tablename);
			$that->db->where($condition);
			
			$query = $that->db->get();
			if(count($query->result())>0){
				return true;
			}else{
				return false;
			}
	}
}

// ------------------------------------------------------------------------

function resize_image($source_url, $reducedsize=0, $newwidth=0, $newheight=0) {
	 
	$info = getimagesize($source_url);
 
	if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);
	elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);
	elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);

	list($width,$height)=getimagesize($source_url);

	if($reducedsize > 0){
		$newwidth=$width - ($width * ($reducedsize / 100));
		$newheight=$height - ($height * ($reducedsize / 100)); //($height/$width)*$newwidth;
	}
	
	$tmp=imagecreatetruecolor($newwidth,$newheight);

	imagecopyresampled($tmp,$image,0,0,0,0,$newwidth,$newheight, $width,$height);

	$filename = $source_url;
	//$filename = "images/". $_FILES['file']['name'];

	imagejpeg($tmp,$filename,100);

	//imagedestroy($src);
	imagedestroy($tmp);

	return($filename);
}

// --------------------------------------------------------------------- //