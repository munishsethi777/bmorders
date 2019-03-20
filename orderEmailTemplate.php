<html>
<head>
<link rel="stylesheet" type="text/css"
	href="1https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<body>
	<div
		style="background-color: grey; width: 100%; color: #676a6c; font-family: open sans, Helvetica Neue, Helvetica, Arial, sans-serif">
		<div
			style="background-color: white; margin: auto; max-width: 600px; padding: 0px 15px 0px 15px">
			<div
				style="padding: 15px; background-color: #DAA520; color: white; margin: 0px -15px 0px -15px;">
				<h1 style="margin-top: 0px; margin-bottom: 20px;">
					<img
						src="https://1ceipl3l02ez252khj15lgak-wpengine.netdna-ssl.com/wp-content/uploads/2018/10/logo-white-small.png"
						style="float: left;">
				</h1>
				<p align="right" style="margin: 0px;">
					<a href="https://www.flydining.com/" style="color: #fff; text-decoration: none;">www.myhealthsolutionz.com</a>
				</p>
			</div>
			<div style="margin-top: 20px;display:flex;padding:15px;">
				<div style="padding:20px 15px;max-width:100%;width:100%">
					<p style="margin: 0px; font-size: 16px;">A new Order has been received on <i>{ORDER_DATE}</i> with</p>
					<p style="font-size: 24px; font-weight: bold; margin: 0px; color: #000;">Order Id: {ORDER_ID}</p>
				</div>
			</div>
			<div style="margin: 20px 0 0;display:flex">
				<div style="border-right: 1px solid #f1f1f1;max-width:50%;padding:0px 15px;">
					<h3 style="color: #000;">{CUSTOMER_NAME}</h3>
					<p style="margin: 0px;">{CUSTOMER_ADDRESS}</p>
					<p style="margin: 0px;">
						<span style="font-weight: bold;">GST#:</span> 29ADHFS4111J1ZY
					</p>
					<p>
						Mobile: {CUSTOMER_MOBILE}<br>
						Email: {CUSTOMER_EMAIL}<br>
					</p>
					<p style="font-size:10pt">
						{ORDER_COMMENTS}
					</p>
					
				</div>
				<div style="margin-bottom: 20px;max-width:50%;padding:0px 15px;">
					<p style="font-size: 18px; color: #000; margin-bottom: 0px;">
						Rs. {ORDER_AMOUNT}/-				
					</p>
					<p style="font-size:14px">Processed by:<br> {PROCESSED_BY_INFO}</p>
					
				</div>
			</div>

			<div style="margin: 0; background: #f1f1f1; padding: 20px 20;display:flex">
				<div style="width:100%">
					<p	style="margin: 0 0 10px 0; font-weight: bold; border-bottom: 1px silver solid;">Order
						Summary</p>
					<table style="text-align:left;font-size:12px;vertical-align:top;border-bottom:1px silver solid;width:100%">
						<tr>
							<th width="75%" style="text-align:left;vertical-align:top">Item</th>
							<th width="10%" style="text-align:right;vertical-align:top">Rate</th>
							<th width="5%" style="text-align:right;vertical-align:top">Qty</th>
							<th width="10%" style="text-align:right;vertical-align:top">Amount</th>
						</tr>
						{PRODUCT_HTML}
					</table>		
					<div style="display:flex;width:100%">
						<div style="width:50%;padding:10px 0px 0px 0px;text-align:left">
							<p style="color: #000; font-size: 16px; margin: 0px;">Gross Total</p>
						</div>
						<div style="width:50%;padding:10px 0px 0px 0px;text-align:right;">
							<p style="color: #000; font-size: 16px; text-align: right; margin: 0px;">{GROSS_TOTAL}/-</p>
						</div>
					</div>
					<div style="display:flex;width:100%;border-bottom:1px silver solid;padding-bottom:10px;">
						<div style="width:50%;padding:10px 0px 0px 0px;text-align:left">
							<p style="color:red; font-size: 16px; margin: 0px;">Discount</p>
						</div>
						<div style="width:50%;padding:10px 0px 0px 0px;text-align:right;">
							<p style="color:red; font-size: 16px; text-align: right; margin: 0px;">{DISCOUNT_AMOUNT}/-</p>
						</div>
					</div>
					<div style="display:flex;width:100%">
						<div style="width:50%;padding:10px 0px 0px 0px;text-align:left">
							<p
								style="font-weight: bold; color: #000; font-size: 21px; margin: 0px;">Net Amount</p>
						</div>
						<div style="width:50%;padding:10px 0px 0px 0px;text-align:right;">
							<p
								style="font-weight: bold; color: #000; font-size: 21px; text-align: right; margin: 0px;">Rs.
								{NET_AMOUNT}/-</p>
						</div>
					</div>
				</div>
			</div>
			<p
				style="background: #DAA520; margin-top: 1 0px; color: #000; padding: 10px;"
				align="center">
				Notifications are generated from online portal.
			</p>
		</div>
	</div>
</body>
</html>;