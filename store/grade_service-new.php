<?php
require_once('../config.php');
require_once($CFG->dirroot . '/course/lib.php');


	  
	/* $schools = $DB->get_records_sql("select name from svhs_schools_detail where parent = 'IEM'");  
	
	foreach($schools as $school){ */
		 
		$users = $DB->get_records_sql("select userid from svhs_user_info_data where data = 'South Sutter Charter School'");
		
	$arr = array(); 
		foreach($users as $user){
				
			$courses = $DB->get_records_sql("select courseid from svhs_user_enrolments as ue join svhs_enrol as e on e.id = ue.enrolid where ue.userid = $user->userid");
			
			foreach($courses as $course){
				
				 		
				$grades = $DB->get_records_sql("select id,itemname from svhs_grade_items where courseid=$course->courseid");
				
				$data= array();
				
				foreach($grades as $grade){
						
					$gradegrades = $DB->get_record_sql("select id,finalgrade from svhs_grade_grades where userid=$user->userid and itemid=$grade->id");

					$data[] = array(
						'itemname' => $grade->itemname,
						'finalgrade' => $gradegrades->finalgrade
						
					);
				}
				
			  	array_push($arr,array('user' => $user->userid,'course' => $course->courseid,'grade' => $data));	

			}
			
		}
	 

		echo $json = json_encode($arr);
	

?>