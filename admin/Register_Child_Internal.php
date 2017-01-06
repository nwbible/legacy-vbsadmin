<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML>
<HEAD>
<TITLE>2012 VBS Child Registration Form</TITLE>

<style type="text/css">
@import url(calendar-green.css);
@import url(/templates/css/AdminTemplate_css.css);




</style>
<script type="text/javascript" src="calendar.js"></script>
<script type="text/javascript" src="lang/calendar-en.js"></script>
<script type="text/javascript" src="calendar-setup.js"></script>

<?php
/*******************************************************************************************
*                         INCLUDES                                                         *
*******************************************************************************************/
include ('Validation.inc');
include ('Default.inc');

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

//include('AdminMenu.php');
error_reporting( error_reporting() & ~E_NOTICE );
/*********************************************************************************************
*                                                                                                     *
*                                Begin Child Registration Form                                        *
*                                                                                                     *
*********************************************************************************************/
$formVars = array ();
$errors = array();

if(isset($_POST['Verify']) || isset($_POST['Submit']))
{  

  
  //Assign each $_POST variable to an array of values
  foreach($_POST as $varname => $value)
  {
     $formVars[$varname] = trim(clean($value));
  }   

  //The foreach loop reformats data and an child_guardianemail could be case sensitive so reset it to original value
  $formVars['child_guardianemail'] = $_POST['child_guardianemail']; 
  $formVars['child_state'] = strtoupper($_POST['child_state']);

  //Validate $formVars
  $errors = validate($formVars);


}

//Check for what sections are completed (Enter, Verify, Complete)
  $completed = array();
  $completed = CheckSectionCompletion($formVars, $errors); 

// Check if the form has been not been submitted for verification or if it has been submitted, but there are errors
if (!isset($formVars['Verify']) || (isset($formVars['Verify']) && count($errors) > 0))
{
  //Display form with or without error messages
  //We need $formVars to hold old data, we need $errors to send the errors array
  print createform($formVars, $errors, $completed); 
  print "<BR /><BR />";
      
}
elseif (!isset($formVars['Submit'])) //Submitted for Verification and NO errors
{
        //Show Child verification information            
        print showverification($formVars, $errors, $completed);
}
else
{
        //Submit to Database and show registration complete information
        SubmitToDatabase($formVars, $errors, $completed);
        
}//fi Submitted and NO errors


/*******************************************************************************************
*                         FUNCTION DELCARATIONS                                            *
*******************************************************************************************/

