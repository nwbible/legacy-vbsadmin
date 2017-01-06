<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>
			VBS Staff Panel
		</title>
<style type="text/css">
  @import url(/templates/css/AdminTemplate_css.css);
  @import url(/templates/css/AdminPrint_css.css) print;

.search {
   position: absolute;
   top: 250px;
   left: 50px;
}		

.search td {
	text-align: center;
}

.Results {
   position: absolute;
   top: 25px;
   left: 25px;
   
}		

.Registration {
   position: absolute;
   top: 25px;
   left: 0;
   border: thin;
      
}		

.ClassAssign {
   position: absolute;
   top: 25px;
   left: 500px;
   border: thin;
   
}		

.weekof {
   position: absolute;
   top: 250px;
   left: 500px;
   border: thin;

}		

</style>


<?php 
    include('Validation.inc');
    require('DBConnect2010.inc');
?>

</head>
<body>

<?php
/********************************************************************************************
*                                    MAIN                                                   *
********************************************************************************************/
if (isset($_POST['PrintRostersButton']))
{
	//Exceute Print Rosters
	print DailyRosters();
	
}
elseif (isset($_POST['PrintAllergyButtonAM']))
{
	//Exceute Print Rosters
	print DailyAllergyAM();
	
}
elseif (isset($_POST['PrintAllergyButtonPM']))
{
	//Exceute Print Rosters
	print DailyAllergyPM();
	
}
elseif (isset($_POST['DailyMedicalButtonAM']))
{
	//Exceute Print Rosters
	print DailyMedicalAM();
	
}
elseif (isset($_POST['DailyMedicalButtonPM']))
{
	//Exceute Print Rosters
	print DailyMedicalPM();
	
}
elseif (isset($_POST['PrintAddressesButton']))
{
	//Exceute Print Rosters
	print ClassAddress();
	
}
elseif (isset($_POST['PrintAlphaListButtonAM']))
{
	//Exceute Print Rosters
	print AlphaRosterAM();
	
}
elseif (isset($_POST['PrintAlphaListButtonPM']))
{
	//Exceute Print Rosters
	print AlphaRosterPM();
	
}
elseif (isset($_POST['PrintBigListButtonAM']))
{
	//Exceute Print Rosters
	print BigRosterListAM();
	
}
elseif (isset($_POST['PrintBigListButtonPM']))
{
	//Exceute Print Rosters
	print BigRosterListPM();
	
}
elseif (isset($_POST['childsearch'])) //A CHILD search has been activated
{
    print ChildSearch();
}  
else
{
    DisplayMenu();    
}




/********************************************************************************************
*                                    FUNCTIONS                                              *
********************************************************************************************/

function ChildSearch()
{
  require('DBConnect2010.inc');
      $query = "SELECT child_id, child_lastname, child_firstname, child_grade, child_guardianname    
            FROM tst_child_info
            WHERE child_lastname 
            LIKE '" . $_POST['lastname'] . "%' OR 
			child_firstname
			LIKE '" . $_POST['lastname'] . "%'";
  
  if ($_POST['assigned'] == 1)
  {
      $query .= " AND child_classassignment != 0";
      $resulttext = "children with classes ASSIGNED.";
  }
  elseif ($_POST['assigned'] == 2)
  {
      $query .= " AND child_classassignment = 0";
      $resulttext = "children with classes UNASSIGNED.";
  }
  else
  {
      $resulttext = "children found.";
  }

  $query .= " ORDER BY child_lastname ASC";

  $rs = mysqli_query($conn, $query);
  
  $displayresults  = "<div class='Results'>";
  $displayresults .= "<B>" . mysqli_num_rows($rs) . " " . $resulttext . "<B>";
  $displayresults .= "<form action='$_SERVER[PHP_SELF]' method='post' name='ChildModify'>";
  $displayresults .= "<table border='01' cellpadding='5'>
                      <tr>
                          <th>Child Name</th>
                          <th>Grade</th>
                          <th>Parent/Guardian</th>
                  			</tr>";

  $grades = translate('tst_grade_translate', 'grade_id', 'grade_description');
  
  while ($resultVars = mysqli_fetch_array($rs, MYSQLI_ASSOC)) 
  {

    $displayresults .= "<tr>";
    $displayresults .= "<td>";
    $displayresults .= "<a href='Modify_Child.php?id=" . $resultVars['child_id'] . "'>";
    $displayresults .= $resultVars['child_lastname'] . ", " . $resultVars['child_firstname'];
    $displayresults .= "</a></td>";
    $displayresults .= "<td>" . $grades[$resultVars['child_grade']] . "</td>";
    $displayresults .= "<td>" . $resultVars['child_guardianname'] . "</td>";
    $displayresults .= "</tr>";
        
  }//end $resultVars while
  
  $displayresults .= "</table></form></div>";
  
  return $displayresults;
}

