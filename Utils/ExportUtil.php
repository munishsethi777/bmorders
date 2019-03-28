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
		$objPHPExcel->setActiveSheetIndex(0)->getStyle('B2:B'.count($expenseLogs))->getNumberFormat()->setFormatCode('#,##0.00');
		foreach($expenseLogs as $expenseLog){
			$colName = $alphas[$i++]. $count;
			$createOn = DateUtil::StringToDateByGivenFormat("Y-m-d H:i:s",$expenseLog->getCreatedOn());
			$createOnStr = $createOn->format("d-m-Y h:i:s a");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $createOnStr);
				
			$colName = $alphas[$i++]. $count;
			//$amount = number_format($expenseLog->getAmount(),2,'.','');
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $expenseLog->getAmount());
	
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
	
	public static function exportOrders($orders){
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Admin")
		->setLastModifiedBy("Admin")
		->setTitle("Orders")
		->setSubject("Orders")
		->setDescription("Orders")
		->setKeywords("office 2007 openxml php")
		->setCategory("Report");
		$alphas = range('A', 'Z');
		$rowCount = 1;
		$count = 1;
		$i = 0;
		
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "#");
		$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
				);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Dated");
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Customer");
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Sr. No.");
		$objPHPExcel->setActiveSheetIndex(0)->getStyle($colName)->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
				);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Product");
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Qty");
		$objPHPExcel->setActiveSheetIndex(0)->getStyle($colName)->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
				);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Rate");
		$objPHPExcel->setActiveSheetIndex(0)->getStyle($colName)->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
				);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Amount");
		$objPHPExcel->setActiveSheetIndex(0)->getStyle($colName)->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
				);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Discount");
		$objPHPExcel->setActiveSheetIndex(0)->getStyle($colName)->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
				);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Discount Amount");
		$objPHPExcel->setActiveSheetIndex(0)->getStyle($colName)->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
				);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Total");
		$objPHPExcel->setActiveSheetIndex(0)->getStyle($colName)->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
				);
		
		
		$count = 2;
		$i = 0;
		$totalQty = 0;
		$grandTotal = 0;
		$totalDiscount = 0;
		$totalNetAmount = 0;
		foreach($orders as $orderDetail){
			$index = 0;
			foreach ($orderDetail as $order){
				
				if($index == 0){
					
					$colName = $alphas[$i++]. $count;
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $order["seq"]);
				
						$colName = $alphas[$i++]. $count;
						$createOn = DateUtil::StringToDateByGivenFormat("Y-m-d H:i:s",$order["createdon"]);
						$createOnStr = $createOn->format("d-m-Y h:i:s a");
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $createOnStr);
						
						$colName = $alphas[$i++]. $count;
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $order["customer"]);
					}	
					$srNo = $index+1;
					$colName = $alphas[$i++]. $count;
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $srNo);
					
					$colName = $alphas[$i++]. $count;
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $order["product"]);
						
					$colName = $alphas[$i++]. $count;
					$qty = $order["quantity"];
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $qty);
					$totalQty += $qty;
					$colName = $alphas[$i++]. $count;
					$price = $order["price"];
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName,$price);
					
					$colName = $alphas[$i++]. $count;
					$amount = $price * $qty;
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName,$amount);
					
					$colName = $alphas[$i++]. $count;
					$discountPercent = $order["discountpercent"];
					$discount = 0;
					$netAmount = $amount;
					if(!empty($discountPercent)){
						$discount = ($discountPercent / 100) * $amount;
						$netAmount = $amount - $discount;
					}
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $discountPercent ."%");
					$objPHPExcel->setActiveSheetIndex(0)->getStyle($colName)->getAlignment()->applyFromArray(
							array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
							);
						
					$colName = $alphas[$i++]. $count;
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $discount);
					$totalDiscount += $discount;
					$colName = $alphas[$i++]. $count;
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $netAmount);
					$totalNetAmount += $netAmount;
					$count++;
					$index++;
					$i = 3;
			}
			$i = 10;
			$colName = $alphas[$i++]. $count;
			$totaAmount = $order["totalamount"];
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $totaAmount);
			$objPHPExcel->getActiveSheet()->getStyle($colName)->getFont()->setBold(true);
			$grandTotal += $totaAmount;
			$i = 0;
			$count = $count+2;
		}
		$i= 4;
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Total");
		$objPHPExcel->getActiveSheet()->getStyle($colName)->getFont()->setBold(true);
		$objPHPExcel->setActiveSheetIndex(0)->getStyle($colName)->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
				);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $totalQty);
		$objPHPExcel->getActiveSheet()->getStyle($colName)->getFont()->setBold(true);
		$i = $i + 1;
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $totalNetAmount);
		$objPHPExcel->getActiveSheet()->getStyle($colName)->getFont()->setBold(true);
		$i = $i + 1;
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $totalDiscount);
		$objPHPExcel->getActiveSheet()->getStyle($colName)->getFont()->setBold(true);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $grandTotal);
		$objPHPExcel->getActiveSheet()->getStyle($colName)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->setTitle("OrderReport");
		
		self::setFormatForOrderReport($objPHPExcel->setActiveSheetIndex(0),$count);
		
			
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
			
			
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Orders"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
			
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		ob_end_clean();
		$objWriter->save('php://output');
	}
	
	private static function setFormatForOrderReport($sheet,$totalRowCount){
		foreach(range('A','K') as $columnID)
		{
		    $sheet->getColumnDimension($columnID)->setAutoSize(true);
		}
		$sheet->getStyle('A1:K1')->getFont()->setBold(true);
		$sheet->getStyle('A1:K1')
		->getFill()
		->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
		->getStartColor()
		->setRGB('D3D3D3');
		$sheet->getStyle('A'.$totalRowCount.':K'.$totalRowCount)
		->getFill()
		->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
		->getStartColor()
		->setRGB('FFFF99');
		$sheet->getStyle('G2:G'.$totalRowCount)->getNumberFormat()->setFormatCode('#,##0.00');
		$sheet->getStyle('H2:H'.$totalRowCount)->getNumberFormat()->setFormatCode('#,##0.00');
		$sheet->getStyle('J2:J'.$totalRowCount)->getNumberFormat()->setFormatCode('#,##0.00');
		$sheet->getStyle('K2:K'.$totalRowCount)->getNumberFormat()->setFormatCode('#,##0.00');
		
	}
}