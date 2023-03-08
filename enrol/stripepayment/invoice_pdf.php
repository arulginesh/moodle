<?php
require_once('../../config.php');

require_once($CFG->dirroot.'/mpdf60/mpdf.php');

global $DB;
global $USER;


			$filename = 'testing_12.pdf';	

            $mpdf=new mPDF('c','Letter','','' , 0 , 0 , 0 , 0 , 0 , 0);
			//$mpdf->SetProtection(array('print'));
			$mpdf->SetProtection(array('copy','print'),'', 'admin@svhs');
			
			
			$mpdf->SetDisplayMode('fullpage');
			 
			$mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
			ob_start();
			
		
			require_once 'invoice_receipt.php';
			$content = ob_get_clean();
			$mpdf->WriteHTML($content);
			//print_r($content);
			
			$mpdf->Output(); //send to browser
			//$mpdf->Output('invoice_pdf/'.$filename,'F');

