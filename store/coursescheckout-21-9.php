<?php

//  Display the course home page.

require_once('../config.php');
require_once($CFG->dirroot . '/course/lib.php');

global $CFG, $DB, $PAGE, $OUTPUT, $USER;

require_login();

// $giveaccess = array(2,4813,171,437,71,11938,10333,24018,23932,1017,3364);
// if(!in_array($USER->id,$giveaccess)){
//  redirect($CFG->wwwroot.'/my/');
// } 

//$pagetitle = 'Test Page';

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/local/store/index.php');
//$PAGE->set_title($pagetitle);
//$PAGE->set_heading('My modules page heading');
//$PAGE->set_pagelayout('standard');


echo $OUTPUT->header();
echo $OUTPUT->heading($pagetitle);

?>
	
<section id="region-main" >

	<h3 style="color: #807e7e;font-weight: 400;font-size: 19px;">PROTECTED : CHECKOUT</h3>


	<span id="const" style="display:none">CHECKOUT COURSES</span>
		
<link href="css/bootstrap-table.min.css" rel="stylesheet">

<script src="js/jquery-3.3.1.js"></script>
<script src="js/jspdf.min.js"></script>
<script src="js/jspdf.plugin.autotable.js"></script>
<script src="js/tableExport.min.js"></script>
<script src="js/bootstrap-table.min.js"></script>
<script src="js/bootstrap-table-export.min.js"></script>

<?php 
	
if(isset($_GET['crmnid'])){
	$crmnid = $_GET['crmnid'];
	$noticourse = $DB->get_record('course',array('id' => $crmnid));

	?>
	<div style="margin: 0px auto !important;width:100%;margin-bottom: 10px !important;padding: 10px;background: #fff3f3;">
	Successfully Removed  <b> &nbsp; <?php echo $noticourse->fullname ; ?> </b> &nbsp; to your cart. <a href="#" onclick="rmtoaddtocart(<?php echo $crmnid ; ?>)">  Undo. </a>
</div>


<script>
function rmtoaddtocart(cid){
		
	 $.ajax({
            url: './ajax/addtocartcourses.php',
            type: 'post',
            data: {cid:cid},
            success:function(response){
           $('#cartadded'+cid).html('<span class="img-subtext" style="border: 1px solid #2F64AD;color: #fff;background: #2F64AD;"><i style="color: lime;font-size: 17px;" class="fa fa-check" aria-hidden="true"></i>Added to Cart</span>');		
	
              updatecart(); 
			  
			 location.href = "<?php $CFG->wwwroot ; ?>/store/coursescheckout.php";
			  
            }		
    });	
	}
</script>

<?php
}		

	
    if(isset($_POST['rmcc']))
    {
		$delc = $_POST['rmcc'];
	    $delcourses = $DB->get_records_sql("select id from {cm_cartcourses} where userid = $USER->id and courseid IN ($delc)");
		foreach ($delcourses as $delcourse) {
			$deletec = $DB->delete_records('cm_cartcourses',array('id' => $delcourse->id));
		}
	   redirect($CFG->wwwroot.'/store/coursescheckout.php');
    }

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
  $courses = $DB->get_records_sql("select id,fullname from {course} where id IN ($cartids)");
   ?>
   <form method="post" name="f1">
   <input type="hidden" name="rmcc" id="rmcc" value="<?php echo $cartids ; ?>">
    <button type="submit" class="close"><i class="fa fa-close" style="font-size:26px;color:black"></i>
</button>
</form>
	 <div class="box generalbox" id="notice" style="margin: 0px auto !important;width:100%" >
	 <?php
 foreach($courses as $course){
	 echo $course->fullname . '<br>';
 }

 if(count($aeids) > 1){

 ?> 
  You're unable to buy these course again as you are already enrolled via this student account.
 <?php 
 } else { ?>
  You're unable to buy this course again as you are already enrolled via this student account.
	 
<?php  } ?>

