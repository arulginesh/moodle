<?php
require_once('../../config.php');
		
$srhtext = $_POST['srhtext'];
$filterval = $_POST['filterval'];

 if (!isset ($_POST['page'])) {  
        $page = 1;  
    } else {  
        $page = $_POST['page'];  
    }  


 $results_per_page = 10; 	

 
if(!empty($filterval)){	
	if(!empty($srhtext)){
	$totcour = $DB->get_records_sql("select * from {course} c 
						 where c.category = 28 and c.visible = 1 and cm_branch IN($filterval) and (lower(fullname) like '%".strtolower($srhtext)."%')");
	} else {				 
	$totcour = $DB->get_records_sql("select * from {course} c 
						 where c.category = 28 and c.visible = 1 and cm_branch IN($filterval)");
	}
} else {

	if(!empty($srhtext)){
	$totcour = $DB->get_records_sql("select * from {course} c 
						 where c.category = 28 and c.visible = 1 and (lower(fullname) like '%".strtolower($srhtext)."%')");
	} else {				 
	$totcour = $DB->get_records_sql("select * from {course} c 
						 where c.category = 28 and c.visible = 1 ");
	}

}	
					 
	 $number_of_result  = count($totcour) ;

	 $number_of_page = ceil ($number_of_result / $results_per_page); 
	            	
        if($page>=2){   
          echo "<a class='prev page-numbers' onclick='paginate($page-1)' style='font-family: Poppins;' href='javascript:;'>PREV</a>";
			
        }       
                   
        for ($i=1; $i<=$number_of_page; $i++) { 
		
          if ($i == $page) {   
              // echo "<a class = 'active' onclick='paginate($i,121)'  href='#'>".$i." </a>";  
  echo "<a class='page-numbers' onclick='paginate($i)' style='background-color: #3165ae!important;
    color: #fff !important;font-family: Poppins;' href='javascript:;'>".$i."</a>";			   
          }	               
          else  {   
        echo "<a class='page-numbers' onclick='paginate($i)' style='font-family: Poppins;' href='javascript:;'>".$i."</a>";			   
     
          }
		   
        };     
          
  
        if($page<$number_of_page){   
           // echo "<a href='index1.php?page=".($page+1)."'>  Next </a>";  
    echo"<a class='next page-numbers' onclick='paginate($page+1)' style='font-family: Poppins;' href='javascript:;'>NEXT</a>";
			
        }
		?>

 			 
	
	
	