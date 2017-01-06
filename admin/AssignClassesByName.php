<html>
	<head>
		<title>
			Assign Classes By Name
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
require('DBConnect2010.inc');
include ('Validation.inc');

error_reporting( error_reporting() & ~E_NOTICE );
/********************************************************************************************
*                                    MAIN                                                   *
********************************************************************************************/


  
print createsearchform();
  
if (isset($_POST['namesearch'])) //A CHILD search BY NAME has been activated
{
  print namesearchresults();
}  
elseif(isset($_POST['UpdateClasses']))  //A CLASSES UPDATE has occurred
{
  $size = count($_POST['assignment']);

  // start a loop in order to update each record
  $i = 0;
  while ($i < $size) 
  {

  // define each variable
  $assignment = $_POST['assignment'][$i];
  $id = $_POST['id'][$i];
  $name = $_POST['childname'][$i];

    if($assignment != $_POST['currentclassid'][$i])
    {
      $query = "UPDATE tst_child_info SET `child_classassignment` = '$assignment' WHERE `child_id` = '$id' LIMIT 1";
      mysqli_query($conn, $query) or die ("Error in query: $query");
      print $name . " has been updated!<br />";
 
    }

  ++$i;
  }

  mysqli_close($conn);

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
  $displaysearch .= "<table border='01' cellpadding='2' width='25%'>";
  $displaysearch .= "<tr>";
  $displaysearch .= "<th>Last Name</th>";
  $displaysearch .= "</tr>";
  $displaysearch .= "<tr>";
  $displaysearch .= "<td align='center'><input type='text' name='lastname' size='25'></td>";
  $displaysearch .= "</tr>";
  $displaysearch .= "<tr>";
  $displaysearch .= "<td align='center'><input type='submit' class='button' name='namesearch' value='Search by Name'></td>";
  $displaysearch .= "</tr>";
  $displaysearch .= "<tr><td style='text-align:center'>";
  $displaysearch .= "<label class='error' style='text-align: left;'><input type='radio' name='assigned' value='0' CHECKED>All</label>";
  $displaysearch .= "<label class='error' style='text-align: left;'><input type='radio' name='assigned' value='1'>Assigned</label>";
  $displaysearch .= "<label class='error' style='text-align: left;'><input type='radio' name='assigned' value='2'>Unassigned</label>";
  $displaysearch .= "</tr>";
  $displaysearch .= "<tr><td style='text-align:center'>";
  $displaysearch .= "<label class='error' style='text-align: left;'><input type='radio' name='session' value='1'>AM</label>";
  $displaysearch .= "<label class='error' style='text-align: left;'><input type='radio' name='session' value='2'>PM</label>";
  $displaysearch .= "</td></tr></table></form>";
  
  return $displaysearch;
}

function namesearchresults()
{
	  $query = "SELECT child_id, child_session, child_lastname, child_firstname, child_grade, child_guardianname, child_placewith, child_classassignment  
            FROM `tst_child_info` 
            WHERE `child_lastname` 
            LIKE '" .
            $_POST['lastname'] . "%'
            ";
            
  if ($_POST['assigned'] == 1)
  {
      $query .= " AND child_classassignment != 0";
      $resulttext = "children with classes ASSIGNED ";
  }
  elseif ($_POST['assigned'] == 2)
  {
      $query .= " AND child_classassignment = 0";
      $resulttext = "children with classes UNASSIGNED ";
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
  require('DBConnect2010.inc');
  $query .= " ORDER BY child_lastname, child_firstname";
  $rs = mysqli_query($conn, $query);

  $classes = translate('tst_class_translate', 'class_id', 'class_description');
  $grades = translate('tst_grade_translate', 'grade_id', 'grade_description');
  
  $displayresults  = "<B>" . mysqli_num_rows($rs) . " " . $resulttext . "<B>";
  $displayresults .= "<form action='$_SERVER[PHP_SELF]' method='post' name='ChildModify'>";
  $displayresults .= "<table border='01' cellpadding='5'>
                      <tr>
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
    $displayresults .= "<tr>";
    $displayresults .= "<td>";
    $displayresults .= "<a href='Modify_Child.php?id=" . $resultVars['child_id'] . "'>";
    $displayresults .= $resultVars['child_lastname'] . ", " . $resultVars['child_firstname'];
    $displayresults .= "</a></td>";
    $displayresults .= "<td>" . $grades[$resultVars['child_grade']] . "</td>";
    $displayresults .= "<td>" . $resultVars['child_guardianname'] . "</td>";
    $displayresults .= "<td>" . $resultVars['child_placewith'] . "</td>";
    $displayresults .= "<td>" . $session . "</td>";
    $displayresults .= "<td><input type='text' readonly='readonly' value='" . $classes[$resultVars['child_classassignment']] . "' name='currentclass[$ctr]'></td>";
    $displayresults .= "<td><SELECT name='assignment[$ctr]'>";
    $displayresults .= "<OPTION value=''>Please Select a Class</OPTION>";
    $displayresults .= createDropDown('tst_class_translate', 'class_id', 'class_description', $whereclause, $resultVars['child_classassignment']);
    $displayresults .= "</SELECT></td>";
    $displayresults .= "</tr>";
        
    $ctr++;
  }//end $resultVars while
  
  $displayresults .= "<tr><td colspan='6' align='center'><input type='submit' class='button' name='UpdateClasses' value='Update Classes'></td>";  
  $displayresults .= "</table></form>";
  
  return $displayresults;
  
}

?>
</body>
</html>