function createform($vars, $errs, $completed)
{
    //Function creates a form for child registration
  $displayform  = "";
  $displayform .= createbanner($errs, $completed);              
  $displayform .= "<div class='wrapper'>";
  $displayform .= "<FORM name='Register' action='$_SERVER[PHP_SELF]' method='post'>";
  $displayform .= "<INPUT type='hidden' name='child_efile' value='0' />";

  $displayform .= "<div class='dropdownbar'>";
  $displayform .= "<label>Class</label>";
  $displayform .= "<SELECT name='child_classassignment'>";
  $displayform .= "<OPTION value='0'>Please Select a Class</OPTION>";
  $displayform .= createDropDown('tst_class_translate', 'class_id', 'class_description', '', @$vars['child_classassignment']);
  $displayform .= "</SELECT>";
  $displayform .= "<label>Medical Release Form</label>";
  $displayform .= "<SELECT name='child_medicalrelease'>";
  $displayform .= "<OPTION value='0' ";
                    if(@$vars['child_medicalrelease'] == 0) 
                    {
                      $displayform .= "SELECTED ";
                    }
  $displayform .= ">Not Turned In</OPTION>";
  $displayform .= "<OPTION value='1' ";
                    if(@$vars['child_medicalrelease'] == 1) 
                    {
                      $displayform .= "SELECTED ";
                    }
  $displayform .= ">No Consent</OPTION>";
  $displayform .= "<OPTION value='2' ";
                    if(@$vars['child_medicalrelease'] == 2) 
                    {
                      $displayform .= "SELECTED ";
                    }
  $displayform .= ">Consent</OPTION>";
  $displayform .= "</SELECT>";
    
  $displayform .= "<label>Photo Release Form</label>";
  $displayform .= "<SELECT name='child_photorelease'>";
  $displayform .= "<OPTION value='0' ";
                    if(@$vars['child_photorelease'] == 0) 
                    {
                      $displayform .= "SELECTED ";
                    }
  $displayform .= ">Not Turned In</OPTION>";
  $displayform .= "<OPTION value='1' ";
                    if(@$vars['child_photorelease'] == 1) 
                    {
                      $displayform .= "SELECTED ";
                    }
  $displayform .= ">No Consent</OPTION>";
  $displayform .= "<OPTION value='2' ";
                    if(@$vars['child_photorelease'] == 2) 
                    {
                      $displayform .= "SELECTED ";
                    }
  $displayform .= ">Consent</OPTION>";
  $displayform .= "</SELECT></div>";
  $displayform .= "<div class='child_wrapper'><fieldset>";
  $displayform .= "<legend>Please Enter Child Information</legend>";
  $displayform .= "<ol>";

//**********************BEGIN CHILD INFORMATION SECTION***********************************-->

  switch(@$vars['child_session'])
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
                                <label class='radio'><INPUT class='radio' type='radio' value= '1' name='child_session' CHECKED/>9:15 AM</label>
                                <label class='radio'><INPUT class='radio' type='radio' value='2' name='child_session' />6:15 PM</label>
                                   ";
         $displayform .= fieldError('child_session', $errs);
         $displayform .=  "</fieldset></li>";    
   break;
   
   case 2:
   $displayform .= "
                <li><fieldset class='radio'><legend class='radio'>Session</legend>
                                <label class='radio'><INPUT class='radio' type='radio' value= '1' name='child_session' />9:15 AM</label>
                                <label class='radio'><INPUT class='radio' type='radio' value='2' name='child_session' CHECKED/>6:15 PM</label>
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

  switch(@$vars['child_gender'])
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
                        <label class='radio'><INPUT class='radio' type='radio' value='0' name='child_gender' CHECKED/>Female</label>";
   $displayform .= fieldError('child_gender', $errs);
   $displayform .= "<fieldset></li>";   
   break;
   
   case 1:
   $displayform .= "
                <li><fieldset class='radio'><legend class='radio'>Gender</legend>
                        <label class='radio'><INPUT class='radio' type='radio' value='1' name='child_gender' CHECKED />Male</label>
                        <label class='radio'><INPUT class='radio' type='radio' value='0' name='child_gender' />Female</label>";
   $displayform .= fieldError('child_gender', $errs);
   $displayform .= "<fieldset></li>";   
   break;

   default:
   $displayform .= "
                <li><fieldset class='radio'><legend class='radio'>Gender</legend>
                        <label class='radio'><INPUT class='radio' type='radio' value='1' name='child_gender' />Male</label>
                        <label class='radio'><INPUT class='radio'>type='radio' value='0' name='child_gender' />Female</label>";
   $displayform .= fieldError('child_gender', $errs);
   $displayform .= "<fieldset></li>";   

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

	$displayform .= "<div class='error'>&nbsp;&nbsp;Must Turn 4 by 6/18/2012</div>";
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
                    if(@$vars['child_grade'] == '') 
                    {
                      $displayform .= "SELECTED ";
                    }
  $displayform .= ">Please select a grade level</OPTION>
                                <OPTION value='16' ";
                    if(@$vars['child_grade'] == 16) 
                    {
                      $displayform .= "SELECTED ";
                    } 
  $displayform .= ">4 Year Olds</OPTION>
                                <OPTION value='17' ";
                    if(@$vars['child_grade'] == 17) 
                    {
                      $displayform .= "SELECTED ";
                    }
  $displayform .= ">5 Year Olds</OPTION>
                                <OPTION value='13' "; 
                    if(@$vars['child_grade'] == 13)
                    {
                      $displayform .= "SELECTED ";
                    }
  $displayform .= ">Kindergarten</OPTION>
                                <OPTION value='1' ";
                   if(@$vars['child_grade'] == 1)
                    {
                      $displayform .= "SELECTED ";
                    }
  $displayform .= ">1st</OPTION>
                                <OPTION value='2' ";
                    if(@$vars['child_grade'] == 2)
                    {
                      $displayform .= "SELECTED ";
                    }
  $displayform .= ">2nd</OPTION>
                                <OPTION value='3' ";
                    if(@$vars['child_grade'] == 3) 
                    { 
                      $displayform .= "SELECTED ";
                    }
  $displayform .= ">3rd</OPTION>
                                <OPTION value='4' ";
                    if(@$vars['child_grade'] == 4) 
                    {
                      $displayform .= "SELECTED ";
                    }
  $displayform .= ">4th</OPTION>
                                <OPTION value='5' ";
                    if(@$vars['child_grade'] == 5) 
                    { 
                      $displayform .= "SELECTED ";
                    }
  $displayform .= ">5th</OPTION>
                                <OPTION value='6' ";
                    if(@$vars['child_grade'] == 6) 
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

                        <li><label>City</label><INPUT maxlength='20' size='50' name='child_city' value='$vars[child_city]' /></li>";
                        
        $displayform .= fieldError('child_city', $errs);
        $displayform .= "
        
                        <li><label>State</label><INPUT maxlength='2' size='50' name='child_state' value='" . strtoupper(@$vars['child_state']) . "' /></li>";
                        
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

  switch(@$vars['child_attendNWB'])
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
  $displayform .= "<li><label style=\"vertical-align: top;\">Allergies:</label><TEXTAREA name='child_allergies' rows='6' cols='38' >" . @$vars['child_allergies'] . "</TEXTAREA></li>";
  $displayform .= "<li><label style=\"vertical-align: top;\">Medical Problems:</label><TEXTAREA name='child_medicalproblems' rows='6' cols='38'>" . @$vars['child_medicalproblems'] . "</TEXTAREA></li>";
  $displayform .= "<li><label style=\"vertical-align: top;\">Medications:</label><TEXTAREA name='child_medications' rows='6' cols='38'>" . @$vars['child_medications'] . "</TEXTAREA></li>";
  $displayform .= "</ol></fieldset></div>";
        
  //**********************END ALLERGY/MEDICAL INFORMATION****************************   

        $displayform .= "<div class='child_wrapper'><fieldset class='submit'>";
        $displayform .= "<INPUT class='submit' type='submit' value='Verify Information' name='Verify' />";
        $displayform .= "</fieldset></div>";

        $displayform .= "</FORM></div>";

  
    
    return $displayform;
}   

