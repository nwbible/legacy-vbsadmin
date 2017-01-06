<html>
<head>
<title>
</title>
<style>
@import url(/templates/css/AdminTemplate_css.css);
th {
    background-color: #000;
    color: #659ed0;
}
</style>
</head>
<body>

<?php
include("DBConnect2010.inc");
include('Validation.inc');

error_reporting( error_reporting() & ~E_NOTICE );

$query1= "select count(child_id) from tst_child_info";  #Total Count
$query2= "select count(child_id) from tst_child_info where child_session = 1";  #AM
$query3= "select count(child_id) from tst_child_info where child_session = 2";  #PM


$result1=mysqli_query($conn, $query1);  #total
$result2=mysqli_query($conn, $query2);  #total AM
$result3=mysqli_query($conn, $query3);  #total PM

echo "<div top=50px; align='center'>";
echo "<table border=1 cellpadding=\"1\"><tr>";
//echo "<COLGROUP width=\"90\">";
echo "  <th><b>Total Enrollment</b></td>";
mysqli_data_seek($result1, 0);
$f2 = mysqli_fetch_assoc( $result1 );
$Tot_Count = $f2["count(child_id)"];
echo "  <th>$Tot_Count</th>";
echo "</tr>";

echo "  <th><b>Total Enrollment - AM</b></td>";
mysqli_data_seek($result2, 0);
$f2 = mysqli_fetch_assoc( $result2 );
$Tot_AM = $f2["count(child_id)"];
echo "  <th>$Tot_AM</th>";
echo "</tr>";

echo "  <th><b>Total Enrollment - PM</b></td>";
mysqli_data_seek($result3, 0);
$f2 = mysqli_fetch_assoc( $result3 );
$Tot_PM = $f2["count(child_id)"];
echo "  <th>$Tot_PM</th>";
echo "</tr>";



$vbs_session=array("AM"=> "1", "PM"=> "2");

foreach( $vbs_session as $key => $value){
    echo "  <th><b>$key Enrollment by Grade Level</b></td><td></td></tr>"; 
	echo "  </tr>";

	$query4= "SELECT tst_grade_translate.grade_id, tst_grade_translate.grade_description, count(tst_child_info.child_grade) AS num_count FROM tst_grade_translate, tst_child_info WHERE tst_child_info.child_session =$value AND (tst_grade_translate.grade_id = tst_child_info.child_grade) GROUP BY tst_child_info.child_grade";  #AM/PM session and by grade level
	
	$result4=mysqli_query($conn, $query4);  #AM/PM by grade level
	$num4=mysqli_num_rows($result4);
	$i=0;
    while ($i < $num4) {
        mysqli_data_seek($result4, $i);
        $f4 = mysqli_fetch_assoc( $result4 );
        $gr_id = $f4["grade_id"];
        $gr_desc = $f4["grade_description"];
        $enroll = $f4["num_count"];
        //$gr_id=mysqli_result($result4, $i, "tst_grade_translate.grade_id");
        //$gr_desc=mysqli_result($result4, $i, "tst_grade_translate.grade_description");
        //$enroll=mysqli_result($result4, $i, "num_count");
        echo "  <td>$gr_desc</td>";
        echo "  <td>$enroll</td>";
        echo "</tr>";
        $i++;
    }
}

/***************************************************************************************************************************************
                                             Efile vs. Paper registration count
 
 $query5="SELECT child_efile, count( child_efile ) AS num_count FROM `tst_child_info` GROUP BY child_efile ORDER BY child_efile";
 

$result5=mysql_query($query5);

echo "  <th><b>EFile vs Paper Form</b></td><td></td></tr>";


    $reg0=mysql_result($result5, 0, "num_count");  //Paper Form
	$reg1=mysql_result($result5, 1, "num_count");  //EFile Form
    echo "  <td>Paper:</td><td>$reg0</td></tr>";
    echo "  <td>EFile:</td><td>$reg1</td>";
	echo "  </tr>";

**************************************************************************************************************************************/

$query6="SELECT child_attendNWB, count( child_attendNWB ) AS num_count FROM `tst_child_info` GROUP BY child_attendNWB ORDER BY child_attendNWB";
$result6=mysqli_query($conn, $query6);
echo "  <th><b>Attend NWB vs Visitors</b></td><td></td></tr>";
    mysqli_data_seek($result6, 0);
    $f6 = mysqli_fetch_assoc( $result6 );
    $reg0 = $f6["num_count"];
    mysqli_data_seek($result6, 1);
    $f6 = mysqli_fetch_assoc( $result6 );
    $reg1 = $f6["num_count"];

    //$reg0=mysqli_result($result6, 0, "num_count");  //Visitors
	//$reg1=mysqli_result($result6, 1, "num_count");  //NWB
    echo "  <td>Attend NWB:</td><td>$reg1</td></tr>";
    echo "  <td>Are Vistors:</td><td>$reg0</td>";
	echo "  </tr>";
echo "</table>";
echo "</div>";

mysqli_close($conn);

?>

</body>
</html>