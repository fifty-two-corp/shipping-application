{{--<section style='position: relative;clear: both;margin: 5px 0;height: 1px;border-top: 1px solid #cbcbcb;margin-bottom: 25px;margin-top: 10px;text-align: center;'>--}}
	{{--<h3 align='center' style='margin-top: -12px;background-color: #FFF;clear: both;width: 180px;margin-right: auto;margin-left: auto;padding-left: 15px;padding-right: 15px; font-family: arial,sans-serif;'>--}}
		{{--<span>REPORT</span>--}}
	{{--</h3>--}}
{{--</section>--}}
<div class="container">
	<h2>General Report</h2>
	<button style="float: right" class="btn btn-info">Save PDF</button><br>
	<p>Date : {{$date_range}}</p>
	<table class="table table-bordered">
		<thead style="background-color: whitesmoke">
		<tr>
			<th>Shipping</th>
			<th>Date</th>
			<th width="18%">Income</th>
			<th width="18%">Tax</th>
			<th width="18%">Operational Cost</th>
		</tr>
		</thead>
		<tbody>
		@foreach($transaction as $transactions)
		<tr>
			<td>
				<strong><u>#{{$transactions->transaction_number}}</u></strong><br>
				{{$transactions->shipping_customer->customer_name}}<br>
				Shipping Method : <strong>{{$transactions->shipping_method}}</strong><br>
				Dest : {{$transactions->shipping_destination['consignee_city']}} - {{$transactions->shipping_destination['consignee_province']}}<br>
				@if($transactions->shipping_method == 'default')
					Shipping Cost : <strong><span style="float: right">{{number_format($transactions->default_cost,0,',','.')}}</span></strong>
				@elseif($transactions->shipping_method == 'vendor')
					Shipping Cost : <strong><span style="float: right">{{number_format($transactions->vendor_cost,0,',','.')}}</span></strong>
				@endif
			</td>
			<td>
				<b>{{date('d-m-Y',strtotime($transactions->created_at))}}</b><br>
				@if($transactions->payment_type == 'installment')
					@foreach($transactions->termin as $termin)
						{{date('d-m-Y',strtotime($termin->payment_date))}}<br>
					@endforeach
				@endif
			</td>
			<td>
				@if($transactions->payment_type == 'pay_off')
					@if($transactions->shipping_method == 'default')
						<strong>Pay Off </strong><br>
						<span style="float: right">{{number_format($transactions->default_cost,0,',','.')}}</span>
					@elseif($transactions->shipping_method == 'vendor')
						<strong>Pay Off </strong><br>
						<span style="float: right">{{number_format($transactions->vendor_cost,0,',','.')}}</span>
					@endif
				@elseif($transactions->payment_type == 'installment')
					<strong>Termin ( {{$transactions->time_period}} days )</strong><br>
					@foreach($transactions->termin as $termin)
						<span style="float: right">{{number_format($termin->payment,0,',','.')}}</span><br>
					@endforeach
				@endif
			</td>
			<td>
				<strong>{{$transactions->tax_value}}%</strong><br>
				<span style="float: right">{{number_format($transactions->tax_cost,0,',','.')}}</span>
			</td>
			<td><span style="float: right">{{number_format($transactions->operational_cost,0,',','.')}}</span></td>
		</tr>
		@endforeach
		</tbody>
		<tfoot>
		<tr>
			<td colspan="2"><strong>TOTAL</strong></td>
			<td><span style="float: right"><strong>{{number_format($income_total,0,',','.')}}</strong></span></td>
			<td><span style="float: right"><strong>{{number_format($tax_total,0,',','.')}}</strong></span></td>
			<td><span style="float: right"><strong>{{number_format($opcost_total,0,',','.')}}</strong></span></td>
		</tr>
		</tfoot>
	</table>
</div>
<hr>