function createsearchform()
{
  
  $displaysearch  ="<div class='search'>";
  $displaysearch .= "<form action='$_SERVER[PHP_SELF]' method='post' name='childsearch' target='_blank'>";
  $displaysearch .= "<table border='0' cellpadding='2' width='75%'>";
  $displaysearch .= "<tr><th><u>Modify Child Information</u></th></tr>";
  $displaysearch .= "<tr>";
  $displaysearch .= "<td>Name (First or Last)<input type='text' name='lastname' size='25'></td>";
  $displaysearch .= "</tr>";
  $displaysearch .= "<tr>";
  $displaysearch .= "<td>";
  $displaysearch .= "<label class='error' style='text-align: left;'><input type='radio' name='assigned' value='0' CHECKED />All</label>";
  $displaysearch .= "<label class='error' style='text-align: left;'><input type='radio' name='assigned' value='1' />Assigned</label>";
  $displaysearch .= "<label class='error' style='text-align: left;'><input type='radio' name='assigned' value='2' />Unassigned</label>";
  $displaysearch .= "</td>";
  $displaysearch .= "<tr>";
  $displaysearch .= "<td><input type='submit' class='button' name='childsearch' value='Search'></td>";
  $displaysearch .= "</tr></table></form></div>";
  
  return $displaysearch;
 
}

function DailyRosters()
{
  $classes = translate('tst_class_translate', 'class_id', 'class_description');

  $displayresults  = "";

  foreach($classes as $key => $value)
  {
require('DBConnect2010.inc');

  $query = "SELECT child_id, child_lastname, child_firstname, child_classassignment 
              FROM tst_child_info
              WHERE child_classassignment = " . $key  . "
              ORDER BY child_lastname, child_firstname";              
  $rs = mysqli_query($conn, $query);
  //print "<br>$query</br>";
  
  $displayresults .= "<table style='page-break-after: always;' border='01' cellpadding='2' width=400>";
  $displayresults .= "<caption>" . $value . "</caption>";
  $displayresults .= "<tr>
                          <th width=100%>Child Name</th>
					  </tr>";

  while ($resultVars = mysqli_fetch_array($rs, MYSQLI_ASSOC)) 
  {

    $displayresults .= "<tr>";
    $displayresults .= "<td width=100%>";
    $displayresults .= $resultVars['child_lastname'] . ", " . $resultVars['child_firstname'];
    $displayresults .= "</td>";
    $displayresults .= "</tr>";
        
  }//end $resultVars while
  $displayresults .= "</table>";
  $displayresults .= "<br /><br />";
  }//end foreach loop
  
  mysqli_close($conn);
  
  return $displayresults;

}

function DailyAllergyAM()
{
  $classes = translate('tst_class_translate', 'class_id', 'class_description', 'class_description', 'tst_class_session = \'AM\'');

  $displayresults  = "";

  foreach($classes as $key => $value)
  {
require('DBConnect2010.inc');

  $query = "SELECT child_lastname, child_firstname, child_classassignment, child_allergies, child_session 
            FROM tst_child_info 
            WHERE child_classassignment = " . $key . " AND (child_allergies != '' AND child_allergies != 'nka' AND child_allergies != 'nkda' AND child_allergies != 'none' AND child_allergies != 'n/a' AND child_allergies != 'na' AND child_allergies != 'no' AND child_allergies != 'No') 
            ORDER BY child_classassignment, child_lastname, child_firstname";
                            
  $rs = mysqli_query($conn, $query);
//  print "<br>$query</br>";
  
  $displayresults .= "<table style='page-break-after: always;' border='01' cellpadding='2' width=800>";
  $displayresults .= "<caption>" . $value . "</caption>";
  $displayresults .= "<tr>
                          <th width=25%>Child Name</th>
                          <th>Allergies</th>
					  </tr>";

  while ($resultVars = mysqli_fetch_array($rs, MYSQLI_ASSOC)) 
  {

    $displayresults .= "<tr>";
    $displayresults .= "<td width=25%>";
	$displayresults .= $resultVars['child_lastname'] . ", " . $resultVars['child_firstname'];
	$displayresults .= "</td>";
    $displayresults .= "<td>" . $resultVars['child_allergies'] . "</td>";
    $displayresults .= "</tr>";
        
  }//end $resultVars while
  $displayresults .= "</table>";
  $displayresults .= "<br /><br />";
  }//end foreach loop
  
  mysqli_close($conn);
  
  return $displayresults;

}

