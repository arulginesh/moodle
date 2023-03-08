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
				
				if(!empty($course->courseid)){
					
				$grades = $DB->get_records_sql("select id,iteminstance from svhs_grade_items where courseid=$course->courseid and itemtype = 'category'");
				
				$data= array();
				$assigndata= array();
				
				foreach($grades as $grade){
					
					
					
					$items = $DB->get_records_sql("select group_concat(id) as id from svhs_grade_items where courseid=$course->courseid and categoryid = $grade->iteminstance and itemmodule != 'assign'");

					foreach($items as $item){
					
					
					$data[] = $item->id;
						
					}
					
					$assigns = $DB->get_records_sql("select id,itemname from svhs_grade_items where courseid=$course->courseid and categoryid = $grade->iteminstance and itemmodule = 'assign'");

					foreach($assigns as $assign){
					
						
					$gradegrades = $DB->get_record_sql("select id,finalgrade from svhs_grade_grades where userid=$user->userid and itemid=$assign->id");

					$assigndata[] = array(
						'itemname' => $assign->itemname,
						'finalgrade' =>	$gradegrades->finalgrade
						); 
						
					}
					
				}
				
				
					$quizs = $data[0];
					if(!empty($quizs)){
					$arrquizs = $DB->get_records_sql("select id,itemname from svhs_grade_items where id IN($quizs)");
					$gradequiz = array();
					foreach($arrquizs as $arrquiz){
						$gradegrades = $DB->get_record_sql("select id,finalgrade from svhs_grade_grades where userid=$user->userid and itemid=$arrquiz->id");

						$gradequiz[] = array(
						'itemname' => $arrquiz->itemname,
						'finalgrade' =>	$gradegrades->finalgrade
						); 
					}
					}
					
					$units = $data[1];
					if(!empty($units)){
					$arrunits = $DB->get_records_sql("select id,itemname from svhs_grade_items where id IN($units)");
					$gradeunits = array();
					foreach($arrunits as $arrunit){
						$gradegradesunits = $DB->get_record_sql("select id,finalgrade from svhs_grade_grades where userid=$user->userid and itemid=$arrunit->id");

						$gradeunits[] = array(
						'itemname' => $arrunit->itemname,
						'finalgrade' =>	$gradegradesunits->finalgrade
						); 
					}
					}
					
					$practicefe = $data[2];
					if(!empty($practicefe)){
					$arrpracticefe = $DB->get_records_sql("select id,itemname from svhs_grade_items where id IN($practicefe)");
					$gradepfexam = array();
					foreach($arrpracticefe as $arrpfe){
						$gradegradespfe = $DB->get_record_sql("select id,finalgrade from svhs_grade_grades where userid=$user->userid and itemid=$arrpfe->id");

						$gradepfexam[] = array(
						'itemname' => $arrpfe->itemname,
						'finalgrade' =>	$gradegradespfe->finalgrade
						); 
					}
					}
					
					$practicfe = $data[3];
					if(!empty($practicfe)){
					$arrpracticfe = $DB->get_records_sql("select id,itemname from svhs_grade_items where id IN($practicfe)");
					$gradefexam = array();
					foreach($arrpracticfe as $arrfe){
						$gradegradespfe = $DB->get_record_sql("select id,finalgrade from svhs_grade_grades where userid=$user->userid and itemid=$arrfe->id");

						$gradefexam[] = array(
						'itemname' => $arrfe->itemname,
						'finalgrade' =>	$gradegradespfe->finalgrade
						); 
					}
					}
					
					$courseoverallgrade = $DB->get_record_sql("select id from svhs_grade_items where courseid=$course->courseid and itemtype = 'course'");
					$gradegradeovarall = $DB->get_record_sql("select id,finalgrade from svhs_grade_grades where userid=$user->userid and itemid=$courseoverallgrade->id");
					
					$overallgrade = array(
					'overall_grade' => $gradegradeovarall->finalgrade
					);
					
					//print_object($data);
					
				
				
			  	array_push($arr,array('user' => $user->userid,'course' => $course->courseid,'grade' => array('quiz'=>$gradequiz,'unit'=>$gradeunits,'assignments'=>$assigndata,'practice_final_exam'=>$gradepfexam,'final_exam'=>$gradefexam,'course_overall_grade'=>$overallgrade)));	
				
				}
			 }
			
		} 
	 

		echo $json = json_encode($arr);
	

?>