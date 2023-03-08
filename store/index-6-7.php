<?php

//  Display the course home page.

require_once('../config.php');
require_once($CFG->dirroot . '/course/lib.php');

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
	<style>
	#adaptable-page-header-wrapper {
		position: fixed;
	}
	.addcheck {
		margin-bottom: 3px;
	}
	.addcheckalign {
		
		margin-top: 3px;
		font-size: 0.8rem;
	}
	</style>
<section id="region-main" >

		 
		 <link rel="stylesheet" href="css/style.css">
		 <link rel="stylesheet" href="css/style2.css">

		<h3 style="color: #807e7e;font-weight: 400;font-size: 19px;">COURSES</h3>
		
    <div her-root="" _nghost-kmb-c683="" ng-version="9.1.12"><div _ngcontent-kmb-c683="" class="heracles-root router-outlet hyd-typography-body" style="opacity: 1;"><router-outlet _ngcontent-kmb-c683=""></router-outlet><div _nghost-kmb-c682="" lms-app="" class="ng-star-inserted"><div _ngcontent-kmb-c682="" class="router-outlet" style="opacity: 1;"><router-outlet _ngcontent-kmb-c682=""></router-outlet><doc-layout class="ng-star-inserted">
		<div id="doc-layout" class="doc-layout doc-layout-internal-super-admin" style="margin-top: 0px; padding-top: 0px;">
		<main id="doc-layout-main" class="doc-layout-main clearfix" aria-hidden="false">
		
		
		
		<div id="doc-layout-page-content" class="doc-layout-page-content" aria-hidden="false">
		<router-outlet></router-outlet><single-channel-wrapper _nghost-kmb-c838="" class="ng-star-inserted">
		<single-channel-widget _ngcontent-kmb-c838="" _nghost-kmb-c837="" id="doc-page-channel-13" class="ng-star-inserted">
		<dynamic-widget-page _ngcontent-kmb-c837="" _nghost-kmb-c507="" class="ng-star-inserted"><widget-render _ngcontent-kmb-c507="" _nghost-kmb-c506="" class="spaced-from-header ng-star-inserted"><div _ngcontent-kmb-c506="" class="widget-render"><div _ngcontent-kmb-c506="" id="doc-widget-single-channel-page" class="ng-star-inserted"><structure-row-widget _nghost-kmb-c389="" class="widget-render-row ng-star-inserted"><!----><div _ngcontent-kmb-c389="" class="mdl-wrapper ng-star-inserted"><widget-children-wrapper _ngcontent-kmb-c389="" _nghost-kmb-c387=""><div _ngcontent-kmb-c387="" id="doc-widget-single-channel-page" class="ng-star-inserted">
		
		<structure-column-widget _nghost-kmb-c388="" class="mdl-cell mdl-cell--12-col widget-render-column widgets-column-large
		ng-star-inserted" style="margin-left:-37px;"><widget-children-wrapper _ngcontent-kmb-c388="" _nghost-kmb-c387="">
		<div _ngcontent-kmb-c387="" class="widget-child ng-star-inserted" id="doc-widget-channel-13">
		<channels-widget _nghost-kmb-c370="" class="ng-star-inserted"><!---->
		<div _ngcontent-kmb-c370="" class="widget-channels">
		<data-browser _ngcontent-kmb-c370=""><div class="docebo-data-browser header-holder collection-specific-holder">
		
		<div class="full-width-header-container bg-white ng-star-inserted" style="margin-bottom:20px;">
		
		<div class="section-wrapper">
		<div class="mdl-grid"><div style="width: 230px;" class=""><section class="content-section">
		<div class="component-content"><div id="sorting-filters" class="">
		
		
		<!-- dropdown code
		
		<div class="border-grey-light sort-filters ng-star-inserted"><div class="sort-holder">
		<span class="text-grey-mid sort-filters-label ng-star-inserted"></span>
		<div class="text-main"><dropdown style="display: block;">
		<div class="dropdown-wrapper ng-star-inserted" id="dropdown-wrapper-7">
		<div aria-live="assertive" class="dropdown-announced-option"></div>
		<input type="text" class="hide ng-untouched ng-pristine ng-valid" name="view-options" id="dropdown-input-7">
		<div class="dropdown">
		<div tabindex="0" role="button" aria-haspopup="listbox" class="dropdown-head text-main border-grey"
		id="dropdown-head-7" aria-expanded="false" aria-controls="dropdown-body-7">
		<span class="dropdown-label text-grey-mid floating-label text-main ng-star-inserted">
		<span class="label-text ng-star-inserted" id="dropdown-label-text-7"></span></span>
		
		<select class="dropdown-title text-grey-dark" onchange="changecat(this.value)" name="catname" id="catname">
	

		<option class="bg-hover-grey-superlight text-grey-dark ng-star-inserted" style="padding:50px 10px;" value="0">Select Category</option>

 
		</select>
		 <span class="dropdown-title text-grey-dark">Campus Management Employee Onboarding</span>
		 </div> 
		
		</div>
		<span class="input-error-msg text-error"><control-messages class="ng-star-inserted">
		</control-messages> </span></div></dropdown></div></div>
		</div>
		
		
		-->
	
		
		<div class="border-grey-light text-mid-grey search-header-container ng-star-inserted"><search-field><div class="form-search">
		<form novalidate="" class="ng-untouched ng-pristine ng-valid"><div class="mdl-textfield mdl-js-textfield is-upgraded" data-upgraded=",MaterialTextfield">
		<button type="submit" class="mdl-button mdl-js-button mdl-button--icon search-label-icon bg-hover-main" for="search-1">
		<i class="zmdi zmdi-search text-grey-mid-permanent text-hover-main"></i></button>
		<div class="mdl-button mdl-js-button mdl-button--icon search-label-icon bg-hover-main" hidden="">
		<i class="zmdi zmdi-search text-grey-mid-permanent text-hover-main"></i></div><span class="search-separator border-grey-mid hidden"></span>
		<div class="mdl-button fa fa-search" style="padding-right: 25px;padding-top: 9px;" bg-before-grey-light bg-hover-main hidden">
		</div><div class="mdl-textfield-holder"><!---->
		<input type="text" autocomplete="off" class="mdl-textfield__input ng-untouched ng-pristine ng-valid" id="search-1" placeholder="Enter text..." name="search">
		
		<label
		class="mdl-textfield__label text-grey-mid search-label bg-after-main docebo-input-text ng-star-inserted" for="search-1"></label>
		<!----><!----></div></div><div class="form-search-body bg-white"><ul><!----></ul></div></form></div></search-field></div><!----><!---->
		
		
		</div></div></section></div></div></div></div><!---->
		
		
		
		<div class="section-wrapper" style="float:left;width:16%">
		
		<div class="addcheck"><input type="checkbox" value="1" onclick="addcheckuncheck();" name="chkbranch" id="art">Art</div>
		<div class="addcheck"><input type="checkbox" value="2" onclick="addcheckuncheck();" name="chkbranch" id="elective">Electives</div>
		<div class="addcheck"><input type="checkbox" value="3" onclick="addcheckuncheck();" name="chkbranch" id="eng">English</div>
		<div class="addcheck"><input type="checkbox" value="4" onclick="addcheckuncheck();" name="chkbranch" id="lang">Languages</div>
		<div class="addcheck"><input type="checkbox" value="5" onclick="addcheckuncheck();" name="chkbranch" id="math">Math</div>
		<div class="addcheck"><input type="checkbox" value="6" onclick="addcheckuncheck();" name="chkbranch" id="science">Science</div>
		<div class="addcheck"><input type="checkbox" value="7" onclick="addcheckuncheck();" name="chkbranch" id="social">Social science</div>
		
		<div style="margin-top: 27px;font-size: 0.8rem;"><span>&#x2022;<span> <b>Enroll anytime:</b> enrollment is open 24 hours a day,  365 days a year—summer school included.</div>
		<div class="addcheckalign"><span>&#x2022;</span> All courses self-paced, teacher-supported and video-based.</div>
		<div class="addcheckalign"><span>&#x2022;</span> “Part 1” = first semester. “Part 2” = second semester.</div>
		<div class="addcheckalign"><span>&#x2022;</span> All courses require 75 hours of study, depending on the speed of the student.</div>
		<div class="addcheckalign"><span>&#x2022;</span> Transcripts are issued for transfer of credits.</div>
		<div class="addcheckalign"><span>&#x2022;</span> Before buying, check your school’s policy for transfer of credits.</div>
		
		<div class="addcheckalign"><span>&#x2022;</span><a href="https://svhs.co/course-catalog/" target="_blank">
		See full course list</a></div>
		
		</div>
		
		<div class="section-wrapper" style="margin-left:17%">
		<div class="mdl-grid grid-content-container">
		<div id="sidebar-filters" class="filters-content mdl-cell mdl-cell--3-col border-grey-light" hidden=""><div class="sidebar-wrapper bg-white text-black"><div class="sidebar-holder border-grey-light" hidden=""><div class="data-tabs mdl-tabs mdl-js-tabs is-upgraded" data-upgraded=",MaterialTabs"><!----><div class="data-tabs-body"><div class="data-tab ng-star-inserted"><!----><!----><div class="filter mdl-cell mdl-cell--12-col border-grey-light ng-star-inserted"><div style="display: inline-flex;"><div class="filter-title"> Available from </div><!----></div><!----><!----><!----><!----><!----><!----><!----><!----><div class="border-grey-light filter-box ng-star-inserted"><!----><radio class="ng-star-inserted"><label class="mdl-radio mdl-js-radio docebo-radio is-checked is-upgraded" for="radio-1" data-upgraded=",MaterialRadio"><!----><input type="radio" class="mdl-radio__button ng-untouched ng-pristine ng-valid ng-star-inserted" id="radio-1"><!----><!----><div class="text-container"><!----><!----><span class="mdl-radio__label docebo-input-text text-grey-dark ng-star-inserted" style="visibility: visible;">Anytime</span><!----><!----><!----><!----></div><span class="mdl-radio__outer-circle"></span><span class="mdl-radio__inner-circle"></span></label></radio><radio class="ng-star-inserted"><label class="mdl-radio mdl-js-radio docebo-radio is-upgraded" for="radio-2" data-upgraded=",MaterialRadio"><!----><input type="radio" class="mdl-radio__button ng-untouched ng-pristine ng-valid ng-star-inserted" id="radio-2"><!----><!----><div class="text-container"><!----><!----><span class="mdl-radio__label docebo-input-text text-grey-dark ng-star-inserted" style="visibility: visible;">Today</span><!----><!----><!----><!----></div><span class="mdl-radio__outer-circle"></span><span class="mdl-radio__inner-circle"></span></label></radio><radio class="ng-star-inserted"><label class="mdl-radio mdl-js-radio docebo-radio is-upgraded" for="radio-3" data-upgraded=",MaterialRadio"><!----><input type="radio" class="mdl-radio__button ng-untouched ng-pristine ng-valid ng-star-inserted" id="radio-3"><!----><!----><div class="text-container"><!----><!----><span class="mdl-radio__label docebo-input-text text-grey-dark ng-star-inserted" style="visibility: visible;">Last 7 Days</span><!----><!----><!----><!----></div><span class="mdl-radio__outer-circle"></span><span class="mdl-radio__inner-circle"></span></label></radio><radio class="ng-star-inserted"><label class="mdl-radio mdl-js-radio docebo-radio is-upgraded" for="radio-4" data-upgraded=",MaterialRadio"><!----><input type="radio" class="mdl-radio__button ng-untouched ng-pristine ng-valid ng-star-inserted" id="radio-4"><!----><!----><div class="text-container"><!----><!----><span class="mdl-radio__label docebo-input-text text-grey-dark ng-star-inserted" style="visibility: visible;">This Month</span><!----><!----><!----><!----></div><span class="mdl-radio__outer-circle"></span><span class="mdl-radio__inner-circle"></span></label></radio><radio class="last ng-star-inserted"><label class="mdl-radio mdl-js-radio docebo-radio is-upgraded" for="radio-5" data-upgraded=",MaterialRadio"><!----><input type="radio" class="mdl-radio__button ng-untouched ng-pristine ng-valid ng-star-inserted" id="radio-5"><!----><!----><div class="text-container"><!----><!----><span class="mdl-radio__label docebo-input-text text-grey-dark ng-star-inserted" style="visibility: visible;">This Year</span><!----><!----><!----><!----></div><span class="mdl-radio__outer-circle"></span><span class="mdl-radio__inner-circle"></span></label></radio><!----></div><!----><!----></div><!----><!----><div class="filter mdl-cell mdl-cell--12-col border-grey-light ng-star-inserted"><div style="display: inline-flex;"><div class="filter-title"> Status </div><!----></div><!----><!----><!----><!----><div class="border-grey-light filter-box ng-star-inserted"><ui-input-checkbox class="ng-untouched ng-pristine ng-valid ng-star-inserted"><div class="ui-input-checkbox"><input type="checkbox" id="ui-input-checkbox-0" name="ui-input-checkbox-0" class="ng-untouched ng-pristine ng-valid" tabindex="0"><label class="ui-input-checkbox-container" for="ui-input-checkbox-0"><span uiripple="" class="ui-ripple ui-input-checkbox-control"><span class="ui-input-checkbox-square"><span class="ui-input-checkbox-check"><ui-icon class="ui-icon ui-icon-size-xs"><span class="color-negative"><svg viewBox="0 0 24 24"><g xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="check" fill-rule="evenodd"><polygon points="8.578125 16.21875 19.21875 5.578125 20.578125 6.984375 8.578125 18.984375 3 13.40625 4.40625 12"></polygon></g></svg></span></ui-icon></span><span class="ui-input-checkbox-indeterminate-check"></span></span></span><span class="ui-input-checkbox-info"><span class="ui-input-checkbox-label ui-typography-body"><ui-input-label>Not Started</ui-input-label><!----></span><span class="ui-input-checkbox-subtitle ui-typography-subtitle"></span></span></label><!----></div></ui-input-checkbox><ui-input-checkbox class="ng-untouched ng-pristine ng-valid ng-star-inserted"><div class="ui-input-checkbox"><input type="checkbox" id="ui-input-checkbox-1" name="ui-input-checkbox-1" class="ng-untouched ng-pristine ng-valid" tabindex="0"><label class="ui-input-checkbox-container" for="ui-input-checkbox-1"><span uiripple="" class="ui-ripple ui-input-checkbox-control"><span class="ui-input-checkbox-square"><span class="ui-input-checkbox-check"><ui-icon class="ui-icon ui-icon-size-xs"><span class="color-negative"><svg viewBox="0 0 24 24"><g xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="check" fill-rule="evenodd"><polygon points="8.578125 16.21875 19.21875 5.578125 20.578125 6.984375 8.578125 18.984375 3 13.40625 4.40625 12"></polygon></g></svg></span></ui-icon></span><span class="ui-input-checkbox-indeterminate-check"></span></span></span><span class="ui-input-checkbox-info"><span class="ui-input-checkbox-label ui-typography-body"><ui-input-label>In Progress</ui-input-label><!----></span><span class="ui-input-checkbox-subtitle ui-typography-subtitle"></span></span></label><!----></div></ui-input-checkbox><ui-input-checkbox class="last ng-untouched ng-pristine ng-valid ng-star-inserted"><div class="ui-input-checkbox"><input type="checkbox" id="ui-input-checkbox-2" name="ui-input-checkbox-2" class="ng-untouched ng-pristine ng-valid" tabindex="0"><label class="ui-input-checkbox-container" for="ui-input-checkbox-2"><span uiripple="" class="ui-ripple ui-input-checkbox-control"><span class="ui-input-checkbox-square"><span class="ui-input-checkbox-check"><ui-icon class="ui-icon ui-icon-size-xs"><span class="color-negative"><svg viewBox="0 0 24 24"><g xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="check" fill-rule="evenodd"><polygon points="8.578125 16.21875 19.21875 5.578125 20.578125 6.984375 8.578125 18.984375 3 13.40625 4.40625 12"></polygon></g></svg></span></ui-icon></span><span class="ui-input-checkbox-indeterminate-check"></span></span></span><span class="ui-input-checkbox-info"><span class="ui-input-checkbox-label ui-typography-body"><ui-input-label>Completed</ui-input-label><!----></span><span class="ui-input-checkbox-subtitle ui-typography-subtitle"></span></span></label><!----></div></ui-input-checkbox><!----></div><!----><!----><!----><!----><!----><!----></div><!----><!----><div class="filter mdl-cell mdl-cell--12-col border-grey-light ng-star-inserted"><div style="display: inline-flex;"><div class="filter-title"> Hidden Items </div><!----></div><!----><!----><!----><!----><!----><!----><!----><!----><div class="border-grey-light filter-box ng-star-inserted"><!----><radio class="ng-star-inserted"><label class="mdl-radio mdl-js-radio docebo-radio is-checked is-upgraded" for="radio-6" data-upgraded=",MaterialRadio"><!----><input type="radio" class="mdl-radio__button ng-untouched ng-pristine ng-valid ng-star-inserted" id="radio-6"><!----><!----><div class="text-container"><!----><!----><span class="mdl-radio__label docebo-input-text text-grey-dark ng-star-inserted" style="visibility: visible;">Don't Show Hidden Items</span><!----><!----><!----><!----></div><span class="mdl-radio__outer-circle"></span><span class="mdl-radio__inner-circle"></span></label></radio><radio class="ng-star-inserted"><label class="mdl-radio mdl-js-radio docebo-radio is-upgraded" for="radio-7" data-upgraded=",MaterialRadio"><!----><input type="radio" class="mdl-radio__button ng-untouched ng-pristine ng-valid ng-star-inserted" id="radio-7"><!----><!----><div class="text-container"><!----><!----><span class="mdl-radio__label docebo-input-text text-grey-dark ng-star-inserted" style="visibility: visible;">Show also Hidden Items</span><!----><!----><!----><!----></div><span class="mdl-radio__outer-circle"></span><span class="mdl-radio__inner-circle"></span></label></radio><radio class="last ng-star-inserted"><label class="mdl-radio mdl-js-radio docebo-radio is-upgraded" for="radio-8" data-upgraded=",MaterialRadio"><!----><input type="radio" class="mdl-radio__button ng-untouched ng-pristine ng-valid ng-star-inserted" id="radio-8"><!----><!----><div class="text-container"><!----><!----><span class="mdl-radio__label docebo-input-text text-grey-dark ng-star-inserted" style="visibility: visible;">Show Hidden Items Only</span><!----><!----><!----><!----></div><span class="mdl-radio__outer-circle"></span><span class="mdl-radio__inner-circle"></span></label></radio><!----></div><!----><!----></div><!----><!----><div class="filter mdl-cell mdl-cell--12-col border-grey-light ng-star-inserted"><div style="display: inline-flex;"><div class="filter-title"> Type </div><!----></div><!----><!----><!----><!----><div class="border-grey-light filter-box ng-star-inserted"><ui-input-checkbox class="ng-untouched ng-pristine ng-valid ng-star-inserted"><div class="ui-input-checkbox"><input type="checkbox" id="ui-input-checkbox-3" name="ui-input-checkbox-3" class="ng-untouched ng-pristine ng-valid" tabindex="0"><label class="ui-input-checkbox-container" for="ui-input-checkbox-3"><span uiripple="" class="ui-ripple ui-input-checkbox-control"><span class="ui-input-checkbox-square"><span class="ui-input-checkbox-check"><ui-icon class="ui-icon ui-icon-size-xs"><span class="color-negative"><svg viewBox="0 0 24 24"><g xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="check" fill-rule="evenodd"><polygon points="8.578125 16.21875 19.21875 5.578125 20.578125 6.984375 8.578125 18.984375 3 13.40625 4.40625 12"></polygon></g></svg></span></ui-icon></span><span class="ui-input-checkbox-indeterminate-check"></span></span></span><span class="ui-input-checkbox-info"><span class="ui-input-checkbox-label ui-typography-body"><ui-input-label>FUNCTIONAL</ui-input-label><!----></span><span class="ui-input-checkbox-subtitle ui-typography-subtitle"></span></span></label><!----></div></ui-input-checkbox><ui-input-checkbox class="ng-untouched ng-pristine ng-valid ng-star-inserted"><div class="ui-input-checkbox"><input type="checkbox" id="ui-input-checkbox-4" name="ui-input-checkbox-4" class="ng-untouched ng-pristine ng-valid" tabindex="0"><label class="ui-input-checkbox-container" for="ui-input-checkbox-4"><span uiripple="" class="ui-ripple ui-input-checkbox-control"><span class="ui-input-checkbox-square"><span class="ui-input-checkbox-check"><ui-icon class="ui-icon ui-icon-size-xs"><span class="color-negative"><svg viewBox="0 0 24 24"><g xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="check" fill-rule="evenodd"><polygon points="8.578125 16.21875 19.21875 5.578125 20.578125 6.984375 8.578125 18.984375 3 13.40625 4.40625 12"></polygon></g></svg></span></ui-icon></span><span class="ui-input-checkbox-indeterminate-check"></span></span></span><span class="ui-input-checkbox-info"><span class="ui-input-checkbox-label ui-typography-body"><ui-input-label>Classroom</ui-input-label><!----></span><span class="ui-input-checkbox-subtitle ui-typography-subtitle"></span></span></label><!----></div></ui-input-checkbox><ui-input-checkbox class="ng-untouched ng-pristine ng-valid ng-star-inserted"><div class="ui-input-checkbox"><input type="checkbox" id="ui-input-checkbox-5" name="ui-input-checkbox-5" class="ng-untouched ng-pristine ng-valid" tabindex="0"><label class="ui-input-checkbox-container" for="ui-input-checkbox-5"><span uiripple="" class="ui-ripple ui-input-checkbox-control"><span class="ui-input-checkbox-square"><span class="ui-input-checkbox-check"><ui-icon class="ui-icon ui-icon-size-xs"><span class="color-negative"><svg viewBox="0 0 24 24"><g xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="check" fill-rule="evenodd"><polygon points="8.578125 16.21875 19.21875 5.578125 20.578125 6.984375 8.578125 18.984375 3 13.40625 4.40625 12"></polygon></g></svg></span></ui-icon></span><span class="ui-input-checkbox-indeterminate-check"></span></span></span><span class="ui-input-checkbox-info"><span class="ui-input-checkbox-label ui-typography-body"><ui-input-label>Webinar</ui-input-label><!----></span><span class="ui-input-checkbox-subtitle ui-typography-subtitle"></span></span></label><!----></div></ui-input-checkbox><ui-input-checkbox class="ng-untouched ng-pristine ng-valid ng-star-inserted"><div class="ui-input-checkbox"><input type="checkbox" id="ui-input-checkbox-6" name="ui-input-checkbox-6" class="ng-untouched ng-pristine ng-valid" tabindex="0"><label class="ui-input-checkbox-container" for="ui-input-checkbox-6"><span uiripple="" class="ui-ripple ui-input-checkbox-control"><span class="ui-input-checkbox-square"><span class="ui-input-checkbox-check"><ui-icon class="ui-icon ui-icon-size-xs"><span class="color-negative"><svg viewBox="0 0 24 24"><g xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
		id="check" fill-rule="evenodd"><polygon points="8.578125 16.21875 19.21875 5.578125 20.578125 6.984375 8.578125 18.984375 3 13.40625 4.40625 12"></polygon></g></svg></span></ui-icon></span><span class="ui-input-checkbox-indeterminate-check"></span></span></span><span class="ui-input-checkbox-info"><span class="ui-input-checkbox-label ui-typography-body"><ui-input-label>Learning Plan</ui-input-label><!----></span><span class="ui-input-checkbox-subtitle ui-typography-subtitle"></span></span></label><!----></div></ui-input-checkbox><ui-input-checkbox class="ng-untouched ng-pristine ng-valid ng-star-inserted"><div class="ui-input-checkbox"><input type="checkbox" id="ui-input-checkbox-7" name="ui-input-checkbox-7" class="ng-untouched ng-pristine ng-valid" tabindex="0"><label class="ui-input-checkbox-container" for="ui-input-checkbox-7"><span uiripple="" class="ui-ripple ui-input-checkbox-control"><span class="ui-input-checkbox-square"><span class="ui-input-checkbox-check"><ui-icon class="ui-icon ui-icon-size-xs"><span class="color-negative"><svg viewBox="0 0 24 24"><g xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="check" fill-rule="evenodd"><polygon points="8.578125 16.21875 19.21875 5.578125 20.578125 6.984375 8.578125 18.984375 3 13.40625 4.40625 12"></polygon></g></svg></span></ui-icon></span><span class="ui-input-checkbox-indeterminate-check"></span></span></span><span class="ui-input-checkbox-info"><span class="ui-input-checkbox-label ui-typography-body"><ui-input-label>Videos</ui-input-label><!----></span><span class="ui-input-checkbox-subtitle ui-typography-subtitle"></span></span></label><!----></div></ui-input-checkbox><ui-input-checkbox class="ng-untouched ng-pristine ng-valid ng-star-inserted"><div class="ui-input-checkbox"><input type="checkbox" id="ui-input-checkbox-8" name="ui-input-checkbox-8" class="ng-untouched ng-pristine ng-valid" tabindex="0"><label class="ui-input-checkbox-container" for="ui-input-checkbox-8"><span uiripple="" class="ui-ripple ui-input-checkbox-control"><span class="ui-input-checkbox-square"><span class="ui-input-checkbox-check"><ui-icon class="ui-icon ui-icon-size-xs"><span class="color-negative"><svg viewBox="0 0 24 24"><g xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="check" fill-rule="evenodd"><polygon points="8.578125 16.21875 19.21875 5.578125 20.578125 6.984375 8.578125 18.984375 3 13.40625 4.40625 12"></polygon></g></svg></span></ui-icon></span><span class="ui-input-checkbox-indeterminate-check"></span></span></span><span class="ui-input-checkbox-info"><span class="ui-input-checkbox-label ui-typography-body"><ui-input-label>Documents</ui-input-label><!----></span><span class="ui-input-checkbox-subtitle ui-typography-subtitle"></span></span></label><!----></div></ui-input-checkbox><ui-input-checkbox class="ng-untouched ng-pristine ng-valid ng-star-inserted"><div class="ui-input-checkbox"><input type="checkbox" id="ui-input-checkbox-9" name="ui-input-checkbox-9" class="ng-untouched ng-pristine ng-valid" tabindex="0"><label class="ui-input-checkbox-container" for="ui-input-checkbox-9"><span uiripple="" class="ui-ripple ui-input-checkbox-control"><span class="ui-input-checkbox-square"><span class="ui-input-checkbox-check"><ui-icon class="ui-icon ui-icon-size-xs"><span class="color-negative"><svg viewBox="0 0 24 24"><g xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="check" fill-rule="evenodd"><polygon points="8.578125 16.21875 19.21875 5.578125 20.578125 6.984375 8.578125 18.984375 3 13.40625 4.40625 12"></polygon></g></svg></span></ui-icon></span><span class="ui-input-checkbox-indeterminate-check"></span></span></span><span class="ui-input-checkbox-info"><span class="ui-input-checkbox-label ui-typography-body"><ui-input-label>Google Drive Items</ui-input-label><!----></span><span class="ui-input-checkbox-subtitle ui-typography-subtitle"></span></span></label><!----></div></ui-input-checkbox><ui-input-checkbox class="ng-untouched ng-pristine ng-valid ng-star-inserted"><div class="ui-input-checkbox"><input type="checkbox" id="ui-input-checkbox-10" name="ui-input-checkbox-10" class="ng-untouched ng-pristine ng-valid" tabindex="0"><label class="ui-input-checkbox-container" for="ui-input-checkbox-10"><span uiripple="" class="ui-ripple ui-input-checkbox-control"><span class="ui-input-checkbox-square"><span class="ui-input-checkbox-check"><ui-icon class="ui-icon ui-icon-size-xs"><span class="color-negative"><svg viewBox="0 0 24 24"><g xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="check" fill-rule="evenodd"><polygon points="8.578125 16.21875 19.21875 5.578125 20.578125 6.984375 8.578125 18.984375 3 13.40625 4.40625 12"></polygon></g></svg></span></ui-icon></span><span class="ui-input-checkbox-indeterminate-check"></span></span></span><span class="ui-input-checkbox-info"><span class="ui-input-checkbox-label ui-typography-body"><ui-input-label>Images</ui-input-label><!----></span><span class="ui-input-checkbox-subtitle ui-typography-subtitle"></span></span></label><!----></div></ui-input-checkbox><ui-input-checkbox class="ng-untouched ng-pristine ng-valid ng-star-inserted"><div class="ui-input-checkbox"><input type="checkbox" id="ui-input-checkbox-11" name="ui-input-checkbox-11" class="ng-untouched ng-pristine ng-valid" tabindex="0"><label class="ui-input-checkbox-container" for="ui-input-checkbox-11"><span uiripple="" class="ui-ripple ui-input-checkbox-control"><span class="ui-input-checkbox-square"><span class="ui-input-checkbox-check"><ui-icon class="ui-icon ui-icon-size-xs"><span class="color-negative"><svg viewBox="0 0 24 24"><g xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="check" fill-rule="evenodd"><polygon points="8.578125 16.21875 19.21875 5.578125 20.578125 6.984375 8.578125 18.984375 3 13.40625 4.40625 12"></polygon></g></svg></span></ui-icon></span><span class="ui-input-checkbox-indeterminate-check"></span></span></span><span class="ui-input-checkbox-info"><span class="ui-input-checkbox-label ui-typography-body"><ui-input-label>Links</ui-input-label><!----></span><span class="ui-input-checkbox-subtitle ui-typography-subtitle"></span></span></label><!----></div></ui-input-checkbox><ui-input-checkbox class="ng-untouched ng-pristine ng-valid ng-star-inserted"><div class="ui-input-checkbox"><input type="checkbox" id="ui-input-checkbox-12" name="ui-input-checkbox-12" class="ng-untouched ng-pristine ng-valid" tabindex="0"><label class="ui-input-checkbox-container" for="ui-input-checkbox-12"><span uiripple="" class="ui-ripple ui-input-checkbox-control"><span class="ui-input-checkbox-square"><span class="ui-input-checkbox-check"><ui-icon class="ui-icon ui-icon-size-xs"><span class="color-negative"><svg viewBox="0 0 24 24"><g xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="check" fill-rule="evenodd"><polygon points="8.578125 16.21875 19.21875 5.578125 20.578125 6.984375 8.578125 18.984375 3 13.40625 4.40625 12"></polygon></g></svg></span></ui-icon></span><span class="ui-input-checkbox-indeterminate-check"></span></span></span><span class="ui-input-checkbox-info"><span class="ui-input-checkbox-label ui-typography-body"><ui-input-label>PDFs</ui-input-label><!----></span><span class="ui-input-checkbox-subtitle ui-typography-subtitle"></span></span></label><!----></div></ui-input-checkbox><ui-input-checkbox class="ng-untouched ng-pristine ng-valid ng-star-inserted"><div class="ui-input-checkbox"><input type="checkbox" id="ui-input-checkbox-13" name="ui-input-checkbox-13" class="ng-untouched ng-pristine ng-valid" tabindex="0"><label class="ui-input-checkbox-container" for="ui-input-checkbox-13"><span uiripple="" class="ui-ripple ui-input-checkbox-control"><span class="ui-input-checkbox-square"><span class="ui-input-checkbox-check"><ui-icon class="ui-icon ui-icon-size-xs"><span class="color-negative"><svg viewBox="0 0 24 24"><g xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="check" fill-rule="evenodd"><polygon points="8.578125 16.21875 19.21875 5.578125 20.578125 6.984375 8.578125 18.984375 3 13.40625 4.40625 12"></polygon></g></svg></span></ui-icon></span><span class="ui-input-checkbox-indeterminate-check"></span></span></span><span class="ui-input-checkbox-info"><span class="ui-input-checkbox-label ui-typography-body"><ui-input-label>Audio</ui-input-label><!----></span><span class="ui-input-checkbox-subtitle ui-typography-subtitle"></span></span></label><!----></div></ui-input-checkbox><ui-input-checkbox class="ng-untouched ng-pristine ng-valid ng-star-inserted"><div class="ui-input-checkbox"><input type="checkbox" id="ui-input-checkbox-14" name="ui-input-checkbox-14" class="ng-untouched ng-pristine ng-valid" tabindex="0"><label class="ui-input-checkbox-container" for="ui-input-checkbox-14"><span uiripple="" class="ui-ripple ui-input-checkbox-control"><span class="ui-input-checkbox-square"><span class="ui-input-checkbox-check"><ui-icon class="ui-icon ui-icon-size-xs"><span class="color-negative"><svg viewBox="0 0 24 24"><g xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="check" fill-rule="evenodd"><polygon points="8.578125 16.21875 19.21875 5.578125 20.578125 6.984375 8.578125 18.984375 3 13.40625 4.40625 12"></polygon></g></svg></span></ui-icon></span><span class="ui-input-checkbox-indeterminate-check"></span></span></span><span class="ui-input-checkbox-info"><span class="ui-input-checkbox-label ui-typography-body"><ui-input-label>Others</ui-input-label><!----></span><span class="ui-input-checkbox-subtitle ui-typography-subtitle"></span></span></label><!----></div></ui-input-checkbox><ui-input-checkbox class="last ng-untouched ng-pristine ng-valid ng-star-inserted"><div class="ui-input-checkbox"><input type="checkbox" id="ui-input-checkbox-15" name="ui-input-checkbox-15" class="ng-untouched ng-pristine ng-valid" tabindex="0"><label class="ui-input-checkbox-container" for="ui-input-checkbox-15"><span uiripple="" class="ui-ripple ui-input-checkbox-control"><span class="ui-input-checkbox-square"><span class="ui-input-checkbox-check"><ui-icon class="ui-icon ui-icon-size-xs"><span class="color-negative"><svg viewBox="0 0 24 24"><g xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="check" fill-rule="evenodd"><polygon points="8.578125 16.21875 19.21875 5.578125 20.578125 6.984375 8.578125 18.984375 3 13.40625 4.40625 12"></polygon></g></svg></span></ui-icon></span><span class="ui-input-checkbox-indeterminate-check"></span></span></span><span class="ui-input-checkbox-info"><span class="ui-input-checkbox-label ui-typography-body"><ui-input-label>Playlist</ui-input-label><!----></span><span class="ui-input-checkbox-subtitle ui-typography-subtitle"></span></span></label><!----></div></ui-input-checkbox><!----></div><!----><!----><!----><!----><!----><!----></div><!----><!----><div class="filter mdl-cell mdl-cell--12-col border-grey-light ng-star-inserted"><div style="display: inline-flex;"><div class="filter-title"> Deadline </div><!----></div><!----><!----><!----><!----><!----><!----><!----><!----><div class="border-grey-light filter-box ng-star-inserted"><!----><radio class="ng-star-inserted"><label class="mdl-radio mdl-js-radio docebo-radio is-checked is-upgraded" for="radio-9" data-upgraded=",MaterialRadio"><!----><input type="radio" class="mdl-radio__button ng-untouched ng-pristine ng-valid ng-star-inserted" id="radio-9"><!----><!----><div class="text-container"><!----><!----><span class="mdl-radio__label docebo-input-text text-grey-dark ng-star-inserted" style="visibility: visible;">All deadlines</span><!----><!----><!----><!----></div><span class="mdl-radio__outer-circle"></span><span class="mdl-radio__inner-circle"></span></label></radio><radio class="ng-star-inserted"><label class="mdl-radio mdl-js-radio docebo-radio is-upgraded" for="radio-10" data-upgraded=",MaterialRadio"><!----><input type="radio" class="mdl-radio__button ng-untouched ng-pristine ng-valid ng-star-inserted" id="radio-10"><!----><!----><div class="text-container"><!----><!----><span class="mdl-radio__label docebo-input-text text-grey-dark ng-star-inserted" style="visibility: visible;">Today</span><!----><!----><!----><!----></div><span class="mdl-radio__outer-circle"></span><span class="mdl-radio__inner-circle"></span></label></radio><radio class="ng-star-inserted"><label class="mdl-radio mdl-js-radio docebo-radio is-upgraded" for="radio-11" data-upgraded=",MaterialRadio"><!----><input type="radio" class="mdl-radio__button ng-untouched ng-pristine ng-valid ng-star-inserted" id="radio-11"><!----><!----><div class="text-container"><!----><!----><span class="mdl-radio__label docebo-input-text text-grey-dark ng-star-inserted" style="visibility: visible;">This Week</span><!----><!----><!----><!----></div><span class="mdl-radio__outer-circle"></span><span class="mdl-radio__inner-circle"></span></label></radio><radio class="ng-star-inserted"><label class="mdl-radio mdl-js-radio docebo-radio is-upgraded" for="radio-12" data-upgraded=",MaterialRadio"><!----><input type="radio" class="mdl-radio__button ng-untouched ng-pristine ng-valid ng-star-inserted" id="radio-12"><!----><!----><div class="text-container"><!----><!----><span class="mdl-radio__label docebo-input-text text-grey-dark ng-star-inserted" style="visibility: visible;">This Month</span><!----><!----><!----><!----></div><span class="mdl-radio__outer-circle"></span><span class="mdl-radio__inner-circle"></span></label></radio><radio class="last ng-star-inserted"><label class="mdl-radio mdl-js-radio docebo-radio is-upgraded" for="radio-13" data-upgraded=",MaterialRadio"><!----><input type="radio" class="mdl-radio__button ng-untouched ng-pristine ng-valid ng-star-inserted" id="radio-13"><!----><!----><div class="text-container"><!----><!----><span class="mdl-radio__label docebo-input-text text-grey-dark ng-star-inserted" style="visibility: visible;">This Year</span><!----><!----><!----><!----></div><span class="mdl-radio__outer-circle"></span><span class="mdl-radio__inner-circle"></span></label></radio><!----></div><!----><!----></div><!----><!----><div class="filter mdl-cell mdl-cell--12-col border-grey-light ng-star-inserted"><div style="display: inline-flex;"><div class="filter-title"> Duration </div><!----></div><!----><!----><!----><!----><!----><!----><!----><!----><div class="border-grey-light filter-box ng-star-inserted"><!----><radio class="ng-star-inserted"><label class="mdl-radio mdl-js-radio docebo-radio is-checked is-upgraded" for="radio-14" data-upgraded=",MaterialRadio"><!----><input type="radio" class="mdl-radio__button ng-untouched ng-pristine ng-valid ng-star-inserted" id="radio-14"><!----><!----><div class="text-container"><!----><!----><span class="mdl-radio__label docebo-input-text text-grey-dark ng-star-inserted" style="visibility: visible;">All durations</span><!----><!----><!----><!----></div><span class="mdl-radio__outer-circle"></span><span class="mdl-radio__inner-circle"></span></label></radio><radio class="ng-star-inserted"><label class="mdl-radio mdl-js-radio docebo-radio is-upgraded" for="radio-15" data-upgraded=",MaterialRadio"><!----><input type="radio" class="mdl-radio__button ng-untouched ng-pristine ng-valid ng-star-inserted" id="radio-15"><!----><!----><div class="text-container"><!----><!----><span class="mdl-radio__label docebo-input-text text-grey-dark ng-star-inserted" style="visibility: visible;">Short (&lt; 5 minutes)</span><!----><!----><!----><!----></div><span class="mdl-radio__outer-circle"></span><span class="mdl-radio__inner-circle"></span></label></radio><radio class="ng-star-inserted"><label class="mdl-radio mdl-js-radio docebo-radio is-upgraded" for="radio-16" data-upgraded=",MaterialRadio"><!----><input type="radio" class="mdl-radio__button ng-untouched ng-pristine ng-valid ng-star-inserted" id="radio-16"><!----><!----><div class="text-container"><!----><!----><span class="mdl-radio__label docebo-input-text text-grey-dark ng-star-inserted" style="visibility: visible;">Medium (5 - 30 minutes)</span><!----><!----><!----><!----></div><span class="mdl-radio__outer-circle"></span><span class="mdl-radio__inner-circle"></span></label></radio><radio class="last ng-star-inserted"><label class="mdl-radio mdl-js-radio docebo-radio is-upgraded" for="radio-17" data-upgraded=",MaterialRadio"><!----><input type="radio" class="mdl-radio__button ng-untouched ng-pristine ng-valid ng-star-inserted" id="radio-17"><!----><!----><div class="text-container"><!----><!----><span class="mdl-radio__label docebo-input-text text-grey-dark ng-star-inserted" style="visibility: visible;">Long (&gt; 30 minutes)</span><!----><!----><!----><!----></div><span class="mdl-radio__outer-circle"></span><span class="mdl-radio__inner-circle"></span></label></radio><!----></div><!----><!----></div><!----><!----><div class="filter mdl-cell mdl-cell--12-col border-grey-light last ng-star-inserted"><div style="display: inline-flex;"><div class="filter-title"> Rating </div><!----></div><!----><!----><!----><!----><!----><!----><!----><div class="border-grey-light filter-box ng-star-inserted"><div class="rating-holder"><radio class="ng-star-inserted"><label class="mdl-radio mdl-js-radio docebo-radio is-checked is-upgraded" for="radio-18" data-upgraded=",MaterialRadio"><!----><input type="radio" class="mdl-radio__button ng-untouched ng-pristine ng-valid ng-star-inserted" id="radio-18"><!----><!----><div class="text-container"><!----><span class="mdl-radio__label docebo-input-text text-grey-dark ng-star-inserted" style="visibility: visible;">All Ratings</span><!----><!----><!----><!----><!----></div><span class="mdl-radio__outer-circle"></span><span class="mdl-radio__inner-circle"></span></label></radio><!----></div><div class="rating-holder ng-star-inserted"><radio><label class="mdl-radio mdl-js-radio docebo-radio is-upgraded" for="radio-19" data-upgraded=",MaterialRadio"><!----><input type="radio" class="mdl-radio__button ng-untouched ng-pristine ng-valid ng-star-inserted" id="radio-19"><!----><!----><div class="text-container"><span class="mdl-radio__label ng-star-inserted"><i class="fa fa-star full-star ng-star-inserted"></i><i class="fa fa-star-o ng-star-inserted"></i><i class="fa fa-star-o ng-star-inserted"></i><i class="fa fa-star-o ng-star-inserted"></i><i class="fa fa-star-o ng-star-inserted"></i><!----><span>1 +</span></span><!----><!----></div><span class="mdl-radio__outer-circle"></span><span class="mdl-radio__inner-circle"></span></label></radio></div><div class="rating-holder ng-star-inserted"><radio><label class="mdl-radio mdl-js-radio docebo-radio is-upgraded" for="radio-20" data-upgraded=",MaterialRadio"><!----><input type="radio" class="mdl-radio__button ng-untouched ng-pristine ng-valid ng-star-inserted" id="radio-20"><!----><!----><div class="text-container"><span class="mdl-radio__label ng-star-inserted"><i class="fa fa-star full-star ng-star-inserted"></i><i class="fa fa-star full-star ng-star-inserted"></i><i class="fa fa-star-o ng-star-inserted"></i><i class="fa fa-star-o ng-star-inserted"></i><i class="fa fa-star-o ng-star-inserted"></i><!----><span>2 +</span></span><!----><!----></div><span class="mdl-radio__outer-circle"></span><span class="mdl-radio__inner-circle"></span></label></radio></div><div class="rating-holder ng-star-inserted"><radio><label class="mdl-radio mdl-js-radio docebo-radio is-upgraded" for="radio-21" data-upgraded=",MaterialRadio"><!----><input type="radio" class="mdl-radio__button ng-untouched ng-pristine ng-valid ng-star-inserted" id="radio-21"><!----><!----><div class="text-container"><span class="mdl-radio__label ng-star-inserted"><i class="fa fa-star full-star ng-star-inserted"></i><i class="fa fa-star full-star ng-star-inserted"></i><i class="fa fa-star full-star ng-star-inserted"></i><i class="fa fa-star-o ng-star-inserted"></i><i class="fa fa-star-o ng-star-inserted"></i><!----><span>3 +</span></span><!----><!----></div><span class="mdl-radio__outer-circle"></span><span class="mdl-radio__inner-circle"></span></label></radio></div><div class="rating-holder last ng-star-inserted"><radio><label class="mdl-radio mdl-js-radio docebo-radio is-upgraded" for="radio-22" data-upgraded=",MaterialRadio"><!----><input type="radio" class="mdl-radio__button ng-untouched ng-pristine ng-valid ng-star-inserted" id="radio-22"><!----><!----><div class="text-container"><span class="mdl-radio__label ng-star-inserted"><i class="fa fa-star full-star ng-star-inserted"></i><i class="fa fa-star full-star ng-star-inserted"></i><i class="fa fa-star full-star ng-star-inserted"></i><i class="fa fa-star full-star ng-star-inserted"></i><i class="fa fa-star-o ng-star-inserted"></i><!----><span>4 +</span></span><!----><!----></div><span class="mdl-radio__outer-circle"></span><span class="mdl-radio__inner-circle"></span></label></radio></div><!----></div><!----><!----><!----></div><!----><!----><!----><div class="border-grey-light clear-filters text-main"><basic-button><button class="mdl-button mdl-js-button button-text docebo-button bg-hover-grey-superlight" type="button" data-upgraded=",MaterialButton"><i class="text-grey-dark text-hover-grey-dark">Clear Active Filters</i></button></basic-button></div></div><!----><!----></div></div></div><div class="sidebar-holder border-grey-light" hidden=""><!----></div><div class="sidebar-holder border-grey-light" hidden=""></div></div></div><div class="data-browser-content mdl-cell mdl-cell--12-col"><div _ngcontent-kmb-c370="" class="widget-channels-content"><!----><channels-tiles-wrapper _ngcontent-kmb-c370="" _nghost-kmb-c372="" class="ng-star-inserted"><div _ngcontent-kmb-c372="" class="course-tiles vertical-card">
		

		
		<div _ngcontent-kmb-c372="" id="catalogcourse" class="course-tiles-inner tiles-5">
		
		
		
		<!----></div>
		
		<blankslate _ngcontent-kmb-c372="" _nghost-kmb-c345=""><!----><!----></blankslate></div></channels-tiles-wrapper><!----><!----></div></div></div>
		</div>
		</div></data-browser></div></channels-widget><!----></div><!----></widget-children-wrapper></structure-column-widget><!----></div><!---->
		</widget-children-wrapper>
		</div><!----></structure-row-widget><!----></div><!----></div></widget-render><!----><!----></dynamic-widget-page><!---->
		<!----><!----><!----></single-channel-widget><!----><!----></single-channel-wrapper><!----></div>
		
		<doc-layout-toasts>
		
		<div class="doc-layout-stacked-toasts">
		<!----></div></doc-layout-toasts>
		
		
		<doc-layout-dialogs><!----></doc-layout-dialogs><doc-layout-common-dialogs><div class="doc-layout-common-dialogs"><!----></div>
		</doc-layout-common-dialogs><doc-layout-launch-dialogs class="ng-star-inserted"><doc-shared-dialog><!----></doc-shared-dialog><doc-shared-dialog>
		<!----></doc-shared-dialog><doc-shared-dialog><!----></doc-shared-dialog><doc-shared-dialog></doc-shared-dialog><new-skills-dialogs-host>
		<new-skills-dialogs><doc-shared-dialog><!----></doc-shared-dialog></new-skills-dialogs></new-skills-dialogs-host></doc-layout-launch-dialogs>
		<!----><doc-layout-public-dialogs><doc-shared-dialog><!----></doc-shared-dialog><!----><!----><doc-shared-dialog><!----></doc-shared-dialog>
		<doc-shared-dialog><!----></doc-shared-dialog></doc-layout-public-dialogs>
		<dialog-component class="ng-tns-c282-0"><div class="dialog-overlay-temp ng-tns-c282-0"></div><dialog class="ng-tns-c282-0 ng-trigger ng-trigger-dialogAnimation mdl-dialog mdl-dialog__ no-actions scrollable" style="opacity: 1; width: 0px; height: 0px; top: 50%;"><div tabindex="0" class="ng-tns-c282-0"></div><div tabindex="0" class="ng-tns-c282-0"></div><div role="dialog" aria-atomic="true" class="dialog-wrapper ng-tns-c282-0" aria-label="" style="height: 300px;"><header class="mdl-dialog__title text-grey-dark ng-tns-c282-0"><div class="mdl-dialog__title--inner ng-tns-c282-0"><h4 class="ng-tns-c282-0"></h4><!----><!----></div><!----></header><div class="mdl-dialog__content text-grey-dark ng-tns-c282-0"><!----></div><!----><!----></div><div tabindex="0" class="ng-tns-c282-0"></div><!----></dialog></dialog-component></main>
		
		
		</div></doc-layout><!----></div></div><!----><router-outlet _ngcontent-kmb-c683="" name="slideup"></router-outlet><!---->
		</div><!----></div>
		
		<div class="pagination-wrapper" style="
    float: right;
    
