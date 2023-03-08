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

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://use.fontawesome.com/557ee20bb6.js"></script>
  <style>
    html,
    body {
      font-family: Open Sans,sans-serif;
    }

    [data-action="opensearch"] {
      border: 1px solid #6a737b;
    }
    [data-action="closesearch"] {
      box-sizing: border-box;
      background: none;
    }
   .btn-submit {
    margin-left: -15px;
   }
    .container {
      max-width: 1400px;
    }

    .left-side-block {
      background-color: #f3f3f3;
      padding: 10px;
    }

    .filter-title {
      color: #3266AE;
      font-family: "Roboto Slab";
      font-size: 14px;
      font-weight: normal;
      text-transform: uppercase;
      line-height: 1.5em;
      letter-spacing: 0.5px;
    }

    .btn-primary {
      background-color: #2F64AD;
      color: #fff;
    }

    .text-primary {
      color: #3165AE !important;
    }

    .form-check-label {
      color: #629CD1;
    }

    li {
      font-size: 12.25px;
      line-height: 1.5em;
      letter-spacing: 0.5px;
      color: #878e95;
    }

    li a {
      text-decoration: none;
      color: #337ab7;
    }
    .right-side-title{
      color: #3266AE;
      font-family: "Square721BT";
      font-size: 24px;
      text-transform: uppercase;
      line-height: 1.5em;
      letter-spacing: 0.5px;
    }
    .img-block:hover{
      transform: scale(0.9);
      transition: 0.5s all ease-in-out;
    }
    .img-block{
     
      border-radius: 5px 5px 5px 5px;
      overflow: hidden;
      box-shadow: 0px 0px 25px -6px rgb(0 0 0 / 50%);
      display: inline-block;
    }
    a.img-title{
        font-size: 12.25px;
      line-height: 1.5em;
      letter-spacing: 0.5px;
      color: #3266AE !important;
      text-align: center;
      text-decoration: none;
  }
  .img-subtitle{
    color:#3266AE !important;
    font-size:12.25px;
    line-height: 1.5em;
    font-weight:bold;
    letter-spacing: 0.5px;
    text-decoration: none;
  }
  .img-subtext{
    color:#3c4b71;
    font-size:12.25px;
    line-height: 1.5em;
    letter-spacing: 0.5px;
	
  }
  	#adaptable-page-header-wrapper {
		position: fixed;
	}
  </style>

</head>


