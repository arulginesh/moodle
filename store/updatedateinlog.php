<?php
require_once('../config.php');

global $USER , $DB, $CFG ;	

 
$translogs = $DB->get_records_sql("select id,userid,courseid from svhs_payment_transaction_log where datecreated is NULL");

foreach ($translogs as $tlog) {
	
$enrolcourses =  $DB->get_record_sql("SELECT ue.id,ue.timecreated FROM {user_enrolments} ue join {enrol} e on ue.enrolid = e.id where userid = $tlog->userid and courseid = $tlog->courseid");


		$objRecord = new stdClass();
		$objRecord->id	= $tlog->id;
		$objRecord->datecreated	= $enrolcourses->timecreated;
		
		$DB->update_record('payment_transaction_log',$objRecord);
		
}

 			 
	
	
	