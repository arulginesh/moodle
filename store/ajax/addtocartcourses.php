<?php
require_once('../../config.php');
		
global $USER , $DB ;		
$cid = $_POST['cid'];

if (!$DB->record_exists('cm_cartcourses', array('userid' => $USER->id, 'courseid' => $cid))) {		
	if($USER->id != 0 && $USER->id != '' && $cid != 0 && $cid != ''){
		$objRecord = new stdClass();
		$objRecord->userid	= $USER->id;
		$objRecord->courseid	= $cid;
		$objRecord->status	= 0;
		$objRecord->timecreated	= time();
		$DB->insert_record('cm_cartcourses',$objRecord);
	}
}
		?>

 			 
	
	
	