<html>
<head>
<title>
</title>
<style>
@import url(/templates/css/AdminTemplate_css.css);

tr, td, th {
    padding       : 5px;
    text-align    : center;
    font-size     : 12;
}

tr.alt1 td {
	background-color: #8ed3ff;
  color: black; 
  font-size:12;
}
tr.alt2 td {
	background-color: gray; 
  color: #8ed3ff; 
  font-size:12;
}

</style>

</head>
<body>

<?php
include('Validation.inc');

  
  $displayoptions = "";
  $displayoptions .= "<table border='0' align='center' width='100%'><tr>";
  $displayoptions .= "<td align='center'><form action='Decisions_Made.php' method='post' name='AlphaOptions'>";
  $displayoptions .= "<input type='submit' class='button' name='AlphaOption' value='Alphabetical Listing'></form></td>";
  $displayoptions .= "<td align='center'><form action='Decisions_Made.php' method='post' name='GradeOptions'>";
  $displayoptions .= "<input type='submit' class='button' name='GradeOption' value='Grade Level Listing'></form></td>";
  $displayoptions .= "<td align='center'><form action='Decisions_Made.php' method='post' name='ReportOptions'>";
  $displayoptions .= "<input type='submit' class='button' name='ReportOption' value='Decisions Made Report'></form></td>";
  $displayoptions .= "</tr></table>";
  
  print $displayoptions;


if(isset($_POST['Update']))  {
  
  include("DBConnect2010.inc");

  // start a loop in order to update each record
  $i = 0;

  while ($i <= count($_POST['id']))
  {
    // define each variable
    $decisionmade = $_POST['decision'][$i];
    $id = $_POST['id'][$i];


    if ($decisionmade == 'on')
    {
    $query = "UPDATE tst_child_info SET `child_decisionmade` = 1 WHERE `child_id` = '$id' LIMIT 1";
    mysqli_query($conn, $query) or die ("Error in query: $query"); 
    }
    
    ++$i;
  }
 
  print count($_POST['decision']) . " updates!<br />";

  mysqli_close($conn);
  exit();

}  

if (isset($_POST['AlphaOption']))
{
  print displayform('child_session, child_lastname, child_firstname');  
}

if (isset($_POST['GradeOption']))
{
  print displayform('child_session, child_grade, child_classassignment, child_lastname, child_firstname');  
}

if (isset($_POST['ReportOption']))
{
  print displayreport();
}


function displayform($ORDERBY) 
{

$classes = translate('tst_class_translate', 'class_id', 'class_description');
$grade = translate('tst_grade_translate', 'grade_id', 'grade_description');
$displayform  = "";
$limit = (!empty($_POST['limit']) ? $_POST['limit'] : COMMITMENT_LIMIT);

include("DBConnect2010.inc");
$query= "SELECT * FROM tst_child_info ORDER BY " . $ORDERBY . " LIMIT " . $limit;
$rs=mysqli_query($conn, $query);

//Print # of decisions made
$count = mysqli_query($conn, "SELECT COUNT(*) FROM tst_child_info WHERE `child_decisionmade` = 1");
$decisioncount = mysqli_fetch_row($count);

$displayform .= "<BR>There were  " . $decisioncount[0] . " children that made a decision this week!<BR>";


$displayform .= "<form method='POST' action='" . $_SERVER['PHP_SELF'] . "' name='Decision'>
	               <table border=1>
                 <tr>
                        <th>Name</th>
                				<th>Session</th>
                				<th>Grade</th>
                				<th>Class</th>
	             					<th>Decision Made</th>
						    </tr>";

$ctr = 0;
while ($resultVars = mysqli_fetch_array($rs, MYSQLI_ASSOC))
{
  if ($ctr % 2 == 0)
    {$rowcolor='alt1';}
  else 
    {$rowcolor='alt2';}

$displayform .= "<input type='hidden' name='id[$ctr]' value='$resultVars[child_id]'>";
$displayform .= "<tr class='$rowcolor'>";
$displayform .= "<td>" . $resultVars['child_lastname'];
$displayform .= ", " . $resultVars['child_firstname'] . "</td>";
$displayform .= "<td>" . (1 == $resultVars['child_session'] ? 'AM' : 'PM') . "</td>";
$displayform .= "<td>" . $grade[$resultVars['child_grade']] . "</td>";
$displayform .= "<td>" . $classes[$resultVars['child_classassignment']] . "</td>";
$displayform .= "<td><input type='checkbox' name='decision[$ctr]'";
$displayform .= (1 == $resultVars['child_decisionmade'] ? "CHECKED" : "") . "></td>";
$displayform .= "</tr>";

$ctr++;
}
  
$displayform .= "<tr><td colspan='8' align='center'><input type='submit' class='button' name='Update' value='Update'></td></table></form>";

print "<form method='POST' action='Decisions_Made.php' name='Decisions'>";
if (isset($_POST['AlphaOption']))
{
  print "<input type='hidden' name='AlphaOption' value='Alphabetical Listing'>";
}
elseif (isset($_POST['GradeOption']))
{
  print "<input type='hidden' name='GradeOption' value='Grade Level Listing'>";
}

print "<table>
        <tr><th>Update Decisions Made</th></tr>
        <tr><td>Limit search to <input size='2' type='textbox' name='limit'> number of children.</td></tr>
        <tr><td style='text-align:center'>Default = " . COMMITMENT_LIMIT . " children</td></tr>
        <tr><td style='text-align:center'><input type='submit' class='button' value='Search' name='SearchButton'></td></tr>
      </table>
      </form>";

mysqli_close($conn);
return $displayform;

}

function displayreport() 
{

$displayform  = "";


include("DBConnect2010.inc");
$query= "SELECT * FROM tst_child_info WHERE `child_decisionmade` = 1 ORDER BY child_session, child_lastname, child_firstname";

$rs=mysqli_query($conn, $query);

//Print # of decisions made
$count = mysqli_query($conn, "SELECT COUNT(*) FROM tst_child_info WHERE `child_decisionmade` = 1");
$decisioncount = mysqli_fetch_row($count);

$displayform .= "<BR>There were  " . $decisioncount[0] . " children that made a decision this week!<BR>";


$displayform .= "<form method='POST' action='" . $_SERVER['PHP_SELF'] . "' name='Decision'>
	               <table border=1>
                 <tr>
                        <th>Name</th>
                				<th>Address</th>
                				<th>City</th>
                				<th>State</th>
	             					<th>Zipcode</th>
						    </tr>";

$ctr = 0;
while ($resultVars = mysqli_fetch_array($rs, MYSQLI_ASSOC))
{

$displayform .= "<input type='hidden' name='id[$ctr]' value='$resultVars[child_id]'>";
$displayform .= "<tr>";
$displayform .= "<td>" . $resultVars['child_lastname'];
$displayform .= ", " . $resultVars['child_firstname'] . "</td>";
$displayform .= "<td>" . $resultVars['child_address'] . "</td>";
$displayform .= "<td>" . $resultVars['child_city'] . "</td>";
$displayform .= "<td>" . $resultVars['child_state'] . "</td>";
$displayform .= "<td>" . $resultVars['child_zipcode'] . "</td>";
$displayform .= "</tr>";

$ctr++;
}
  
$displayform .= "</table></form>";


mysqli_close($conn);
return $displayform;

}
?>
</body>
</html>