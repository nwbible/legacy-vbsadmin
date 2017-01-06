<?php 

//CONSTANT DECLARATIONS
define('SEARCH_LIMIT', 20);
define('COMMITMENT_LIMIT', 1300);

//Function declaration
function debug($var)
{
  print "<BR>";
  print "<div style='color: #FF0000'>";
  print "<BR>*****<BR>";
  print_r($var);
  print "<BR>*****<BR>";
  print "</div>";
  print "<BR>";
}

function clean($input)
{
     $input = ucwords(strtolower(htmlentities($input)));
     $input = EscapeShellCmd($input);
     return ($input);
}

function stripChars($number)
{//returns a string with only digits
	if(!empty($number))
  {
      $number = preg_replace('/[^0-9]/','',$number);
  
  }
  else
  {
      $number = NULL;
  }
	
  return $number;
}

function formatPhone($number)
{//Returns a digit only string in Phone number format xxx-xxx-xxxx
    if((!empty($number)) && (strlen($number)==10))
    {
      $number = ((substr($number,0,3)) . "-" . (substr($number,3,3)) . "-" . (substr($number,6,4)));   
    }
    elseif ((!empty($number)) && (strlen($number)==7))
    {
      $number = ((substr($number,0,3)) . "-" . (substr($number,3,4)));   
    }
    else
    {
	  $number = "";
	}
	return $number;
}

function checkEmail($email)
{
//Check an email address is possibly valid
	$pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$";
	
	if (filter_var($email, FILTER_VALIDATE_EMAIL))
  //if (eregi($pattern, $email))
	{
		return true;
	}
	else
	{
		return false;
	}
}


function validate($vars)
{

//debug($vars);

    //Validates the $vars array
    $errors = array ();
  
  if (empty($vars["child_session"]))
  {
      // Session cannot be a null string
      $errors["child_session"] =
          "You must choose a session to attend.";
  }
  
  // Validate the firstName
  if (empty($vars["child_firstname"]))
  {
      // First name cannot be a null string
      $errors["child_firstname"] =
          "The first name field cannot be blank.";
  }
  elseif (strlen($vars["child_firstname"]) > 25)
  {
       $errors["child_firstname"] =
      "The first name can be no longer than 25 " .
         "characters";
  }//fi firstname
  
  // Validate the Lastname
  if (empty($vars["child_lastname"]))
  {
      // the user's lastname cannot be a null string
      $errors["child_lastname"] =
          "The last name field cannot be blank.";
  }
  elseif (strlen($vars["child_lastname"]) > 25)
  {
      $errors["child_lastname"] =
          "The last name can be no longer than 25 " .
          "characters";
  }//fi lastname

if (!isset($vars[child_gender]))
  {
      // Gender cannot be a null string
      $errors[child_gender] =
          "Please specify the gender of your child.";
  }

/******************************************************************
DOB Check
******************************************************************/
  $parts = explode('/', $vars[child_birthday]);

  // Validate Date of Birth
  if (empty($vars[child_birthday]))
  {
      // the user's date of birth cannot be a null string
      $errors[child_birthday] = "You must supply a date of birth.";
  }
  //elseif (!preg_match("/^([0-9]{2})/([0-9]{2})/([0-9]{4})$/", $vars[child_birthday], $parts))
  //    // Check the format
  //    $errors[child_birthday] =
  //      "The date of birth is not a valid date in the " .
  //      "format DD/MM/YYYY";
  elseif (!checkdate($parts[0],$parts[1],$parts[2]))
  {
      $errors[child_birthday] =
         "The date of birth is invalid. Please check " .
         "that the month is between 1 and 12, and the " .
         "day is valid for that month.";
  }
  elseif (intval($parts[2]) < 1993)
  {
      // Make sure that the user has a reasonable birth year
      $errors[child_birthday] =
         "Please check your birth year!";
  }

/*******************************************************************
END DOB CHECK
*******************************************************************/
 
 if (empty($vars[child_grade]))
  {
      // Grade level completed cannot be a null string
      $errors[child_grade] =
          "Please choose the last grade level your child completed.";
  }
   
  // Validate the Address
  if (empty($vars["child_address"]))
{
      // all the fields of the address cannot be null
      $errors["child_address"] =
          "You must supply an address.";
}
  else
{
      if (strlen($vars["child_address"]) > 50)
        $errors["child_address"] =
          "The address line can be no longer " .
          "than 50 characters";
}//fi address

  // Validate the City
  if (empty($vars["child_city"]))
  {
      // the user's city cannot be a null string
      $errors["child_city"] = "You must supply a city.";
  }
  elseif (strlen($vars["child_city"]) > 20)
  {
	    $errors["child_city"] =
        "The city can be no longer than 20 characters";
  }//fi city
  
  // Validate State - any string less than 21 characters
  if (strlen($vars["child_state"]) != 2)
  {
      $errors["child_state"] =
         "The state must be 2 characters";
  }//fi state
  
  // Validate Zipcode
  if (!preg_match("/^[0-9]{5}?$/", $vars["child_zipcode"]))
  {
      $errors["child_zipcode"] =
         "The zipcode must be 5 digits in length";
  }//fi zipcode
  
   if (empty($vars[child_guardianname]))
  {
      //Guardian Name cannot be empty
      $errors["child_guardianname"] = "Please enter parent or guardian information.";
  }
 
  $validPhoneExpr =
     "/^([0-9]{3}[ ]?)?[0-9]{3}[ ]?[0-9]{4}$/";

	 // Check home phone number***********************************
  if (!empty($vars[child_guardianhomephone]) &&
      !preg_match($validPhoneExpr, stripChars($vars[child_guardianhomephone])))
  {
      $errors[child_guardianhomephone] =
        "The home phone number must be 10 numbers in length " .
        "including the area code.";
  }//fi homephone

  
/* No longer require the work or cell phone numbers  
  // Check work phone number***********************************
  if (!empty($vars[child_guardianworkphone]) &&
      !ereg($validPhoneExpr, stripChars($vars[child_guardianworkphone])))
  {
      $errors[child_guardianworkphone] =
        "The work phone number must be 10 numbers in length " .
        "including the area code.";
  }//fi workphone
  
  // Check cell phone number***********************************
  if (!empty($vars[child_guardiancellphone]) &&
      !ereg($validPhoneExpr, stripChars($vars[child_guardiancellphone])))
  {
      $errors[child_guardiancellphone] =
        "The cell phone number must be 10 numbers in length " .
        "including the area code.";
  }//fi cellphone
*/


  // Validate email address*************************************
     $validEmailExpr =
         "/^[0-9a-z~`!#$%&_-]([.]?[0-9a-z~!#$%&_-])*@[0-9a-z~!#$%&_-]([.]?[0-9a-z~!#$%&_-])*$/";

     if (empty($vars[child_guardianemail]))
     {
         // the user's email cannot be a null string
         ;
     }
     elseif (!filter_var($vars['child_guardianemail'], FILTER_VALIDATE_EMAIL))
     //elseif (!preg_match($validEmailExpr, $vars[child_guardianemail]))
     {
	     // The email must match the above regular
         // expression
         $errors[child_guardianemail] =
            "The email address must be in the " .
            "name@domain format.";
	   }
     elseif (strlen($vars[child_guardianemail]) > 75)
     {
	      // The length cannot exceed 50 characters
         $errors[child_guardianemail] =
            "The email address can be no longer than " .
            "75 characters.";
 	 }//fi email

  if(empty($vars[child_guardianhomephone]) && empty($vars[child_guardianworkphone]) && empty($vars[child_guardiancellphone]) && empty($vars[child_guardianemail]))
  {
      //Send back an error message that we need at least 1 phone number
      $errors[contact] = 
        "Please enter at least one (1) phone number or an email at which you can be reached.";
  }

return $errors;

}

