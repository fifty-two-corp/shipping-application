<link href="{{ asset('public/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet"/>
<div class="container">
  <img src="{{ asset('public/img/jp-name-logo2.png') }}" width="350px" alt="" /><br>
  <strong><span style="font-size:11px">CARGO SERVICE - JAWA, BALI, SUMATRA</span><br></strong>
  <span style="font-size:11px" >Perum. Taman Hedona, Blok B5/3, Lingkar Timur, Siduarjo, Telp./Fax: (031) 807 6110, (031) 716 25334</span>
  <div style="border-bottom:1px solid;"></div>
</div>
<div class="container" style="font-size: 10px">
  <div style="padding-top: 40px">
    <section style='position: relative;clear: both;margin: 5px 0;height: 1px;border-top: 1px solid #cbcbcb;margin-bottom: 25px;margin-top: 10px;text-align: center;'>
      <h3 align='center' style='margin-top: -18px;background-color: #FFF;clear: both;width: 260px;margin-right: auto;margin-left: auto;padding-left: 15px;padding-right: 15px; font-family: arial,sans-serif;'>
        <span><strong>DELIVERY ORDER<strong></span><br>
        <span style="font-size: 12px">No. {{ $data->transaction_number }}</span>
      </h3>
    </section>
  </div>
</div>
<div class="container" style="font-size: 10px">
  <div style="padding-top: 30px">
    <table class="table" width="100%" style="font-size: 12px">
      <thead>
      <tr style="padding-left: 10px">
        <td style="border-right: none" width="15%"><strong>Load Date</strong></td>
        <td width="1%">:</td>
        <td width="15%">
          @if($data->load_date)
            {{ date('d-m-Y', strtotime($data->load_date)) }}
          @else
            -
          @endif
        </td>
        <td width="18%"><strong>Delivery method</td>
        <td width="1%">:</td>
        <td width="15%">{{$data->shipping_method}}</td>
        <td><strong>Delivery Type :</strong></td>
        <td>:</td>
        <td>
          @if ($data->shipping_method == 'default')
          {{ $data->default_type }}
          @elseif ($data->shipping_method == 'vendor')
          {{ $data->vendor_type }}
          @endif
        </td>
      </tr>
      </thead>
      <tbody>
      <tr>
        <td><strong>License Plate</strong></td>
        <td>:</td>
        <td>
          @if ($data->shipping_method == 'default' && !empty($data->shipping_vehicle))
          {{ $data->shipping_vehicle->vehicle_plat_number }}
          @elseif($data->shipping_method == 'vendor')
          {{ $data->shipping_vendor->vendor_license_plate }}
          @endif
        </td>
        <td><strong>Driver</strong></td>
        <td>:</td>
        <td style="border-bottom: 1px">
          @if ($data->shipping_method == 'default' && !empty($data->shipping_vehicle))
            {{ $data->shipping_vehicle->vehicle_driver }}
          @elseif($data->shipping_method == 'vendor')
            {{ $data->shipping_vendor->vendor_driver }}
          @endif
        </td>
        <td>@if($data->shipping_method == 'vendor')<strong>Vendor</strong>@endif</td>
        <td>@if($data->shipping_method == 'vendor'):@endif</td>
        <td>
          @if($data->shipping_method == 'vendor')
            {{ $data->shipping_vendor->vendor_name }}
          @endif
        </td>
      </tr>
      <tr><td colspan="9"></td></tr>
      </tbody>
    </table>
  </div>
