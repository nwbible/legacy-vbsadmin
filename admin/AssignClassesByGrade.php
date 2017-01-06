<html>
	<head>
		<title>
			Assign Classes By Grade
		</title>
		<style type="text/css">
    @import url(/templates/css/AdminTemplate_css.css);
		th {font-family: "Arial"; font-size:8pt; font-weight:bold; text-align: center;}
		td {font-family: "Arial"; font-size:8pt; font-weight:normal;}
		</style>
	</head>
<body>

<?php
//This page takes the information from the Child Search form 
//and looks for a child by that last name 
include ('Validation.inc');

error_reporting( error_reporting() & ~E_NOTICE );


/********************************************************************************************
*                                    MAIN                                                   *
********************************************************************************************/
 
print createsearchform();
  
if (isset($_POST['gradesearch'])) //A Child search Grade Level has been activated
{
  print gradesearchresults();
}  
elseif(isset($_POST['UpdateClasses']))  //A CLASSES UPDATE has occurred
{
  print updateresults();
}
elseif (isset($_POST['massassign'])) //Mass assign children to one class
{
  print massassignresults();
}
  
  print $displayresults;
  
/********************************************************************************************
*                                  END MAIN                                                   *
********************************************************************************************/

/********************************************************************************************
*                                    FUNCTIONS                                              *
********************************************************************************************/



function createsearchform()
{
  $displaysearch  ="";
  $displaysearch .= "<form action='$_SERVER[PHP_SELF]' method='post' name='childsearch'>";
  $displaysearch .= "<table border='0' cellpadding='2' width='100%'>";
  $displaysearch .= "<tr>";
  $displaysearch .= "<th>Grade Completed</th>";
  $displaysearch .= "</tr>";
  $displaysearch .= "<tr>";
  $displaysearch .= "<td align='center' cellpadding='5'><SELECT size='1' name='grade'>";
  $displaysearch .= createDropDown('tst_grade_translate','grade_id','grade_description','', $_POST['grade']);
  $displaysearch .= "</SELECT>";
  $displaysearch .= "<input type='submit' class='button' name='gradesearch' value='Search by Grade'></td>";
  $displaysearch .= "</tr>";
  $displaysearch .= "<tr><td style='text-align:center'>";
  $displaysearch .= "<label class='error' style='text-align: left;'><input type='radio' name='assigned' value='0' CHECKED>All</label>";
  $displaysearch .= "<label class='error' style='text-align: left;'><input type='radio' name='assigned' value='1'>Assigned</label>";
  $displaysearch .= "<label class='error' style='text-align: left;'><input type='radio' name='assigned' value='2'>Unassigned</label>";
  $displaysearch .= "</tr>";
  $displaysearch .= "<tr><td style='text-align:center'>";
  $displaysearch .= "<label class='error' style='text-align: left;'><input type='radio' name='session' value='1' ";
  $displaysearch .= ">AM</label>";
  $displaysearch .= "<label class='error' style='text-align: left;'><input type='radio' name='session' value='2'";
  $displaysearch .= ">PM</label>";
  $displaysearch .= "</td></tr></table></form>";
  
  return $displaysearch;
}