function DailyAllergyPM()
{
  $classes = translate('tst_class_translate', 'class_id', 'class_description', 'class_description', 'tst_class_session = \'PM\'');

  $displayresults  = "";

  foreach($classes as $key => $value)
  {
require('DBConnect2010.inc');

  $query = "SELECT child_lastname, child_firstname, child_classassignment, child_allergies, child_session 
            FROM tst_child_info 
            WHERE child_classassignment = " . $key . " AND (child_allergies != '' AND child_allergies != 'nka' AND child_allergies != 'nkda' AND child_allergies != 'none' AND child_allergies != 'n/a' AND child_allergies != 'na' AND child_allergies != 'no' AND child_allergies != 'No') 
            ORDER BY child_classassignment, child_lastname, child_firstname";
                            
  $rs = mysqli_query($conn, $query);
//  print "<br>$query</br>";
  
  $displayresults .= "<table style='page-break-after: always;' border='01' cellpadding='2' width=800>";
  $displayresults .= "<caption>" . $value . "</caption>";
  $displayresults .= "<tr>
                          <th width=25%>Child Name</th>
                          <th>Allergies</th>
					  </tr>";

  while ($resultVars = mysqli_fetch_array($rs, MYSQLI_ASSOC)) 
  {

    $displayresults .= "<tr>";
    $displayresults .= "<td width=25%>";
	$displayresults .= $resultVars['child_lastname'] . ", " . $resultVars['child_firstname'];
	$displayresults .= "</td>";
    $displayresults .= "<td>" . $resultVars['child_allergies'] . "</td>";
    $displayresults .= "</tr>";
        
  }//end $resultVars while
  $displayresults .= "</table>";
  $displayresults .= "<br /><br />";
  }//end foreach loop
  
  mysqli_close($conn);
  
  return $displayresults;

}

function DailyMedicalAM()
{
  $classes = translate('tst_class_translate', 'class_id', 'class_description', 'class_description', 'tst_class_session = \'AM\'');

  $displayresults  = "";

  foreach($classes as $key => $value)
  {
require('DBConnect2010.inc');

  $query = "SELECT child_lastname, child_firstname, child_classassignment, child_medicalproblems, child_medications, child_session 
            FROM tst_child_info 
            WHERE child_classassignment = " . $key . " AND (child_medicalproblems != '' AND child_medicalproblems != 'none' AND child_medicalproblems != 'n/a' AND child_medicalproblems != 'na') 
            ORDER BY child_classassignment, child_lastname, child_firstname";
                            
  $rs = mysqli_query($conn, $query);
//  print "<br>$query</br>";
  
  $displayresults .= "<table style='page-break-after: always;' border='01' cellpadding='2' width=800>";
  $displayresults .= "<caption>" . $value . "</caption>";
  $displayresults .= "<tr>
                          <th width=33%>Child Name</th>
                          <th width=33%>Medical Problems</th>
                          <th width=33%>Medications</th>
					  </tr>";

  while ($resultVars = mysqli_fetch_array($rs, MYSQLI_ASSOC)) 
  {

    $displayresults .= "<tr>";
    $displayresults .= "<td width=33%>";
	$displayresults .= $resultVars['child_lastname'] . ", " . $resultVars['child_firstname'];
	$displayresults .= "</td>";
    $displayresults .= "<td width=33%>" . $resultVars['child_medicalproblems'] . "</td>";
    $displayresults .= "<td width=33%>" . $resultVars['child_medications'] . "</td>";
    $displayresults .= "</tr>";
        
  }//end $resultVars while
  $displayresults .= "</table>";
  $displayresults .= "<br /><br />";
  }//end foreach loop
  
  mysqli_close($conn);
  
  return $displayresults;

}

