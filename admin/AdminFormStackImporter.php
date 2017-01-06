<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>
			FormStack Data Importer
		</title>
<style type="text/css">
  @import url(/templates/css/AdminTemplate_css.css);
  @import url(/templates/css/AdminPrint_css.css) print;


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


</style>


<?php 
    include('Validation.inc');
	include("Formstack.php");
    require('DBConnect2010.inc');
	
?>

</head>
<body>

<?php
/********************************************************************************************
*                                    MAIN                                                   *
********************************************************************************************/
$formstackapikey = "<INSERT YOUR FORMSTACK API KEY HERE>";
$vbsregistrationformid = "<INSERT YOUR FORMSTACK VBS REGISTRATION FORM ID HERE>";


$number_of_your_children_being_registered_now = "32652069";
$parentguardian_name = "32652071";
$email = "32652072";
$address = "32652073";
$phone = "32652074";
$relationship_to_children_being_registered = "32652075";
$does_your_family_attend_northwest_bible_church = "32652076";
$what_church_does_your_family_call_home = "32652077";
$who_invited_you_to_vbs_at_northwest = "32652078";
$emergency_contact_name = "32652080";
$emergency_contact_phone = "32652081";
$emergency_contact_relationship = "32652082";
$morning_or_evening_session_c1 = "32652084";
$name_c1 = "32652085";
$gender_c1 = "32652086";
$birth_date_c1 = "32652087";
$grade_completed_c1 = "32652088";
$does_this_child_have_any_allergies_c1 = "32652089";
$please_explain_allergies_c1 = "32652090";
$does_this_child_have_any_medical_conditions_c1 = "32652091";
$please_explain_medical_conditions_c1 = "32652092";
$is_this_child_taking_any_medications_c1 = "32652093";
$please_explain_medications_c1 = "32652094";
$please_place_my_child_with_c1 = "32652095";
$morning_or_evening_session_c2 = "32652097";
$name_c2 = "32652098";
$gender_c2 = "32652099";
$birth_date_c2 = "32652100";
$grade_completed_c2 = "32652101";
$does_this_child_have_any_allergies_c2 = "32652102";
$please_explain_allergies_c2 = "32652103";
$does_this_child_have_any_medical_conditions_c2 = "32652104";
$please_explain_medical_conditions_c2 = "32652105";
$is_this_child_taking_any_medications_c2 = "32652106";
$please_explain_medications_c2 = "32652107";
$please_place_my_child_with_c2 = "32652108";
$morning_or_evening_session_c3 = "32652110";
$name_c3 = "32652111";
$gender_c3 = "32652112";
$birth_date_c3 = "32652113";
$grade_completed_c3 = "32652114";
$does_this_child_have_any_allergies_c3 = "32652115";
$please_explain_allergies_c3 = "32652116";
$does_this_child_have_any_medical_conditions_c3 = "32652117";
$please_explain_medical_conditions_c3 = "32652118";
$is_this_child_taking_any_medications_c3 = "32652119";
$please_explain_medications_c3 = "32652120";
$please_place_my_child_with_c3 = "32652121";
$morning_or_evening_session_c4 = "32652123";
$name_c4 = "32652124";
$gender_c4 = "32652125";
$birth_date_c4 = "32652126";
$grade_completed_c4 = "32652127";
$does_this_child_have_any_allergies_c4 = "32652128";
$please_explain_allergies_c4 = "32652129";
$does_this_child_have_any_medical_conditions_c4 = "32652130";
$please_explain_medical_conditions_c4 = "32652131";
$is_this_child_taking_any_medications_c4 = "32652132";
$please_explain_medications_c4 = "32652133";
$please_place_my_child_with_c4 = "32652134";
$morning_or_evening_session_c5 = "32652136";
$name_c5 = "32652137";
$gender_c5 = "32652138";
$birth_date_c5 = "32652139";
$grade_completed_c5 = "32652140";
$does_this_child_have_any_allergies_c5 = "32652141";
$please_explain_allergies_c5 = "32652142";
$does_this_child_have_any_medical_conditions_c5 = "32652143";
$please_explain_medical_conditions_c5 = "32652144";
$is_this_child_taking_any_medications_c5 = "32652145";
$please_explain_medications_c5 = "32652146";
$please_place_my_child_with_c5 = "32652147";
$by_checking_this_box_you_agree_to_the_terms_and_conditions_above = "32652149";

