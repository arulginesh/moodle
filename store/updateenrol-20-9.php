<?php
require_once('../config.php');
		
global $USER , $DB, $CFG ;	

 $courses = $DB->get_records_sql("select id,shortname from {course} where id !=1 and visible = 1 and category = 28");


foreach($courses as $course){
	
	if (!$DB->record_exists('enrol', array('enrol' => 'stripepayment', 'courseid' => $course->id))) {		
 
		$objRecord = new stdClass();
		$objRecord->enrol	= 'stripepayment';
		$objRecord->status	= 0;
		$objRecord->courseid = $course->id;
		$objRecord->sortorder = 6;
		$objRecord->name = $course->shortname;
		$objRecord->cost = 125;
		$objRecord->currency = 'USD';
		$objRecord->roleid = 5;
		$objRecord->customint3 = 0;
		$objRecord->timecreated	= time();
		$objRecord->timemodified = time();
		$DB->insert_record('enrol',$objRecord);

	} 
	
	if ($DB->record_exists('enrol', array('enrol' => 'stripepayment', 'courseid' => $course->id))) {	
		$enrols = $DB->get_records_sql("select id from {enrol} where enrol != 'stripepayment' and courseid = $course->id");
			foreach($enrols as $enrol){
				$updRecord = new stdClass();
				$updRecord->id	= $enrol->id;
				$updRecord->status	= 1;
				$DB->update_record('enrol',$updRecord);
			}

	}	

	
}




?>