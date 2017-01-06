<?php
include('Validation.inc');
ini_set('upload_tmp_dir','tmp');

function SaveViaTempFile($objWriter){
    $filePath = 'temp/' . rand(0, getrandmax()) . rand(0, getrandmax()) . ".tmp";
    $objWriter->save($filePath);
    readfile($filePath);
    unlink($filePath);
    exit;
}

/** Include PHPExcel */
require_once('Classes/PHPExcel.php');

// Create an instance
$xlsfile = new PHPExcel();
#$sheet = $xlsfile->getSheet(0);


#$sheet->setTitle('Simple');
#$sheet->setCellValue('A1','A1');
#$sheet->setCellValue('B2','B2');


$classes = translate('tst_class_translate', 'class_id', 'class_description', 'class_description');

$counter=0;
foreach($classes as $key => $value) {
    require('DBConnect2010.inc');

    $query = "SELECT child_id, child_lastname, child_firstname, child_classassignment
                FROM tst_child_info
                WHERE child_classassignment = " . $key  . "
                ORDER BY child_lastname, child_firstname";
    $rs = mysqli_query($conn, $query);

    $sheetname = substr($value,0,31);

    if ($counter > 0) {
    // Add worksheets for each class to the file
       $xlsfile->createSheet();
       $sheet = $xlsfile->setActiveSheetIndex($counter);
       $sheet->setTitle("$sheetname");
       $sheet->setCellValue('A1','Child Name');
       $sheet->setCellValue('B1','Monday');
       $sheet->setCellValue('C1','Tuesday');
       $sheet->setCellValue('D1','Wednesday');
       $sheet->setCellValue('E1','Thursday');
       $sheet->setCellValue('F1','Friday');
       $sheet->getStyle('A1:F1')->getFont()->setBold(true);
       $sheet->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    } else {
       $sheet = $xlsfile->setActiveSheetIndex(0);
       $sheet->setCellValue('A1','Child Name');
       $sheet->setCellValue('B1','Monday');
       $sheet->setCellValue('C1','Tuesday');
       $sheet->setCellValue('D1','Wednesday');
       $sheet->setCellValue('E1','Thursday');
       $sheet->setCellValue('F1','Friday');
       $sheet->setTitle("$sheetname");
       $sheet->getStyle('A1:F1')->getFont()->setBold(true);
       $sheet->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    }

    $i=1;
      while ($resultVars = mysqli_fetch_array($rs, MYSQL_ASSOC))
      {
        $childname = $resultVars['child_lastname'] . ", " . $resultVars['child_firstname'];
        $sheet->setCellValueByColumnAndRow(0,$i+1,$childname);
        $i++;
      }//end $resultVars while

    $xlsfile->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);

    foreach(range('B','F') as $columnID) {
        $xlsfile->getActiveSheet()->getColumnDimension($columnID)
        ->setWidth('12');
    }

    $counter++;
}//end foreach loop


mysqli_close($conn);

$xlsfile->setActiveSheetIndex(0);

$writer = PHPExcel_IOFactory::createWriter($xlsfile, 'Excel2007');
// We'll be outputting an excel file
header('Content-type: application/vnd.ms-excel');

// It will be called file.xls
header('Content-Disposition: attachment; filename="2016_VBS.xlsx"');

#$writer->save('php://output');
SaveViaTempFile($writer);

?>