<body>
  <div class="container" style="width:100%">
    <div class="row">
      <div class="col-sm-3 col-lg-3">
        <div class="left-side-block">
          <div>
            <p class="filter-title">APPLY FILTER</p>
            <form class="d-flex">
              <input class="form-control me-2" id="search-1" autocomplete="off" type="search" placeholder="Search" aria-label="Search">
              <span class=" btn-primary px-4" style="cursor: default;" ><i class="fa fa-search"
                  aria-hidden="true"></i></span>
            </form>
          </div>
          <div class="mt-3">
            <p class="text-primary" style="font-weight:600;">Department:</p>
            <div  style="cursor:pointer;margin-top: -39px;color: #ffffff;float: right;padding: 1px 15px;background: #2f64ad;border-radius: 3px;" onclick="clearradioselected();" >
                clear
              </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="1" onclick="addcheckuncheck();" name="chkbranch" id="art">
              <label class="form-check-label" for="flexCheckDefault">
                Art
              </label>
            </div>
			
            <div class="form-check">
              <input class="form-check-input" type="radio" value="2" onclick="addcheckuncheck();" name="chkbranch" id="elective">
              <label class="form-check-label" for="flexCheckChecked">
                Electives
              </label>
            </div>
			
			<div class="form-check">
              <input class="form-check-input" type="radio" value="3" onclick="addcheckuncheck();" name="chkbranch" id="eng">
              <label class="form-check-label" for="flexCheckChecked">
                English
              </label>
            </div>
			
			<div class="form-check">
              <input class="form-check-input" type="radio" value="4" onclick="addcheckuncheck();" name="chkbranch" id="lang">
              <label class="form-check-label" for="flexCheckChecked">
                Languages
              </label>
            </div>
			
			<div class="form-check">
              <input class="form-check-input" type="radio" value="5" onclick="addcheckuncheck();" name="chkbranch" id="math">
              <label class="form-check-label" for="flexCheckChecked">
                Math
              </label>
            </div>
			
			<div class="form-check">
              <input class="form-check-input" type="radio" value="6" onclick="addcheckuncheck();" name="chkbranch" id="science">
              <label class="form-check-label" for="flexCheckChecked">
                Science
              </label>
            </div>
			
			<div class="form-check">
              <input class="form-check-input" type="radio" value="7" onclick="addcheckuncheck();" name="chkbranch" id="social">
              <label class="form-check-label" for="flexCheckChecked">
                Social science
              </label>
            </div>
			
          </div>
          <div class="mt-3"  >
            <p class="text-primary" style="font-weight:600;">Courses Approved By:</p>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="calif" onclick="addapprovefilter();" name="approvefilter" id="flexCheckDefault">
              <label class="form-check-label" for="flexCheckDefault">
                Approved by University of California (A-G Program)
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="ncaa" onclick="addapprovefilter();" name="approvefilter" id="flexCheckChecked" >
              <label class="form-check-label" for="flexCheckChecked">
                Approved by NCAA
              </label>
            </div>
          </div>
          <ul class="mt-3">
            <li>Enroll anytime: enrollment is open 24 hours a day, 365 days a year—summer school included.</li>
            <li>All courses self-paced, teacher-supported and video-based.</li>
            <li>“Part 1” = first semester. “Part 2” = second semester.</li>
            <li>All courses require 75 hours of study, depending on the speed of the student.</li>
            <li>Transcripts are issued for transfer of credits.</li>
            <li>Before buying, check your school’s policy for transfer of credits.</li>
            <li><a target="_blank" href="https://svhs.co/course-catalog/">See full course list.</a></li>
            <li><a target="_blank" href="https://svhs.co/pdf/svhs-flyer.pdf">Print version of course catalog.</a></li>
            <li><a target="_blank" href="https://svhs.co/about/">About our courses.</a></li>
            <li><a target="_blank" href="https://svhs.co/support/">Frequently asked questions.</a></li>
          </ul>
          <div class="d-flex justify-content-center">
            <img src="https://svhs.co/wp-content/uploads/2020/11/96.png">
          </div>          
        </div>
      </div>
      <div class="col-sm-9 col-lg-9">
        <p class="right-side-title">SELECT YOUR COURSE:</p>
        <div class="row" id="catalogcourse" >
		
		  
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
</body>

        <script src="js/jquery.min.js"></script>   
		<script>
