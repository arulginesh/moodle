<?php

//  Display the course home page.

require_once('../config.php');
global $CFG, $DB, $PAGE, $OUTPUT;

require_login();
//$pagetitle = 'Test Page';

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/local/cm/index.php');
//$PAGE->set_title($pagetitle);
//$PAGE->set_heading('My modules page heading');
//$PAGE->set_pagelayout('standard');


echo $OUTPUT->header();
echo $OUTPUT->heading($pagetitle);
?>

	
	 <link rel="stylesheet" href="css/jquery.bxslider.css">

        <script src="js/jquery.min.js"></script>
<style>
		
		.bx-wrapper .bx-controls-direction a {
			z-index : 0 !important;
			
		}
		
		.bx-default-pager {
display : none;
}
	.bx-prev {
	    margin-left: -30px;
    margin-top: -146px;
    float: left;
}
.bx-next {
	float: right;
    margin-right: -26px;
    margin-top: -146px;
}

.bx-wrapper{
margin-left: 41px;
    margin-right: 41px;	
	
}
		
 .bx-viewport {
		    margin-left: 40px;
		}
 .bx-wrapper .bx-next {
	 right : -13px !important;
 }
 .bx-wrapper .bx-prev {
 left:-12px !important;
 }
  
  .bx-wrapper {
  -moz-box-shadow: none !important;

  -webkit-box-shadow: none !important;
  box-shadow: none !important;
  border: none !important;
  background: none !important;
}
  </style>
 

<section id="region-main">

		 <link rel="stylesheet" href="css/style.css">

		<h3 style="color: #807e7e;font-weight: 400;font-size: 19px;">COURSES</h3>
<div class="corsesbxs">


<?php
$courses = $DB->get_records_sql("select id,fullname from {course} where visible = 1 and category = 28 order by id desc");
//print_object($courses);


foreach ($courses as $course){
?>
 


<?php
        $courseimage = $CFG->wwwroot . "/cm/img/image.png";
			
       												
?>
  <div class="item">
		
		
  <div her-root="" _nghost-kmb-c683="" ng-version="9.1.12">
  <div _ngcontent-kmb-c683="" class="heracles-root router-outlet hyd-typography-body" style="opacity: 1;">
  <router-outlet _ngcontent-kmb-c683=""></router-outlet><div _nghost-kmb-c682="" lms-app="" class="ng-star-inserted">
  <div _ngcontent-kmb-c682="" class="router-outlet" style="opacity: 1;">
  <router-outlet _ngcontent-kmb-c682=""></router-outlet><doc-layout class="ng-star-inserted">
		
		<div id="doc-layout" class="doc-layout doc-layout-internal-super-admin" style="margin-top: 0px; padding-top: 0px;">
		

		<structure-column-widget _nghost-kmb-c388="" class="mdl-cell mdl-cell--12-col widget-render-column widgets-column-large ng-star-inserted" 
		>
		<widget-children-wrapper _ngcontent-kmb-c388="" _nghost-kmb-c387="">

		
  
  <div _ngcontent-kmb-c372="" class="course-tile ng-star-inserted ">
		
		<tile _ngcontent-kmb-c372="" class="tile-el">
		<div class="tile-wrapper rectangular my-course vertical-card ng-star-inserted">
		<div class="demo-card-wide mdl-card mdl-shadow--2dp 0 ng-star-inserted">
		<a href="<?php echo $courselink ; ?>">
		<div class="tile-bg bg-grey text-white has-background-image"><!----><!----><!---->
		<div class="tile-bg-image bg-white" style="background-image: url('<?php echo $courseimage ; ?>');"></div>
		<div class="demo-card-image">
		<!----><!----><!----><!----><div class="item-status-box bolded text-white ng-star-inserted">
		
		<!--<span class="new-item bg-positive-green ng-star-inserted">new</span>-->
		
		<!----><!----><!----><!----></div><!----><!---->
		<!----><!----><!----></div>
		</div> </a>
		<!-- <div class="docebo-tooltip" id="<?php echo $course->id ;?>" style="top: 77px;position: absolute;display:none ">
<span class="text-tooltip">nnn</span>
</div> -->
		<div class="tile-supporting-text ng-star-inserted"><div class="mdl-card__title"><h2 class="mdl-card__title-text text-main title-text-alt">
		<!----><a position="top" class="text-main ng-star-inserted"  href="#">Course Name</a><!---->
		<!----></h2></div>
						
	<div class="subtitle-boxes mdl-card__supporting-text text-mid-grey single-subtitleBox ng-star-inserted" style="padding-bottom: 24px;">
		<span style="">$ 120 </span><br><!----></div></div><!----><!----><!----><!----></div><!---->
		<!----><!----></div><!----><!----><!----><!----></div><!----><!---->
		</tile>
		</div>
		
		
		</widget-children-wrapper>
		
		</structure-column-widget>
		
		
		
			</div></doc-layout><!----></div></div><!---->
			<router-outlet _ngcontent-kmb-c683="" name="slideup"></router-outlet><!----></div><!---->
			
			
			</div>

		
<?php } ?>
 
 </div>
  </section>
  
  	<script>
$( document ).ready(function() {
	
	
		
	$('.corsesbxs').bxSlider({
		minSlides: 4,
		maxSlides: 4,
		slideWidth: 1000,
		slideMargin: 10,
		infiniteLoop: false,
 touchEnabled: false
	});	
	
	
	
	
	
	
});

</script>
 
<script src="js/jquery.bxslider.js" integrity="sha512-no2/KDsCWSGu0LVyWVdwha859xFOn1K8oLPIi2O6gxIv5fQ704L2pQh5H8X4PpTEzjGD58/M7TYwdf8LWeSQKw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="js/jquery.easing.1.3.js" integrity="sha512-brrjTp9G6MkKX5QjXwwAQkscfFpKi3okjyZ/M3vGwwg9qI1msoz7z+EbQBLXsTnVK3POjYBGHcQvX34GFKr/7A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="js/jquery.fitvids.js" integrity="sha512-+57rhvXpYUhxCGXuIg+Ln8RrfCV8PwAwfhRr+V/+nXcKrFMLbN+puAks08PGsANOh/n3b6lSc7F37ek766Pk1w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


  
<?php
echo $OUTPUT->footer();