function DailyMedicalPM()
{
  $classes = translate('tst_class_translate', 'class_id', 'class_description', 'class_description', 'tst_class_session = \'PM\'');

  $displayresults  = "";

  foreach($classes as $key => $value)
  {
require('DBConnect2010.inc');

  $query = "SELECT child_lastname, child_firstname, child_classassignment, child_medicalproblems, child_medications, child_session 
            FROM tst_child_info 
            WHERE child_classassignment = " . $key . " AND (child_medicalproblems != '' AND child_medicalproblems != 'none' AND child_medicalproblems != 'n/a' AND child_medicalproblems != 'na') 
            ORDER BY child_classassignment, child_lastname, child_firstname";
                            
  $rs = mysqli_query($conn, $query);
//  print "<br>$query</br>";
  
  $displayresults .= "<table style='page-break-after: always;' border='01' cellpadding='2' width=800>";
  $displayresults .= "<caption>" . $value . "</caption>";
  $displayresults .= "<tr>
                          <th width=33%>Child Name</th>
                          <th width=33%>Medical Problems</th>
                          <th width=33%>Medications</th>
					  </tr>";

  while ($resultVars = mysqli_fetch_array($rs, MYSQLI_ASSOC)) 
  {

    $displayresults .= "<tr>";
    $displayresults .= "<td width=33%>";
	$displayresults .= $resultVars['child_lastname'] . ", " . $resultVars['child_firstname'];
	$displayresults .= "</td>";
    $displayresults .= "<td width=33%>" . $resultVars['child_medicalproblems'] . "</td>";
    $displayresults .= "<td width=33%>" . $resultVars['child_medications'] . "</td>";
    $displayresults .= "</tr>";
        
  }//end $resultVars while
  $displayresults .= "</table>";
  $displayresults .= "<br /><br />";
  }//end foreach loop
  
  mysqli_close($conn);
  
  return $displayresults;

}


function ClassAddress()
{
  $classes = translate('tst_class_translate', 'class_id', 'class_description');

  $displayresults  = "";

  foreach($classes as $key => $value)
  {
require('DBConnect2010.inc');

  $query = "SELECT child_classassignment, child_lastname, child_firstname, child_address, child_city, child_state, child_zipcode  
              FROM tst_child_info
              WHERE child_classassignment = " . $key  . "
              ORDER BY child_lastname, child_firstname";              
  $rs = mysqli_query($conn, $query);
  //print "<br>$query</br>";
  $displayresults .= "<table style='page-break-after: always;' border='01' cellpadding='2' width=800>";
  $displayresults .= "<caption>" . $value . "</caption>";
  $displayresults .= "<tr>
                          <th>Child Name</th>
                          <th>Address</th>
						  <th>City</th>
						  <th>State</th>
						  <th>Zip</th>
                	  </tr>";

  while ($resultVars = mysqli_fetch_array($rs, MYSQLI_ASSOC)) 
  {

    $displayresults .= "<tr>";
    $displayresults .= "<td>";
	$displayresults .= $resultVars['child_lastname'] . ", " . $resultVars['child_firstname'];
	$displayresults .= "</td>";
	$displayresults .= "<td>" . $resultVars['child_address'] . "</td>";
	$displayresults .= "<td>" . $resultVars['child_city'] . "</td>";
	$displayresults .= "<td>" . $resultVars['child_state'] . "</td>";
	$displayresults .= "<td>" . $resultVars['child_zipcode'] . "</td>";
    $displayresults .= "</tr>";
        
  }//end $resultVars while
  $displayresults .= "</table>";
  $displayresults .= "<br /><br />";
  }//end foreach loop
  
  mysqli_close($conn);
  
  return $displayresults;

}

