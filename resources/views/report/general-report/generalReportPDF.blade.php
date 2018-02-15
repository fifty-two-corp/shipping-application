<link href="{{ asset('public/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet" />
<div class="container">
  <img src="{{ asset('public/img/jp-name-logo2.png') }}" width="350px" alt="" /><br>
  <strong><span style="font-size:11px" >CARGO SERVICE - JAWA, BALI, SUMATRA</span><br></strong>
  <span style="font-size:11px" >Perum. Taman Hedona, Blok B5/3, Lingkar Timur, Siduarjo, Telp./Fax: (031) 807 6110, (031) 716 25334</span>
  <hr>
</div>
<div class="container" style="font-size: 10px">
  <h3>General Report</h3>
  <p><span>Date : {{$date_range}} </span></p>
  <table class="table table-bordered" style="font-size: 10px">
    <thead style="background-color: whitesmoke">
    <tr>
      <th>Shipping</th>
      <th>Date</th>
      <th width="18%">Income</th>
      <th width="18%">Tax</th>
      <th width="18%">Op. Cost</th>
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