function showverification($formVars, $errs, $completed)
{

//Clean-up phone variables
  $formVars['child_guardianhomephone'] = stripChars($formVars['child_guardianhomephone']);
  $formVars['child_guardianworkphone'] = stripChars($formVars['child_guardianworkphone']);
  $formVars['child_guardiancellphone'] = stripChars($formVars['child_guardiancellphone']);
  $formVars['child_contactphone'] = stripChars($formVars['child_contactphone']);

//Creates a child information verification page
      $displayverification  = "";
      $displayverification .= createbanner($errs, $completed);
      $displayverification .= "<div class='wrapper'>";                  
          $displayverification .= "<div class='child_wrapper'><div class='verify_child'>";
      $displayverification .= "<div class='error'>Child Information</div>";
                        
                        $displayverification .= "My child will be attending ";
                        
                        switch ($formVars['child_session'])
      {
          case 1:
            $displayverification .= "the AM session.<BR />";
            break;
            
          case 2:
            $displayverification .= "the PM session.<BR />";
            break;
      }
      
      $displayverification .= $formVars['child_firstname'] . " " . $formVars['child_lastname'] . "<BR />";

      if ($formVars['child_gender'] == 1)
      {
          $displayverification .= "Gender: Male<BR />";
      }
      else
      {
          $displayverification .= "Gender: Female<BR />";
      }
      
      
      
      $displayverification .= "Birthdate: " . $formVars['child_birthday'] . "<BR />";
      $displayverification .= "Grade Completed: ";
      if ($formVars['child_grade'] == '13')
      {
       $displayverification .= "Kindergarten<BR />";   
      } 
      elseif ($formVars['child_grade'] == '16')
      {
       $displayverification .= "4 Year Olds<BR />";   
      } 
      elseif ($formVars['child_grade'] == '17')
      {
       $displayverification .= "5 Year Olds<BR />";   
      } 
      else
      {
        $displayverification .= $formVars['child_grade'] . "<BR />";
      }
      
      $displayverification .= $formVars['child_address'] . "<BR />";
      $displayverification .= $formVars['child_city'] . ", " . $formVars['child_state'] . " " . $formVars['child_zipcode'] . "<BR />"; 

          $displayverification .= "</div>";
          
          $displayverification .= "<div class='verify_guardian'>";
      $displayverification .= "<div class='error'>Guardian Information</div>";
      $displayverification .= $formVars['child_guardianname'] . "<BR />";
      $displayverification .= "Home Phone: " . formatPhone($formVars['child_guardianhomephone']) . "<BR />";
      $displayverification .= "Work Phone: " . formatPhone($formVars['child_guardianworkphone']) . "<BR />";
      $displayverification .= "Cell Phone: " . formatPhone($formVars['child_guardiancellphone']) . "<BR />";
      $displayverification .= "Email: " . $formVars['child_guardianemail'] . "<BR />";
      $displayverification .= "<BR /><div class='error'>Emergency Contact Information</div>";
      $displayverification .= ((!empty($formVars['child_contactname']))?$formVars['child_contactname'] . "<br />" .
                                                                        "Relationship: " . $formVars['child_contactrelation'] . "<BR />" . 
                                                                "Phone: " . formatPhone($formVars['child_contactphone']) . "<BR />":'N/A');
          $displayverification .= "</div>";
          
          $displayverification .= "<div class='verify_other'>";
          $displayverification .= "<div class='error'>Other Information</div>";
      $displayverification .= ((!empty($formVars['child_placewith']))?"Please place my child with " . $formVars['child_placewith'] . ".<br />":'') . "";
      $displayverification .= ((!empty($formVars['child_guestof']))?"My child is coming as a guest of " . $formVars['child_guestof'] . ".<br />":'') . "";

      if ($formVars['child_attendNWB'] == 1)
      {
          $displayverification .= "We attend Northwest Bible Church<BR />";
      }
      else
      {
          $displayverification .= "We do not attend Northwest Bible Church.<br />";
          
          if (!empty($formVars['child_churchattending']))
          {
              $displayverification .= "We attend " . $formVars['child_churchattending'] . ".<BR />";
          }
          else
          {
              $displayverification .= "<BR />";
          }
      }
    
    $displayverification .= "</div>";
    
    $displayverification .= "<div class='verify_medical'>";
          $displayverification .= "<div class='error'>Allergies</div>";
          $displayverification .= $formVars['child_allergies'] . "<BR />";
          $displayverification .= "<div class='error'>Medical Problems</div>";
          $displayverification .= $formVars['child_medicalproblems'] . "<BR />";
          $displayverification .= "<div class='error'>Medications</div>";
          $displayverification .= $formVars['child_medications'] . "<BR />";
                  $displayverification .= "</div>";

//                $displayverification .= "</div>";
       
              $displayverification .= "<div class='verify_buttons'><form method='POST' action='$_SERVER[PHP_SELF]' id='Submit' name='DBSubmit'>";
    $displayverification .= passPostArray($formVars);
        $displayverification .= "<input type='button' value='Edit Info' alt='Edit Info'";
    $displayverification .= "name='Back' onClick=\"history.go(-1)\">";
        $displayverification .= "<input type='submit' accesskey='' value='Register' alt='Submit'";
    $displayverification .= "name='Submit' title='Register'></form></div></div>";
        
    return $displayverification;
    
}

