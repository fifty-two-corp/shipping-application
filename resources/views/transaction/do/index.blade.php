
  <div class="tab-pane" id="invoice{{ $data->id }}">
    <div bgcolor='#e4e4e4' text='#ff6633' link='#666666' vlink='#666666' alink='#ff6633' style='margin:0;font-family:Arial,Helvetica,sans-serif;border-bottom:1'>
      <table width='100%' style='padding:20px 0 20px 0' cellspacing='0' border='0' align='center' cellpadding='0'>
        <tbody>
          <tr>
            <td>
              <table width='620' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor='#FFFFFF' style='border-radius: 5px;'>
                <tbody>
                  <tr>
                    <td style="border-bottom: 1px solid" valign='top' style='color:#404041;line-height:16px;padding:0px 20px 20px 20px'>
                      <img src="{{ asset('public/img/jp-name-logo2.png') }}" width="350px" alt="" /><br>
                      <strong><span style="font-size:11px" >CARGO SERVICE - JAWA, BALI, SUMATRA</span><br></strong>
                      <span style="font-size:11px" >Perum. Taman Hedona, Blok B5/3, Lingkar Timur, Siduarjo, Telp./Fax: (031) 807 6110, (031) 716 25334</span>
                    </td>
                  </tr>
                  <tr>
                    <td valign='top' style='color:#404041;line-height:16px;padding:25px 20px 0px 20px'>
                      <p>
                        <section style='position: relative;clear: both;margin: 5px 0;height: 1px;border-top: 1px solid #cbcbcb;margin-bottom: 25px;margin-top: 10px;text-align: center;'>
                            <h3 align='center' style='margin-top: -12px;background-color: #FFF;clear: both;width: 180px;margin-right: auto;margin-left: auto;padding-left: 15px;padding-right: 15px; font-family: arial,sans-serif;'>
                                <span>DELIVERY ORDER</span>
                                <span style="font-size: 12px">No. {{ $data->transaction_number }}</span>
                            </h3>
                        </section>
                      </p>            
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <table width='620' border='0' cellspacing='0' cellpadding='0' style='border-bottom:solid 0px #e5e5e5'>
                        <tbody>
                          <tr>
                            <td align='left' valign='top' style='padding:0px 5px 0px 20px' >
                              <table height='80' width='100%' border='0' cellpadding='3' cellspacing='3'>
                                  <tbody>
                                    <tr>
                                      <td height='16' valign='top' style='color:#404041;font-size:13px;padding:15px 5px 0px 5px'>
                                        <strong>Load Date : </strong>
                                        @if($data->load_date)
                                        {{ date('d-m-Y', strtotime($data->load_date)) }}
                                        @else
                                        -
                                        @endif
                                      </td>
                                    </tr>
                                    <tr>
                                      <td valign='top' style='color:#404041;font-size:13px;padding:5px 5px 0px 5px'>
                                        <strong>License Plate :</strong>
                                        @if ($data->shipping_method == 'default')
                                          {{ $data->shipping_vehicle->vehicle_plat_number }}
                                        @elseif($data->shipping_method == 'vendor')
                                          {{ $data->shipping_vendor->vendor_license_plate }}
                                        @endif
                                      </td>
                                    </tr>
                                  </tbody>
                              </table>
                            </td>
                            <td align='left' valign='top' style='padding:0px 5px 0px 5px'>
                              <table height='80' width='100%' border='0' cellpadding='3' cellspacing='3'>
                                <tbody>
                                    <tr>
                                      <td height='16' valign='top' style='color:#404041;font-size:13px;padding:15px 5px 0px 5px'>
                                        <strong>Delivery method : </strong>
                                        {{ $data->shipping_method }}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td valign='top' style='color:#404041;font-size:13px;padding:5px 5px 0px 5px'>
                                        <strong>Driver : </strong>
                                        @if ($data->shipping_method == 'default')
                                          {{ $data->shipping_vehicle->vehicle_driver }}
                                        @elseif($data->shipping_method == 'vendor')
                                          {{ $data->shipping_vendor->vendor_driver }}
                                        @endif
                                      </td>
                                    </tr>
                                </tbody>
                              </table>
                            </td>
                            <td align='left' valign='top' style='padding:0px 5px 0px 0px'>
                              <table height='80' width='100%' border='0' cellpadding='3' cellspacing='3'>
                                <tbody>
                                  <tr>
                                    <td height='16' valign='top' style='color:#404041;font-size:13px;padding:15px 5px 0px 5px'>
                                      <strong>Delivery Type :</strong>
                                      @if ($data->shipping_method == 'default')
                                        {{ $data->default_type }}
                                      @elseif ($data->shipping_method == 'vendor')
                                        {{ $data->vendor_type }}
                                      @endif
                                    </td>
                                  </tr>
                                  @if($data->shipping_method == 'vendor')
                                  <tr>
                                    <td valign='top' style='color:#404041;font-size:13px;padding:5px 5px 0px 5px'>
                                      <strong>Vendor : </strong>
                                      {{ $data->shipping_vendor->vendor_name }}
                                    </td>
                                  </tr>
                                  @endif
                                </tbody>
                              </table>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td style='color:#404041;font-size:12px;line-height:16px;padding:10px 16px 20px 18px'>
                        <table width='100%' border='0' cellpadding='0' cellspacing='0' style='border-radius:5px;border:solid 1px #e5e5e5'>
                            <tbody>
                                <tr>
                                    <td>
                                        <table width='570' border='0' cellspacing='0' cellpadding='0'>
                                            <tbody>
                                                <tr>
                                                    <td width='15'>&nbsp;</td>
                                                    <td colspan='5' align='left' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:5px 10px 3px 5px;border-bottom:solid 1px #e5e5e5'>           
                                                        <strong>Item</strong>
                                                    </td>
                                                    <td width='85' align='right' style='color:#404041;font-size:12px;line-height:16px;padding:5px 10px 3px 5px;border-bottom:solid 1px #e5e5e5'>
                                                        <strong>Quantity</strong>
                                                    </td>
                                                    <td width='60' align='right' style='color:#404041;font-size:12px;line-height:16px;padding:5px 10px 3px 5px;border-bottom:solid 1px #e5e5e5'>
                                                        <strong>Dimension</strong>
                                                    </td>
                                                </tr>
                                                @foreach($data->load_list as $item)
                                                <tr>
                                                  <td width='15'>&nbsp;</td>
                                                  <td colspan='5' align='left' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:5px 5px 3px 5px;border-bottom:dashed 1px #e5e5e5'>
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
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                  </tr>
                  <tr align='left' >
                    <td style='color:#404041;font-size:12px;line-height:16px;padding:10px 16px 20px 18px'>
                      <table width='0' border='0' align='right' cellpadding='0' cellspacing='0'>
                        <tbody>
                            <tr>
                              <td align='left' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:5px 0px 3px 0px'>
                                  <strong>Delivery cost :</strong>
                              </td>
                              <td width='120' align='right' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:5px 5px 3px 5px'>
                                Rp. 
                                  @if ($data->shipping_method == 'default')
                                      {{ number_format($data->default_cost) }}
                                  @elseif ($data->shipping_method == 'vendor')
                                      {{ number_format($data->vendor_cost) }}
                                  @endif
                              </td>
                            </tr>
                            <tr>
                              <td align='left' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:5px 0px 3px 0px;border-bottom:solid 1px #999999'>
                                  <strong>Tax ({{ $data->tax_value }}%) :</strong>
                              </td>
                              <td width='120' align='right' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:5px 5px 3px 5px;border-bottom:solid 1px #999999'>
                                  Rp. {{ number_format($data->tax_cost) }}
                              </td>
                            </tr>
                            <tr>
                              <td align='left' valign='bottom' style='color:#404041;font-size:13px;line-height:16px;padding:5px 0px 3px 0px'>
                                  <strong>Grand Total:</strong>
                              </td>
                              <td width='120' align='right' valign='bottom' style='color:#339933;font-size:13px;line-height:16px;padding:5px 5px 3px 5px'>
                                  <strong>Rp. {{ number_format($data->cost) }}</strong>
                              </td>
                            </tr>
                        </tbody>
                      </table>
                      <table width='0' border='0' align='left' cellpadding='0' cellspacing='0'>
                        <tbody>
                          <tr>
                            <td width='0' align='left' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:0px 0px 0px 0px'>
                                <strong>Bank:</strong> 
                            </td>
                            <td width='0' align='right' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:0px 5px 3px 5px'>
                                Mandiri
                            </td>
                          </tr>
                          <tr>
                            <td align='left' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:5px 0px 3px 0px;'>
                                <strong>Account Name:</strong>
                            </td>
                            <td width='62' align='right' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:5px 5px 3px 5px;'>
                                123456789
                            </td>
                          </tr>
                          <tr>
                            <td align='left' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:5px 0px 3px 0px;'>
                                <strong>Account Number:</strong>
                            </td>
                            <td width='62' align='right' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:5px 5px 3px 5px;'>
                                123456789
                            </td>
                          </tr>
                          
                        </tbody>
                      </table>
                    </td>
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>                    