function AlphaRosterAM()
{
  $classes = translate('tst_class_translate', 'class_id', 'class_description');

  $query = "SELECT child_classassignment, child_session, child_lastname, child_firstname 
            FROM tst_child_info
			WHERE child_session = 1 
            ORDER BY child_lastname, child_firstname";

require('DBConnect2010.inc');
              
  $rs = mysqli_query($conn, $query);
//  print "<br>$query</br>";
  mysqli_close($conn);

  $displayresults = "";
  $displayresults .= "<table border='01' cellpadding='2' width=1024>";
  $displayresults .= "<caption style='font-size: 14px; text-align: center;'>AM Class Assignment List</caption>";
  $displayresults .= "<tr>
                          <th style='font-size: 14px'>Child Name</th>
                          <th style='font-size: 14px'>Class Assignment</th>
                      </tr>";

$ctr=1;
  while ($resultVars = mysqli_fetch_array($rs, MYSQLI_ASSOC)) 
  {

    //$displayresults .= (($ctr % 25 == 0) ? "<tr style='page-break-before: always;'>" : "<tr>");
    $displayresults .= "<tr><td style='font-size: 14px'>";
	$displayresults .= $resultVars['child_lastname'] . ", " . $resultVars['child_firstname'];
	$displayresults .= "</td>";
    $displayresults .= "<td style='font-size: 14px'>" . $classes[$resultVars['child_classassignment']] . "</td>";
$ctr++;
    $displayresults .= "</tr>";  
  }//end $resultVars while
  
  $displayresults .= "</table>";
  
  return $displayresults;

}

function AlphaRosterPM()
{
  $classes = translate('tst_class_translate', 'class_id', 'class_description');

  $query = "SELECT child_classassignment, child_session, child_lastname, child_firstname 
            FROM tst_child_info
			WHERE child_session = 2 
            ORDER BY child_lastname, child_firstname";

require('DBConnect2010.inc');
              
  $rs = mysqli_query($conn, $query);
//  print "<br>$query</br>";
  mysqli_close($conn);

  $displayresults = "";
  $displayresults .= "<table border='01' cellpadding='2' width=1024>";
  $displayresults .= "<caption style='font-size: 28px; text-align: center;'>PM Class Assignment List</caption>";
  $displayresults .= "<tr>
                          <th style='font-size: 28px'>Child Name</th>
                          <th style='font-size: 28px'>Class Assignment</th>
                      </tr>";

$ctr=1;
  while ($resultVars = mysqli_fetch_array($rs, MYSQLI_ASSOC)) 
  {

    //$displayresults .= (($ctr % 25 == 0) ? "<tr style='page-break-before: always;'>" : "<tr>");
    $displayresults .= "<tr><td style='font-size: 14px'>";
	$displayresults .= $resultVars['child_lastname'] . ", " . $resultVars['child_firstname'];
	$displayresults .= "</td>";
    $displayresults .= "<td style='font-size: 14px'>" . $classes[$resultVars['child_classassignment']] . "</td>";
$ctr++;
    $displayresults .= "</tr>";  
  }//end $resultVars while
  
  $displayresults .= "</table>";
  
  return $displayresults;
}

function BigRosterListAM()
{
  $classes = translate('tst_class_translate', 'class_id', 'class_description');

  $query = "SELECT child_classassignment, child_session, child_lastname, child_firstname 
            FROM tst_child_info
			WHERE child_session = 1 
            ORDER BY child_lastname, child_firstname";

require('DBConnect2010.inc');
              
  $rs = mysqli_query($conn, $query);
//  print "<br>$query</br>";
  mysqli_close($conn);

  $displayresults = "";
  $displayresults .= "<table border='01' cellpadding='2' width=1024>";
  $displayresults .= "<caption style='font-size: 28px; text-align: center;'>AM Class Assignment List</caption>";
  $displayresults .= "<tr>
                          <th style='font-size: 28px'>Child Name</th>
                          <th style='font-size: 28px'>Class Assignment</th>
                      </tr>";

$ctr=1;
  while ($resultVars = mysqli_fetch_array($rs, MYSQLI_ASSOC)) 
  {

    //$displayresults .= (($ctr % 25 == 0) ? "<tr style='page-break-before: always;'>" : "<tr>");
    $displayresults .= "<td style='font-size: 42px'>";
	$displayresults .= $resultVars['child_lastname'] . ", " . $resultVars['child_firstname'];
	$displayresults .= "</td>";
    $displayresults .= "<td style='font-size: 42px'>" . $classes[$resultVars['child_classassignment']] . "</td>";
$ctr++;
    $displayresults .= "</tr>";
    $displayresults .= "<tr><td style='font-size: 42px'>&nbsp;</td><td style='font-size: 42px'>&nbsp;</td></tr>";  
  }//end $resultVars while
  
  $displayresults .= "</table>";
  
  return $displayresults;

}