</div>
<div class="container" style="font-size: 10px">
  <table width='0' border='0' align='right' cellpadding='0' cellspacing='0'>
    <tbody>
      <tr>
        <td align='left' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:5px 0px 3px 0px'>
          <strong>Cost +Tax({{ $data->tax_value }}%)</strong>
        </td>

          <td width='120' align='right' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:5px 5px 3px 5px'>
            @if ($data->payment_type == 'pay_off')
              <span style="color:#339933"><strong><u>Rp.
                @if ($data->shipping_method == 'default')
                {{ number_format($data->default_cost + $data->tax_cost) }}
                @elseif ($data->shipping_method == 'vendor')
                {{ number_format($data->vendor_cost + $data->tax_cost) }}
                @endif
              </u></strong></span>
            @else
              Rp.
              @if ($data->shipping_method == 'default')
                {{ number_format($data->default_cost + $data->tax_cost) }}
              @elseif ($data->shipping_method == 'vendor')
                {{ number_format($data->vendor_cost + $data->tax_cost) }}
              @endif
        </td>
      </tr>
      <tr>
        <td align='left' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:5px 0px 3px 0px;border-bottom:solid 1px #999999'>
          <strong>DP :</strong>
        </td>
        <td width='120' align='right' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:5px 5px 3px 5px;border-bottom:solid 1px #999999'>
          Rp. {{ number_format($data->down_payment) }}
        </td>
      </tr>
      <tr>
        <td align='left' valign='bottom' style='color:#404041;font-size:13px;line-height:16px;padding:5px 0px 3px 0px'>
          <strong>Remaining Payment</strong>
        </td>
        <td width='120' align='right' valign='bottom' style='color:#339933;font-size:13px;line-height:16px;padding:5px 5px 3px 5px'>
          <strong>Rp. {{ number_format($data->cost - $data->down_payment) }}</strong>
        </td>
      </tr>

    </tbody>
  </table>
  <table width='0' border='0' align='left' cellpadding='0' cellspacing='0'>
    <tbody>
      <tr>
        <td width='0' align='left' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:0px 0px 0px 0px'>
          <strong>Bank</strong>
        </td>
        <td width='0' align='right' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:0px 5px 3px 5px'>
          Mandiri
        </td>
      </tr>
      <tr>
        <td align='left' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:5px 0px 3px 0px;'>
          <strong>Account Name</strong>
        </td>
        <td width='62' align='right' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:5px 5px 3px 5px;'>
          123456789
        </td>
      </tr>
      <tr>
        <td align='left' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:5px 0px 3px 0px;'>
          <strong>Account Number</strong>
        </td>
        <td width='62' align='right' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:5px 5px 3px 5px;'>
          123456789
        </td>
      </tr>
    </tbody>
    @endif
  </table>
</div>
<div style="border-bottom:1px dashed; margin-bottom: 30px; margin-top: 25px"></div>
<div class="container">
  <img src="{{ asset('public/img/jp-name-logo2.png') }}" width="350px" alt="" /><br>
  <strong><span style="font-size:11px">CARGO SERVICE - JAWA, BALI, SUMATRA</span><br></strong>
  <span style="font-size:11px" >Perum. Taman Hedona, Blok B5/3, Lingkar Timur, Siduarjo, Telp./Fax: (031) 807 6110, (031) 716 25334</span>
  <div style="border-bottom:1px solid;"></div>