function gradesearchresults()
{
    $query = "SELECT child_id, child_session, child_lastname, child_firstname, child_grade, child_guardianname, child_placewith, child_classassignment  
            FROM `tst_child_info`";
		if ($_POST['grade'] != '')
		{
			$query .= "WHERE `child_grade` = '" . $_POST['grade'] . "'";
		}
    else
    {
        $query .= "WHERE `child_grade` != ''";
    } 
            

  if ($_POST['assigned'] == 1)
  {
      $query .= " AND child_classassignment != 0";
      $resulttext = "children with classes <u>ASSIGNED</u> ";
  }
  elseif ($_POST['assigned'] == 2)
  {
      $query .= " AND child_classassignment = 0";
      $resulttext = "children with classes <u>UNASSIGNED</u> ";
  }
  else
  {
      $resulttext = "children found ";
  }
  
  switch($_POST['session'])
  {
    case 1:
      $query .= " AND child_session = 1";
      $resulttext .= "attending the AM session.";
      break;
      
    case 2:
      $query .= " AND child_session = 2";
      $resulttext .= "attending the PM session.";
      break;
    
    default:
      $query .= "";
      $resulttext .= "attending either the AM or PM session.";
      
  }

  $query .= " ORDER BY child_session, child_classassignment, child_lastname, child_firstname";

  require('DBConnect2010.inc');
  $rs = mysqli_query($conn, $query);
  mysqli_close($conn);
  
  $classes = translate('tst_class_translate', 'class_id', 'class_description');
  $grades = translate('tst_grade_translate', 'grade_id', 'grade_description');

  $displayresults  = "<B>" . mysqli_num_rows($rs) . " " . $resulttext . "<B><BR><BR>";
  $displayresults .= "<u>Hints</u><BR>";
  $displayresults .= "1)  To Assign children to individual classes use the drop-downs on the far right and press the Assign Individuals button at the bottom of the list.<BR><BR>";
  $displayresults .= "2)  To Assign children to ONE class select a class using the 'Select a class' drop-down below.  Place a check mark next to each child to be added to the selected class.  Press the Assign Group to Class button.<BR><BR>";
  $displayresults .= "<form action='$_SERVER[PHP_SELF]' method='post' name='ChildModify'>";
  $displayresults .= "<table border='01' cellpadding='2'>";
  $displayresults .= "<td colspan='3'><SELECT name='assigntoclass[$ctr]'>";
  $displayresults .= "<OPTION value=''>Please Select a Class</OPTION>";
  $displayresults .= createDropDown('tst_class_translate', 'class_id', 'class_description');
  $displayresults .= "</SELECT></td>";
  $displayresults .= "<td colspan='3' align='left'><input type='submit' class='button' name='massassign' value='Assign Group to Class'></td>";
  $displayresults .= "<td colspan='2' align='right'><input type='submit' class='button' name='UpdateClasses' value='Assign Individuals'></td>";  
  $displayresults .= "</tr><tr>
                          <th>Assign<BR>
                              to<BR>
                              Class</th>
                          <th>Child Name</th>
                          <th>Grade</th>
                          <th>Parent/Guardian</th>
                          <th>Place With</th>
                          <th>Session</th>
                          <th>Current Class Assignment</th>
                          <th>New Class Assignment</th>
                			</tr>";
  $ctr = 0;
  while ($resultVars = mysqli_fetch_array($rs, MYSQLI_ASSOC)) 
  {

	$session = (1 == $resultVars['child_session'] ? 'AM' : 'PM');
	$whereclause = "`class_description` LIKE '$session%'";

    $displayresults .= "<input type='hidden' name='childname[$ctr]' value='" . $resultVars['child_lastname'] . ", " . $resultVars['child_firstname'] . "'>";    
    $displayresults .= "<input type='hidden' name='id[$ctr]' value='$resultVars[child_id]'>";
    $displayresults .= "<input type='hidden' name='currentclassid[$ctr]' value='$resultVars[child_classassignment]'>";
    $displayresults .= "<input type='hidden' name='grade' value='$_POST[grade]'>";
    $displayresults .= "<tr>";
    $displayresults .= "<td align='center'><input type='checkbox' name='assign[$ctr]'></td>";
    $displayresults .= "<td>";
    $displayresults .= "<a href='Modify_Child.php?id=" . $resultVars['child_id'] . "'>";
    $displayresults .= $resultVars['child_lastname'] . ", " . $resultVars['child_firstname'];
    $displayresults .= "</a></td>";
    $displayresults .= "<td>" . $grades[$resultVars['child_grade']] . "</td>";
    $displayresults .= "<td>" . $resultVars['child_guardianname'] . "</td>";
    $displayresults .= "<td>" . $resultVars['child_placewith'] . "</td>";
    $displayresults .= "<td>" . $session . "</td>";
    $displayresults .= "<td>" . $classes[$resultVars['child_classassignment']] . "</td>";
    $displayresults .= "<td><SELECT name='assignment[$ctr]'>";
    $displayresults .= "<OPTION value='0'>Unassigned</OPTION>";
    $displayresults .= createDropDown('tst_class_translate', 'class_id', 'class_description', $whereclause, $resultVars['child_classassignment']);
    $displayresults .= "</SELECT></td>";
    $displayresults .= "</tr>";
        
    $ctr++;
  }//end $resultVars while
  
  $displayresults .= "<tr><td colspan='8' align='right'><input type='submit' class='button' name='UpdateClasses' value='Assign Individuals'></td></tr>";  
  $displayresults .= "</table></form>";
  
  return $displayresults;
}

function updateresults()
{
  $classes = translate('tst_class_translate', 'class_id', 'class_description');
  $displayresult = "";
  $size = count($_POST['id']);
  // start a loop in order to update each record
  $i = 0;

  require('DBConnect2010.inc');
  while ($i < $size) 
  {

  // define each variable
  $newassignment = $_POST['assignment'][$i];
  $currentassignment = $_POST['currentclassid'][$i];
  $id = $_POST['id'][$i];
  $name = $_POST['childname'][$i];

    if($newassignment != $currentassignment)
    {
      $query = "UPDATE tst_child_info SET `child_classassignment` = '$newassignment' WHERE `child_id` = '$id' LIMIT 1";
      
      mysqli_query($conn, $query) or die ("Error in query: $query");
      if($newassignment != 0){
        $displayresults .= $name . " has been assigned to " . $classes[$newassignment] . "!<br />"; 
      }
      else {
        $displayresults .= $name . " has been unassigned!<br />"; 
      }
    }

  ++$i;
  }
  mysqli_close($conn);
  
  return $displayresults;
}

function massassignresults()
{
  $classes = translate('tst_class_translate', 'class_id', 'class_description');
  $massresult = "";
  $size = count($_POST['id']);
  // start a loop in order to update each record
  $i = 0;

  $newassignment = $_POST['assigntoclass'][0];
  $newclass = $classes[$newassignment];

  require('DBConnect2010.inc');
  while ($i < $size) 
  {

  // define each variable
  $checked = $_POST[assign][$i];
//  $currentassignment = $_POST['currentclassid'][$i];
  $id = $_POST['id'][$i];
  $name = $_POST['childname'][$i];

    if($checked == 'on')
    {
      $query = "UPDATE tst_child_info SET `child_classassignment` = '$newassignment' WHERE `child_id` = '$id' LIMIT 1";

      mysqli_query($conn, $query) or die ("Error in query: $query");
      if($newassignment != 0){
        $massresults .= $name . " has been assigned to " . $newclass . "!<br />"; 
      }
      else {
        $massresults .= $name . " has been unassigned!<br />"; 
      }
    }

  ++$i;
  }
  mysqli_close($conn);
  
  return $massresults;
  
}
?>
</body>
</html>