function BigRosterListPM()
{
  $classes = translate('tst_class_translate', 'class_id', 'class_description');

  $query = "SELECT child_classassignment, child_session, child_lastname, child_firstname 
            FROM tst_child_info
			WHERE child_session = 2 
            ORDER BY child_lastname, child_firstname";

require('DBConnect2010.inc');
              
  $rs = mysqli_query($conn, $query);
//  print "<br>$query</br>";
  mysqli_close($conn);

  $displayresults = "";
  $displayresults .= "<table border='01' cellpadding='2' width=1024>";
  $displayresults .= "<caption style='font-size: 28px; text-align: center;'>PM Class Assignment List</caption>";
  $displayresults .= "<tr>
                          <th style='font-size: 28px'>Child Name</th>
                          <th style='font-size: 28px'>Class Assignment</th>
                      </tr>";

$ctr=1;
  while ($resultVars = mysqli_fetch_array($rs, MYSQLI_ASSOC)) 
  {

    //$displayresults .= (($ctr % 25 == 0) ? "<tr style='page-break-before: always;'>" : "<tr>");
    $displayresults .= "<td style='font-size: 42px'>";
	$displayresults .= $resultVars['child_lastname'] . ", " . $resultVars['child_firstname'];
	$displayresults .= "</td>";
    $displayresults .= "<td style='font-size: 42px'>" . $classes[$resultVars['child_classassignment']] . "</td>";
$ctr++;
    $displayresults .= "</tr>";
    $displayresults .= "<tr><td style='font-size: 42px'>&nbsp;</td><td style='font-size: 42px'>&nbsp;</td></tr>";  
  }//end $resultVars while
  
  $displayresults .= "</table>";
  
  return $displayresults;

}

