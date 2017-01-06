<?php

include ('Validation.inc');
include ('Default.inc');

$ctr=0;

if ($import = file('Classroom-assignments.csv')) //Reading file into array
{
    
	foreach ($import as $impline => $import)
		{
		$import = ereg_replace("\"","",$import);
		$import = ereg_replace("\n","",$import);
		$importfields=explode(",",$import);
        
        require ('DBConnect2010.inc');
        $class = mysql_real_escape_string($importfields[0]);
        
        $namefields = explode(" ",$importfields[3]);
               
        $classquery = "SELECT * FROM  `tst_class_translate` WHERE  `class_description` =  '$class'";
        $rs = mysql_query($classquery) or die(mysql_error());

        $classVars = mysql_fetch_array($rs, MYSQL_ASSOC);
        
        $fname = mysql_real_escape_string($namefields[0]);
        $lname = mysql_real_escape_string($namefields[1]);
        $query = "UPDATE  `tst_child_info` SET  `child_classassignment` =  '" . $classVars[class_id] . "' WHERE  `child_firstname` = '" . trim($fname) . "' AND `child_lastname` = '" . trim($lname) . "'";
$ctr++;
print $query . "<br>";
        
        $urs = mysql_query($query) or die(mysql_error());
                
        

        }
        
        
}

print $ctr . "<br>";

?>