$number_of_your_children_being_registered_now_value = "";
$parentguardian_name_value = "";
$email_value = "";
$address_value = "";
$city_value = "";
$state_value = "";
$zip_value = "";
$phone_value = "";
$relationship_to_children_being_registered_value = "";
$does_your_family_attend_northwest_bible_church_value = "";
$what_church_does_your_family_call_home_value = "";
$who_invited_you_to_vbs_at_northwest_value = "";
$emergency_contact_name_value = "";
$emergency_phone_value = "";
$emergency_contact_relationship_value = "";
$morning_or_evening_session_c1_value = "";
$name_c1_value = "";
$lastname_c1_value = "";
$gender_c1_value = "";
$birth_date_c1_value = "";
$grade_completed_c1_value = "";
$does_this_child_have_any_allergies_c1_value = "";
$please_explain_allergies_c1_value = "";
$does_this_child_have_any_medical_conditions_c1_value = "";
$please_explain_medical_conditions_c1_value = "";
$is_this_child_taking_any_medications_c1_value = "";
$please_explain_medications_c1_value = "";
$please_place_my_child_with_c1_value = "";
$morning_or_evening_session_c2_value = "";
$name_c2_value = "";
$lastname_c2_value = "";
$gender_c2_value = "";
$birth_date_c2_value = "";
$grade_completed_c2_value = "";
$does_this_child_have_any_allergies_c2_value = "";
$please_explain_allergies_c2_value = "";
$does_this_child_have_any_medical_conditions_c2_value = "";
$please_explain_medical_conditions_c2_value = "";
$is_this_child_taking_any_medications_c2_value = "";
$please_explain_medications_c2_value = "";
$please_place_my_child_with_c2_value = "";
$morning_or_evening_session_c3_value = "";
$name_c3_value = "";
$lastname_c3_value = "";
$gender_c3_value = "";
$birth_date_c3_value = "";
$grade_completed_c3_value = "";
$does_this_child_have_any_allergies_c3_value = "";
$please_explain_allergies_c3_value = "";
$does_this_child_have_any_medical_conditions_c3_value = "";
$please_explain_medical_conditions_c3_value = "";
$is_this_child_taking_any_medications_c3_value = "";
$please_explain_medications_c3_value = "";
$please_place_my_child_with_c3_value = "";
$morning_or_evening_session_c4_value = "";
$name_c4_value = "";
$lastname_c4_value = "";
$gender_c4_value = "";
$birth_date_c4_value = "";
$grade_completed_c4_value = "";
$does_this_child_have_any_allergies_c4_value = "";
$please_explain_allergies_c4_value = "";
$does_this_child_have_any_medical_conditions_c4_value = "";
$please_explain_medical_conditions_c4_value = "";
$is_this_child_taking_any_medications_c4_value = "";
$please_explain_medications_c4_value = "";
$please_place_my_child_with_c4_value = "";
$morning_or_evening_session_c5_value = "";
$name_c5_value = "";
$lastname_c5_value = "";
$gender_c5_value = "";
$birth_date_c5_value = "";
$grade_completed_c5_value = "";
$does_this_child_have_any_allergies_c5_value = "";
$please_explain_allergies_c5_value = "";
$does_this_child_have_any_medical_conditions_c5_value = "";
$please_explain_medical_conditions_c5_value = "";
$is_this_child_taking_any_medications_c5_value = "";
$please_explain_medications_c5_value = "";
$please_place_my_child_with_c5_value = "";
$by_checking_this_box_you_agree_to_the_terms_and_conditions_above_value = "";

$total_registrations_processed = 0;
$lastRegDate;





	
	//Get last processed timestamp from DB.
	$lastImportTimestamp = GetLastImportTimestamp();
	$newDateTime = new DateTime($lastImportTimestamp);
	$newDateTime->modify('+1 second');
#	$newDateTime->add(new DateInterval('PT1S'));
	$newDTString = $newDateTime->format("Y-m-d H:i:s");
	//TODO:  Handle case if there is no last timestamp in DB
	$totalpages = ProcessFormStackData(1, $newDTString);
	if($totalpages > 1 )
	{
		for($i = 2; $i <= $totalpages; $i++)
		{
			ProcessFormStackData($i, $newDTString);
		}
	}

	
	//Update DB latest timestamp
	if($GLOBALS['total_registrations_processed'] > 0)
	{
		InsertLastRecordTimestamp($GLOBALS['lastRegDate']);
	}

	
	//TODO:Show any errors
	
	//Let user know it is finished.
	print "<h1>The FormStack data has been imported!</h1>";
	print "<h2>" . $GLOBALS['total_registrations_processed'] . " registrations processed</h2><br/><br/>";
	print "<a href='index.php'>Back to Admin Page</a>";
		


