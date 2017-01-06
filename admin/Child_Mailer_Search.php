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

<SCRIPT LANGUAGE="JavaScript">
<!-- Begin
function Checkall(form){ 
  for (var i = 1; i < form.elements.length; i++){    
    eval("form.elements[" + i + "].checked = form.elements[0].checked");  
  } 
} 

// End -->
</script>

</head>
<body>

<?php
include("DBConnect2010.inc");
include('Validation.inc');

error_reporting( error_reporting() & ~E_NOTICE );

if(isset($_POST['Update']))  
{
// start a loop in order to update each record
  $i = 0;

  while ($i <= count($_POST['id']))
  {
    // define each variable
    $sent = $_POST['mailer'][$i];
    $id = $_POST['id'][$i];


    if ($sent == 'on')
    {
    $query = "UPDATE tst_child_info SET `child_mailersent` = 1 WHERE `child_id` = '$id' LIMIT 1";
    mysqli_query($conn, $query) or die ("Error in query: $query"); 
    }
    
    ++$i;
  }
 
  print count($_POST['mailer']) . " updates!<br />";

  print "<form method='POST' action='Child_Mailer_Search.php' name='MailerSearch'>
  <table>
  <tr><th>Mailers NOT Sent Search</th></tr>
  <tr><td>Limit search to <input type='textbox' name='limit'> number of children.</td></tr>
  <tr><td style='text-align:center'>Default = " . SEARCH_LIMIT . " children</td></tr>
  <tr><td style='text-align:center'><input type='submit' class='button' value='Search' name='SearchButton'></td></tr>
  </table>
  </form>";
  exit();

}  

$displayform  = "";

$limit = (!empty($_POST['limit']) ? $_POST['limit'] : SEARCH_LIMIT);


$query= "SELECT * FROM tst_child_info WHERE child_mailersent = 0 ORDER BY child_session, child_lastname, child_firstname LIMIT " . $limit;

$rs=mysqli_query($conn, $query);

//Print remaining postcard mailers needed
$count = mysqli_query($conn, "SELECT COUNT(*) FROM tst_child_info WHERE `child_mailersent` = 0");
$mailcount = mysqli_fetch_row($count);
$displayform .= "<BR>There are " . $mailcount[0] . " children that still need postcards mailed.<BR>";


$displayform .= "<form method='POST' action='" . $_SERVER['PHP_SELF'] . "' name='mailer'>
	               <table border=1>
                 <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Zip</th>
                				<th>Session</th>
	             					<th>Mailer Sent<BR>
                        Check All<BR>
                        <input type='checkbox' name='Check_ctr' value='yes'
                               onClick='Checkall(mailer)'>
                        </th>
						    </tr>";


$ctr = 0;
while ($resultVars = mysqli_fetch_array($rs, MYSQLI_ASSOC))
{
  if ($ctr % 2 == 0)
    {$rowcolor=alt1;}
  else 
    {$rowcolor=alt2;}

$displayform .= "<input type='hidden' name='id[$ctr]' value='$resultVars[child_id]'>";
$displayform .= "<tr class='$rowcolor'>";
$displayform .= "<td>" . $resultVars['child_firstname'];
$displayform .= " " . $resultVars['child_lastname'] . "</td>";
$displayform .= "<td>" . $resultVars['child_address'] . "</td>";
$displayform .= "<td>" . $resultVars['child_city'] . "</td>";
$displayform .= "<td>" . strtoupper($resultVars['child_state']) . "</td>";
$displayform .= "<td>" . $resultVars['child_zipcode'] . "</td>";
$displayform .= "<td>" . (1 == $resultVars['child_session'] ? AM : PM) . "</td>";
$displayform .= "<td><input type='checkbox' name='mailer[$ctr]'></td>";
$displayform .= "</tr>";

$ctr++;
}
  
$displayform .= "<tr><td colspan='8' align='center'><input type='submit' class='button' name='Update' value='Update'></td></table></form>";

mysqli_close($conn);

  print "<form method='POST' action='Child_Mailer_Search.php' name='MailerSearch'>
  <table>
  <tr><th>Mailers NOT Sent Search</th></tr>
  <tr><td>Limit search to <input size='2' type='textbox' name='limit'> number of children.</td></tr>
  <tr><td style='text-align:center'>Default = " . SEARCH_LIMIT . " children</td></tr>
  <tr><td style='text-align:center'><input type='submit' class='button' value='Search' name='SearchButton'></td></tr>
  </table>
  </form>";

print $displayform;

?>
</body>
</html>