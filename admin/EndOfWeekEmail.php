<?php

include ('Validation.inc');

//DEFINITIONS
$classes = translate('tst_class_translate', 'class_id', 'class_description');
$success=$failure=$nomail=0;

require('DBConnect2010.inc');

$query = "SELECT child_id, child_lastname, child_firstname, child_classassignment, child_guardianname, child_guardianemail FROM tst_child_info WHERE child_mailersent = 0";

$rs = mysql_query($query);

/*
//These next lines enable a single e-mail to be sent as a test.  Also, the TO line needs commented out inside the while loop and the $test increment needs uncommented
$test=0;
$resultVars = mysql_fetch_array($rs, MYSQL_ASSOC);
$to = "TEST NAME <TEST@gmail.com>";
while ($test<1){
*/
while ($resultVars = mysql_fetch_array($rs, MYSQL_ASSOC)) {

    //Send Email
    if (!empty($resultVars[child_guardianemail]))	
    { 
	        $to = "$resultVars[child_guardianname] <$resultVars[child_guardianemail]>";
			$subject = "Church VBS 2012 Closing Program";	
        
            $body = "
                <br>
                <img src='http://vbs.CHURCH.org/kapop_16x9.jpg' />
                <h1>Huzzah!</h1>
                A great week needs a great ending. The Closing Program brings everyone together to celebrate and learn what God has been doing all week. The program will take place on Sunday morning, June 17, during both worship services. The children will come into the church service for the first 20-25 minutes where they will perform some of the songs from the week, watch a wrap-up video, and hear our final missions count. The children will then go to the gym to hear a special Christian kids concert from a group called Ka*POP!
                    <br>
                    <ul>
                    	<li>Families whose last names end in A-L are asked to attend the 9am service, if possible. Please arrive promptly by 8:45am so you don't miss it!</li>
                    	<br>
                    	<li>Families whose last names end in M-Z are asked to attend the 10:45am service. Please arrive at 10:30am. Feel free to come to either service, however, as your schedule dictates.</li>
                    </ul>
                    <br>We will meet in the gym to line up. Please wear your VBS T-shirt if you have one. Parents are asked to pick up their children at the end of each service in the gym.
                    <br>
                    <br>This will be a big, exciting time for the children, so we're looking forward to seeing you on Sunday morning!
                <br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-The VBS Crew
            ";
            
// To send HTML mail, the Content-type header must be set
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: VBS at CHURCH <vbs@CHURCHNAME.org>' . "\r\n" . 'Reply-To: no-reply@CHURCHNAME.org' . "\r\n" . 'X-Mailer: PHP/' . phpversion();


            $message  = mail($to, $subject, $body, $headers);

            if ($message = 1)
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
            
            usleep(5000000);    
    }
    else
    {
        print "There is no e-mail for " . $resultVars[child_guardianname] . " - " . $resultVars[child_guardianemail] . " at " . date('h:i:s') . ".<br>";
        $query = "UPDATE tst_child_info SET `child_mailersent` = 2 WHERE `child_id` = '$resultVars[child_id]' LIMIT 1";
        mysql_query($query) or die ("Error in query: $query");
        $nomail++;
        
    }  

//Uncomment next line to enable a single test message to be sent
//$test = $test+1;

}

mysql_close();

print $success . " messages sent.<br>";
print $failure . " messages NOT sent.<br>";
print $nomail . " messages COULD NOT be sent.<br>";

?>