/********************************************************************************************
*                                    FUNCTIONS                                              *
********************************************************************************************/
function ProcessFormStackData($page, $newDTString)
{
	//Get FormStack data based on last timestamp.
	$formstack = new Formstack($GLOBALS['formstackapikey']);
	$res = $formstack->data($GLOBALS['vbsregistrationformid'], array('per_page' => 100, 'page' => $page, 'min_time' => $newDTString));
	foreach($res['submissions'] as $submission)
	{
		ResetFieldValues();
			
		foreach($submission['data'] as $data)
		{
			$fieldid = $data['field'];
			$fieldvalue = $data['value'];
			
			PopulateField($fieldid, $fieldvalue);
		}
		
		if($GLOBALS['name_c1_value'] != "")
		{
			$query = "insert into tst_child_info (child_regdate, child_firstname, child_lastname, child_gender, child_address,
						child_city, child_state, child_zipcode, child_session, child_birthday, child_placewith, child_grade,
						child_guestof, child_guardianname, child_guardianemail, child_guardianhomephone, child_guardianworkphone,
						child_guardiancellphone, child_contactname, child_contactphone, child_contactrelation, child_attendNWB, 
						child_churchattending, child_allergies, child_medicalproblems, child_medications) values (";
						
			//TODO: Form must be updated for seperate first and last names.  DONE
			//TODO: Form must be updated for seperate address, city, state, zip fields. DONE
			//TODO: Form should have both guardian home, work, cell phone fields. DONE BY SETTING WORK AND CELL FIELDS TO 'n/a'.
			//TODO: Guardian relationship to children being registered form field does not exist in DB. DONE, IGNORING DATA IN FORMSTACK FORM.
			$query = $query . "'" . $submission['timestamp'] .  "', '" . mysql_real_escape_string($GLOBALS['name_c1_value']) . "', '" . mysql_real_escape_string($GLOBALS['lastname_c1_value']) . "', '" . mysql_real_escape_string($GLOBALS['gender_c1_value']) . "', '";
			$query = $query . mysql_real_escape_string($GLOBALS['address_value']) . "', '" . mysql_real_escape_string($GLOBALS['city_value']) . "', '" . mysql_real_escape_string($GLOBALS['state_value']) . "', '" . mysql_real_escape_string($GLOBALS['zip_value']) . "', '" . mysql_real_escape_string($GLOBALS['morning_or_evening_session_c1_value']);
			$query = $query . "', '" . mysql_real_escape_string($GLOBALS['birth_date_c1_value']) . "', '" . mysql_real_escape_string($GLOBALS['please_place_my_child_with_c1_value']) . "', '" . mysql_real_escape_string($GLOBALS['grade_completed_c1_value']);
			$query = $query . "', '" . mysql_real_escape_string($GLOBALS['who_invited_you_to_vbs_at_northwest_value']) . "', '" . mysql_real_escape_string($GLOBALS['parentguardian_name_value']) . "', '" . mysql_real_escape_string($GLOBALS['email_value']);
			$query = $query . "', '" . mysql_real_escape_string($GLOBALS['phone_value']) . "', 'n/a', 'n/a', '";
			$query = $query . mysql_real_escape_string($GLOBALS['emergency_contact_name_value']) . "', '" . mysql_real_escape_string($GLOBALS['emergency_phone_value']) . "', '" . mysql_real_escape_string($GLOBALS['emergency_contact_relationship_value']);
			$query = $query . "', '" . mysql_real_escape_string($GLOBALS['does_your_family_attend_northwest_bible_church_value']) . "', '" . mysql_real_escape_string($GLOBALS['what_church_does_your_family_call_home_value']);
			$query = $query . "', '" . mysql_real_escape_string($GLOBALS['please_explain_allergies_c1_value']) . "', '" . mysql_real_escape_string($GLOBALS['please_explain_medical_conditions_c1_value']);
			$query = $query . "', '" . mysql_real_escape_string($GLOBALS['please_explain_medications_c1_value']) . "')";
				
			$rs = mysql_query($query);
			
			$GLOBALS['total_registrations_processed']++;
		}
		
		if($GLOBALS['name_c2_value'] != "")
		{
			$query = "insert into tst_child_info (child_regdate, child_firstname, child_lastname, child_gender, child_address,
						child_city, child_state, child_zipcode, child_session, child_birthday, child_placewith, child_grade,
						child_guestof, child_guardianname, child_guardianemail, child_guardianhomephone, child_guardianworkphone,
						child_guardiancellphone, child_contactname, child_contactphone, child_contactrelation, child_attendNWB, 
						child_churchattending, child_allergies, child_medicalproblems, child_medications) values (";
						
			$query = $query . "'" . $submission['timestamp'] .  "', '" . mysql_real_escape_string($GLOBALS['name_c2_value']) . "', '" . mysql_real_escape_string($GLOBALS['lastname_c2_value']) . "', '" . mysql_real_escape_string($GLOBALS['gender_c2_value']) . "', '";
			$query = $query . mysql_real_escape_string($GLOBALS['address_value']) . "', '" . mysql_real_escape_string($GLOBALS['city_value']) . "', '" . mysql_real_escape_string($GLOBALS['state_value']) . "', '" . mysql_real_escape_string($GLOBALS['zip_value']) . "', '" . mysql_real_escape_string($GLOBALS['morning_or_evening_session_c2_value']);
			$query = $query . "', '" . mysql_real_escape_string($GLOBALS['birth_date_c2_value']) . "', '" . mysql_real_escape_string($GLOBALS['please_place_my_child_with_c2_value']) . "', '" . mysql_real_escape_string($GLOBALS['grade_completed_c2_value']);
			$query = $query . "', '" . mysql_real_escape_string($GLOBALS['who_invited_you_to_vbs_at_northwest_value']) . "', '" . mysql_real_escape_string($GLOBALS['parentguardian_name_value']) . "', '" . mysql_real_escape_string($GLOBALS['email_value']);
			$query = $query . "', '" . mysql_real_escape_string($GLOBALS['phone_value']) . "', 'n/a', 'n/a', '";
			$query = $query . mysql_real_escape_string($GLOBALS['emergency_contact_name_value']) . "', '" . mysql_real_escape_string($GLOBALS['emergency_phone_value']) . "', '" . mysql_real_escape_string($GLOBALS['emergency_contact_relationship_value']);
			$query = $query . "', '" . mysql_real_escape_string($GLOBALS['does_your_family_attend_northwest_bible_church_value']) . "', '" . mysql_real_escape_string($GLOBALS['what_church_does_your_family_call_home_value']);
			$query = $query . "', '" . mysql_real_escape_string($GLOBALS['please_explain_allergies_c2_value']) . "', '" . mysql_real_escape_string($GLOBALS['please_explain_medical_conditions_c2_value']);
			$query = $query . "', '" . mysql_real_escape_string($GLOBALS['please_explain_medications_c2_value']) . "')";
				
			$rs = mysql_query($query);			
			
			$GLOBALS['total_registrations_processed']++;

		}
		
		if($GLOBALS['name_c3_value'] != "")
		{
			$query = "insert into tst_child_info (child_regdate, child_firstname, child_lastname, child_gender, child_address,
						child_city, child_state, child_zipcode, child_session, child_birthday, child_placewith, child_grade,
						child_guestof, child_guardianname, child_guardianemail, child_guardianhomephone, child_guardianworkphone,
						child_guardiancellphone, child_contactname, child_contactphone, child_contactrelation, child_attendNWB, 
						child_churchattending, child_allergies, child_medicalproblems, child_medications) values (";
						
			$query = $query . "'" . $submission['timestamp'] .  "', '" . mysql_real_escape_string($GLOBALS['name_c3_value']) . "', '" . mysql_real_escape_string($GLOBALS['lastname_c3_value']) . "', '" . mysql_real_escape_string($GLOBALS['gender_c3_value']) . "', '";
			$query = $query . mysql_real_escape_string($GLOBALS['address_value']) . "', '" . mysql_real_escape_string($GLOBALS['city_value']) . "', '" . mysql_real_escape_string($GLOBALS['state_value']) . "', '" . mysql_real_escape_string($GLOBALS['zip_value']) . "', '" . mysql_real_escape_string($GLOBALS['morning_or_evening_session_c3_value']);
			$query = $query . "', '" . mysql_real_escape_string($GLOBALS['birth_date_c3_value']) . "', '" . mysql_real_escape_string($GLOBALS['please_place_my_child_with_c3_value']) . "', '" . mysql_real_escape_string($GLOBALS['grade_completed_c3_value']);
			$query = $query . "', '" . mysql_real_escape_string($GLOBALS['who_invited_you_to_vbs_at_northwest_value']) . "', '" . mysql_real_escape_string($GLOBALS['parentguardian_name_value']) . "', '" . mysql_real_escape_string($GLOBALS['email_value']);
			$query = $query . "', '" . mysql_real_escape_string($GLOBALS['phone_value']) . "', 'n/a', 'n/a', '";
			$query = $query . mysql_real_escape_string($GLOBALS['emergency_contact_name_value']) . "', '" . mysql_real_escape_string($GLOBALS['emergency_phone_value']) . "', '" . mysql_real_escape_string($GLOBALS['emergency_contact_relationship_value']);
			$query = $query . "', '" . mysql_real_escape_string($GLOBALS['does_your_family_attend_northwest_bible_church_value']) . "', '" . mysql_real_escape_string($GLOBALS['what_church_does_your_family_call_home_value']);
			$query = $query . "', '" . mysql_real_escape_string($GLOBALS['please_explain_allergies_c3_value']) . "', '" . mysql_real_escape_string($GLOBALS['please_explain_medical_conditions_c3_value']);
			$query = $query . "', '" . mysql_real_escape_string($GLOBALS['please_explain_medications_c3_value']) . "')";
				
			$rs = mysql_query($query);			
			
			$GLOBALS['total_registrations_processed']++;
		}
		
		if ($GLOBALS['name_c4_value'] != "")
		{
			$query = "insert into tst_child_info (child_regdate, child_firstname, child_lastname, child_gender, child_address,
						child_city, child_state, child_zipcode, child_session, child_birthday, child_placewith, child_grade,
						child_guestof, child_guardianname, child_guardianemail, child_guardianhomephone, child_guardianworkphone,
						child_guardiancellphone, child_contactname, child_contactphone, child_contactrelation, child_attendNWB, 
						child_churchattending, child_allergies, child_medicalproblems, child_medications) values (";
						
			$query = $query . "'" . $submission['timestamp'] .  "', '" . mysql_real_escape_string($GLOBALS['name_c4_value']) . "', '" . mysql_real_escape_string($GLOBALS['lastname_c4_value']) . "', '" . mysql_real_escape_string($GLOBALS['gender_c4_value']) . "', '";
			$query = $query . mysql_real_escape_string($GLOBALS['address_value']) . "', '" . mysql_real_escape_string($GLOBALS['city_value']) . "', '" . mysql_real_escape_string($GLOBALS['state_value']) . "', '" . mysql_real_escape_string($GLOBALS['zip_value']) . "', '" . mysql_real_escape_string($GLOBALS['morning_or_evening_session_c4_value']);
			$query = $query . "', '" . mysql_real_escape_string($GLOBALS['birth_date_c4_value']) . "', '" . mysql_real_escape_string($GLOBALS['please_place_my_child_with_c4_value']) . "', '" . mysql_real_escape_string($GLOBALS['grade_completed_c4_value']);
			$query = $query . "', '" . mysql_real_escape_string($GLOBALS['who_invited_you_to_vbs_at_northwest_value']) . "', '" . mysql_real_escape_string($GLOBALS['parentguardian_name_value']) . "', '" . mysql_real_escape_string($GLOBALS['email_value']);
			$query = $query . "', '" . mysql_real_escape_string($GLOBALS['phone_value']) . "', 'n/a', 'n/a', '";
			$query = $query . mysql_real_escape_string($GLOBALS['emergency_contact_name_value']) . "', '" . mysql_real_escape_string($GLOBALS['emergency_phone_value']) . "', '" . mysql_real_escape_string($GLOBALS['emergency_contact_relationship_value']);
			$query = $query . "', '" . mysql_real_escape_string($GLOBALS['does_your_family_attend_northwest_bible_church_value']) . "', '" . mysql_real_escape_string($GLOBALS['what_church_does_your_family_call_home_value']);
			$query = $query . "', '" . mysql_real_escape_string($GLOBALS['please_explain_allergies_c4_value']) . "', '" . mysql_real_escape_string($GLOBALS['please_explain_medical_conditions_c4_value']);
			$query = $query . "', '" . mysql_real_escape_string($GLOBALS['please_explain_medications_c4_value']) . "')";
				
			$rs = mysql_query($query);			
			
			$GLOBALS['total_registrations_processed']++;
		}
		
		if ($GLOBALS['name_c5_value'] != "")
		{
			$query = "insert into tst_child_info (child_regdate, child_firstname, child_lastname, child_gender, child_address,
						child_city, child_state, child_zipcode, child_session, child_birthday, child_placewith, child_grade,
						child_guestof, child_guardianname, child_guardianemail, child_guardianhomephone, child_guardianworkphone,
						child_guardiancellphone, child_contactname, child_contactphone, child_contactrelation, child_attendNWB, 
						child_churchattending, child_allergies, child_medicalproblems, child_medications) values (";
						
			$query = $query . "'" . $submission['timestamp'] .  "', '" . mysql_real_escape_string($GLOBALS['name_c5_value']) . "', '" . mysql_real_escape_string($GLOBALS['lastname_c5_value']) . "', '" . mysql_real_escape_string($GLOBALS['gender_c5_value']) . "', '";
			$query = $query . mysql_real_escape_string($GLOBALS['address_value']) . "', '" . mysql_real_escape_string($GLOBALS['city_value']) . "', '" . mysql_real_escape_string($GLOBALS['state_value']) . "', '" . mysql_real_escape_string($GLOBALS['zip_value']) . "', '" . mysql_real_escape_string($GLOBALS['morning_or_evening_session_c5_value']);
			$query = $query . "', '" . mysql_real_escape_string($GLOBALS['birth_date_c5_value']) . "', '" . mysql_real_escape_string($GLOBALS['please_place_my_child_with_c5_value']) . "', '" . mysql_real_escape_string($GLOBALS['grade_completed_c5_value']);
			$query = $query . "', '" . mysql_real_escape_string($GLOBALS['who_invited_you_to_vbs_at_northwest_value']) . "', '" . mysql_real_escape_string($GLOBALS['parentguardian_name_value']) . "', '" . mysql_real_escape_string($GLOBALS['email_value']);
			$query = $query . "', '" . mysql_real_escape_string($GLOBALS['phone_value']) . "', 'n/a', 'n/a', '";
			$query = $query . mysql_real_escape_string($GLOBALS['emergency_contact_name_value']) . "', '" . mysql_real_escape_string($GLOBALS['emergency_phone_value']) . "', '" . mysql_real_escape_string($GLOBALS['emergency_contact_relationship_value']);
			$query = $query . "', '" . mysql_real_escape_string($GLOBALS['does_your_family_attend_northwest_bible_church_value']) . "', '" . mysql_real_escape_string($GLOBALS['what_church_does_your_family_call_home_value']);
			$query = $query . "', '" . mysql_real_escape_string($GLOBALS['please_explain_allergies_c5_value']) . "', '" . mysql_real_escape_string($GLOBALS['please_explain_medical_conditions_c5_value']);
			$query = $query . "', '" . mysql_real_escape_string($GLOBALS['please_explain_medications_c5_value']) . "')";
				
			$rs = mysql_query($query);			
			
			$GLOBALS['total_registrations_processed']++;
		}

		$GLOBALS['lastRegDate'] = $submission['timestamp'];
	}
	
	return (int)$res['pages'];

}



