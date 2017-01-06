<html>
	<head>
		<title>
			Rosters
		</title>
		<style type="text/css">
        @import url(/templates/css/AdminTemplate_css.css);
        @import url(/templates/css/AdminPrint_css.css) print;
		div.page
            {
                page-break-after: always;
                page-break-inside: avoid;
            }
        </style>
	</head>
<body>

<?php
//This page takes the information from the Child Search form 
//and looks for a child by that last name 
require('DBConnect2010.inc');
include ('Validation.inc');

error_reporting( error_reporting() & ~E_NOTICE );
/********************************************************************************************
*                                    MAIN                                                   *
********************************************************************************************/

  
print createsearchform();

if (isset($_POST['gradesearch'])) //A Child search Grade Level has been activated
{
  print gradesearchresults();
}  
elseif ($_POST['ClassListing'])
{
  print ClassList();
}
elseif ($_POST['ConsentListing'])
{
  print ConsentList();
}



print $displayresults;
/********************************************************************************************
*                                  END MAIN                                                   *
********************************************************************************************/

/********************************************************************************************
*                                    FUNCTIONS                                              *
********************************************************************************************/



function createsearchform()
{
  $displaysearch  ="";
  $displaysearch .= "<form action='$_SERVER[PHP_SELF]' method='post' name='childsearch'>";
  $displaysearch .= "<table border='0' cellpadding='2'>";
  $displaysearch .= "<tr>";
  $displaysearch .= "<td><input type='submit' class='button' name='gradesearch' value='Class Counts'></td>";
  $displaysearch .= "</tr>";
  $displaysearch .= "<tr><td align='center'><input type='submit' class='button' name='ClassListing' value='Class Listings'></td></tr>";
  $displaysearch .= "<tr><td align='center'><input type='submit' class='button' name='ConsentListing' value='Missing Consent Forms'></td></tr>";
  //$displaysearch .= "<tr><td style='text-align:center' colspan='2'>";
  //$displaysearch .= "<input type='radio' name='session' value='1'>AM";
  //$displaysearch .= "<input type='radio' name='session' value='2'>PM";
  //$displaysearch .= "</td></tr>
  $displaysearch .="</table></form>";
  
  return $displaysearch;
}


function gradesearchresults()
{
	require('DBConnect2010.inc');
    $WarnLimit = 20;
	$query1 = "SELECT * FROM `tst_class_translate` where `tst_class_session` = \"AM\" order by `tst_class_session`,`class_description` ";  //Get list of Classes in order
	$result1 = mysqli_query($conn, $query1);
	$num1=mysqli_num_rows($result1);
	
	
	echo "<table border='01' cellpadding='2' width=30% ><tr>";
	echo "<th>AM Classes</th><th> </th></tr>";
	
	$i=0;
	while ( $i < $num1 ) {
	
	  mysqli_data_seek($result1, $i);
    $f = mysqli_fetch_assoc( $result1 );
    $classid = $f[ "class_id"];
    $classnm = $f[ "class_description"];
		
	  $query2="select count(child_id) from tst_child_info where child_classassignment = $classid";
	  $result2 = mysqli_query($conn, $query2);
    mysqli_data_seek($result2, $i);
    $f2 = mysqli_fetch_assoc( $result2 );
    $Cl_Count = $f2["count(child_id)"];
	  
	  if ( $Cl_Count > $WarnLimit ) { 
	    $BG="#FF0000";  //red  This is warning
		$FG="#FFFFFF";  //white
	  }
	  else { 
		$BG="#8ed3ff";  //white  This is normal or OK limit
		$FG="#000000";  //black
	  }
		
	  echo "  <th bgcolor=$BG><font color=$FG><b>$classnm</b></font></td>";
	  echo "  <td bgcolor=$BG><font color=$FG>$Cl_Count</font></td>";
	  echo "</tr>";
	
	  $i++;
	}
	

	$query1 = "SELECT * FROM `tst_class_translate` where `tst_class_session` = \"PM\" order by `tst_class_session`,`class_description` ";  //Get list of Classes in order
	$result1 = mysqli_query($conn, $query1);
	$num1=mysqli_num_rows($result1);
	
	
	echo "<table border=0 cellpadding=\"2\" width=30% ><tr>";
	echo "<th>PM Classes</th><th> </th></tr>";
	
	$i=0;
	while ( $i < $num1 ) {
	  
    mysqli_data_seek($result1, $i);
    $f = mysqli_fetch_assoc( $result1 );
    $classid = $f[ "class_id"];
    $classnm = $f[ "class_description"];
		
	  $query2="select count(child_id) from tst_child_info where child_classassignment = $classid";
	  $result2 = mysqli_query($conn, $query2);
    mysqli_data_seek($result2, $i);
    $f2 = mysqli_fetch_assoc( $result2 );
    $Cl_Count = $f2[ "count(child_id)" ];
	  
	  if ( $Cl_Count > $WarnLimit ) { 
	    $BG="#FF0000";  //red  This is warning
		$FG="#000000";  //white
	  }
	  else { 
		$BG="#8ed3ff";  //white  This is normal or OK limit
		$FG="#000000";  //black
	  }
		
	  echo "  <th bgcolor=$BG><font color=$FG><b>$classnm</b></font></td>";
	  echo "  <td bgcolor=$BG><font color=$FG>$Cl_Count</font></td>";
	  echo "</tr>";
	
	  $i++;
	}

		
	echo "</table></form>";
	
}

