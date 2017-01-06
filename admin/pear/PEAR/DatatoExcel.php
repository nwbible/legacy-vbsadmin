<?php
include('Validation.inc');
$dir = "";
 // Include PEAR::Spreadsheet_Excel_Writer
 require_once ("Spreadsheet/Excel/Writer.php");

// Create an instance
$xls =& new Spreadsheet_Excel_Writer();

// Send HTTP headers to tell the browser what's coming
$xls->send("test.xls");
$xls->setTempDir ('/var/www/vhosts/nwbible.org/subdomains/vbs/httpdocs/admin/temp');


/*
 // Write some numbers
 for ( $i=0;$i<11;$i++ ) {
   // Use PHP's decbin() function to convert integer to binary
   $sheet->write($i,0,decbin($i));
 }
*/
 // Finish the spreadsheet, dumping it to the browser


  $classes = translate('tst_class_translate', 'class_id', 'class_description', 'class_description');


  foreach($classes as $key => $value)
  {
require('DBConnect2010.inc');

  $query = "SELECT child_id, child_lastname, child_firstname, child_classassignment
              FROM tst_child_info
              WHERE child_classassignment = " . $key  . "
              ORDER BY child_lastname, child_firstname";
  $rs = mysql_query($query);

// Add a worksheet to the file, returning an object to add data to
 $sheetname = $value;
 $sheet =& $xls->addWorksheet($sheetname);
 $sheet->write(0,0,'Child Name');


$i=1;
  while ($resultVars = mysql_fetch_array($rs, MYSQL_ASSOC))
  {
    $childname = $resultVars[child_lastname] . ", " . $resultVars[child_firstname];
    $sheet->write($i,0,$childname);
    $i++;
  }//end $resultVars while
  }//end foreach loop

  mysql_close();

 $xls->close();

?>