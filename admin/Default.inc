<?php


function passPostArray($array) 
{
  foreach ($_POST as $key => $val) {
    $return .= '<input type="hidden" name="' . $key . 
      '" value="' . htmlentities($val, ENT_QUOTES) . '" />' . "\r\n";
  }
  
  return $return;
  
}

function printPost($array)
{
	foreach ($_POST as $key => $val) {
		echo $key . " = " . htmlentities($val, ENT_QUOTES) . "<br>";
	}
}

function createbanner($errors, $status) {
  
  $displaybanner  = "";	
  $displaybanner .= "
	<table width=75% align='center' border='0'cellpadding='0' cellspacing='0'>
		<tr>
			<!-- td colspan=3 align='center'><img src=\"/templates/images/vbs-graphic-header.gif\"></td -->
            <td colspan=3 align='center'></td>
  		</tr>
	    <tr>
			<td align='center'>";
	$displaybanner .= (($status[1] == "inprogress")? "<img src='/templates/images/button-step1-active.gif' width='220' height='62' />" : "<img src='/templates/images/button-step1-passive.gif' width='220' height='62' />");
	$displaybanner .= "</td><td align='center'>";
	$displaybanner .= (($status[2] == "inprogress")? "<img src='/templates/images/button-step2-active.gif' width='220' height='62' />" : "<img src='/templates/images/button-step2-passive.gif' width='220' height='62' />");
	$displaybanner .= "</td><td align='center'	>";
	$displaybanner .= (($status[3] == "inprogress")? "<img src='/templates/images/button-step3-active.gif' width='220' height='62' />" : "<img src='/templates/images/button-step3-passive.gif' width='220' height='62' />");
	$displaybanner .= "</td>";
	$displaybanner .= "</tr>
<!--
  		<tr>
			<td class='$status[1]'><img src='/templates/images/button-step1-active.gif' width='220' height='62' /></td>
			<td class='$status[2]'><img src='/templates/images/button-step1-active.gif' width='220' height='62' /></td>
			<td class='$status[3]'><img src='/templates/images/button-step1-active.gif' width='220' height='62' /></td>
-->
	</table>
";
  if (!empty($errors))
  {
        $displaybanner .= "<div class='error'>Oops. Looks like you missed something.</div>
							<div class='error' style='font-size:14px;'>Please check your form to ensure everything is filled out correctly.</div>";
    }
  
	return $displaybanner;
	
}

function mymail($to, $subject, $body)
{ 

include ('Mail.php');

$from = "VBS Registration <vbs@churchname.org>";
$host = "localhost";
$username = "vbsuser";
$password = "vbsuser";

$headers = array ('From' => $from,
'To' => $to,
'Subject' => $subject);
$smtp = Mail::factory('smtp',
array ('host' => $host,
//'auth' => false,
'auth' => true,
'username' => $username,
'password' => $password));

$mail = $smtp->send($to, $headers, $body);

if (PEAR::isError($mail)) {
$message = "<p class='error'>" . $mail->getMessage() . "</p>";
} else {
$message = "<p class='error'>An confirmation e-mail has been successfully sent to the address you supplied!</p>";
}

return $message;
} 

?>