</div>
 <?php } ?>
 
 </div>	
		
		<?php
		if(!empty($cartids)){
	$crtcourses = $DB->get_records_sql("select * from {cm_cartcourses} where userid = $USER->id and courseid NOT IN($cartids)");
} else {
	$crtcourses = $DB->get_records('cm_cartcourses',array('userid' => $USER->id));
}
	if(count($crtcourses) != 0){
		?>

	<div id="cartpayment" >
	
<div id="toolbar" style="display:none" class="select">
  <select class="form-control">
    <option value="">Export Current Page</option>
    <option value="all">Export All</option>
  </select>
</div>


<table id="table"
  data-show-export="false"
  data-pagination="false"
  data-search="false"
  data-detail-formatter="detailFormatter"
  data-detail-view="false"
  data-click-to-select="false"
  data-toolbar="#toolbar"
  data-show-toggle="false"
  data-show-columns="false"
 data-show-fullscreen="false"
  >
		


<?php


$s = 1;
 foreach ($crtcourses as $cartcourse) { 
 
  require_once($CFG->libdir. '/coursecatlib.php');
  
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
            $courseimage = $CFG->wwwroot . "/store/img/image.png";
			
        }
$coursen = str_replace(",","",$course->fullname);
 $coursenl = str_replace(" ","-",$coursen);

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
			  
			   ucfirst($bname) ;
 $rowId = "remove_item_id_".$course->id;
?>
	<tr id="<?php echo $rowId;?>">
<td><a onclick="removecartcrs(<?php echo $course->id ;?>)"><i style="font-size:20px" class="fa fa-times-circle" aria-hidden="true"></i></a></td>
<td><a  target="_blank" href="<?php echo "https://svhs.co/store/online-high-school-$bname-courses/$coursenl-id-$course->id/" ; ?>">
<?php echo '<img style="height: 40px;" src="'.$courseimage.'">';?></a> </td>
<td><a  target="_blank" href="<?php echo "https://svhs.co/store/online-high-school-$bname-courses/$coursenl-id-$course->id/" ; ?>"><?php echo ucfirst($course->fullname);?></a></td>


<td>$125</td>

</tr>
<?php	
$s++;   
 }
 ?>	
 
 <tr >
    <td id="hidetd"></td>
    <td id="hidetd"></td>
    <td id="tot">Total</td>
    <td id="totalitemcost"><?php echo '$'. 125 * count($crtcourses) ; ?></td>
  </tr>
 
 
	</table>
	<?php $totalDue =  125 * count($crtcourses) ;?>	
	<input type="hidden" name="totaldueamount_hidden" id="totaldueamount_hidden" value="<?php echo $totalDue ; ?>">
<style>
#tot {
	text-align: right !important;
	font-weight: bold;
	border-bottom: 1px solid #fff;
}
#hidetd {
	border: 1px solid #fff;
}
#adaptable-page-header-wrapper {
		position: fixed;
	}
</style>
	
	<div style="margin-top: 2%;"  class="card">
	<?php 
	
	if(count($crtcourses) != 0){
		if(!empty($cartids)){	
		 $addtocartcid = $DB->get_record_sql("select id,courseid from {cm_cartcourses} where userid = $USER->id and courseid NOT IN($cartids) limit 1");
			} else {
		 $addtocartcid = $DB->get_record_sql("select id,courseid from {cm_cartcourses} where userid = $USER->id limit 1");
			} 
			
		$course = $DB->get_record('course',array('id' => $addtocartcid->courseid));

		$context = context_course::instance($course->id, MUST_EXIST);



		// get all enrol forms available in this course
		$enrols = enrol_get_plugins(true);

		$enrolinstances = enrol_get_instances($course->id, true);
		$forms = array();
		foreach($enrolinstances as $instance) {
			if (!isset($enrols[$instance->enrol])) {
				continue;
			}
			$form = $enrols[$instance->enrol]->enrol_page_hook($instance);
			if ($form) {
				$forms[$instance->id] = $form;
			}
		}


		foreach ($forms as $form) {
			echo $form;
		}
}


	
?>
</div>
</div>

<?php 
	}
	
$cnocrs = count($cartcourses);

	if($cnocrs == 0){
		?>
	 <div class="box generalbox" class="notices" id="notice" style="width:100%"  >
	
  No Items in Cart.</div>
	<?php } ?>
		<script>
	

	
var $table = $('#table')

  $(function() {
    $('#toolbar').find('select').change(function () {
      $table.bootstrapTable('destroy').bootstrapTable({
        exportDataType: $(this).val(),
        exportTypes: [ 'excel', 'pdf'],
      columns: [
        [{          
		  title: 'Remove Item',
          field: 'ID',
          
          align: 'center',
          valign: 'middle',
		    width:'15%'
		  
        }, {
          title: 'Course Image',
          field: 'Course Image',
          
          align: 'left',
          valign: 'middle',
          sortable: false,
		    width:'20%'
         
        }, 
		{
          field: 'Course Name',
          title: 'Course Name',
          sortable: false,
          align: 'left'
		 
        },
		
		
		{
          field: 'Price',
          title: 'Price',
          sortable: false,
          align: 'left'
		    
        }],[]
       
      ]
      })
    }).trigger('change')
  })

  </script>
	
	<style>
	#billingtable > td {
		border : none;
	}
	.card {
		box-shadow: 0 4px 8px 0 rgb(0 0 0 / 77%);
    transition: 0.3s;
    margin: 0 auto;
   
    margin-bottom: 10px;
    margin-top: 25px;
    width: 45%;
    padding: 30px;
	}
	#buynow {
		padding: 20px;
	}
	
	#payButton {
	padding: 10px 16px !important;
    border-radius: 5%;
    background-color: #3165ae !important;
    border: 1px solid #3165ae !important;
	
	}
	</style>
	
	<?php
echo $OUTPUT->footer();
