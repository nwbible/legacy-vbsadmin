<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<HTML>
<HEAD>
<TITLE>VBS Child Registration Form - Modify</TITLE>

<style type="text/css">
@import url(/templates/css/AdminTemplate_css.css);

th {
    color: #659ed0;
    font-size: 12pt;
    font-weight: inherit;
    
}
</style>

<?php
error_reporting( error_reporting() & ~E_NOTICE );
/******************************************************
*                  INCLUDES                           *
******************************************************/
include ('Validation.inc');
include ('Default.inc');
require_once('DBConnect2010.inc');

/******************************************************
*                  FUNCTIONS                          *
******************************************************/
function createform($vars, $errs)
{

    //Function creates a form for child registration
  $displayform  = "";
  $displayform .= createbanner($errs, $completed);              
  $displayform .= "<div class='wrapper'>";
  $displayform .= "<FORM name='Register' action='$_SERVER[PHP_SELF]' method='post'>";
  $displayform .= "<INPUT type='hidden' name='child_id' value='$vars[child_id]'>";
  $displayform .= "<div class='dropdownbar'>";
  $displayform .= "<label>Class</label>";
  $displayform .= "<SELECT name='child_classassignment'>";
  $displayform .= "<OPTION value='0'>Please Select a Class</OPTION>";
  $displayform .= createDropDown(tst_class_translate, class_id, class_description, '', $vars['child_classassignment']);
  $displayform .= "</SELECT>";
  $displayform .= "<label>Medical Release Form</label>";
  $displayform .= "<SELECT name='child_medicalrelease'>";
  $displayform .= "<OPTION value='0' ";
                    if($vars['child_medicalrelease'] == 0) 
                    {
                      $displayform .= "SELECTED ";
                    }
  $displayform .= ">Not Turned In</OPTION>";
  $displayform .= "<OPTION value='1' ";
                    if($vars['child_medicalrelease'] == 1) 
                    {
                      $displayform .= "SELECTED ";
                    }
  $displayform .= ">No Consent</OPTION>";
  $displayform .= "<OPTION value='2' ";
                    if($vars['child_medicalrelease'] == 2) 
                    {
                      $displayform .= "SELECTED ";
                    }
  $displayform .= ">Consent</OPTION>";
  $displayform .= "</SELECT>";
    
  $displayform .= "<label>Photo Release Form</label>";
  $displayform .= "<SELECT name='child_photorelease'>";
  $displayform .= "<OPTION value='0' ";
                    if($vars['child_photorelease'] == 0) 
                    {
                      $displayform .= "SELECTED ";
                    }
  $displayform .= ">Not Turned In</OPTION>";
  $displayform .= "<OPTION value='1' ";
                    if($vars['child_photorelease'] == 1) 
                    {
                      $displayform .= "SELECTED ";
                    }
  $displayform .= ">No Consent</OPTION>";
  $displayform .= "<OPTION value='2' ";
                    if($vars['child_photorelease'] == 2) 
                    {
                      $displayform .= "SELECTED ";
                    }
  $displayform .= ">Consent</OPTION>";
  $displayform .= "</SELECT></div>";
  $displayform .= "<div class='child_wrapper'><fieldset>";
  $displayform .= "<legend>Please Enter Child Information</legend>";
  $displayform .= "<ol>";

//**********************BEGIN CHILD INFORMATION SECTION***********************************-->

  switch($vars['child_session'])
  {
   case NULL:
   $displayform .= "
                <li><fieldset class='radio'><legend class='radio'>Session</legend>
                                <label class='radio'><INPUT class='radio' type='radio' value= '1' name='child_session' />9:15 AM</label>
                                <label class='radio'><INPUT class='radio' type='radio' value='2' name='child_session' />6:15 PM</label>
                               ";
         $displayform .= fieldError('child_session', $errs);
         $displayform .= "</fieldset></li>";     
   break;
   
   case 1:
   $displayform .= "
                <li><fieldset class='radio'><legend class='radio'>Session</legend>
                                <label class='radio'><INPUT class='radio' type='radio' value= '1' name='child_session' CHECKED />9:15 AM</label>
                                <label class='radio'><INPUT class='radio' type='radio' value='2' name='child_session' />6:15 PM</label>
                                   ";
         $displayform .= fieldError('child_session', $errs);
         $displayform .=  "</fieldset></li>";    
   break;
   
   case 2:
   $displayform .= "
                <li><fieldset class='radio'><legend class='radio'>Session</legend>
                                <label class='radio'><INPUT class='radio' type='radio' value= '1' name='child_session' />9:15 AM</label>
                                <label class='radio'><INPUT class='radio' type='radio' value='2' name='child_session' CHECKED />6:15 PM</label>
                                ";
         $displayform .= fieldError('child_session', $errs);
         $displayform .= "</fieldset></li>";     
   break;

   default:
   $displayform .= "
                <li><fieldset class='radio'><legend class='radio'>Session</legend>
                                <label class='radio'><INPUT class='radio' type='radio' value= '1' name='child_session' />9:15 AM</label>
                                <label class='radio'><INPUT class='radio' type='radio' value='2' name='child_session' />6:15 PM</label>
                                ";
   $displayform .= fieldError('child_session', $errs);
   $displayform .= "</fieldset></li>";   
  }

  $displayform .= "
                <li><label>First Name</label><INPUT maxlength='25' size='50' name='child_firstname' value='$vars[child_firstname]' />";
                          
  $displayform .= fieldError('child_firstname', $errs);
  $displayform .= "</li>";
  
  $displayform .= "<li><label>Last Name</label><INPUT maxlength='25' size='50' name='child_lastname' value='$vars[child_lastname]' />";
                        
  $displayform .= fieldError('child_lastname', $errs) . "</li>";

  switch($vars['child_gender'])
  {
   case NULL:
   $displayform .= "
                <li><fieldset class='radio'><legend class='radio'>Gender</legend>
                        <label class='radio'><INPUT class='radio' type='radio' value='1' name='child_gender' />Male</label>
                        <label class='radio'><INPUT class='radio' type='radio' value='0' name='child_gender' />Female</label>";
   $displayform .= fieldError('child_gender', $errs);
   $displayform .= "</fieldset></li>";   
   break;
   
   case 0:
   $displayform .= "
                <li><fieldset class='radio'><legend class='radio'>Gender</legend>
                        <label class='radio'><INPUT class='radio' type='radio' value='1' name='child_gender' />Male</label>
                        <label class='radio'><INPUT class='radio' type='radio' value='0' name='child_gender' CHECKED />Female</label>";
   $displayform .= fieldError('child_gender', $errs);
   $displayform .= "</fieldset></li>";   
   break;
   
   case 1:
   $displayform .= "
                <li><fieldset class='radio'><legend class='radio'>Gender</legend>
                        <label class='radio'><INPUT class='radio' type='radio' value='1' name='child_gender' CHECKED />Male</label>
                        <label class='radio'><INPUT class='radio' type='radio' value='0' name='child_gender' />Female</label>";
   $displayform .= fieldError('child_gender', $errs);
   $displayform .= "</fieldset></li>";   
   break;

   default:
   $displayform .= "
                <li><fieldset class='radio'><legend class='radio'>Gender</legend>
                        <label class='radio'><INPUT class='radio' type='radio' value='1' name='child_gender' />Male</label>
                        <label class='radio'><INPUT class='radio' type='radio' value='0' name='child_gender' />Female</label>";
   $displayform .= fieldError('child_gender', $errs);
   $displayform .= "</fieldset></li>";   

  }


  $displayform .= 
    "
                        <li><label>Birthday (mm/dd/yyyy)</label>
                                <INPUT name='child_birthday' value='$vars[child_birthday]' />
<!--                            <button type='reset' id='trigger'>...</button>
                   <script type='text/javascript'>
                    Calendar.setup(
                    {
                      inputField  : \"child_birthday\",         // ID of the input field
                      ifFormat    : \"%m/%d/%Y\",    // the date format
                      button      : \"trigger\",       // ID of the button
                      showsTime   : false,
                      step        : 1,
                      weekNumbers : false
                    }
                    );
                    </script>
-->     ";
        $displayform .= fieldError('child_birthday', $errs);
        $displayform .= "</li>";
        
    $displayform .= "
                        <li><label>Grade Completed</label>
                          <SELECT size='1' name='child_grade'>";
/*                      <OPTION value='14'";
                    if($vars[child_grade] == 14) 
                    {
                      $displayform .= " SELECTED ";
                    }
  $displayform .= ">Nursery - 1 yr</OPTION>";
*/
  $displayform .= "
                                <OPTION value='' 
                                  ";
                    if($vars['child_grade'] == '') 
                    {
                      $displayform .= "SELECTED ";
                    }
  $displayform .= ">Please select a grade level</OPTION>
                                <OPTION value='16' ";
                    if($vars['child_grade'] == 16) 
                    {
                      $displayform .= "SELECTED ";
                    } 
  $displayform .= ">4 Year Olds</OPTION>
                                <OPTION value='17' ";
                    if($vars['child_grade'] == 17) 
                    {
                      $displayform .= "SELECTED ";
                    }
  $displayform .= ">5 Year Olds</OPTION>
                                <OPTION value='13' "; 
                    if($vars['child_grade'] == 13)
                    {
                      $displayform .= "SELECTED ";
                    }
  $displayform .= ">Kindergarten</OPTION>
                                <OPTION value='1' ";
                   if($vars['child_grade'] == 1)
                    {
                      $displayform .= "SELECTED ";
                    }
  $displayform .= ">1st</OPTION>
                                <OPTION value='2' ";
                    if($vars['child_grade'] == 2)
                    {
                      $displayform .= "SELECTED ";
                    }
  $displayform .= ">2nd</OPTION>
                                <OPTION value='3' ";
                    if($vars['child_grade'] == 3) 
                    { 
                      $displayform .= "SELECTED ";
                    }
  $displayform .= ">3rd</OPTION>
                                <OPTION value='4' ";
                    if($vars['child_grade'] == 4) 
                    {
                      $displayform .= "SELECTED ";
                    }
  $displayform .= ">4th</OPTION>
                                <OPTION value='5' ";
                    if($vars['child_grade'] == 5) 
                    { 
                      $displayform .= "SELECTED ";
                    }
  $displayform .= ">5th</OPTION>
                                <OPTION value='6' ";
                    if($vars['child_grade'] == 6) 
                    {
                      $displayform .= "SELECTED ";
                    }
  $displayform .= ">6th</OPTION>
                                </SELECT>";
  $displayform .= fieldError('child_grade', $errs);
  $displayform .= "</li>";
  
  $displayform .= "

                        <li><label>Address</label><INPUT maxlength='50' size='50' name='child_address' value='$vars[child_address]' /></li>";
                                
        $displayform .= fieldError('child_address', $errs);
        $displayform .= 
                "       

                        <li><label>City</label><INPUT maxlength='15' size='50' name='child_city' value='$vars[child_city]' /></li>";
                        
        $displayform .= fieldError('child_city', $errs);
        $displayform .= "
        
                        <li><label>State</label><INPUT maxlength='2' size='50' name='child_state' value='" . strtoupper($vars['child_state']) . "' /></li>";
                        
        $displayform .= fieldError('child_state', $errs);
        $displayform .= "
        
                        <li><label>Zip</label><INPUT maxlength='5' size='50' name='child_zipcode' value='$vars[child_zipcode]' />";
                        
        $displayform .= fieldError('child_zipcode', $errs) . "</li></ol>";

        $displayform .= "</fieldset></div>";
//*********************END CHILD INFORMATION SECTION****************************************
        
        
        
//**********************BEGIN PARENT/GUARDIAN INFORMATION SECTION*************************
        $displayform .= "<div class='child_wrapper'><fieldset><legend>Please enter Parent/Guardian Information</legend>";
        $displayform .= "<ol>";
        $displayform .= "<li><label>Parent/Guardian</label><INPUT maxlength='50' size='50' name='child_guardianname' value='$vars[child_guardianname]' />";

        $displayform .= fieldError('child_guardianname', $errs) . "</li>";      
        $displayform .= fieldError('contact', $errs);
        $displayform .= "<li><label>Home Phone</label><INPUT maxlength='15' size='50' name='child_guardianhomephone' value='$vars[child_guardianhomephone]' />";

        $displayform .= fieldError('child_guardianhomephone', $errs) . "</li>";
        
        $displayform .= "<li><label>Work Phone</label><INPUT maxlength='15' size='50' name='child_guardianworkphone' value='$vars[child_guardianworkphone]' />";

        $displayform .= fieldError('child_guardianworkphone', $errs) . "</li>";
        
        $displayform .= "<li><label>Cell Phone</label><INPUT maxlength='15' size='50' name='child_guardiancellphone' value='$vars[child_guardiancellphone]' />";

        $displayform .= fieldError('child_guardiancellphone', $errs) . "</li>";
        
        
        $displayform .= "<li><label>Email</label><INPUT maxlength='75' size='50' name='child_guardianemail' value='$vars[child_guardianemail]' />";
        
        $displayform .= fieldError('child_guardianemail', $errs) . "</li>";
        
        $displayform .= "<li><label>Other Emergency Contact Person</label><INPUT maxlength='50' size='50' name='child_contactname' value='$vars[child_contactname]' /></li>";
        
        $displayform .= "<li><label>Relationship</label><INPUT maxlength='15' size='50' name='child_contactrelation' value='$vars[child_contactrelation]' /></li>";
        
        $displayform .= "<li><label>Phone</label><INPUT maxlength='100' size='100' name='child_contactphone' value='$vars[child_contactphone]' />";
        
        $displayform .= fieldError('child_contactphone', $errs) . "</li>";

        $displayform .= "</ol></fieldset></div>";               
        //***********************END PARENT/GUARDIAN INFORMATION TABLE***********************
        
        
        
        //**********************BEGIN PLACEMENT/CHURCH INFORMATION TABLE*************************
        $displayform .= "<div class='child_wrapper'><fieldset><legend>Please enter church and placement information</legend>";
    $displayform .= "<ol><li><label>Please place my child with</label><INPUT maxlength='50' size='50' name='child_placewith' value='$vars[child_placewith]' /></li>";
    
        $displayform .= "<li><fieldset class='radio'><legend class='radio'>Do you attend Northwest Bible Church?</legend>";

  switch($vars['child_attendNWB'])
  {
        case NULL:
        $displayform .= 
"
                                <label class='radio'><INPUT class='radio' type='radio' value='1' name='child_attendNWB' CHECKED />Yes</label>
                                <label class='radio'><INPUT class='radio' type='radio' value='0' name='child_attendNWB' />No</label>
";
        $displayform .= fieldError('child_attendNWB', $errs) . "</fieldset></li>";   
        break;
   
        case 0:
        $displayform .= 
"
                                <label class='radio'><INPUT class='radio' type='radio' value='1' name='child_attendNWB' />Yes</label>
                                <label class='radio'><INPUT class='radio' type='radio' value='0' name='child_attendNWB' CHECKED />No</label>
";
        $displayform .= fieldError('child_attendNWB', $errs) . "</fieldset></li>";       
        break;
   
        case 1:
        $displayform .=  
"
                                <label class='radio'><INPUT class='radio' type='radio' value='1' name='child_attendNWB' CHECKED />Yes</label>
                                <label class='radio'><INPUT class='radio' type='radio' value='0' name='child_attendNWB' />No</label>
";
        $displayform .= fieldError('child_attendNWB', $errs) . "</fieldset></li>";       
        break;

        default:
        $displayform .= 
"
                                <label class='radio'><INPUT class='radio' type='radio' value='1' name='child_attendNWB' CHECKED />Yes</label>
                                <label class='radio'><INPUT class='radio' type='radio' value='0' name='child_attendNWB' />No</label>
";
   $displayform .= fieldError('child_attendNWB', $errs) . "</fieldset></li>";
      
  }

        
        $displayform .= "<li><label>Name of home church</label><INPUT maxlength='25' size='50' name='child_churchattending' value='$vars[child_churchattending]' /></li>";
        
        $displayform .= "<li><label>Coming as a guest of</label><INPUT maxlength='50' size='50' name='child_guestof' value='$vars[child_guestof]' /></li>";
        $displayform .= "</ol></fieldset></div>";
                
  //**********************END PLACEMENT/CHURCH INFORMATION TABLE******************************

  //**********************BEGIN ALLERGY/MEDICAL INFORMATION**************************** 
  $displayform .= "<div class='child_wrapper'><fieldset><legend>Please enter Allergy/Medical Information</legend><ol>";
  $displayform .= "<li><label style=\"vertical-align: top;\">Allergies:</label><TEXTAREA name='child_allergies' rows='6' cols='38' >" . $vars['child_allergies'] . "</TEXTAREA></li>";
  $displayform .= "<li><label style=\"vertical-align: top;\">Medical Problems:</label><TEXTAREA name='child_medicalproblems' rows='6' cols='38'>" . $vars['child_medicalproblems'] . "</TEXTAREA></li>";
  $displayform .= "<li><label style=\"vertical-align: top;\">Medications:</label><TEXTAREA name='child_medications' rows='6' cols='38'>" . $vars['child_medications'] . "</TEXTAREA></li>";
  $displayform .= "</ol></fieldset></div>";
        
  //**********************END ALLERGY/MEDICAL INFORMATION****************************   

        $displayform .= "<div class='child_wrapper'><fieldset class='submit'>";
        $displayform .= "<INPUT class='submit' type='submit' value='Submit Information' name='Verify' />";
        $displayform .= "</fieldset></div>";
		
        $displayform .= "<div class='child_wrapper'><fieldset class='submit'>";
        $displayform .= "<INPUT class='submit' type='submit' value='Delete Child - DO NOT PRESS THIS UNLESS YOU ARE DOUBLE SURE YOU WANT TO PERMANENTLY DELETE THIS CHILD' name='Delete' />";
        $displayform .= "</fieldset></div>";

        $displayform .= "</FORM></div>";

    
    return $displayform;
}   


