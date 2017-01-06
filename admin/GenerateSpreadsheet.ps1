$MySQLAdminUserName = 'root'
$MySQLAdminPassword = 'password'
$MySQLDatabase = 'INSERT DATABASE NAME HERE'
$MySQLHost = 'localhost'
$ConnectionString = "server=" + $MySQLHost + ";port=3306;uid=" + $MySQLAdminUserName + ";pwd=" + $MySQLAdminPassword + ";database="+$MySQLDatabase
$ClassQuery = 'SELECT class_id, class_description FROM tst_class_translate ORDER BY class_description'

Try {
  [void][System.Reflection.Assembly]::LoadWithPartialName("MySql.Data")
  $Connection = New-Object MySql.Data.MySqlClient.MySqlConnection
  $Connection.ConnectionString = $ConnectionString
  $Connection.Open()

  $Command = New-Object MySql.Data.MySqlClient.MySqlCommand($ClassQuery, $Connection)
  $DataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($Command)
  $DataSet = New-Object System.Data.DataSet
  $RecordCount = $DataAdapter.Fill($DataSet, "data")
  
  $ExcelObject = new-Object -comobject Excel.Application  
  $ExcelObject.visible = $True 
  $ExcelObject.DisplayAlerts =$false
  $ActiveWorkbook = $ExcelObject.Workbooks.Open(".\ClassExport.xlsx")


  
  
  $count = 0
  
  foreach($Class in $DataSet.Tables[0])
  {
	$classId = $Class.class_id
	$className = $Class.class_description
	write-host $classId " : " $className
	$count = $count + 1
	$ActiveWorksheet = $ActiveWorkbook.Worksheets.Item(1)
	$ActiveWorksheet.Cells.Item(1,$count) = $className

	
	$Command.CommandText="SELECT child_id, child_lastname, child_firstname, child_classassignment FROM tst_child_info WHERE child_classassignment = " + $classId + " ORDER BY child_lastname, child_firstname"
	
	$StudentDataSet = New-Object System.Data.DataSet
	$StudentRecordCount = $DataAdapter.Fill($StudentDataSet, "data")
	
	foreach($Student in $StudentDataSet.Tables[0])
	{
		write-host $Student.child_lastname "," $Student.child_firstname
	}
  }
  
  $ActiveWorkbook.Close($False)
  $ActiveWorkbook.Save()
  $ExcelObject.Quit()
  
}

Catch {
  Write-Host "ERROR : Unable to run query : $query `n$Error[0]"
 }

Finally {
  $Connection.Close()
  }
 