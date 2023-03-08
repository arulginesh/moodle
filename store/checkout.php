<?php
require_once('../config.php');
		
global $USER , $DB, $CFG ;	


$cids = $_GET['ids'];


$_SESSION['cids'] = $cids ;
$_SESSION['cartmodes'] = 'cart';

if (!isloggedin()) {

$_SESSION['cids'] = $cids ;
$_SESSION['cartmodes'] = 'cart';	
	redirect($CFG->wwwroot.'/login/index.php?ids='.$cids.'&mode=cart');
} 


 if(!empty($cids)){
 $coursepids = explode(',',$cids);
 
 foreach($coursepids as $cid){
	 
	
	 
	if (!$DB->record_exists('cm_cartcourses', array('userid' => $USER->id, 'courseid' => $cid))) {		
 
		$objRecord = new stdClass();
		$objRecord->userid	= $USER->id;
		$objRecord->courseid	= $cid;
		$objRecord->status	= 0;
		$objRecord->timecreated	= time();
		//print_object($objRecord);
		$DB->insert_record('cm_cartcourses',$objRecord);
	}
	 
 }
 redirect('coursescheckout.php');
 }


?>