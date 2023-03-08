<?php
require_once('../../config.php');
		
global $USER , $DB, $CFG ;	

$cid = $_POST['cid'];
 
 $cartcourses = $DB->delete_records('cm_cartcourses',array('userid' => $USER->id,'courseid' => $cid ));


$crtcourses = $DB->get_records('cm_cartcourses',array('userid' => $USER->id));
$totalcost = 125 * count($crtcourses);

$response_data = array("id"=>$cid,"totaldue"=>$totalcost);
echo json_encode($response_data);

 			 
	
	
	