<?php

//  Display the course home page.

require_once('../config.php');
require_once($CFG->dirroot . '/course/lib.php');

global $CFG, $DB, $PAGE, $OUTPUT, $USER;

require_login();
//$pagetitle = 'Test Page';

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/local/store/index.php');
//$PAGE->set_title($pagetitle);
//$PAGE->set_heading('My modules page heading');
//$PAGE->set_pagelayout('standard');


echo $OUTPUT->header();
echo $OUTPUT->heading($pagetitle);

?>
	
    <!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://use.fontawesome.com/557ee20bb6.js"></script>

  <style>
    .order_header{
        background-color: #629cd152;
        border-top-right-radius: 15px;
        border-top-left-radius: 15px;
    }
    .orderdetails{
        padding: 15px;
        font-size: 12px;
    }
    .ordervalue{
        font-weight: bold;
        font-size:14px;
    }
    .order_card{
        margin-bottom : 25px;
    }
    .box_border{
        border: 1px solid #ccc;
        border-bottom-right-radius: 10px;
        border-bottom-left-radius: 10px;
        background: #c3d2e759;
    }
    button{
        height: 28px !important;
        width: 100%;
        margin-top:20px;
        margin-bottom:20px;
    }
    .invoice_btn{
        width: 85px;
        height: 31px;
        font-weight: bold;
        color: #fff;
        background-color: #b6af64;
        border-color: #b6af64;
    }
    .invoice_btn:hover {
        background-color: #d6ce86 !important;
        border-color: #d6ce86;
    }
    .sidebarBtn{
        background: #3165ae;
    }
    .sidebarBtn{
        background: #3165ae;
        border-color: #3165ae;
    }
    .sidebarBtn:hover{
        background: #629cd1 !important;
        border-color: #629cd1;
    }
    @media screen and (max-width: 600px) {
    img {
        width:100%;
    }
    }
  </style>
</head>
<body>

<div class="container">
<?php
    $sql = "select transaction_id,datecreated,customer_name,customer_email, GROUP_CONCAT(courseid) as couse_id from svhs_payment_transaction_log where userid=$USER->id group by transaction_id";
    $records = $DB->get_records_sql($sql);

?>
    <!-- <div class="row justify-content-md-center order_card"> -->
    <div class="row order_card">
        <div class="col-lg-10">
        <h4 class="text-center">Your Orders</h4>
        <!-- <div class="overflow-auto" style="max-height: 700px;"> -->
        <div>
        <?php  if(!empty($records)){
                foreach($records as $record){ 
                    $transaction_id = $record->transaction_id;
                    $filen = "$CFG->dirroot/enrol/stripepayment/invoice_pdf/$record->transaction_id.pdf";

                    $sql_order = "select t.*,c.id as courseid,c.fullname from svhs_payment_transaction_log as t inner join svhs_course as c on c.id=t.courseid where t.transaction_id='".$transaction_id."'";
                    $records_order = $DB->get_records_sql($sql_order);
                    $total_course = count($records_order);
                    $paying_due_amount = 125*$total_course;
                    
        ?>
        <div class="col-lg-12" style="margin-bottom:20px;">
            <div class="row order_header" >
                <div class="col-sm-3 col-lg-2 orderdetails">
                    <p>ORDER PLACED</p>
                    <p class="ordervalue"><?php echo date('M d ,Y',$record->datecreated);?></p>
                </div>
                <div class="col-sm-3 col-lg-2 orderdetails">
                    <p>TOTAL</p>
                    <p class="ordervalue"> $ <?php echo $paying_due_amount;?></p>
                </div>
                <div class="col-sm-6 col-lg-4 orderdetails">
                    <p>Payee Name: <span class="ordervalue"><?php echo $record->customer_name;?></span></p>
                    <p>Payee Email:<span class="ordervalue"><?php echo $record->customer_email;?></span></p>
                </div>
                
                    <div class="row float-sm-left float-lg-right  col-lg-4 orderdetails" >
                        <div class="col-sm-6 col-lg-8 orderdetails">
                            <p>ORDER # <span class="ordervalue"><?php echo $transaction_id;?></span></p>
                        </div>
                        <div class="col-sm-6 col-lg-4 orderdetails">
                            <?php
                        if(file_exists($filen)) {
                            echo '<a class="invoice_btn btn btn-warning btn-sm" href="'.$CFG->wwwroot.'/enrol/stripepayment/invoice_pdf/'.$record->transaction_id.'.pdf" download="'.$record->transaction_id.'.pdf"><i class="fa fa-download" aria-hidden="true"></i> Invoice</a>';
                            }?>
                        </div>
                    </div>
                
            </div>    
            <div class="row box_border">
                    <div class="col-lg-12">
                    <?php
                     require_once($CFG->libdir. '/coursecatlib.php');
                    
                        foreach($records_order as $order){ 
                            $courseid= $order->courseid;

                            $course = $DB->get_record('course',array('id' => $courseid));
	                        $course = new course_in_list($course);
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
                            ?>
                            
                    <div class="row">
                        <div class="col-sm-4 col-lg-4 text-center" style="margin-bottom:10px;margin-top:10px;"> 
                        <a href="https://lms.svhs.co/course/view.php?id=<?php echo $courseid;?>"><img width="100px" src="<?php echo $courseimage;?>"></a>
                        </div>
                        <div class="col-sm-4 col-lg-4 text-center" style="padding-top: 25px;"> 
                             <?php echo $order->fullname;?>
                        </div>
                        <div class="col-sm-4 col-lg-4 text-center" style="padding-top:25px;"> 
                             <?php if($order->status == 1){
                                echo 'Status : <b>Unenrolled</b>';
                            }else{
                                echo "Status : <b>Enrolled</b>";
                            }?>
                        </div>
                    </div>  
                    <?php $i++;  } ?>

                    </div>
                    <!-- <div class="col-lg-3" style="border-left: 1px solid #ccc;"> 
                        <div class="col-lg-12 float-right">
                            <button type="button" class="btn btn-warning btn-sm align-right ">Request Refund</button>
                        </div>
                        <div class="col-lg-12 float-right">
                            <button type="button" class="btn btn-warning btn-sm align-right ">Invoice</button>
                        </div>
                    </div> -->
            </div>
                
        </div>
        <?php } } else { echo "<div class='norecords'>No order history available.</div>";} ?> 
          </div>
        </div>   
        <div class="col-lg-2" style="background: #cccccc29;padding-bottom:20px;">
            <div class="col-lg-12" > 
                <button type="button" class="sidebarBtn btn btn-primary btn-sm align-right" onclick="dashboard()">Dashboard</button>    
                <button type="button" class="sidebarBtn btn btn-primary btn-sm align-right" onclick="buy_new_course()">Buy New Course</button>       
                <button type="button" class="sidebarBtn btn btn-primary btn-sm align-right" onclick="view_cart()">View cart</button>
            </div>
        </div>
    </div>
    
    
    
</div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
    <script>
    function dashboard()
    {
        location.href = "https://lms.svhs.co/my/index.php";
    }
    function buy_new_course()
    {
        location.href = "https://lms.svhs.co/store/";
    }
    function view_cart()
    {
        location.href = "https://lms.svhs.co/store/coursescheckout.php";
    } 
    </script>
</body>

</html>