function ShowRegistrationComplete($formVars, $errs, $completed)
{
   
    //Creates a child information verification page
      $displaycomplete  = "";
          $displaycomplete .= createbanner($errs, $completed);
      $displaycomplete .= "";
      $displaycomplete .= "<div class='error'>Your registration was successful!</div>";
      $displaycomplete .= "<div class='error' style='font-size: 14px;'>If you entered an email address we will be sending you an email as a confirmation.<br />";
          $displaycomplete .= "If any of this information is incorrect, please contact Church at (555)555-5555.<br /><br />";
          $displaycomplete .= "Please be sure to print your child&#39;s release form by clicking below and return it to the church office</div>";
      $displaycomplete .= "<div class='verify_buttons'><form method='POST' action='../ReleaseForm.php?id=$formVars[child_id]' id='ReleaseForm' name='ReleaseForm'>";
      $displaycomplete .= "<input type='submit' accesskey='' value='Print Release Forms' alt='Print Release Form'";
      $displaycomplete .= "name='btnReleaseForm' title='Print Release Form'></form></div>";
      $displaycomplete .= "<br><form method='POST' action='Register_Child_Internal.php' id='New_Child' name='New_Child'>";
      $displaycomplete .= "<input type='submit' value='New Child' alt='New Child'";
      $displaycomplete .= "name='New_Child' title='New Child' class=''></form>";
      
        
    return $displaycomplete;
    
}

