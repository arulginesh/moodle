<?php
require_once('../config.php');
require_once($CFG->dirroot . '/course/lib.php');

	
	
	
	  
	$functionnasme = 'core_grades_get_grades';
	$restformat = 'json';
      $token = '4fc3cec61d0e2e7166bf1aa23ae440d4';
	 
		$params = array(
 'courseid' => 343,
 'userids[0]' => 1017
 );
	  

       $serverurl = $CFG->wwwroot . '/webservice/rest/server.php'. '?wstoken=' . $token . '&wsfunction='.$functionnasme;

      $curl = new curl;
      $restformat = ($restformat == 'json')?'&moodlewsrestformat=' . $restformat:'';
      $resp = $curl->post($serverurl . $restformat, $params);
      $arrOutput  = json_decode($resp,true);
	 
	 print_object($arrOutput);
	foreach($arrOutput as $record){
		
	}
	

?>