/**************************************************************
*                  END OF HEADER                              *
**************************************************************/
?>

</HEAD>
<BODY>

<?php
/**************************************************************
*                  BEGIN BODY                                 *
**************************************************************/

//Parse Child Info into $formVars()
if (!isset($_POST['Verify']) && !isset($_POST['Delete']))//First look at this page
{
  $query = "SELECT * 
          FROM `tst_child_info` 
          WHERE `child_id` =" . $_GET['id'];
  
  $rs = mysqli_query($conn, $query);

  $formVars = mysqli_fetch_array($rs, MYSQLI_ASSOC);

//Reformat Date of Birth so that it looks normal MM/DD/YYYY
  $parts = explode('-', $formVars['child_birthday']);
  //ereg("^([0-9]{4})-([0-9]{2})-([0-9]{2})$",$formVars['child_birthday'], $parts);
  $formVars['child_birthday'] = $parts[1] . "/" . $parts[2] . "/" . $parts[0]; 

  $errors = validate($formVars);

//  print_r($errors);
  print createform($formVars, $errors);
  
}
elseif(isset($_POST['Delete'])) //Child is being deleted
{
  $delformVars = array ();
  
  //Assign each $_POST variable to an array of values
  foreach($_POST as $varname => $value)
  {
     $delformVars[$varname] = trim(clean($value));
  }   

  $delquery = "DELETE FROM tst_child_info WHERE child_id = $delformVars[child_id]";

  if (mysqli_query($conn, $delquery)) //Delete was successful
  {      
    //Show Child delete information            
    print "Child with id " . $delformVars['child_id'] . " was deleted!" . "<BR>";
  }
  else //Insert was not successful
  {
    print "Mysql Error:" . mysqli_error();
  }
 
  unset($formVars);
  mysqli_close($conn);
}
elseif(isset($_POST['Verify'])) //Modify Form has been submitted
{  
  $formVars = array ();
  
  //Assign each $_POST variable to an array of values
	foreach($_POST as $varname => $value)
  {
     $formVars[$varname] = trim(clean($value));
  }   


  //The foreach loop reformats data and an child_guardianemail could be case sensitive so reset it to original value  and phone numbers need stripped
  $formVars['child_guardianemail'] = $_POST['child_guardianemail']; 
  $formVars['child_guardianhomephone'] = stripChars($formVars['child_guardianhomephone']);
  $formVars['child_guardianworkphone'] = stripChars($formVars['child_guardianworkphone']);
  $formVars['child_guardiancellphone'] = stripChars($formVars['child_guardiancellphone']);
  $formVars['child_contactphone'] = stripChars($formVars['child_contactphone']);
  $formVars['child_state'] = strtoupper($formVars['child_state']);

//Reformat Date of Birth so that it is in MySql format YYYYMMDD
  $parts = explode('/', $formVars['child_birthday']);
 //ereg("^([0-9]{2})/([0-9]{2})/([0-9]{4})$",$formVars['child_birthday'], $parts);
  $dob = $parts[2] . $parts[0] . $parts[1]; 
  

  //Validate $formVars
  $errors = validate($formVars);

  if (count($errors) > 0)//Submitted BUT errors 
  {
    print createform($formVars, $errors);          
  }
  else //Submitted and no errors
  {
//UPDATE DB with data
    
      $query = "UPDATE tst_child_info SET 
	  		  child_classassignment = $formVars[child_classassignment],
			  child_medicalrelease = $formVars[child_medicalrelease],
			  child_photorelease = $formVars[child_photorelease],
			  child_session = $formVars[child_session],
			  child_firstname = '$formVars[child_firstname]',
			  child_lastname = '$formVars[child_lastname]',
			  child_gender = $formVars[child_gender],
			  child_birthday = $dob,
			  child_grade  = $formVars[child_grade],
			  child_address = '$formVars[child_address]',
			  child_city = '$formVars[child_city]',
			  child_state = '$formVars[child_state]',
			  child_zipcode = $formVars[child_zipcode],
			  child_guardianname = '$formVars[child_guardianname]',
			  child_guardianhomephone = '$formVars[child_guardianhomephone]',
			  child_guardianworkphone = '$formVars[child_guardianworkphone]',
			  child_guardiancellphone = '$formVars[child_guardiancellphone]',
			  child_guardianemail = '$formVars[child_guardianemail]',
			  child_contactname = '$formVars[child_contactname]',
			  child_contactrelation = '$formVars[child_contactrelation]',
			  child_contactphone = '$formVars[child_contactphone]',
			  child_placewith = '$formVars[child_placewith]',
			  child_attendNWB = $formVars[child_attendNWB],
			  child_churchattending = '$formVars[child_churchattending]',
			  child_guestof = '$formVars[child_guestof]',
			  child_allergies = '$formVars[child_allergies]',
			  child_medicalproblems = '$formVars[child_medicalproblems]',
			  child_medications = '$formVars[child_medications]' 
			  WHERE child_id = $formVars[child_id]";
/*
			  child_classassignment = $formVars[child_classassignment],
			  child_medicalrelease = $formVars[child_medicalrelease],
			  child_photorelease = $formVars[child_photorelease] 
*/
//print "<br>" . $query . "<br>";

  if (mysqli_query($conn, $query)) //Insert was successful
  {      
        //Show Child verification information            
    print "You have successfully updated " . $formVars['child_firstname'] . " " . $formVars['child_lastname'] . "<BR>";
  }
  else //Insert was not successful
  {
    print "Mysql Error:" . mysqli_error();
  }

// Clear the formVars so a future <form> is blank
  unset($errors);  
  unset($formVars);
  mysqli_close($conn);
  
  }
}

?>
</BODY>
</HTML>