">

  <div class="pagination">
	
	
  </div>
</div>

 </section>
 
 <!-- pagination -->
   
         <script src="js/jquery.min.js"></script>   
		<script>
$(document).ready(function(){
	

  $('#search-1').keyup(function(){
 
 	var filterval = "";
            $.each($("input[name='chkbranch']:checked"), function(){  
                filterval += ","+$(this).val();  
            });
		filterval = filterval .substring(1);
		
   // Search text
   var text = $(this).val().toLowerCase();
     
    $.ajax({
            url: './ajax/ajax_catlogcourses.php',
            type: 'post',
            data: {srhtext:text,filterval:filterval},
            success:function(response){                

                $("#catalogcourse").html(response);  
				
				       
            }		
    });
	
	
	 $.ajax({
            url: './ajax/ajax_pagination.php',
            type: 'post',
            data: {srhtext:text,filterval:filterval},
            success:function(response){                

                $(".pagination").html(response);  
				
				       
            }		
    });
	
 
 
 });
 
	
     $.ajax({
            url: './ajax/ajax_catlogcourses.php',
            type: 'post',
            success:function(response){                

                $("#catalogcourse").html(response);  
				
				       
            }		
    });
	
	
	 $.ajax({
            url: './ajax/ajax_pagination.php',
            type: 'post',
            success:function(response){                

                $(".pagination").html(response);  
				
				       
            }		
    });
	
 });
 
 
		
	
	function paginate(pageid){
		
	var srhtext = $('#search-1').val().toLowerCase();
		
		var filterval = "";
            $.each($("input[name='chkbranch']:checked"), function(){  
                filterval += ","+$(this).val();  
            });
		filterval = filterval .substring(1);
	
	 $.ajax({
            url: './ajax/ajax_catlogcourses.php',
            type: 'post',
            data: {page:pageid,filterval:filterval,srhtext:srhtext},
            success:function(response){                
                $("#catalogcourse").html(response);  	       
            }		
    });
	
	
	 $.ajax({
            url: './ajax/ajax_pagination.php',
            type: 'post',
            data: {page:pageid,filterval:filterval,srhtext:srhtext},
            success:function(response){                
               $(".pagination").html(response);  	       
            }		
    });
	
	}
	
	function addtocart(cid){
		
	 $.ajax({
            url: './ajax/addtocartcourses.php',
            type: 'post',
            data: {cid:cid},
            success:function(response){
           $('#cartadded'+cid).html('<a style="font-size: 11px;float: right;margin-bottom: 11px;" class="btn btn-primary" data-dismiss="modal"><i style="color: lime;font-size: 17px;margin-left: -10px;margin-right: 5px;" class="fa fa-check" aria-hidden="true"></i>Added in cart</a>');		
	
              updatecart();  	       
            }		
    });	
	}

function updatecart(){
	
	 $.ajax({
            url: './ajax/updatecartcounts.php',
            type: 'post',
            success:function(response){                
                
				$('#ex4').html(response);
            }		
    });	
}

function addcheckuncheck(){

	//filter
		
		var filterval = "";
            $.each($("input[name='chkbranch']:checked"), function(){  
                filterval += ","+$(this).val();  
            });
		filterval = filterval .substring(1);
		//alert(filterval);
	
		var srhtext = $('#search-1').val().toLowerCase();
   
		
		 $.ajax({
            url: './ajax/ajax_catlogcourses.php',
            type: 'post',
            data: {filterval:filterval,srhtext:srhtext},
            success:function(response){      
			
                $("#catalogcourse").html(response);  	       
            }		
		});
		
		
		 $.ajax({
				url: './ajax/ajax_pagination.php',
				type: 'post',
				data: {filterval:filterval,srhtext:srhtext},
				success:function(response){                
				   $(".pagination").html(response);  	       
				}		
		});
		
}

	</script>

 
<?php
	
echo $OUTPUT->footer();
