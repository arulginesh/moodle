<?php
require_once('../../config.php');
$srhtext = $_POST['srhtext'];		
 $filterval = $_POST['filterval'];
 $checkboxval = $_POST['checkboxval'];
 
 if(!empty($checkboxval)){
	$checkopts = explode(',',$checkboxval);
	$uofc = $checkopts[0];
	$ncaa = $checkopts[1];
	
	if(!empty($filterval)){		
		if(!empty($uofc) && !empty($ncaa)){
			
		$courses1 = $DB->get_records_sql("select id,fullname from {course} c 
						 where c.category = 28 and c.visible = 1 and cm_branch IN($filterval) and (uofc = 1 or ncaa = 1) order by fullname asc ");
		} else if(!empty($uofc)){
			
			if($uofc =='calif'){
			$courses1 = $DB->get_records_sql("select id,fullname from {course} c 
						 where c.category = 28 and c.visible = 1 and cm_branch IN($filterval) and uofc = 1 order by fullname asc ");
			} else {
			
			$courses1 = $DB->get_records_sql("select id,fullname from {course} c 
						 where c.category = 28 and c.visible = 1 and cm_branch IN($filterval) and ncaa = 1 order by fullname asc ");
			}
		}
	} else {
		if(!empty($uofc) && !empty($ncaa)){
			
		$courses1 = $DB->get_records_sql("select id,fullname from {course} c 
						 where c.category = 28 and c.visible = 1 and (uofc = 1 or ncaa = 1) order by fullname asc ");
		} else if(!empty($uofc)){
			
			if($uofc =='calif'){
			$courses1 = $DB->get_records_sql("select id,fullname from {course} c 
						 where c.category = 28 and c.visible = 1 and uofc = 1 order by fullname asc ");
			} else {
			
			$courses1 = $DB->get_records_sql("select id,fullname from {course} c 
						 where c.category = 28 and c.visible = 1 and ncaa = 1 order by fullname asc ");
			}
		}
		
	}

} else {
	
	if(!empty($filterval)){	
		if(!empty($srhtext)){	
		 $courses1 = $DB->get_records_sql("select id,fullname from {course} c 
							 where c.category = 28 and c.visible = 1 and cm_branch IN($filterval) and (lower(fullname) like '%".strtolower($srhtext)."%') order by fullname asc");
		
		
		} else {
		$courses1 = $DB->get_records_sql("select id,fullname from {course} c 
							 where c.category = 28 and c.visible = 1 and cm_branch IN($filterval) order by fullname asc ");
		}
	} else {

		if(!empty($srhtext)){	
		$courses1 = $DB->get_records_sql("select id,fullname from {course} c 
							 where c.category = 28 and c.visible = 1 and (lower(fullname) like '%".strtolower($srhtext)."%') order by fullname asc ");
		} else {
		$courses1 = $DB->get_records_sql("select id,fullname from {course} c 
						 where c.category = 28 and c.visible = 1 order by fullname asc ");
		}	
	}
}

// if(!empty($checkboxval)){
// 	$checkopts = explode(',',$checkboxval);
// 	$uofc = $checkopts[0];
// 	$ncaa = $checkopts[1];
	
// 	if(!empty($filterval)){		
// 		if(!empty($uofc) && !empty($ncaa)){
			
// 		$courses1 = $DB->get_records_sql("select id,fullname from {course} c 
// 						 where c.id IN(371,374,392,404,410) and c.visible = 1 and cm_branch IN($filterval) and (uofc = 1 or nacc = 1) order by fullname asc ");
// 		} else if(!empty($uofc)){
			
// 			if($uofc =='calif'){
// 			$courses1 = $DB->get_records_sql("select id,fullname from {course} c 
// 						 where c.id IN(371,374,392,404,410) and c.visible = 1 and cm_branch IN($filterval) and uofc = 1 order by fullname asc ");
// 			} else {
			
// 			$courses1 = $DB->get_records_sql("select id,fullname from {course} c 
// 						 where c.id IN(371,374,392,404,410) and c.visible = 1 and cm_branch IN($filterval) and nacc = 1 order by fullname asc ");
// 			}
// 		}
// 	} else {
// 		if(!empty($uofc) && !empty($ncaa)){
			
// 		$courses1 = $DB->get_records_sql("select id,fullname from {course} c 
// 						where c.id IN(371,374,392,404,410)  and c.visible = 1 and (uofc = 1 or ncaa = 1) order by fullname asc ");
// 		} else if(!empty($uofc)){
			
// 			if($uofc =='calif'){
// 			$courses1 = $DB->get_records_sql("select id,fullname from {course} c 
// 						where c.id IN(371,374,392,404,410)  and c.visible = 1 and uofc = 1 order by fullname asc ");
// 			} else {
			
// 			$courses1 = $DB->get_records_sql("select id,fullname from {course} c 
// 						where c.id IN(371,374,392,404,410)  and c.visible = 1 and ncaa = 1 order by fullname asc ");
// 			}
// 		}
// 	}
// } else {
// 	if(!empty($filterval)){	
// 		if(!empty($srhtext)){	
// 		$courses1 = $DB->get_records_sql("select id,fullname from {course} c 
// 							where c.id IN(371,374,392,404,410)  and c.visible = 1 and cm_branch IN($filterval) and (lower(fullname) like '%".strtolower($srhtext)."%') order by fullname asc");
		
		
// 		} else {
// 		$courses1 = $DB->get_records_sql("select id,fullname from {course} c 
// 							where c.id IN(371,374,392,404,410)  and c.visible = 1 and cm_branch IN($filterval) order by fullname asc ");
// 		}
// 	} else {

// 		if(!empty($srhtext)){	
// 		$courses1 = $DB->get_records_sql("select id,fullname from {course} c 
// 							where c.id IN(371,374,392,404,410)  and c.visible = 1 and (lower(fullname) like '%".strtolower($srhtext)."%') order by fullname asc ");
// 		} else {
// 		$courses1 = $DB->get_records_sql("select id,fullname from {course} c 
// 						where c.id IN(371,374,392,404,410)  and c.visible = 1 order by fullname asc ");
// 		}	
// 	}
// }


$cuntc1 = count($courses1);		
		 
if($cuntc1 > 0){	
	
foreach ($courses1 as $course){
	
	 require_once($CFG->libdir. '/coursecatlib.php');
		$course = $DB->get_record('course',array('id' => $course->id));

	    $course = new course_in_list($course);
		
		$courselink = new moodle_url('/course/view.php', array('id' => $course->id,'visible' => 1));
        $coursenamelink = html_writer::link($courselink, $course->fullname, array('class' => $course->visible ? '' : 'dimmed'));
	
		$courseimage = '';
		foreach ($course->get_course_overviewfiles() as $file) {
		    $isimage = $file->is_valid_image();

            $url = new moodle_url("$CFG->wwwroot/pluginfile.php" . '/'. $file->get_contextid(). '/'. $file->get_component(). '/'.
            $file->get_filearea(). $file->get_filepath(). $file->get_filename(), ['forcedownload' => !$isimage]);

			$courseimage = $url ;
		}
        if (empty($courseimage)) {
            $courseimage = $CFG->wwwroot . "/store/img/courses.png";
			
        }
		
		$enrolcourses =  $DB->get_records_sql("SELECT ue.id FROM {user_enrolments} ue join {enrol} e on ue.enrolid = e.id where userid = $USER->id and courseid = $course->id");
 $cntencorse = count($enrolcourses);
 
 $coursen = str_replace(",","",$course->fullname);
 $coursenl = str_replace(" ","-",$coursen);

		?>
		
          <div class="col-12 col-md-6 col-lg-3 text-center">
            <div class="mb-3">
              <a class="img-title"><?php 
			  if($course->cm_branch == 1){
				  $bname = 'Art';
			  } else if($course->cm_branch == 2){
				  $bname = 'Electives';
			  } else if($course->cm_branch == 3){
				  $bname = 'English';
			  } else if($course->cm_branch == 4){
				  $bname = 'Languages';
			  } else if($course->cm_branch == 5){
				  $bname = 'Math';
			  } else if($course->cm_branch == 6){
				  $bname = 'Science';
			  } else if($course->cm_branch == 7){
				  $bname = 'Social science';
			  }
			  
			  echo ucfirst($bname) ; ?>  </a>
            </div>
            <div class="img-block">
			
			<a target="_blank" href="<?php echo "https://svhs.co/store/online-high-school-$bname-courses/$coursenl-id-$course->id/" ; ?>">
			
                <img width="240" height="160" src="<?php echo $courseimage ; ?>">
            
			 </a>  
			 
            </div>
            <div class="mt-3">
              <a target="_blank" href="<?php echo "https://svhs.co/store/online-high-school-$bname-courses/$coursenl-id-$course->id/" ; ?>" class="img-subtitle"><?php echo ucfirst($course->fullname) ; ?></a>
            </div>
            <p class="img-subtext" style="margin-bottom: 0.2rem;">$125.00
			</p>
			<!-- <?php 
			if($cntencorse == 0 ){
					if (!$DB->record_exists('cm_cartcourses', array('userid' => $USER->id, 'courseid' => $course->id))) {		

			?>
				<span id="cartadded<?php echo $course->id ; ?>" class="img-subtext" style="border: 1px solid #2F64AD;padding: 3px 8px;color: #fff;background: #2F64AD;cursor: pointer;"><a onclick="addtocart(<?php echo $course->id ; ?>)">
				Add to Cart</a></span>	
			<?php } else { ?>
				<span class="img-subtext" style="border: 1px solid #2F64AD;padding: 3px 8px;color: #fff;background: #2F64AD;"><i style="color: lime;font-size: 17px;" class="fa fa-check" aria-hidden="true"></i>
				Added to Cart</span>
			<?php }
			} else {
			?>
			<span class="img-subtext" style="border: 1px solid #2F64AD;padding: 3px 8px;color: #fff;background: #2F64AD;"><i style="color: lime;font-size: 17px;" class="fa fa-check" aria-hidden="true"></i>
				Enrolled</span>
			<?php } ?> -->

			<?php
			            if($cntencorse == 0 ){
							if (!$DB->record_exists('cm_cartcourses', array('userid' => $USER->id, 'courseid' => $course->id))) {
								//Add to cart
								$status = "<a onclick='addtocart(".$course->id.")'>Add to Cart</a>";
								$style = "border: 1px solid #2F64AD;padding: 3px 8px;color: #fff;background: #2F64AD;cursor: pointer;";
								$icon = "";
							}else{
								// Added To cart
								$status = "Added to Cart";
								$style = "border: 1px solid #2F64AD;padding: 3px 8px;color: #fff;background: #2F64AD;";
								$icon = "<i style='color: lime;font-size: 17px;' class='fa fa-check' aria-hidden='true'></i>";
							}
						}else{
							//enrolled
							$status = "Enrolled";
							$style = "border: 1px solid #2F64AD;padding: 3px 8px;color: #fff;background: #2F64AD;";
							$icon = "<i style='color: lime;font-size: 17px;' class='fa fa-check' aria-hidden='true'></i>";
						}
			
					echo "<span id='cartadded".$course->id."' class='img-subtext' style='.$style.'>".$icon.' '.$status."</span>";
			?>
			<p class="img-subtext">
			</p>
          </div>
		  
		  
       <?php 
		}
		} else {	   
		?>
	
	 <div class="box generalbox" id="notice" >
	
  No matching Courses Found.</div>';
	
	
		<?php } ?>