<?php

include ('Validation.inc');

//DEFINITIONS
$classes = translate('tst_class_translate', 'class_id', 'class_description');
$test=$success=$failure=$nomail=0;

$debug="FALSE";
//FALSE=Live...Send messages
//TRUE=Truly debugging...No messages sent.  Information is only printed to screen: $to, $subject, $body, $headers
//TEST=Send out 3 messages to Test recipients only

require('DBConnect2010.inc');

$query = "SELECT child_id, child_lastname, child_firstname, child_classassignment, child_guardianname, child_guardianemail FROM tst_child_info WHERE child_mailersent = 0 ORDER BY child_id";

$rs = mysql_query($query);

while ($resultVars = mysql_fetch_array($rs, MYSQL_ASSOC)){

    //Send Email
    if (!empty($resultVars[child_guardianemail])){
	        if ($debug === "TEST"){
				$to = "Test Name <test@test.com>";
                $subject = "TEST - Church VBS 2016 - TEST";
                $test=$test+1;
            }
            else{
                $to = "$resultVars[child_guardianname] <$resultVars[child_guardianemail]>";
                $subject = "Church VBS 2016";
            }

            $body  = "Hey " . $resultVars[child_firstname] . " " . $resultVars[child_lastname] . ",<br><br>";
            $body .= "We are looking forward to seeing you at <i><strong>INSERT VBS NAME HERE</strong></i> on Monday! You have been assigned to the:<br><br>";
            $body .= "<strong>" . $classes[$resultVars[child_classassignment]] . " Class</strong><br><br>";
            $body .= "When you arrive on Monday, go straight to the gym and find the table with your group name on it to get signed in. ";
            $body .= "<br><br>Unfortunately, our AM session is full.  We are not able to accept any new or walk-in registrations. ";
			$body .= "<br><br>For more information, including snack information regarding allergies, check out our <a href='http://www.CHURCHWEBSITE.org/post/vbs-faqs'>VBS FAQ page.</a>";
            $body .= "<br><br>See you Monday,<br><br>";
            $body .= "-The VBS Crew";

// To send HTML mail, the Content-type header must be set
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: VBS at Church <vbs@CHURCHNAME.org>' . "\r\n" . 'Reply-To: no-reply@CHURCHNAME.org' . "\r\n" . 'X-Mailer: PHP/' . phpversion();

            if ($debug === "TRUE"){
                print "Message #: " . $test . "<br><br>";
                print "TO: " . $to . "<br><br>";
                print "Subject: " . $subject . "<br><br>";
                print "Body: " . $body . "<br><br>";
                print "Headers: " . $headers . "<br><br>";
            }
            else{
                $message  = mail($to, $subject, $body, $headers);
            }

            if ($message == 1)
            {
                print "<br>Message sent to " . $resultVars[child_guardianname] . " - " . $resultVars[child_guardianemail] . " at " . date('h:i:s') . ".<br>";

                //Update database to show e-mail sent
                $query = "UPDATE tst_child_info SET `child_mailersent` = 1 WHERE `child_id` = '$resultVars[child_id]' LIMIT 1";
                mysql_query($query) or die ("Error in query: $query");

                $success = $success + 1;
            }
            else
            {
                print "Message could NOT be sent to " . $resultVars[child_guardianname] . " - " . $resultVars[child_guardianemail] . " at " . date('h:i:s') . ".<br>";
                $failure = $failure + 1;
            }

            sleep(75);
    }
    else
    {
        print "There is no e-mail for " . $resultVars[child_guardianname] . " - " . $resultVars[child_guardianemail] . " at " . date('h:i:s') . ".<br>";
        $query = "UPDATE tst_child_info SET `child_mailersent` = 2 WHERE `child_id` = '$resultVars[child_id]' LIMIT 1";
        mysql_query($query) or die ("Error in query: $query");
        $nomail++;

    }

print "<br><br>******************************************************<br>";
print "***DEBUG: " . $debug . "     |     Test: " . $test . "***<br>";
print "*************************************************************<br><br>";
//If test email, the next line will exit after sending 3 test messages to debug addresses
    if($debug !== "FALSE" && $test > 3){
        mysql_close();
        print "Exiting...";
        exit();
    }

}

mysql_close();

print $success . " messages sent.<br>";
print $failure . " messages NOT sent.<br>";
print $nomail . " messages COULD NOT be sent.<br>";

?>