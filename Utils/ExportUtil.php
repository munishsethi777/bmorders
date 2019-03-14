<?php
require_once($ConstantsArray['dbServerUrl'] ."Utils/DateUtil.php");
require_once $ConstantsArray['dbServerUrl'] . 'PHPExcel/IOFactory.php';
class ExportUtil{
	public static function exportCustomers($customers){
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Admin")
		->setLastModifiedBy("Admin")
		->setTitle("customers")
		->setSubject("customers")
		->setDescription("customers")
		->setKeywords("office 2007 openxml php")
		->setCategory("Report");
		$alphas = range('A', 'Z');
		$rowCount = 1;
		$count = 1;
		$i = 0;
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Title");
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Email");
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Phone");
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Contact Person");
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Mobile");
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Address1");
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Address2");
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "City");
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "State");
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Zip Code");
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Discount");
		
		$count = 2;
		$i = 0;
		foreach($customers as $customer){
		
			$colName = $alphas[$i++]. $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $customer->getTitle());
				
			$colName = $alphas[$i++]. $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $customer->getEmail());
	
			$colName = $alphas[$i++]. $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $customer->getPhone());
			
			$colName = $alphas[$i++]. $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $customer->getContactPerson());
	
			$colName = $alphas[$i++]. $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $customer->getMobile());
			
			$colName = $alphas[$i++]. $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $customer->getAddress1());
			
			$colName = $alphas[$i++]. $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $customer->getAddress2());
			
			$colName = $alphas[$i++]. $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $customer->getCity());
			
			$colName = $alphas[$i++]. $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $customer->getState());
			
			$colName = $alphas[$i++]. $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $customer->getZip());
			
			$colName = $alphas[$i++]. $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $customer->getDiscount());
			
			$count++;
			$i = 0;
		}
		$objPHPExcel->getActiveSheet()->setTitle("Report");
			
			
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
			
			
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Customers"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
			
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
		ob_end_clean();
		$objWriter->save('php://output');
	}
	
	
	public static function exportProducts($products){
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Admin")
		->setLastModifiedBy("Admin")
		->setTitle("products")
		->setSubject("products")
		->setDescription("products")
		->setKeywords("office 2007 openxml php")
		->setCategory("Report");
		$alphas = range('A', 'Z');
		$rowCount = 1;
		$count = 1;
		$i = 0;
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Title");
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Brand");
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Category");
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Flavour");
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Stock");
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Qty");
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Msr Type");
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Price");
		$count = 2;
		$i = 0;
		foreach($products as $product){
		
			$colName = $alphas[$i++]. $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $product["title"]);
				
			$colName = $alphas[$i++]. $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $product["brand"]);
	
			$colName = $alphas[$i++]. $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $product["category"]);
			
			$colName = $alphas[$i++]. $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $product["flavour"]);
	
			$colName = $alphas[$i++]. $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName,  $product["stock"]);
			
			$colName = $alphas[$i++]. $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $product["quantity"]);
			
			$colName = $alphas[$i++]. $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName,  $product["measuringunit"]);
			
			$colName = $alphas[$i++]. $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName,  $product["price"]);
			$count++;
			$i = 0;
		}
		$objPHPExcel->getActiveSheet()->setTitle("Report");
			
			
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
			
			
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Products"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
			
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
		ob_end_clean();
		$objWriter->save('php://output');
	}
	
	
	
	public static function exportExpenseLogs($expenseLogs){
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Admin")
		->setLastModifiedBy("Admin")
		->setTitle("Cashbook")
		->setSubject("Cashbook")
		->setDescription("Cashbook")
		->setKeywords("office 2007 openxml php")
		->setCategory("Report");
		$alphas = range('A', 'Z');
		$rowCount = 1;
		$count = 1;
		$i = 0;
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Date");
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Amount");
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Title");
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Description");
		$count = 2;
		$i = 0;
		foreach($expenseLogs as $expenseLog){
			$colName = $alphas[$i++]. $count;
			$createOn = DateUtil::StringToDateByGivenFormat("Y-m-d H:i:s",$expenseLog->getCreatedOn());
			$createOnStr = $createOn->format("d-m-Y h:i:s a");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $createOnStr);
				
			$colName = $alphas[$i++]. $count;
			$amount = number_format($expenseLog->getAmount(),2,'.','');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $amount);
	
			$colName = $alphas[$i++]. $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $expenseLog->getTitle());
	
			$colName = $alphas[$i++]. $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $expenseLog->getDescription());
			$count++;
			$i = 0;
		}
		$objPHPExcel->getActiveSheet()->setTitle("Report");
			
			
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
			
			
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Cashbook"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
			
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
		ob_end_clean();
		$objWriter->save('php://output');
	}
}