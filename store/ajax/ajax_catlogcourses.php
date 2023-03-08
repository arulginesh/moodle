<?php
require_once('../../config.php');
$srhtext = $_POST['srhtext'];		
 $filterval = $_POST['filterval'];
 
 
 
 $results_per_page = 10; 	


  if (!isset ($_POST['page'])) {  
        $page = 1;  
    } else {  
        $page = $_POST['page'];  
    }  
	
	 
  $page_first_result = ($page-1) * $results_per_page;  

 
if(!empty($filterval)){	
	if(!empty($srhtext)){	
	$courses1 = $DB->get_records_sql("select id,fullname from {course} c 
						 where c.category = 28 and c.visible = 1 and cm_branch IN($filterval) and (lower(fullname) like '%".strtolower($srhtext)."%') order by id desc LIMIT ". $page_first_result . ',' . $results_per_page);
	} else {
	$courses1 = $DB->get_records_sql("select id,fullname from {course} c 
						 where c.category = 28 and c.visible = 1 and cm_branch IN($filterval) order by id desc LIMIT ". $page_first_result . ',' . $results_per_page);
	}
} else {

	if(!empty($srhtext)){	
	$courses1 = $DB->get_records_sql("select id,fullname from {course} c 
						 where c.category = 28 and c.visible = 1 and (lower(fullname) like '%".strtolower($srhtext)."%') order by id desc LIMIT ". $page_first_result . ',' . $results_per_page);
	} else {
	$courses1 = $DB->get_records_sql("select id,fullname from {course} c 
					 where c.category = 28 and c.visible = 1 order by id desc LIMIT ". $page_first_result . ',' . $results_per_page);
	}
	

}	
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

			//$courseimage = $url ;
		}
        if (empty($courseimage)) {
            $courseimage = $CFG->wwwroot . "/store/img/courses.png";
			
        }
				
?>
 <div _ngcontent-kmb-c372="" class="course-tile ng-star-inserted">
		
		<tile _ngcontent-kmb-c372="" class="tile-el tile-first-row">
		<div class="tile-wrapper rectangular my-course vertical-card ng-star-inserted" >
		<div class="demo-card-wide mdl-card mdl-shadow--2dp 0 ng-star-inserted">
		<?php 
		$enrolcourses =  $DB->get_records_sql("SELECT ue.id FROM {user_enrolments} ue join {enrol} e on ue.enrolid = e.id where userid = $USER->id and courseid = $course->id");
 $cntencorse = count($enrolcourses);
if($cntencorse != 0 ){
	?>
		<a href="<?php echo $courselink ; ?>">
<?php } ?>
		<div <?php if($cntencorse != 0 ){ ?> style="cursor:pointer;" <?php } else { ?>  style="cursor:default;"<?php } ?> class="tile-bg bg-grey text-white has-background-image"><!----><!----><!---->
		<div class="tile-bg-image bg-white" style="background-image: url('<?php echo $courseimage ; ?>');"></div>
		<div class="demo-card-image">
		<!--<i class="zmdi zmdi-image-alt text-white hidden ng-star-inserted"></i>--><!----><!----><!----><!----><!----><!----><!---->
		<div class="item-status-box bolded text-white ng-star-inserted">
		<!--
		<span class="new-item bg-positive-green ng-star-inserted">new</span> 
		-->
		<!----><!----><!----><!----></div><!----><!---
		<div class="type-box bolded ng-star-inserted"><?php echo ($ct); ?></div>----><!----><!---->
		<!----></div></div>
		<?php if($cntencorse != 0 ){ ?>
		</a>
		<?php } ?>
	<!--	<div class="docebo-tooltip" id="<?php echo $course->id ;?>" style="top: 77px;position: absolute;display:none ">
<span class="text-tooltip"><?php echo $course->fullname ; ?></span>
</div>-->
		<div style="cursor:default;" class="tile-supporting-text ng-star-inserted"><div class="mdl-card__title"><h2 class="mdl-card__title-text text-main title-text-alt"><!---->
		<a style="cursor:default;" position="top" class="text-main ng-star-inserted" 
		
		aria-labelledby="docebo-tooltip-1" onmouseover="toll('<?php echo "$course->id" ; ?>');" onmouseout="tollh('<?php echo "$course->id" ; ?>')"><?php echo ucfirst($course->fullname) ; ?></a><!----><!----></h2></div>
		
		<?php 
if($cntencorse == 0 ){
		?>
		
		<div class="subtitle-boxes mdl-card__supporting-text text-mid-grey single-subtitleBox ng-star-inserted" style="margin-bottom: -19px;cursor:default;">
		<span style="font-size: 14px;"><i style="margin-right: -3px;" class="icon fa fa-usd text-muted fa-fw "></i>125</span>
		<?php
	
	if (!$DB->record_exists('cm_cartcourses', array('userid' => $USER->id, 'courseid' => $course->id))) {		
		
	?>
	<span id="cartadded<?php echo $course->id ; ?>">
		 <a style="font-size: 11px;float: right;margin-bottom: 11px;" class="btn btn-primary" onclick="addtocart(<?php echo $course->id ; ?>)" data-dismiss="modal">Add to Cart</a>		
		</span>	
		<?php } else { ?>
		
		<a style="font-size: 11px;float: right;margin-bottom: 11px;" class="btn btn-primary" data-dismiss="modal">
	<i style="color: lime;font-size: 17px;margin-left: -10px;margin-right: 5px;" class="fa fa-check" aria-hidden="true"></i>Added in cart</a>
		
	<?php } 
	?>	
		</div>
<?php } else { ?>	
		<div class="subtitle-boxes mdl-card__supporting-text text-mid-grey single-subtitleBox ng-star-inserted" style="cursor:default;">
		<span style="font-size: 14px;"><i style="margin-right: -3px;" class="icon fa fa-usd text-muted fa-fw "></i>125</span>
		
		</div>
<?php } ?>
		<!----><!----><!----></div><!----><!----><!----></div><!----><!----><!----><!----></div><!----><!---->
		</tile></div>	
	<?php } 

} else { ?>


	
<div _ngcontent-kmb-c372="" class="course-tile ng-star-inserted">
		
		<tile _ngcontent-kmb-c372="" class="tile-el tile-first-row">
		<div class="tile-wrapper rectangular my-course vertical-card ng-star-inserted" style="    border: 1px solid #ddd;
    margin-top: 17px;
    width: 800px !important;box-shadow: none;
    cursor: default;    background: #fff;margin-bottom: 65px;" >
		<div  style="min-height: 60px">
		
	
		<div class="tile-supporting-text ng-star-inserted"><div class="mdl-card__title"><h2 class="mdl-card__title-text text-main title-text-alt"><!---->
		<a position="top" style="cursor: default;" class="text-main ng-star-inserted"
		
		aria-labelledby="docebo-tooltip-1" ><b><?php echo 'No Courses Found.' ; ?></b></a><!----><!----></h2></div>
		
		
		<div class="subtitle-boxes mdl-card__supporting-text text-mid-grey single-subtitleBox ng-star-inserted"><div class="subtitle-box">
		
		 <div class="tile-author ng-star-inserted">
		 <div class="ng-star-inserted">
		<div position="top" class="truncated-text text-grey-mid ng-star-inserted" ><img style="width:70px;height:16px;display:none" src="img/rating/3.5.png"> </div>
	</div>
		 
 
 </div>
		
		
		
		 
		<!----></div></div><!----><!----><!----><!----></div><!----><!----><!----></div><!----><!----><!----><!----></div><!----><!---->
</tile></div>	
	
<?php }

 ?>			 
	
	
	