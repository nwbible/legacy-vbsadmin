<html>
<head>
<title>
</title>
<style>
@import url(/templates/css/AdminTemplate_css.css);

td, th {
    padding       : 5px;
    text-align    : center;
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
include("DBConnect2010.inc");
include('Validation.inc');

error_reporting( error_reporting() & ~E_NOTICE );

/****************************************************************
*                           UPDATE FORM                         *
****************************************************************/
if(isset($_POST['Update']))  
{
// start a loop in order to update each record
  $i = 0;

  while ($i <= count($_POST['id']))
  {
    // define each variable
    $medical = $_POST['medical'][$i];
    $photo = $_POST['photo'][$i];
    $id = $_POST['id'][$i];

    if ($medical != 0 OR $photo != 0)
    {
      $query = "UPDATE tst_child_info SET ";
      if ($medical != 0)
      {
       $query .= "`child_medicalrelease` = $medical "; 
      } 
      if ($medical != 0 AND $photo != 0)
      {
        $query .= ", ";
      }
      if ($photo != 0)
      {
       $query .= "`child_photorelease` = $photo ";  
      }
      
      $query .= "WHERE `child_id` = '$id' LIMIT 1";

//debug($query);

      mysqli_query($conn, $query) or die ("Error in query: $query");
       
    }
    
    ++$i;
  }
 
  print count($_POST['medical']) . " medical release updates!<br />";
  print count($_POST['photo']) . " photo release updates!<br />";

  print "<form method='POST' action='ConsentFormSearch.php' name='ConsentSearch'>
  <table>
  <tr><th>Consent Form Search</th></tr>
  <tr><td>Limit search to <input type='textbox' name='limit'> number of children.</td></tr>
  <tr><td style='text-align:center'>Default = " . SEARCH_LIMIT . " children</td></tr>
  <tr><td style='text-align:center'><input type='submit' class='button' value='Search' name='SearchButton'></td></tr>
  </table>
  </form>";
  exit();

}  
/*******************************************************************
*                          END UPDATE FORM                         *
*******************************************************************/

/*******************************************************************
*                             Main Form                            *
*******************************************************************/
$displayform  = "";

$limit = (!empty($_POST['limit']) ? $_POST['limit'] : SEARCH_LIMIT);


//$query= "SELECT * FROM tst_child_info WHERE (`child_medicalrelease` = 0 OR `child_photorelease` = 0) ORDER BY child_session, child_lastname, child_firstname LIMIT " . $limit;
$query= "SELECT * FROM tst_child_info WHERE (`child_medicalrelease` = 0 OR `child_photorelease` = 0) ORDER BY child_session, child_lastname, child_firstname LIMIT " . $limit;
$rs=mysqli_query($conn, $query);

//Print remaining postcard mailers needed
$count = mysqli_query($conn, "SELECT COUNT(*) FROM tst_child_info WHERE (`child_medicalrelease` = 0 OR `child_photorelease` = 0)");
$mailcount = mysqli_fetch_row($count);
$displayform .= "<BR>There are " . $mailcount[0] . " children that still need consent forms returned.<BR>";


$displayform .= "<form method='POST' action='" . $_SERVER['PHP_SELF'] . "' name='mailer'>
	               <table border=1>
                 <tr>
                        <th>Name</th>
                				<th>Session</th>
	             					<th>Medical Consent</th>
	             					<th>Photo Consent</th>
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
$displayform .= "<td>" . $resultVars['child_firstname'];
$displayform .= " " . $resultVars['child_lastname'] . "</td>";
$displayform .= "<td>" . (1 == $resultVars['child_session'] ? 'AM' : 'PM') . "</td>";
$displayform .= "<td><SELECT name='medical[$ctr]'>";
$displayform .= "<OPTION value='0' ";
                    if($resultVars['child_medicalrelease'] == 0) 
                    {
                      $displayform .= "SELECTED ";
                    }
$displayform .= ">Not Turned In</OPTION>";
$displayform .= "<OPTION value='1' ";
                    if($resultVars['child_medicalrelease'] == 1) 
                    {
                      $displayform .= "SELECTED ";
                    }
$displayform .= ">No Consent</OPTION>";
$displayform .= "<OPTION value='2' ";
                    if($resultVars['child_medicalrelease'] == 2) 
                    {
                      $displayform .= "SELECTED ";
                    }
$displayform .= ">Consent</OPTION>";
$displayform .= "</SELECT></td>";

$displayform .= "<td><SELECT name='photo[$ctr]'>";
$displayform .= "<OPTION value='0' ";
                    if($resultVars['child_photorelease'] == 0) 
                    {
                      $displayform .= "SELECTED ";
                    }
$displayform .= ">Not Turned In</OPTION>";
$displayform .= "<OPTION value='1' ";
                    if($resultVars['child_photorelease'] == 1) 
                    {
                      $displayform .= "SELECTED ";
                    }
$displayform .= ">No Consent</OPTION>";
$displayform .= "<OPTION value='2' ";
                    if($resultVars['child_photorelease'] == 2) 
                    {
                      $displayform .= "SELECTED ";
                    }
$displayform .= ">Consent</OPTION>";
$displayform .= "</SELECT></td>";
$displayform .= "</tr>";

$ctr++;
}
  
$displayform .= "<tr><td colspan='8' align='center'><input type='submit' class='button' name='Update' value='Update'></td></table></form>";

mysqli_close($conn);

  print "<form method='POST' action='ConsentFormSearch.php' name='ConsentSearch'>
  <table>
  <tr><th>Consent Form Search</th></tr>
  <tr><td>Limit search to <input size='2' type='textbox' name='limit'> number of children.</td></tr>
  <tr><td style='text-align:center'>Default = " . SEARCH_LIMIT . " children</td></tr>
  <tr><td style='text-align:center'><input type='submit' class='button' value='Search' name='SearchButton'></td></tr>
  </table>
  </form>";

print $displayform;

?>
</body>
</html>