</div>
<div class="container" style="font-size: 10px">
  <div style="padding-top: 40px">
  <section style='position: relative;clear: both;margin: 5px 0;height: 1px;border-top: 1px solid #cbcbcb;margin-bottom: 25px;margin-top: 10px;text-align: center;'>
    <h3 align='center' style='margin-top: -18px;background-color: #FFF;clear: both;width: 240px;margin-right: auto;margin-left: auto;padding-left: 15px;padding-right: 15px; font-family: arial,sans-serif;'>
      <span><strong>SURAT MUATAN<strong></span><br>
      <span style="font-size: 12px">No. {{ $data->transaction_number }}</span>
    </h3>
  </section>
  </div>
  <div style="padding-top: 40px">
    <table width="100%" style="font-size: 12px" border="0">
      <tbody>
      <tr>
        <td width="50%">
          <strong>Pengirim Yth,</strong><br>
          <p style="padding-left: 10px; padding-top: 10px">
            {{ $data->shipping_customer->customer_name }}<br>
            {{ $data->shipping_customer->customer_address }}<br>
            {{ $data->shipping_customer->customer_district }}<br>
            {{ $data->shipping_customer->customer_city }}<br>
            {{ $data->shipping_customer->customer_province }}<br>
            <strong>Tel: </strong>{{ $data->shipping_customer->customer_phone }}
          </p>
        </td>
        <td width="50%">
          <strong>Disampaikan dh,</strong><br>
          <p style="padding-left: 10px; padding-top: 10px">
            {{ $data->shipping_destination->consignee_name }}<br>
            {{ $data->shipping_destination->consignee_address }}<br>
            {{ $data->shipping_destination->consignee_district }}<br>
            {{ $data->shipping_destination->consignee_city }}<br>
            {{ $data->shipping_destination->consignee_province }}<br>
            <strong>Tel: </strong>{{ $data->shipping_destination->consignee_phone }}
          </p></td>
      </tr>
      </tbody>
    </table>
  </div>
  <div style="padding-top: 10px">
    <table class="table table-bordered" style="font-size: 10px">
      <thead style="background-color: whitesmoke">
      <tr>
        <th style="text-align: center" width="60%">Item</th>
        <th style="text-align: center">Dimension</th>
        <th style="text-align: center">Quantity</th>
      </tr>
      </thead>
      <tbody>
      @foreach($data->load_list as $item)
        <tr>
          <td align='left' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:5px 5px 3px 5px;border-bottom:dashed 1px #e5e5e5'>
            {{ $item->item }}
          </td>
          <td width='85' align='right' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:5px 5px 3px 5px;border-bottom:dashed 1px #e5e5e5'>
            {{ $item->quantity }}
          </td>
          <td width='60' align='right' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:5px 5px 3px 5px;border-bottom:dashed 1px #e5e5e5'>
            {{ $item->dimension }}
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
    <h4 style="color: #0a6aa1;margin-top: -10px">BARANG2 TIDAK DIPERIKSA ISINYA</h4>
  </div>
  <div style="padding-top: 10px">
    <table width="100%" style="font-size: 10px" border="0">
      <tbody>
      <tr>
        <td width="30%" style="vertical-align: top; border: red 1px solid ">
          <div align="center" style="color: red"><strong>PERHATIAN</strong></div>
            <ol style="padding-left: 12px;font-size: 7px;color: red">
              <li>Kerusakan-Kehilangan barang/claim diganti 10x ongkos barang yanghilang/rusak.</li>
              <li>Jika sipenerima tidak ingin membayar ongkos kirim, maka penrim yang harus membayar.</li>
              <li>Tidak diberi pengantian untuk kehilangan dan kerugian yang disebabkan keadaan kahar, misalnya: kecelakaan, kebakaran, perampokan/pencurian, huru hara, bencana alam, dll.</li>
              <li>Barang cair atau mudah pecah dengan packing yang kurang baik/bocor adalah diluar tanggung jawab kami.</li>
              <li>Kerusakan atau kehilangan barang harus disaksikan oleh mandor atau supir, selewatnya dari tanggal pengiriman bukan tanggung jawab kami.</li>
              <li>Segala pengaduan lebih dari 2 bulan setelah barang diterima bukan tanggung jawab kami</li>
          </ol>
        </td>
        <td width="2%"></td>
        <td width="15%" style="text-align: center; border-bottom:1px dashed; vertical-align: top" height="100px">
          <p style="line-height: 1.9;">
            ................. Tgl,...........<br>
            Tanda tangan Penerima dan Stempel
          </p>
        </td>
        <td width="3%"></td>
        <td width="15%" style="text-align: center; border-bottom:1px dashed; vertical-align: top" height="100px">
          <p style="line-height: 1.9;">Tanda Tangan Supir</p>
        </td>
        <td width="3%"></td>
        <td width="15%" style="text-align: center; border-bottom:1px dashed; vertical-align: top" height="100px">
          <p style="line-height: 1.9;">
            ................. Tgl,...........<br>
            Tanda tangan Pengurus
          </p>
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</div>