function ClassList()
{
  $classes = translate('tst_class_translate', 'class_id', 'class_description', 'class_description');
  
  $displayresults  = "";
  $displayresults .= "<div class='page'></div>";

  foreach($classes as $key => $value)
  {
  require('DBConnect2010.inc');

  $query = "SELECT child_id, child_lastname, child_firstname, child_classassignment, child_medicalrelease, child_photorelease  
              FROM tst_child_info
              WHERE child_classassignment = " . $key  . "
              ORDER BY child_lastname, child_firstname";              
  $rs = mysqli_query($conn, $query);
  
  $displayresults .= "<div class='page'><table border='01' cellpadding='2' width=50%>";
  $displayresults .= "<caption>" . $value . "</caption>";
  $displayresults .= "<tr>
                          <th width=50%>Child Name</th><th width=25%>Medical Release</th><th width=25%>Photo Release</th>
					  </tr>";

  while ($resultVars = mysqli_fetch_array($rs, MYSQLI_ASSOC)) 
  {

    $displayresults .= "<tr>";
    $displayresults .= "<td width=50%>";
    //$displayresults .= "<a href='Modify_Child.php?id=" . $resultVars[child_id] . "'>";  <--- Original Line
    $displayresults .= $resultVars['child_lastname'] . ", " . $resultVars['child_firstname'];
    $displayresults .= "</a></td>";
	$displayresults .= "<td width=25%>";
		if ($resultVars['child_medicalrelease']==2) 
		{ $displayresults .="Consent";}
		elseif ($resultVars['child_medicalrelease']==1)
		{ $displayresults .="No Consent";}
		else
		{ $displayresults .="Not Turned In";}
	$displayresults .= "</td>";

	$displayresults .= "<td width=25%>";
		if ($resultVars['child_photorelease']==2) 
		{ $displayresults .="Consent";}
		elseif ($resultVars['child_photorelease']==1)
		{ $displayresults .="No Consent";}
		else
		{ $displayresults .="Not Turned In";}
	$displayresults .= "</td>";
    $displayresults .= "</tr>";
        
  }//end $resultVars while
  $displayresults .= "</table></form>";
  /*$displayresults .= "<B>" . mysql_num_rows($rs) . " children with medical/photo release forms.</B><BR>";
  $displayresults .= "(Y = Consent, N = No Consent, Blank = Not Turned In)<BR><BR><HR>";   #<-- Original line
  $displayresults .= "(Y = Consent, N = No Consent, Blank = Not Turned In)<BR><BR>";  #<--- Original line*/
  $displayresults .= "<BR></div>";
  }//end foreach loop
  
  mysqli_close($conn);
  return $displayresults;

}

function ConsentList()
{
  $classes = translate('tst_class_translate', 'class_id', 'class_description', 'class_description');
  
  $displayresults  = "";
  $displayresults .= "<div class='page'></div>";

  foreach($classes as $key => $value)
  {
  require('DBConnect2010.inc');

  $query = "SELECT child_id, child_lastname, child_firstname, child_classassignment, child_medicalrelease, child_photorelease  
              FROM tst_child_info
              WHERE child_classassignment = " . $key  . " AND (child_medicalrelease < 1 OR child_photorelease < 1)
              ORDER BY child_lastname, child_firstname";              
  $rs = mysqli_query($conn, $query);
  //print "<br>$query</br>";
  
  $displayresults .= "<div class='page'><table border='01' cellpadding='2' width=50%>";
  $displayresults .= "<caption>" . $value . "</caption>";
  $displayresults .= "<tr>
                          <th width=50%>Child Name</th><th width=25%>Medical Release</th><th width=25%>Photo Release</th>
					  </tr>";

  while ($resultVars = mysqli_fetch_array($rs, MYSQLI_ASSOC)) 
  {

    $displayresults .= "<tr>";
    $displayresults .= "<td width=50%>";
    //$displayresults .= "<a href='Modify_Child.php?id=" . $resultVars[child_id] . "'>";  <--- Original Line
    $displayresults .= $resultVars['child_lastname'] . ", " . $resultVars['child_firstname'];
    $displayresults .= "</a></td>";
	$displayresults .= "<td width=25%>";
		if ($resultVars['child_medicalrelease']==2) 
		{ $displayresults .="Consent";}
		elseif ($resultVars['child_medicalrelease']==1)
		{ $displayresults .="No Consent";}
		else
		{ $displayresults .="Not Turned In";}
	$displayresults .= "</td>";

	$displayresults .= "<td width=25%>";
		if ($resultVars['child_photorelease']==2) 
		{ $displayresults .="Consent";}
		elseif ($resultVars['child_photorelease']==1)
		{ $displayresults .="No Consent";}
		else
		{ $displayresults .="Not Turned In";}
	$displayresults .= "</td>";
    $displayresults .= "</tr>";
        
  }//end $resultVars while
  $displayresults .= "</table></form>";
  /*$displayresults .= "<B>" . mysql_num_rows($rs) . " children with medical/photo release forms.</B><BR>";
  $displayresults .= "(Y = Consent, N = No Consent, Blank = Not Turned In)<BR><BR><HR>";   #<-- Original line
  $displayresults .= "(Y = Consent, N = No Consent, Blank = Not Turned In)<BR><BR>";  #<--- Original line*/
  $displayresults .= "<BR></div>";
  }//end foreach loop
  
  mysqli_close($conn);
  return $displayresults;

}

function consent($var)
{
  switch($var)
  {
    case 0:
      return $value = '';
      break;
      
    case 1:
      return "N";
      break;
      
    case 2:
      return "Y";
      break;
      
  }
}

?>