function createDropDown($tbl, $value, $description, $where = '', $select = '')
{
    //Searches through a table and creates a Drop Down List of values

  require('DBConnect2010.inc');
  $ddquery  = "SELECT " . $value . ", " . $description . " FROM " . $tbl;
	if ($where != '')
	{
		$ddquery .= " WHERE $where";
	}
	
	$ddquery .= " ORDER BY " . $value;
	
  $ddresult = mysqli_query($conn, $ddquery);

  $ctr = mysqli_num_rows($ddresult);
  $i=0;  

  $options ="";
  $descname = "";
  while ($i < $ctr)
  {
    $selected = '';

    mysqli_data_seek($ddresult, $i);
    if( !empty($value) || !empty($description))
    {
          $f = mysqli_fetch_assoc( $ddresult);
          $valuename = $f[ $value ];
          $descname = $f [ $description ];
    }
    else
    {
      $f = mysqli_fetch_array( $ddresult);
      $valuename = $f[0];
      $descname = $f[1];
    }

    $selected = ($select == $valuename) ? ' SELECTED ' : '';
    $options .= "<option value='" . $valuename . "'";
    $options .= $selected . ">" . $descname . "</option>"; 
    $i++;
  }
    
  mysqli_close($conn);
  return $options;      
}

function translateold($tbl, $id, $description, $order = ''){

  require('DBConnect2010.inc');

  $query = "SELECT " . $id . ", " . $description . " FROM " . $tbl;
  
  if($order != '')
  {
    $query .= " ORDER BY " . $order;
  }
  
  $rs = mysqli_query($conn, $query);
  
  while($tmparray = mysqli_fetch_array($rs, MYSQL_ASSOC))
  {
    $result[$tmparray[$id]]= $tmparray[$description];
  }
        
    mysqli_close($conn);  
  return $result;
  
}

function translate($tbl, $id, $description, $order = '', $where = ''){

  require('DBConnect2010.inc');

  $query = "SELECT " . $id . ", " . $description . " FROM " . $tbl;
  
  if($where != '')
  {
    $query .= " WHERE " . $where;
  }
  
  if($order != '')
  {
    $query .= " ORDER BY " . $order;
  }
  
//  print $where . "<br>";
//  print $query . "<br>";
  
  $rs = mysqli_query($conn, $query);
  
  while($tmparray = mysqli_fetch_array($rs, MYSQLI_ASSOC))
  {
    $result[$tmparray[$id]]= $tmparray[$description];
  }
        
    mysqli_close($conn);  
  return $result;
  
}

function fieldError($fieldName, $errors)
{
    //Function sets an error message in a field
    if (isset($errors[$fieldName])) 
    {
           $errormessage = 
"
<div class='error'>*** $errors[$fieldName] </div>
";
           
           return $errormessage;
    }
}

?>