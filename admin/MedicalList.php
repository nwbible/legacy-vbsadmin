<html>
	<head>
		<title>
			medicalproblems List
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
 * Displays an alphabetical listing of children with medical issues
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
  //print $AMQuery
  print AMMedicalList();
}
elseif ($_POST['PMListing'])
{
  //print $PMQuery
  print PMMedicalList();
}

  
/********************************************************************************************
*                                  END MAIN                                                   *
********************************************************************************************/

/********************************************************************************************
*                                    FUNCTIONS                                              *
********************************************************************************************/

function AMMedicalList()
{
  require('DBConnect2010.inc');

  $AMquery = "SELECT child_lastname, child_firstname, child_grade, child_classassignment, child_medicalproblems 
              FROM tst_child_info 
              WHERE child_session = 1 AND (child_medicalproblems != '' AND child_medicalproblems != 'none' AND child_medicalproblems != 'n/a' AND child_medicalproblems != 'na') 
              ORDER BY child_classassignment, child_lastname, child_firstname";
              
  $rs = mysqli_query($conn, $AMquery);
  mysqli_close($conn);

  $classes = translate('tst_class_translate', 'class_id', 'class_description');
  $grades = translate('tst_grade_translate', 'grade_id', 'grade_description');

  $displayresults  = "<B>" . mysqli_num_rows($rs) . " children with medicalproblems in the AM session.</B><BR><BR>";
  $displayresults .= "<table border='01' cellpadding='2'>";
//  $displayresults .= "<tr>
//                          <th>Child Name</th>
//                          //<th>Grade</th>
 //                         <th>Class Assignment</th>
//                          <th>medicalproblems</th>
//                			</tr>";

  $displayresults .= "<tr>
                          <th>Child Name</th>
                          <th>Class Assignment</th>
                          <th>Medical Problems</th>
                			</tr>";

$ctr = 0;
  while ($resultVars = mysqli_fetch_array($rs, MYSQL_ASSOC)) 
  {

    $displayresults .= "<tr>";
    $displayresults .= "<td>";
    //$displayresults .= "<a href='Modify_Child.php?id=" . $resultVars[child_id] . "'>";
	$displayresults .= $resultVars['child_lastname'] . ", " . $resultVars['child_firstname'];
    //$displayresults .= "</a></td>";
	$displayresults .= "</td>";
  //  $displayresults .= "<td>" . $grades[$resultVars[child_grade]] . "</td>";
    $displayresults .= "<td>" . $classes[$resultVars['child_classassignment']] . "</td>";
    $displayresults .= "<td>" . $resultVars['child_medicalproblems'] . "</td>";
    $displayresults .= "</tr>";
        
    $ctr++;
  }//end $resultVars while
  
  $displayresults .= "</table></form>";
  
  return $displayresults;

}

function PMMedicalList()
{
  require('DBConnect2010.inc');

   $PMquery = "SELECT child_lastname, child_firstname, child_grade, child_classassignment, child_medicalproblems 
               FROM tst_child_info 
               WHERE child_session = 2 AND (child_medicalproblems != '' AND child_medicalproblems != 'none' AND child_medicalproblems != 'n/a' AND child_medicalproblems != 'na') 
               ORDER BY child_classassignment, child_lastname, child_firstname";
              
  $rs = mysqli_query($conn, $PMquery);
  mysqli_close($conn);

  $classes = translate('tst_class_translate', 'class_id', 'class_description');
  $grades = translate('tst_grade_translate', 'grade_id', 'grade_description');

  $displayresults  = "<B>" . mysqli_num_rows($rs) . " children with medicalproblems in the PM session.</B><BR><BR>";
  $displayresults .= "<table border='01' cellpadding='2'>";
  //$displayresults .= "<tr>
  //                        <th>Child Name</th>
  //                        <th>Grade</th>
  //                        <th>Class Assignment</th>
  //                        <th>medicalproblems</th>
  //              			</tr>";
  $displayresults .= "<tr>
                          <th>Child Name</th>
                          <th>Class Assignment</th>
                          <th>Medical Problems</th>
                			</tr>";
  $ctr = 0;
  while ($resultVars = mysqli_fetch_array($rs, MYSQL_ASSOC)) 
  {

    $displayresults .= "<tr>";
    $displayresults .= "<td>";
    //$displayresults .= "<a href='Modify_Child.php?id=" . $resultVars[child_id] . "'>";
	$displayresults .= $resultVars['child_lastname'] . ", " . $resultVars['child_firstname'];
    //$displayresults .= "</a></td>";
	$displayresults .= "</td>";
  //  $displayresults .= "<td>" . $grades[$resultVars[child_grade]] . "</td>";
    $displayresults .= "<td>" . $classes[$resultVars['child_classassignment']] . "</td>";
    $displayresults .= "<td>" . $resultVars['child_medicalproblems'] . "</td>";
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