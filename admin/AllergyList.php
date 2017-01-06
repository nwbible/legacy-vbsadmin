<html>
	<head>
		<title>
			Allergies List
		</title>
		<style type="text/css">
    @import url(/templates/css/AdminTemplate_css.css);
		//body {font-family: "Arial"; color: red; font-size: 8pt; font-weight: bold;}
		th {font-family: "Arial"; font-size:8pt; font-weight:bold; text-align: center;}
		td {font-family: "Arial"; font-size:8pt; font-weight:normal;}
		</style>
	</head>
<body>

<?php
/**
 * 
 * Displays an alphabetical listing of children with allergies
 * by either AM or PM.
 *
 */

include ('Validation.inc');

/********************************************************************************************
*                                    MAIN                                                   *
********************************************************************************************/            
print sessionchoice();
 
if ($_POST['AMListing'])
{
  print AMAllergyList();
}
elseif ($_POST['PMListing'])
{
  print PMAllergyList();
}

  
/********************************************************************************************
*                                  END MAIN                                                   *
********************************************************************************************/

/********************************************************************************************
*                                    FUNCTIONS                                              *
********************************************************************************************/

function AMAllergyList()
{
  require('DBConnect2010.inc');

  $AMquery = "SELECT child_lastname, child_firstname, child_grade, child_classassignment, child_allergies 
              FROM tst_child_info 
              WHERE child_session = 1 AND (child_allergies != '' AND child_allergies != 'none' AND child_allergies != 'n/a' AND child_allergies != 'na') 
              ORDER BY child_classassignment, child_lastname, child_firstname";
              
  $rs = mysqli_query($conn, $AMquery);
  mysqli_close($conn);

  $classes = translate('tst_class_translate', 'class_id', 'class_description');
  $grades = translate('tst_grade_translate', 'grade_id', 'grade_description');

  $displayresults  = "<B>" . mysqli_num_rows($rs) . " children with allergies in the AM session.</B><BR><BR>";
  $displayresults .= "<table border='01' cellpadding='2'>";

  $displayresults .= "<tr>
                          <th>Child Name</th>
                          <th>Class Assignment</th>
                          <th>Allergies</th>
                			</tr>";

  $ctr = 0;
  while ($resultVars = mysqli_fetch_array($rs, MYSQL_ASSOC)) 
  {

    $displayresults .= "<tr>";
    $displayresults .= "<td>";
  	$displayresults .= $resultVars['child_lastname'] . ", " . $resultVars['child_firstname'];
	  $displayresults .= "</td>";
    $displayresults .= "<td>" . $classes[$resultVars['child_classassignment']] . "</td>";
    $displayresults .= "<td>" . $resultVars['child_allergies'] . "</td>";
    $displayresults .= "</tr>";
        
    $ctr++;
  }//end $resultVars while
  
  $displayresults .= "</table></form>";
  
  return $displayresults;

}

function PMAllergyList()
{
  require('DBConnect2010.inc');

   $PMquery = "SELECT child_lastname, child_firstname, child_grade, child_classassignment, child_allergies 
               FROM tst_child_info 
               WHERE child_session = 2 AND (child_allergies != '' AND child_allergies != 'none' AND child_allergies != 'n/a' AND child_allergies != 'na') 
               ORDER BY child_classassignment, child_lastname, child_firstname";
              
  $rs = mysqli_query($conn, $PMquery);
  mysqli_close($conn);

  $classes = translate('tst_class_translate', 'class_id', 'class_description');
  $grades = translate('tst_grade_translate', 'grade_id', 'grade_description');

  $displayresults  = "<B>" . mysqli_num_rows($rs) . " children with allergies in the PM session.</B><BR><BR>";
  $displayresults .= "<table border='01' cellpadding='2'>";
  $displayresults .= "<tr>
                          <th>Child Name</th>
                          <th>Class Assignment</th>
                          <th>Allergies</th>
                			</tr>";
  $ctr = 0;
  while ($resultVars = mysqli_fetch_array($rs, MYSQL_ASSOC)) 
  {

    $displayresults .= "<tr>";
    $displayresults .= "<td>";
  	$displayresults .= $resultVars['child_lastname'] . ", " . $resultVars['child_firstname'];
  	$displayresults .= "</td>";
    $displayresults .= "<td>" . $classes[$resultVars['child_classassignment']] . "</td>";
    $displayresults .= "<td>" . $resultVars['child_allergies'] . "</td>";
    $displayresults .= "</tr>";
        
    $ctr++;
  }//end $resultVars while
  
  $displayresults .= "</table></form>";
  
  return $displayresults;
}

function sessionchoice()
{
  
  $displayresults  = "";
  $displayresults .= "<form action=$_SERVER[PHP_SELF] method='post' name='SessionChoice'>";
  $displayresults .= "<table border='0' width='50%'><tr>";
  $displayresults .= "<td align='center'><input type='submit' class='button' name='AMListing' value='AM Session'></td>";
  $displayresults .= "<td align='center'><input type='submit' class='button' name='PMListing' value='PM Session'></td>";
  $displayresults .= "</tr></table></form>";
  
  return $displayresults;
}
?>