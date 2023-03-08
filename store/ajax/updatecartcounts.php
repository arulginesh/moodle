<?php
require_once('../../config.php');
require_once($CFG->libdir. '/coursecatlib.php');

global $USER , $DB, $CFG ;	

 
$cartcourses = $DB->get_records('cm_cartcourses',array('userid' => $USER->id));
$aeids = array();
foreach ($cartcourses as $cidss) {
$enrolcourses =  $DB->get_record_sql("SELECT ue.id,e.courseid FROM {user_enrolments} ue join {enrol} e on ue.enrolid = e.id where userid = $USER->id and courseid = $cidss->courseid");

if(!empty($enrolcourses->courseid)){
	$aeids[] = $cidss->courseid;	 
}
}

$cartids = implode(',',$aeids);
 
if(!empty($cartids)){
	$crtcourses = $DB->get_records_sql("select * from {cm_cartcourses} where userid = $USER->id and courseid NOT IN($cartids)");
} else {
	$crtcourses = $DB->get_records('cm_cartcourses',array('userid' => $USER->id));
}

$cartcoursescnt = count($crtcourses);
    
 if($cartcoursescnt != 0){
 
$content_append = "<ul class='list-group list-group-flush'>";
 foreach ($crtcourses as $cartcourse) {
	   
     

   	   $course = $DB->get_record('course',array('id' => $cartcourse->courseid));
		
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
            $courseimage = $CFG->wwwroot . '/store/img/image.png';
			
        }
		

  

  	$content_append .= "<li class='list-group-item' style='padding: 0px;line-height:20px;'>";
	$content_append .= "<div style='float:left;margin-right:10px;'><img width='60px' src='".$courseimage."'></div>";
	$content_append .= "<div style='font-size: 11px;'>".$course->fullname."</div> ";
	$content_append .= "<div style='font-size: 11px;'> $125 <span style='float:right;'><a onclick='removecartcrs(".$course->id.")'><i style='font-size:20px;color: #000;' class='fa fa-times-circle' aria-hidden='true'></i></a></span>  </div>";
  	$content_append .= "</li>";
  
 } 
	$checkoutpath = $CFG->wwwroot.'/store/coursescheckout.php';
	$subtotal = 125 * count($crtcourses);

	$content_append .="</ul>";
	$content_append .= "<div style='border-top: 1px solid #ddd;border-bottom: 1px solid #ddd;padding: 10px;font-size: 11px;'><span>Subtotal :</span> <span style='float:right;'>$ ".$subtotal."</span> </div>";
	$content_append .= "<div style='margin-top:15px;'><a style='padding: 5px 109px;font-size: 11px;background: #629cd1;text-decoration: none;' href='".$checkoutpath."' class='btn-primary'>View Cart</a></div>";
	$content_append .="<div style='margin-top:15px;'><a style='padding: 5px 110px;font-size: 11px;background: #3165ae;text-decoration: none;' href='".$checkoutpath."' class='btn-primary'>Checkout</a></div>";
	$content_append .= "<div style='margin-top:15px;'><a style='padding: 5px 115px;font-size: 11px;background: #629cd1;text-decoration: none;
	width: 265px;' href='".$orderpath."' class='btn-primary'>Orders</a></div>";
 } else { 

	$content_append = "<ul class='list-group list-group-flush'> ";
	$content_append.= "<li class='list-group-item' style='padding: 0px;'>";
	$content_append.= "<div style='font-size: 11px;'>No products in the cart.</div> </li>";
	$content_append.= "</ul>";

} 

$responseData = array("content"=>$content_append,"itemcount"=>$cartcoursescnt);

echo json_encode($responseData);

 			 
	
	
	