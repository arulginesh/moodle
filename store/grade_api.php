<?php
require_once('../config.php');
require_once($CFG->dirroot . '/course/lib.php');

	   $schoolname = $_GET['schoolname'];
			
	 $functionnasme = 'local_school_grades_service_get_grades_details';
	$restformat = 'json';
	$token = '99c244086d13e5f6fd0746d3760543ee';
		
		//$params = array('userid' => $user->id);
		//$schoolname = 'South Sutter Charter School';
		$params = array('schoolname'=>$schoolname);
	  
		$serverurl = $CFG->wwwroot . '/webservice/rest/server.php'. '?wstoken=' . $token . '&wsfunction='.$functionnasme.'&moodlewsrestformat=json';

		$curl = new curl;
		$resp = $curl->post($serverurl, $params);
		echo $resp ;
      
		
		

?>