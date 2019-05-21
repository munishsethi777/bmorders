<?php
require_once($ConstantsArray['dbServerUrl'] ."Utils/DateUtil.php");
require_once $ConstantsArray['dbServerUrl'] . 'PHPExcel/IOFactory.php';
require_once $ConstantsArray['dbServerUrl'] . 'Enums/ExpenseType.php';
require_once $ConstantsArray['dbServerUrl'] . 'Enums/PaymentMode.php';
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
	
	
	public static function exportProducts($productsDetails){
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
		$objPHPExcel->getActiveSheet()->getStyle($colName)->getFont()->setBold(true);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Brand");
		$objPHPExcel->getActiveSheet()->getStyle($colName)->getFont()->setBold(true);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Category");
		$objPHPExcel->getActiveSheet()->getStyle($colName)->getFont()->setBold(true);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Flavour");
		$objPHPExcel->getActiveSheet()->getStyle($colName)->getFont()->setBold(true);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Total Stock");
		$objPHPExcel->getActiveSheet()->getStyle($colName)->getFont()->setBold(true);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Qty");
		$objPHPExcel->getActiveSheet()->getStyle($colName)->getFont()->setBold(true);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Msr Type");
		$objPHPExcel->getActiveSheet()->getStyle($colName)->getFont()->setBold(true);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Rate");
		$objPHPExcel->getActiveSheet()->getStyle($colName)->getFont()->setBold(true);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Lot Number");
		$objPHPExcel->getActiveSheet()->getStyle($colName)->getFont()->setBold(true);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Expiring On");
		$objPHPExcel->getActiveSheet()->getStyle($colName)->getFont()->setBold(true);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Stock");
		$objPHPExcel->getActiveSheet()->getStyle($colName)->getFont()->setBold(true);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Price");
		$objPHPExcel->getActiveSheet()->getStyle($colName)->getFont()->setBold(true);
		$count = 2;
		$i = 0;
		$index = 0;
		$totalRows = 0;
		foreach($productsDetails as $products){
			$index = 0;
			$totalQuantityColName = "";
			$totalQty = 0;
			foreach($products as $product){
				$totalQty += $product["totalquantity"];
				if($index == 0){
					$colName = $alphas[$i++]. $count;
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $product["title"]);
						
					$colName = $alphas[$i++]. $count;
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $product["brand"]);
			
					$colName = $alphas[$i++]. $count;
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $product["category"]);
					
					$colName = $alphas[$i++]. $count;
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $product["flavour"]);
			
					$totalQuantityColName = $colName = $alphas[$i++]. $count;
					
					$colName = $alphas[$i++]. $count;
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $product["quantity"]);
					
					$colName = $alphas[$i++]. $count;
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName,  $product["measuringunit"]);
					
					$colName = $alphas[$i++]. $count;
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName,  $product["price"]);
					$index++;
				}
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($totalQuantityColName,  $totalQty);
				
				$colName = $alphas[$i++]. $count;
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName,  $product["lotnumber"]);
				
				$colName = $alphas[$i++]. $count;
				$expirydateStr = "NA";
				if(!empty($product["expirydate"])){
					$expirydate = DateUtil::StringToDateByGivenFormat("Y-m-d H:i:s",$product["expirydate"]);
					$expirydateStr = $expirydate->format("d-m-Y");
				}
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName,  $expirydateStr);
				
				$colName = $alphas[$i++]. $count;
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName,  $product["stock"]);
				
				$colName = $alphas[$i++]. $count;
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName,  $product["netrate"]);
				$count++;
				$i = 8;
				
			}
			$count++;
			$i = 0;
		}
		$objPHPExcel->getActiveSheet()->setTitle("Product Report");
		$totalRows = $count-2;
		$objPHPExcel->setActiveSheetIndex(0)->getStyle('H2:H'.$totalRows)->getNumberFormat()->setFormatCode('#,##0.00');
		$objPHPExcel->setActiveSheetIndex(0)->getStyle('L2:L'.$totalRows)->getNumberFormat()->setFormatCode('#,##0.00');
			
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
	
	
	public static function exportPurchases($purchases){
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
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "#");
		$objPHPExcel->setActiveSheetIndex(0)->getStyle($colName)->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
				);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Dated");
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Supplier");
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Invoice #");
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Invoice Date");
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Sr. No.");
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Product");
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Lot Number");
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Expiry Date");
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
		$index = 0;
		$totalRows = 0;
		$srNo = 1;
		$totalQty = 0;
		$totalAmount = 0;
		$totalDiscount = 0;
		$totalNetAmount = 0;
		foreach($purchases as $purchase){
			$index = 0;
			$productSrNo = 1;
			$invoiceTotalAmount = 0;
			$invoiceTotalDiscount = 0;
			$invoiceNetAmount = 0;
			$comments = "";
			foreach($purchase as $purchaseDetail){
				if($index == 0){
					$colName = $alphas[$i++]. $count;
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $srNo);
					
					$createddate = DateUtil::StringToDateByGivenFormat("Y-m-d H:i:s",$purchaseDetail["createdon"]);
					$createddateStr = $createddate->format("d-m-Y h:i:s a");
					
					$colName = $alphas[$i++]. $count;
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $createddateStr);
					
					$colName = $alphas[$i++]. $count;
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $purchaseDetail["title"]);
						
					$colName = $alphas[$i++]. $count;
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $purchaseDetail["invoicenumber"]);
						
					$colName = $alphas[$i++]. $count;
					
					$invoicedate = DateUtil::StringToDateByGivenFormat("Y-m-d H:i:s",$purchaseDetail["invoicedate"]);
					$invoicedateStr = $invoicedate->format("d-m-Y");
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $invoicedateStr);
					$index++;
				}
				
				$colName = $alphas[$i++]. $count;
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $productSrNo);
				
				$colName = $alphas[$i++]. $count;
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName,  $purchaseDetail["producttitle"]);
				
				$colName = $alphas[$i++]. $count;
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName,  $purchaseDetail["lotnumber"]);
				
				$colName = $alphas[$i++]. $count;
				$expirydateStr = "NA";
				if(!empty($purchaseDetail["expirydate"])){
					$expirydate = DateUtil::StringToDateByGivenFormat("Y-m-d H:i:s",$purchaseDetail["expirydate"]);
					$expirydateStr = $expirydate->format("d-m-Y");
				}
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName,  $expirydateStr);
	
				$colName = $alphas[$i++]. $count;
				$qty = $purchaseDetail["quantity"];
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName,  $qty);
				$totalQty += $qty;
				$rate = $purchaseDetail["netrate"];
				$invoiceTotalRate +=$rate;
				$colName = $alphas[$i++]. $count;
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName,  $rate);
				
				$colName = $alphas[$i++]. $count;
				$amount = $qty * $rate;
				$invoiceTotalAmount += $amount;
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName,  $amount);
				
				
				$colName = $alphas[$i++]. $count;
				$discountPercent = $purchaseDetail["detaildiscount"];
				$discount = 0;
				$netAmount = $amount;
				if(!empty($discountPercent)){
					$discount = ($discountPercent / 100) * $amount;
					$netAmount = $amount - $discount;
				}
				$invoiceTotalDiscount += $discount;
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName,  $discountPercent."%");
	
				$colName = $alphas[$i++]. $count;
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName,  $discount);
				
	
				$colName = $alphas[$i++]. $count;
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName,  $netAmount);
				$invoiceNetAmount += $netAmount;
				$comments = $purchaseDetail["comments"];
				$count++;
				$productSrNo++;
				$i = 5;
			}
			
			if(!empty($comments)){
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$count, "Comments - " . $comments);
			}
			$totalDiscount += $invoiceTotalDiscount;
			$totalAmount += $invoiceTotalAmount;
			$totalNetAmount += $invoiceNetAmount;
			$colName = "L". $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName,  $invoiceTotalAmount);
			$objPHPExcel->getActiveSheet()->getStyle($colName)->getFont()->setBold(true);
			$colName = "N". $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName,  $invoiceTotalDiscount);
			$objPHPExcel->getActiveSheet()->getStyle($colName)->getFont()->setBold(true);
			$colName = "O". $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName,  $invoiceNetAmount);
			$objPHPExcel->getActiveSheet()->getStyle($colName)->getFont()->setBold(true);
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $count .':K' . $count);
			$comments = $order["comments"];
			$srNo++;
			$count++;
			$count++;
			$i = 0;
		}
		$i = 8;
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName,  "Total");
		$objPHPExcel->getActiveSheet()->getStyle($colName)->getFont()->setBold(true);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName,  $totalQty);
		$objPHPExcel->getActiveSheet()->getStyle($colName)->getFont()->setBold(true);
		$i+=1;
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName,  $totalAmount);
		$objPHPExcel->getActiveSheet()->getStyle($colName)->getFont()->setBold(true);
		$i++;
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName,  $totalDiscount);
		$objPHPExcel->getActiveSheet()->getStyle($colName)->getFont()->setBold(true);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName,  $totalNetAmount);
		$objPHPExcel->getActiveSheet()->getStyle($colName)->getFont()->setBold(true);
		foreach(range('A','O') as $columnID)
		{
			$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($columnID)->setAutoSize(true);
		}
		$objPHPExcel->getActiveSheet()->setTitle("Product Report");
		$objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getFont()->setBold(true);
		$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:O1')
		->getFill()
		->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
		->getStartColor()
		->setRGB('D3D3D3');
		$objPHPExcel->setActiveSheetIndex(0)->getStyle('A'. $count .':O' . $count)
		->getFill()
		->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
		->getStartColor()
		->setRGB('FFFF99');
		$objPHPExcel->setActiveSheetIndex(0)->getStyle('K2:K'.$count)->getNumberFormat()->setFormatCode('#,##0.00');
		$objPHPExcel->setActiveSheetIndex(0)->getStyle('L2:L'.$count)->getNumberFormat()->setFormatCode('#,##0.00');
		$objPHPExcel->setActiveSheetIndex(0)->getStyle('N2:N'.$count)->getNumberFormat()->setFormatCode('#,##0.00');
		$objPHPExcel->setActiveSheetIndex(0)->getStyle('O2:O'.$count)->getNumberFormat()->setFormatCode('#,##0.00');
			
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
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		ob_end_clean();
		$objWriter->save('php://output');
	}
	
	
	public static function exportCashbook($cashBooks){
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
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($alphas[$i])->setAutoSize(true);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Date");
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($alphas[$i])->setAutoSize(true);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "User");
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($alphas[$i])->setAutoSize(true);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Title");
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($alphas[$i])->setAutoSize(true);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Description");
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($alphas[$i])->setAutoSize(true);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Category");
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($alphas[$i])->setAutoSize(true);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Payment");
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($alphas[$i])->setAutoSize(true);
		$objPHPExcel->setActiveSheetIndex(0)->getStyle($colName)->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
				);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Receipt");
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($alphas[$i])->setAutoSize(true);
		$objPHPExcel->setActiveSheetIndex(0)->getStyle($colName)->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
				);
		$count = 2;
		$i = 0;
		$totalRow = count($cashBooks) + 2;
		$objPHPExcel->setActiveSheetIndex(0)->getStyle('F2:F'.$totalRow)->getNumberFormat()->setFormatCode('#,##0.00');
		$objPHPExcel->setActiveSheetIndex(0)->getStyle('G2:G'.$totalRow)->getNumberFormat()->setFormatCode('#,##0.00');
		$receiptTotal = 0;
		$paymentTotal = 0;
		foreach($cashBooks as $cashBook){
			$colName = $alphas[$i++]. $count;
			$createOn = DateUtil::StringToDateByGivenFormat("Y-m-d H:i:s",$cashBook["createdon"]);
			$createOnStr = $createOn->format("d-m-Y h:i:s a");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $createOnStr);
						
			$colName = $alphas[$i++]. $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $cashBook["fullname"]);
	
			$colName = $alphas[$i++]. $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $cashBook["title"]);
			
			$colName = $alphas[$i++]. $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $cashBook["description"]);
	
			$expenseType = $cashBook["category"];
			$expenseType = ExpenseType::getValue($expenseType);
			$colName = $alphas[$i++]. $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $expenseType);
			$amount = $cashBook["amount"];
			if($cashBook["transactiontype"] == "receipt"){
				$colName = $alphas[$i++]. $count;
				$receiptTotal += $amount; 
			}else {
				$paymentTotal += $amount;
			}
			$colName = $alphas[$i++]. $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $amount);
			$count++;
			$i = 0;
		}
		$i=5;
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $paymentTotal);
		
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $receiptTotal);
		$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:G1')->getFont()->setBold(true);
		$objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$totalRow.':G'.$totalRow)->getFont()->setBold(true);
		$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:G1')
		->getFill()
		->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
		->getStartColor()
		->setRGB('D3D3D3');
		$objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$totalRow.':G'.$totalRow)
		->getFill()
		->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
		->getStartColor()
		->setRGB('FFFF99');
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
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
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
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Lot Number");
		$objPHPExcel->setActiveSheetIndex(0)->getStyle($colName)->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
				);
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
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $order["lotnumber"]);
						
					$colName = $alphas[$i++]. $count;
					$qty = $order["quantity"];
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $qty);
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
			$comments = $order["comments"];
			if(!empty($comments)){
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$count, "Comments - " . $comments);
			}
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$count. ':J'.$count);
			$totaAmount = $order["totalamount"];
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $totaAmount);
			$objPHPExcel->getActiveSheet()->getStyle($colName)->getFont()->setBold(true);
			$grandTotal += $totaAmount;
			$i = 0;
			$count = $count+3;
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
	
	public static function exportPayments($payments){
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Admin")
		->setLastModifiedBy("Admin")
		->setTitle("Payments")
		->setSubject("Payments")
		->setDescription("Payments")
		->setKeywords("office 2007 openxml php")
		->setCategory("Report");
		$alphas = range('A', 'Z');
		$rowCount = 1;
		$count = 1;
		$i = 0;
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($alphas[$i])->setAutoSize(true);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Order#");
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($alphas[$i])->setAutoSize(true);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Customer");
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($alphas[$i])->setAutoSize(true);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Order Date");
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($alphas[$i])->setAutoSize(true);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Mode");
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($alphas[$i])->setAutoSize(true);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Paid On");
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($alphas[$i])->setAutoSize(true);
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Paid");
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($alphas[$i])->setAutoSize(true);
		
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Expected Date");
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($alphas[$i])->setAutoSize(true);
		
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Details");
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($alphas[$i])->setAutoSize(true);
		
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, "Amount");
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($alphas[$i])->setAutoSize(true);
		$objPHPExcel->setActiveSheetIndex(0)->getStyle($colName)->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
				);
		
		$count = 2;
		$i = 0;
		$totalRow = count($payments) + 2;
		$objPHPExcel->setActiveSheetIndex(0)->getStyle('I2:I'.$totalRow)->getNumberFormat()->setFormatCode('#,##0.00');
		$paymentTotal = 0;
		foreach($payments as $payment){
			$colName = $alphas[$i++]. $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $payment["ordernumber"]);
			
			$colName = $alphas[$i++]. $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $payment["customer"]);
			
			$colName = $alphas[$i++]. $count;
			$createOn = DateUtil::StringToDateByGivenFormat("Y-m-d H:i:s",$payment["orderdate"]);
			$createOnStr = $createOn->format("d-m-Y h:i:s a");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $createOnStr);
			
			$paymentMode  = $payment["paymentmode"];
			$paymentMode = PaymentMode::getValue($paymentMode);
			$colName = $alphas[$i++]. $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $paymentMode);
			
			$colName = $alphas[$i++]. $count;
			$createOn = DateUtil::StringToDateByGivenFormat("Y-m-d H:i:s",$payment["createdon"]);
			$createOnStr = $createOn->format("d-m-Y h:i:s a");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $createOnStr);
			
			$isPaid = $payment["ispaid"];
			$paid = "YES";
			if(empty($isPaid)){
				$paid = "NO"; 
			}
			$colName = $alphas[$i++]. $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $paid);
			
			$colName = $alphas[$i++]. $count;
			if(!empty($payment["expectedon"])){
				$expectedDate = DateUtil::StringToDateByGivenFormat("Y-m-d H:i:s",$payment["expectedon"]);
				$expectedDate = $expectedDate->format("d-m-Y");
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $expectedDate);
			}
			
			$colName = $alphas[$i++]. $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $payment["details"]);
			
			$amount = $payment["amount"];
			$paymentTotal += $amount;
			$colName = $alphas[$i++]. $count;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $payment["amount"]);
			$count++;
			$i = 0;
		}
		$i=8;
		$colName = $alphas[$i++]. $count;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colName, $paymentTotal);
		$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:I1')->getFont()->setBold(true);
		$objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$totalRow.':I'.$totalRow)->getFont()->setBold(true);
		$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:I1')
		->getFill()
		->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
		->getStartColor()
		->setRGB('D3D3D3');
		$objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$totalRow.':I'.$totalRow)
		->getFill()
		->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
		->getStartColor()
		->setRGB('FFFF99');
		$objPHPExcel->getActiveSheet()->setTitle("Report");
			
			
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
			
			
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Payments"');
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