function PopulateField($fieldid, $fieldvalue)
{
	if($fieldid == $GLOBALS['number_of_your_children_being_registered_now'])
	{
		$GLOBALS['number_of_your_children_being_registered_now_value'] = $fieldvalue;
	}
	
	elseif ($fieldid == $GLOBALS['parentguardian_name'])
	{
		$GLOBALS['parentguardian_name_value'] = trim($fieldvalue);
	}
	elseif ($fieldid == $GLOBALS['email'])
	{
		$GLOBALS['email_value'] = trim($fieldvalue);
	}
	elseif ($fieldid == $GLOBALS['address'])
	{
		$address = "";
		$city = "";
		$state = "";
		$zip = "";
			
		$len = strlen($fieldvalue);
		
		//get zip
		$zip = trim(substr($fieldvalue, $len - 5, 5));
		
		//get state
		$state = trim(substr($fieldvalue, $len - 8, 2));
		
		//get city and address
		$temp = substr($fieldvalue, 0, $len - 10);
		$tokens = explode("\n", $temp);
		$address = trim($tokens[0]);
		$city = trim($tokens[count($tokens) - 1]);
		
		$GLOBALS['address_value'] = $address;
		$GLOBALS['city_value'] = $city;
		$GLOBALS['state_value'] = $state;
		$GLOBALS['zip_value'] = $zip;
	}
	elseif ($fieldid == $GLOBALS['phone'])
	{
		$phone = str_replace(" ", "", $fieldvalue);
		$phone = str_replace("(", "", $phone);
		$phone = str_replace(")", "", $phone);
		$phone = str_replace("-", "", $phone);
		$GLOBALS['phone_value'] = trim($phone);
	}
	elseif ($fieldid == $GLOBALS['relationship_to_children_being_registered'])
	{
		$GLOBALS['relationship_to_children_being_registered_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['does_your_family_attend_northwest_bible_church'])
	{
		if(strtolower($fieldvalue) == "no")
		{
			$GLOBALS['does_your_family_attend_northwest_bible_church_value'] = 0;
		}
		else
		{
			$GLOBALS['does_your_family_attend_northwest_bible_church_value'] = 1;
		}
	}
	elseif ($fieldid == $GLOBALS['what_church_does_your_family_call_home'])
	{
		$GLOBALS['what_church_does_your_family_call_home_value'] = trim($fieldvalue);
	}
	elseif ($fieldid == $GLOBALS['who_invited_you_to_vbs_at_northwest'])
	{
		$GLOBALS['who_invited_you_to_vbs_at_northwest_value'] = trim($fieldvalue);
	}
	elseif ($fieldid == $GLOBALS['emergency_contact_name'])
	{
		$GLOBALS['emergency_contact_name_value'] = trim($fieldvalue);
	}
	elseif ($fieldid == $GLOBALS['emergency_contact_phone'])
	{
		$phone = str_replace(" ", "", $fieldvalue);
		$phone = str_replace("(", "", $phone);
		$phone = str_replace(")", "", $phone);
		$phone = str_replace("-", "", $phone);
		$GLOBALS['emergency_phone_value'] = $phone;
	}
	elseif ($fieldid == $GLOBALS['emergency_contact_relationship'])
	{
		$GLOBALS['emergency_contact_relationship_value'] = trim($fieldvalue);
	}
	elseif ($fieldid == $GLOBALS['morning_or_evening_session_c1'])
	{
		$sessionString = substr(strtolower($fieldvalue), 0, 7);
		if($sessionString == "morning")
		{
			$GLOBALS['morning_or_evening_session_c1_value'] = 1;
		}
		else
		{
			$GLOBALS['morning_or_evening_session_c1_value'] = 2;
		}	
	}
	elseif ($fieldid == $GLOBALS['name_c1'])
	{
		$firstspaceindex = strpos($fieldvalue, " ");
		$firstname = substr($fieldvalue, 0, $firstspaceindex);
		$lastname = substr($fieldvalue, $firstspaceindex + 1, strlen($fieldvalue) - $firstspaceindex + 1);
		$GLOBALS['lastname_c1_value'] = trim($lastname);
		$GLOBALS['name_c1_value'] = trim($firstname);
	}
	elseif ($fieldid == $GLOBALS['gender_c1'])
	{
		$genderString = $fieldvalue;
		if(strtolower($genderString) == "male")
		{
			$GLOBALS['gender_c1_value'] = 1;
		}
		else
		{
			$GLOBALS['gender_c1_value'] = 0;
		}
	}
	elseif ($fieldid == $GLOBALS['birth_date_c1'])
	{
		$bDate = new DateTime($fieldvalue);
		$GLOBALS['birth_date_c1_value'] = $bDate->format('Y-m-d');
	}
	elseif ($fieldid == $GLOBALS['grade_completed_c1'])
	{
		$GLOBALS['grade_completed_c1_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['does_this_child_have_any_allergies_c1'])
	{
		$GLOBALS['does_this_child_have_any_allergies_c1_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['please_explain_allergies_c1'])
	{
		$GLOBALS['please_explain_allergies_c1_value'] = trim($fieldvalue);
	}
	elseif ($fieldid == $GLOBALS['does_this_child_have_any_medical_conditions_c1'])
	{
		$GLOBALS['does_this_child_have_any_medical_conditions_c1_value'] = trim($fieldvalue);
	}
	elseif ($fieldid == $GLOBALS['please_explain_medical_conditions_c1'])
	{
		$GLOBALS['please_explain_medical_conditions_c1_value'] = trim($fieldvalue);
	}
	elseif ($fieldid == $GLOBALS['is_this_child_taking_any_medications_c1'])
	{
		$GLOBALS['is_this_child_taking_any_medications_c1_value'] = trim($fieldvalue);
	}
	elseif ($fieldid == $GLOBALS['please_explain_medications_c1'])
	{
		$GLOBALS['please_explain_medications_c1_value'] = trim($fieldvalue);
	}
	elseif ($fieldid == $GLOBALS['please_place_my_child_with_c1'])
	{
		$GLOBALS['please_place_my_child_with_c1_value'] = trim($fieldvalue);
	}
	elseif ($fieldid == $GLOBALS['morning_or_evening_session_c2'])
	{
		$sessionString = substr(strtolower($fieldvalue), 0, 7);
		if($sessionString == "morning")
		{
			$GLOBALS['morning_or_evening_session_c2_value'] = 1;
		}
		else
		{
			$GLOBALS['morning_or_evening_session_c2_value'] = 2;
		}	
	}
	elseif ($fieldid == $GLOBALS['name_c2'])
	{
		$firstspaceindex = strpos($fieldvalue, " ");
		$firstname = substr($fieldvalue, 0, $firstspaceindex);
		$lastname = substr($fieldvalue, $firstspaceindex + 1, strlen($fieldvalue) - $firstspaceindex + 1);
		$GLOBALS['lastname_c2_value'] = trim($lastname);
		$GLOBALS['name_c2_value'] = trim($firstname);
	}
	elseif ($fieldid == $GLOBALS['gender_c2'])
	{
		$genderString = $fieldvalue;
		if(strtolower($genderString) == "male")
		{
			$GLOBALS['gender_c2_value'] = 1;
		}
		else
		{
			$GLOBALS['gender_c2_value'] = 0;
		}
	}
	elseif ($fieldid == $GLOBALS['birth_date_c2'])
	{
		$bDate = new DateTime($fieldvalue);
		$GLOBALS['birth_date_c2_value'] = $bDate->format('Y-m-d');
	}
	elseif ($fieldid == $GLOBALS['grade_completed_c2'])
	{
		$GLOBALS['grade_completed_c2_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['does_this_child_have_any_allergies_c2'])
	{
		$GLOBALS['does_this_child_have_any_allergies_c2_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['please_explain_allergies_c2'])
	{
		$GLOBALS['please_explain_allergies_c2_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['does_this_child_have_any_medical_conditions_c2'])
	{
		$GLOBALS['does_this_child_have_any_medical_conditions_c2_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['please_explain_medical_conditions_c2'])
	{
		$GLOBALS['please_explain_medical_conditions_c2_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['is_this_child_taking_any_medications_c2'])
	{
		$GLOBALS['is_this_child_taking_any_medications_c2_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['please_explain_medications_c2'])
	{
		$GLOBALS['please_explain_medications_c2_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['please_place_my_child_with_c2'])
	{
		$GLOBALS['please_place_my_child_with_c2_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['morning_or_evening_session_c3'])
	{
		$sessionString = substr(strtolower($fieldvalue), 0, 7);
		if($sessionString == "morning")
		{
			$GLOBALS['morning_or_evening_session_c3_value'] = 1;
		}
		else
		{
			$GLOBALS['morning_or_evening_session_c3_value'] = 2;
		}	
	}
	elseif ($fieldid == $GLOBALS['name_c3'])
	{
		$firstspaceindex = strpos($fieldvalue, " ");
		$firstname = substr($fieldvalue, 0, $firstspaceindex);
		$lastname = substr($fieldvalue, $firstspaceindex + 1, strlen($fieldvalue) - $firstspaceindex + 1);
		$GLOBALS['lastname_c3_value'] = trim($lastname);
		$GLOBALS['name_c3_value'] = trim($firstname);
	}
	elseif ($fieldid == $GLOBALS['gender_c3'])
	{
		$genderString = $fieldvalue;
		if(strtolower($genderString) == "male")
		{
			$GLOBALS['gender_c3_value'] = 1;
		}
		else
		{
			$GLOBALS['gender_c3_value'] = 0;
		}
	}
	elseif ($fieldid == $GLOBALS['birth_date_c3'])
	{
		$bDate = new DateTime($fieldvalue);
		$GLOBALS['birth_date_c3_value'] = $bDate->format('Y-m-d');
	}
	elseif ($fieldid == $GLOBALS['grade_completed_c3'])
	{
		$GLOBALS['grade_completed_c3_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['does_this_child_have_any_allergies_c3'])
	{
		$GLOBALS['does_this_child_have_any_allergies_c3_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['please_explain_allergies_c3'])
	{
		$GLOBALS['please_explain_allergies_c3_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['does_this_child_have_any_medical_conditions_c3'])
	{
		$GLOBALS['does_this_child_have_any_medical_conditions_c3_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['please_explain_medical_conditions_c3'])
	{
		$GLOBALS['please_explain_medical_conditions_c3_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['is_this_child_taking_any_medications_c3'])
	{
		$GLOBALS['is_this_child_taking_any_medications_c3_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['please_explain_medications_c3'])
	{
		$GLOBALS['please_explain_medications_c3_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['please_place_my_child_with_c3'])
	{
		$GLOBALS['please_place_my_child_with_c3_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['morning_or_evening_session_c4'])
	{
		$sessionString = substr(strtolower($fieldvalue), 0, 7);
		if($sessionString == "morning")
		{
			$GLOBALS['morning_or_evening_session_c4_value'] = 1;
		}
		else
		{
			$GLOBALS['morning_or_evening_session_c4_value'] = 2;
		}	
	}
	elseif ($fieldid == $GLOBALS['name_c4'])
	{
		$firstspaceindex = strpos($fieldvalue, " ");
		$firstname = substr($fieldvalue, 0, $firstspaceindex);
		$lastname = substr($fieldvalue, $firstspaceindex + 1, strlen($fieldvalue) - $firstspaceindex + 1);
		$GLOBALS['lastname_c4_value'] = trim($lastname);
		$GLOBALS['name_c4_value'] = trim($firstname);
	}
	elseif ($fieldid == $GLOBALS['gender_c4'])
	{
		$genderString = $fieldvalue;
		if(strtolower($genderString) == "male")
		{
			$GLOBALS['gender_c4_value'] = 1;
		}
		else
		{
			$GLOBALS['gender_c4_value'] = 0;
		}
	}
	elseif ($fieldid == $GLOBALS['birth_date_c4'])
	{
		$bDate = new DateTime($fieldvalue);
		$GLOBALS['birth_date_c4_value'] = $bDate->format('Y-m-d');
	}
	elseif ($fieldid == $GLOBALS['grade_completed_c4'])
	{
		$GLOBALS['grade_completed_c4_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['does_this_child_have_any_allergies_c4'])
	{
		$GLOBALS['does_this_child_have_any_allergies_c4_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['please_explain_allergies_c4'])
	{
		$GLOBALS['please_explain_allergies_c4_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['does_this_child_have_any_medical_conditions_c4'])
	{
		$GLOBALS['does_this_child_have_any_medical_conditions_c4_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['please_explain_medical_conditions_c4'])
	{
		$GLOBALS['please_explain_medical_conditions_c4_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['is_this_child_taking_any_medications_c4'])
	{
		$GLOBALS['is_this_child_taking_any_medications_c4_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['please_explain_medications_c4'])
	{
		$GLOBALS['please_explain_medications_c4_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['please_place_my_child_with_c4'])
	{
		$GLOBALS['please_place_my_child_with_c4_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['morning_or_evening_session_c5'])
	{
		$sessionString = substr(strtolower($fieldvalue), 0, 7);
		if($sessionString == "morning")
		{
			$GLOBALS['morning_or_evening_session_c5_value'] = 1;
		}
		else
		{
			$GLOBALS['morning_or_evening_session_c5_value'] = 2;
		}	
	}
	elseif ($fieldid == $GLOBALS['name_c5'])
	{
		$firstspaceindex = strpos($fieldvalue, " ");
		$firstname = substr($fieldvalue, 0, $firstspaceindex);
		$lastname = substr($fieldvalue, $firstspaceindex + 1, strlen($fieldvalue) - $firstspaceindex + 1);
		$GLOBALS['lastname_c5_value'] = trim($lastname);
		$GLOBALS['name_c5_value'] = trim($firstname);
	}
	elseif ($fieldid == $GLOBALS['gender_c5'])
	{
		$genderString = $fieldvalue;
		if(strtolower($genderString) == "male")
		{
			$GLOBALS['gender_c5_value'] = 1;
		}
		else
		{
			$GLOBALS['gender_c5_value'] = 0;
		}
	}
	elseif ($fieldid == $GLOBALS['birth_date_c5'])
	{
		$bDate = new DateTime($fieldvalue);
		$GLOBALS['birth_date_c5_value'] = $bDate->format('Y-m-d');
	}
	elseif ($fieldid == $GLOBALS['grade_completed_c5'])
	{
		$GLOBALS['grade_completed_c5_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['does_this_child_have_any_allergies_c5'])
	{
		$GLOBALS['does_this_child_have_any_allergies_c5_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['please_explain_allergies_c5'])
	{
		$GLOBALS['please_explain_allergies_c5_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['does_this_child_have_any_medical_conditions_c5'])
	{
		$GLOBALS['does_this_child_have_any_medical_conditions_c5_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['please_explain_medical_conditions_c5'])
	{
		$GLOBALS['please_explain_medical_conditions_c5_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['is_this_child_taking_any_medications_c5'])
	{
		$GLOBALS['is_this_child_taking_any_medications_c5_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['please_explain_medications_c5'])
	{
		$GLOBALS['please_explain_medications_c5_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['please_place_my_child_with_c5'])
	{
		$GLOBALS['please_place_my_child_with_c5_value'] = $fieldvalue;
	}
	elseif ($fieldid == $GLOBALS['by_checking_this_box_you_agree_to_the_terms_and_conditions_above'])
	{
		$GLOBALS['by_checking_this_box_you_agree_to_the_terms_and_conditions_above_value'] = $fieldvalue;
	}
	
	return;
}


function InsertLastRecordTimestamp($lastRecordTimestamp)
{
	require('DBConnect2010.inc');

	$query = "insert into tst_formstack_import_log (last_imported_record_timestamp) values ('{$lastRecordTimestamp}');";
    
	$rs = mysql_query($query) or die(mysql_error());

}

function GetLastImportTimestamp()
{
	require('DBConnect2010.inc');

	$query = "select last_imported_record_timestamp from tst_formstack_import_log order by last_imported_record_timestamp desc limit 1;";
                            
	$rs = mysql_query($query);	
	$ts = mysql_result($rs, 0, 0);
	
	return $ts;
}


function ResetFieldValues()
{
	$GLOBALS['number_of_your_children_being_registered_now_value'] = "";
	$GLOBALS['parentguardian_name_value'] = "";
	$GLOBALS['email_value'] = "";
	$GLOBALS['address_value'] = "";
	$GLOBALS['city_value'] = "";
	$GLOBALS['state_value'] = "";
	$GLOBALS['zip_value'] = "";
	$GLOBALS['phone_value'] = "";
	$GLOBALS['relationship_to_children_being_registered_value'] = "";
	$GLOBALS['does_your_family_attend_northwest_bible_church_value'] = "";
	$GLOBALS['what_church_does_your_family_call_home_value'] = "";
	$GLOBALS['who_invited_you_to_vbs_at_northwest_value'] = "";
	$GLOBALS['emergency_contact_name_value'] = "";
	$GLOBALS['emergency_phone_value'] = "";
	$GLOBALS['emergency_contact_relationship_value'] = "";
	$GLOBALS['morning_or_evening_session_c1_value'] = "";
	$GLOBALS['name_c1_value'] = "";
	$GLOBALS['lastname_c1_value'] = "";
	$GLOBALS['gender_c1_value'] = "";
	$GLOBALS['birth_date_c1_value'] = "";
	$GLOBALS['grade_completed_c1_value'] = "";
	$GLOBALS['does_this_child_have_any_allergies_c1_value'] = "";
	$GLOBALS['please_explain_allergies_c1_value'] = "";
	$GLOBALS['does_this_child_have_any_medical_conditions_c1_value'] = "";
	$GLOBALS['please_explain_medical_conditions_c1_value'] = "";
	$GLOBALS['is_this_child_taking_any_medications_c1_value'] = "";
	$GLOBALS['please_explain_medications_c1_value'] = "";
	$GLOBALS['please_place_my_child_with_c1_value'] = "";
	$GLOBALS['morning_or_evening_session_c2_value'] = "";
	$GLOBALS['name_c2_value'] = "";
	$GLOBALS['lastname_c2_value'] = "";
	$GLOBALS['gender_c2_value'] = "";
	$GLOBALS['birth_date_c2_value'] = "";
	$GLOBALS['grade_completed_c2_value'] = "";
	$GLOBALS['does_this_child_have_any_allergies_c2_value'] = "";
	$GLOBALS['please_explain_allergies_c2_value'] = "";
	$GLOBALS['does_this_child_have_any_medical_conditions_c2_value'] = "";
	$GLOBALS['please_explain_medical_conditions_c2_value'] = "";
	$GLOBALS['is_this_child_taking_any_medications_c2_value'] = "";
	$GLOBALS['please_explain_medications_c2_value'] = "";
	$GLOBALS['please_place_my_child_with_c2_value'] = "";
	$GLOBALS['morning_or_evening_session_c3_value'] = "";
	$GLOBALS['name_c3_value'] = "";
	$GLOBALS['lastname_c3_value'] = "";
	$GLOBALS['gender_c3_value'] = "";
	$GLOBALS['birth_date_c3_value'] = "";
	$GLOBALS['grade_completed_c3_value'] = "";
	$GLOBALS['does_this_child_have_any_allergies_c3_value'] = "";
	$GLOBALS['please_explain_allergies_c3_value'] = "";
	$GLOBALS['does_this_child_have_any_medical_conditions_c3_value'] = "";
	$GLOBALS['please_explain_medical_conditions_c3_value'] = "";
	$GLOBALS['is_this_child_taking_any_medications_c3_value'] = "";
	$GLOBALS['please_explain_medications_c3_value'] = "";
	$GLOBALS['please_place_my_child_with_c3_value'] = "";
	$GLOBALS['morning_or_evening_session_c4_value'] = "";
	$GLOBALS['name_c4_value'] = "";
	$GLOBALS['lastname_c4_value'] = "";
	$GLOBALS['gender_c4_value'] = "";
	$GLOBALS['birth_date_c4_value'] = "";
	$GLOBALS['grade_completed_c4_value'] = "";
	$GLOBALS['does_this_child_have_any_allergies_c4_value'] = "";
	$GLOBALS['please_explain_allergies_c4_value'] = "";
	$GLOBALS['does_this_child_have_any_medical_conditions_c4_value'] = "";
	$GLOBALS['please_explain_medical_conditions_c4_value'] = "";
	$GLOBALS['is_this_child_taking_any_medications_c4_value'] = "";
	$GLOBALS['please_explain_medications_c4_value'] = "";
	$GLOBALS['please_place_my_child_with_c4_value'] = "";
	$GLOBALS['morning_or_evening_session_c5_value'] = "";
	$GLOBALS['name_c5_value'] = "";
	$GLOBALS['lastname_c5_value'] = "";
	$GLOBALS['gender_c5_value'] = "";
	$GLOBALS['birth_date_c5_value'] = "";
	$GLOBALS['grade_completed_c5_value'] = "";
	$GLOBALS['does_this_child_have_any_allergies_c5_value'] = "";
	$GLOBALS['please_explain_allergies_c5_value'] = "";
	$GLOBALS['does_this_child_have_any_medical_conditions_c5_value'] = "";
	$GLOBALS['please_explain_medical_conditions_c5_value'] = "";
	$GLOBALS['is_this_child_taking_any_medications_c5_value'] = "";
	$GLOBALS['please_explain_medications_c5_value'] = "";
	$GLOBALS['please_place_my_child_with_c5_value'] = "";
	$GLOBALS['by_checking_this_box_you_agree_to_the_terms_and_conditions_above_value'] = "";
}

?>
</body>
</html>