$(document).ready(function(){
	
	$('input').bind('keypress', function (event) {

   
    
    var regex = new RegExp("^[a-zA-Z0-9, ]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);

    if (!regex.test(key)) {
        event.preventDefault();
        return false;
    }
});
	

  $('#search-1').keyup(function(){
    $.each($("input[name='chkbranch']:checked"), function(){  
        $("input:radio[name=chkbranch]:checked")[0].checked = false;
      });
			
      $.each($("input[name='approvefilter']:checked"), function(){
            $("input:checkbox[name=approvefilter]:checked")[0].checked = false;
        
      });
   
 	var filterval = "";
            $.each($("input[name='chkbranch']:checked"), function(){  
                filterval += ","+$(this).val();  
            });
		filterval = filterval .substring(1);
		
   // Search text
   var text = $(this).val().toLowerCase();
     
    $.ajax({
            url: './ajax/ajax_courses.php',
            type: 'post',
            data: {srhtext:text,filterval:filterval},
            success:function(response){                

                $("#catalogcourse").html(response);  
				
				       
            }		
    });
	
 });
 
	
     $.ajax({
            url: './ajax/ajax_courses.php',
            type: 'post',
            success:function(response){                

                $("#catalogcourse").html(response);  
				
				       
            }		
    });
	
	
	
 });
 
 
function addcheckuncheck(){
  $("#search-1").val('');
	//filter
		
		var filterval = "";
            $.each($("input[name='chkbranch']:checked"), function(){  
                filterval += ","+$(this).val();  
            });
		filterval = filterval .substring(1);
		//alert(filterval);

    var checkboxval = "";
            $.each($("input[name='approvefilter']:checked"), function(){  
                checkboxval += ","+$(this).val();  
            });
		checkboxval = checkboxval .substring(1);
		
	
		var srhtext = $('#search-1').val().toLowerCase();
   
		
		 $.ajax({
            url: './ajax/ajax_courses.php',
            type: 'post',
            data: {filterval:filterval,srhtext:srhtext,checkboxval:checkboxval},
            success:function(response){      
			
                $("#catalogcourse").html(response);  	       
            }		
		});

}

function addapprovefilter(){
	
	var filterval = "";
            $.each($("input[name='chkbranch']:checked"), function(){  
                filterval += ","+$(this).val();  
            });
		filterval = filterval .substring(1);
		//alert(filterval);
			
	var checkboxval = "";
            $.each($("input[name='approvefilter']:checked"), function(){  
                checkboxval += ","+$(this).val();  
            });
		checkboxval = checkboxval .substring(1);
		//alert(checkboxval);
		
		$.ajax({
            url: './ajax/ajax_courses.php',
            type: 'post',
            data: {filterval:filterval,checkboxval:checkboxval},
            success:function(response){      
			
                $("#catalogcourse").html(response);  	       
            }		
		});
	
}


function clearradioselected(){
	
  $.each($("input[name='chkbranch']:checked"), function(){  
          $("input:radio[name=chkbranch]:checked")[0].checked = false;
              });
      
    
    var checkboxval = "";
              $.each($("input[name='approvefilter']:checked"), function(){  
                  checkboxval += ","+$(this).val();  
              });
      checkboxval = checkboxval .substring(1);
      //alert(checkboxval);
          
        
       $.ajax({
              url: './ajax/ajax_courses.php',
              type: 'post',
        data: {checkboxval:checkboxval},
              success:function(response){                
  
                  $("#catalogcourse").html(response);  
          
                 
              }		
      });	
          
  }

// function update_badge_count(count){
//   $("#badge_data_append").empty();

//   var badge_count = "<span id='itemcount' class='p1 fa-stack fa-2x has-badge' data-count='"+count+"'><i style='color: #3165ae;' class='p3 fa fa-shopping-cart fa-stack-1x'data-count='4b'></i></span></h2>";

//   $("#badge_data_append").html(badge_count);

//   var noitem_popup = "<ul class='list-group list-group-flush'>";
//   noitem_popup += "<li class='list-group-item' style='padding: 0px;'>";
//   noitem_popup += "<div style='font-size: 11px;'>No products in the cart</div> </li>";
//   noitem_popup += "</ul>";

//   if(count==0){
//     $("#cartitemlist").html(noitem_popup);
//   }
// }

	function addtocart(cid){
    var count_val = $("#itemcount").data('count');
    var newcount = "";
    if(count_val==0){
       newcount = 1;
    }else{
      newcount = count_val+1;
    }
	
	 $.ajax({
            url: './ajax/addtocartcourses.php',
            type: 'post',
            data: {cid:cid},
            success:function(response){
           $('#cartadded'+cid).html('<span class="img-subtext" style="border: 1px solid #2F64AD;color: #fff;background: #2F64AD;"><i style="color: lime;font-size: 17px;" class="fa fa-check" aria-hidden="true"></i>Added to Cart</span>');		
	
              updatecart();  	   
            }		
    });	
	}


 </script>
</html>

	<?php
echo $OUTPUT->footer();