function SubmitToDatabase($formVars, $errs, $completed)
{
                //Submit information to the Database    
  $formVars['child_guardianhomephone'] = stripChars($formVars['child_guardianhomephone']);
  $formVars['child_guardianworkphone'] = stripChars($formVars['child_guardianworkphone']);
  $formVars['child_guardiancellphone'] = stripChars($formVars['child_guardiancellphone']);
  $formVars['child_contactphone'] = stripChars($formVars['child_contactphone']);
  $parts = explode('/', $formVars['child_birthday']);
  //Reformat Date of Birth so that it fits the MySQL date field type
  $dob = $parts[2] . $parts[0] . $parts[1]; 


  $query = "INSERT INTO tst_child_info 
                          (
                          child_regdate,
                          child_efile, 
                  child_session,
                          child_firstname,
                          child_lastname,
                          child_gender,
                          child_birthday,
                          child_grade,
                          child_address,
                          child_city,
                          child_state,
                          child_zipcode,
                          child_guardianname,
                          child_guardianhomephone,
                          child_guardianworkphone,
                          child_guardiancellphone,
                          child_guardianemail,
                          child_contactname,
                          child_contactrelation,
                          child_contactphone,
                          child_placewith,
                          child_attendNWB,
                          child_churchattending,
                          child_guestof,
                          child_allergies,
                          child_medicalproblems,
                          child_medications, 
                          child_classassignment,                          
                          child_medicalrelease, 
                          child_photorelease
                          )                       
                          VALUES
                          (                       
                          now(),
                          $formVars[child_efile],
                  $formVars[child_session], 
                          '$formVars[child_firstname]', 
                  '$formVars[child_lastname]', 
                  $formVars[child_gender], 
                          $dob, 
                          $formVars[child_grade], 
                          '$formVars[child_address]', 
                  '$formVars[child_city]', 
                  '$formVars[child_state]', 
                  $formVars[child_zipcode], 
                  '$formVars[child_guardianname]', 
                      '$formVars[child_guardianhomephone]', 
                  '$formVars[child_guardianworkphone]', 
                  '$formVars[child_guardiancellphone]', 
                  '$formVars[child_guardianemail]', 
                  '$formVars[child_contactname]', 
              '$formVars[child_contactrelation]', 
                      '$formVars[child_contactphone]', 
                  '$formVars[child_placewith]', 
                      $formVars[child_attendNWB], 
                  '$formVars[child_churchattending]', 
                      '$formVars[child_guestof]', 
                  '$formVars[child_allergies]', 
                      '$formVars[child_medicalproblems]', 
                  '$formVars[child_medications]', 
                  '$formVars[child_classassignment]', 
                          '$formVars[child_medicalrelease]', 
                          '$formVars[child_photorelease]' 
                          )";

//debug($query);

  require_once ('DBConnect2010.inc');
  if (mysqli_query($conn, $query)) //Insert was successful
  {      
                //Get new child_id number for data
                $formVars['child_id'] = mysqli_insert_id($conn);

//Send Email
  if (!empty($formVars['child_guardianemail']))   
  { 
                $to = "$formVars[child_guardianname] <$formVars[child_guardianemail]>, <tphillips@nwbible.org>";
                        $subject = "2012 VBS Registration Complete";    
                $body = "Please do not respond to this e-mail directly.  This e-mail is to confirm that your Church VBS Registration has been completed.  If any of the following information is incomplete or incorrect please contact Church at 555-555-5555.\n";

                $body .= "
        Child's Name: $formVars[child_firstname] $formVars[child_lastname]\n
               Session: ";
                        $body .= ($formVars['child_session']==1?"AM\n":"PM\n");
                        $body .= "
                Gender: ";
                        $body .= ($formVars['child_gender']==1?"Male\n":"Female\n");
								$body .= "Birthdate: $formVars[child_birthday]\n";
/**************************************************************************
* Need to translate child_grade into it's actual grade level to send home *
**************************************************************************/
								if ($formVars['child_grade'] == '13')
								  {
								   $body .= "Grade: Kindergarten\n";   
								  } 
								  elseif ($formVars['child_grade'] == '16')
								  {
								   $body .= "Grade: 4 Year Olds\n";   
								  } 
								  elseif ($formVars['child_grade'] == '17')
								  {
								   $body .= "Grade: 5 Year Olds\n";   
								  } 
								  else
								  {
									$body .= "Grade: $formVars[child_grade]\n";
								  }
              $body .= "Address: $formVars[child_address]\n $formVars[child_city], $formVars[child_state] $formVars[child_zipcode]\n
             Allergies: $formVars[child_allergies]\n
 Medical Problems: $formVars[child_medicalproblems]\n
         Medications: $formVars[child_medications]\n
 
  Parent/Guardian: $formVars[child_guardianname]\n
       Home Phone: $formVars[child_guardianhomephone]\n
        Work Phone: $formVars[child_guardianworkphone]\n
          Cell Phone: $formVars[child_guardiancellphone]\n
                  Email: $formVars[child_guardianemail]\n
         
Emergency Contact: $formVars[child_contactname]\n
                 Relation: $formVars[child_contactrelation]\n
                    Phone: $formVars[child_contactphone]\n

           Place with: $formVars[child_placewith]\n
       Attend NWB?: ";
                        $body .= ($formVars['child_attendNWB']==1?"Yes\n":"No\n");
                        $body .= "
      Home Church: $formVars[child_churchattending]\n
             Guest of: $formVars[child_guestof]\n
";

                        $headers = 'From: VBS at CHURCH <vbs@CHURCH.org>' . "\r\n" . 'Reply-To: no-reply@CHURCH.org' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
                //$message = mail($to, $subject, $body, $headers);


//              print $message;
                $formVars['RegistrationComplete']="Complete";
}

    //Show Child verification information            
    print ShowRegistrationComplete($formVars, $errs, $completed);

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

function CheckSectionCompletion($vars, $errs)
{
        
        $sectionstatus[1]="inprogress";
        $sectionstatus[2]="waiting";
        $sectionstatus[3]="waiting";

        if ((isset($vars['Verify'])) && (empty($errs))) 
        {
                $sectionstatus[1]="completed";
                $sectionstatus[2]="inprogress";
                $sectionstatus[3]="waiting";
        }
        
        if ((isset($vars['Submit'])) && (empty($vars['RegistrationComplete']))) 
        {
                $sectionstatus[1]="completed";
                $sectionstatus[2]="completed";
                $sectionstatus[3]="inprogress";
        }
        
        if ((isset($vars['Submit'])) && (!empty($vars['RegistrationComplete']))) 
        {
                $sectionstatus[1]="completed";
                $sectionstatus[2]="completed";
                $sectionstatus[3]="completed";
        }
        
        return $sectionstatus;
        
}


?>
</BODY>
</HTML>