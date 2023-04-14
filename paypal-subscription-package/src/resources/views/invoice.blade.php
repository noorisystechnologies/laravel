<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Invoice</title>
		<style>
			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}
		</style>
	</head>

	<body>
		<div class="invoice-box">
			<table cellpadding="0" cellspacing="0">
				
				<tr class="top">
					<td colspan="2">
						<table>
							<tr>
								<td>
									<h1>{{ trans('msg.Invoice') }}</h1>
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="2">
						<table>
							<tr>

								<td>
									{{ $user_name }}<br />
									{{ $user_email }}<br />
								</td>

								<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
								<td style="text-align: left">
									<b >{{ trans('msg.Invoice No') }}</b> <br/>
									<b class="text-bold">{{ trans('msg.Start Date') }}</b> <br/>
                                    <b class="text-bold">{{ trans('msg.End Date') }}</b> <br/>
								</td>

								<td >
								{{ $invoice_number }}<br />
								{{ $start_date }}<br />
                                {{ $end_date }}<br />
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>

			<table cellpadding="0" cellspacing="0">
				<tr class="heading" align="center">
					<td>{{ trans('msg.Description') }}</td>
					<td>{{ trans('msg.Price') }}</td>
					<td>{{ trans('msg.Amount') }}</td>
				</tr>
				<tr class="item" align="center">
				    <td style="border:none">{{ $plan_name }}</td>
					<td style="border:none">£{{ $plan_price }}</td>
					<td style="border:none">£{{ $amount_paid }}</td>
				</tr>
                <tr class="item" align="center">
				    <td style="border:none">{{ $start_date. ' - ' .$end_date}}</td>
					<td style="border:none"></td>
					<td style="border:none"></td>
				</tr>
				<tr></tr>
				<tr align="center">
					<td></td>
					<td style="border-bottom: 1px solid #eee">{{ trans('msg.Subtotal') }}</td>
					<td style="border-bottom: 1px solid #eee">£{{ $amount_paid }}</td>
				</tr>
				<tr align="center">
					<td></td>
					<td style="border-bottom: 1px solid #eee">{{ trans('msg.Total') }}</td>
					<td style="border-bottom: 1px solid #eee">£{{ $amount_paid }}</td>
				</tr>
				<tr align="center">
					<td></td>
					<td style="border-bottom: 1px solid #eee"><b>{{ trans('msg.Amount Paid') }}</b></td>
					<td style="border-bottom: 1px solid #eee">£{{ $amount_paid }}</td>
				</tr>
			</table>
			<br/>
		</div>
	</body>
</html>