function DisplayMenu()
{
print "
<div id='intro'>
	This is the STAFF control page with links to all other components available to the admin.
</div>

<div class='Registration'>
	<table border='0'>
    <tr>
	    <th>Registration</th>
    </tr>
    <tr>
      <td align='center' valign='center' width='50%'>
        <form method='POST' action='Register_Child_Internal.php' name='RegisterChild' target='_blank'>
        <input type='submit' class='button' value='Register Child' name='RegisterChildButton' />
        </form>
        <form method='POST' action='Child_Mailer_Search.php' name='MailerSearch' target='_blank'>
        <label class='error'><input type='submit' class='button' value='Postcards NOT Sent' name='SearchButton' />IS THE ABOVE STILL NEEDED?</label>
        </form>
        <form method='POST' action='ConsentFormSearch.php' name='ConsentSearch' target='_blank'>
        <input type='submit' class='button' value='Consent Form Update' name='SearchButton' />
        </form>
        <form method='POST' action='the_numbers.php' name='EnrolNumbers' target='_blank'>
        <input type='submit' class='button' value='VBS Statistics' name='SearchButton' target='_blank' />
        </form>
      </td>
    </tr>
    <tr>
        <td>
" . 
createsearchform() 
. "
        </td>
    </tr>
    </table>
</div>
<div class='ClassAssign'>
    <table border='0'>
    <tr>
	    <th>Classroom Assignments</th>
	</tr>
    <tr>
        <td valign='top' align='center' width='50%'>
        <form method='POST' action='Rosters.php' name='Rosters' target='_blank'>
        <input type='submit' class='button' value='Rosters' name='RostersButton' />
        </form>
        <form method='POST' action='AssignClassesByName.php' name='NameAssign' target='_blank'>
        <input type='submit' class='button' value='Assign Classes By Name' name='NameAssignButton' />
        </form>
        <form method='POST' action='AssignClassesByGrade.php' name='GradeAssign' target='_blank'>
        <input type='submit' class='button' value='Assign Classes By Grade' name='GradeAssignButton' />
        </form>
        <form method='POST' action='Decisions_Made.php' name='Decisions' target='_blank'>
        <input type='submit' class='button' value='Decisions Made Listing' name='DecisionsButton' />
        </form>
<!--        <form method='POST' action='Email.php' name='ClassAssignmentEmail' target='_blank'>
        <input type='submit' class='button' value='Send Class Assignment Email' name='SendClassAssignEmailButton' />
        </form>
-->        
      </td>
 	</tr>
    <tr>
        <td>
            <table border=1>
            <tr>
                <th align='center'>Emails Sent</th>
                <th align='center'>Emails Not Sent</th>
                <th>No Address</th>
                <th>Total</th>
            </tr>
            <tr>
                <td align='center'> " . EmailsSent() . "</td>
                <td align='center'>" . EmailsNotSent() . "</td>
                <td align='center'>" . EmailsUnable() . "</td>
                <td align='center'>" . TotalNumber() . "</td>             
            </tr>
            </table>
        </td>
    </tr>
	</table>
</div>

<div class='weekof'>
    <table border='0'>
    <tr>
	    <th align='center'>Week of VBS Tasks</th>
	</tr>
    <tr>
    <td valign='top' align='center' width='50%'>
		<form method='POST' action='" . $_SERVER['PHP_SELF'] . "' name='PrintRosters' target='_blank'>
        <input type='submit' class='button' value='Print Rosters' name='PrintRostersButton' />
        </form>
        <form method='POST' action='DatatoExcel.php' name='ExportRosters' target='_blank'>
        <input type='submit' class='button' value='Export Rosters' name='ExportRostersButton' />
        </form>
        <form method='POST' action='" . $_SERVER['PHP_SELF'] . "' name='PrintAddresses' target='_blank'>
        <input type='submit' class='button' value='Print Address Lists' name='PrintAddressesButton' />
        </form>
    </td>
    </tr>
    <tr>
        <th align='center'>AM</th><th align='center'>PM</th>
    </tr>
    <tr>
        <td valign='top' align='center' width='50%'>
        <form method='POST' action='" . $_SERVER['PHP_SELF'] . "' name='PrintAllergyAM' target='_blank'>
        <input type='submit' class='button' value='Print AM Allergy Lists' name='PrintAllergyButtonAM' />
        </form>
        <form method='POST' action='" . $_SERVER['PHP_SELF'] . "' name='PrintMedicalAM' target='_blank'>
        <input type='submit' class='button' value='Print AM Medical Issues Lists' name='DailyMedicalButtonAM' />
        </form>
        <form method='POST' action='" . $_SERVER['PHP_SELF'] . "' name='PrintAlphaListAM' target='_blank'>
        <input type='submit' class='button' value='Print Alpha AM Class Lists' name='PrintAlphaListButtonAM' />
        </form>
        <form method='POST' action='" . $_SERVER['PHP_SELF'] . "' name='PrintBigListAM' target='_blank'>
        <input type='submit' class='button' value='Print BIG AM Class Lists' name='PrintBigListButtonAM' />
        </form>
      </td>
      <td>
        <form method='POST' action='" . $_SERVER['PHP_SELF'] . "' name='PrintAllergyPM' target='_blank'>
        <input type='submit' class='button' value='Print PM Allergy Lists' name='PrintAllergyButtonPM' />
        </form>
        <form method='POST' action='" . $_SERVER['PHP_SELF'] . "' name='PrintMedicalPM' target='_blank'>
        <input type='submit' class='button' value='Print PM Medical Issues Lists' name='DailyMedicalButtonPM' />
        </form>
		<form method='POST' action='" . $_SERVER['PHP_SELF'] . "' name='PrintAlphaListPM' target='_blank'>
        <input type='submit' class='button' value='Print Alpha PM Class Lists' name='PrintAlphaListButtonPM' />
        </form>
		<form method='POST' action='" . $_SERVER['PHP_SELF'] . "' name='PrintBigListPM' target='_blank'>
        <input type='submit' class='button' value='Print BIG PM Class Lists' name='PrintBigListButtonPM' />
        </form>            
      </td>
 	</tr>
	</table>
</div>";
    
}

function EmailsSent()
{
    require('DBConnect2010.inc');
    $query = "SELECT child_id FROM tst_child_info WHERE child_mailersent = 1";
    $rs = mysqli_query($conn, $query);
    $num_rows = mysqli_num_rows($rs);
    return $num_rows;
    
}

function EmailsNotSent()
{
    require('DBConnect2010.inc');
    $query = "SELECT child_id FROM tst_child_info WHERE child_mailersent = 0";
    $rs = mysqli_query($conn, $query);
    $num_rows = mysqli_num_rows($rs);
    return $num_rows;
    
}

function EmailsUnable()
{
    require('DBConnect2010.inc');
    $query = "SELECT child_id FROM tst_child_info WHERE child_mailersent = 2";
    $rs = mysqli_query($conn, $query);
    $num_rows = mysqli_num_rows($rs);
    return $num_rows;
    
}

function TotalNumber()
{
    require('DBConnect2010.inc');
    $query= "select child_id from tst_child_info";
    $rs = mysqli_query($conn, $query);
    return mysqli_num_rows($rs);

}
?>
</body>
</html>