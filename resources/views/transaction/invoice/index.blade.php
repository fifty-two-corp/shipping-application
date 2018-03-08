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
                              <span>INVOICE</span>
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
                          <td width="30%" align='left' valign='top' style='padding:0px 5px 0px 5px' >
                            <table height='20px' width='100%' border='0' cellpadding='0' cellspacing='0'>
                                <tbody>
                                  <tr>
                                    <td height='10px' valign='top' style='color:#404041;font-size:13px;padding:5px 5px 0px 20px'>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td valign='top' style='color:#404041;font-size:13px;padding:5px 5px 0px 20px'>
                                      <strong>No. Shipping:</strong> 
                                    </td>
                                  </tr>
                                  <tr>
                                    <td valign='top' style='color:#404041;font-size:12px;padding:5px 5px 0px 20px'>
                                        #{{ $data->transaction_number }}
                                    </td>
                                  </tr>
                                  
                                  <tr>
                                      <td valign='top' style='color:#404041;font-size:13px;padding:5px 5px 0px 20px'>
                                          <strong>Date:</strong>
                                          {{ $date }}
                                      </td>
                                  </tr>
                                </tbody>
                            </table>
                          </td>
                          <td width="35%" align='left' valign='top' style='padding:0px 5px 0px 5px'>
                            <table height='146' width='100%' border='0' cellpadding='3' cellspacing='3' style='border-right:solid 0px #e5e5e5'>
                              <tbody>
                                  <tr>
                                    <td height='16' valign='top' style='color:#404041;font-size:13px;padding:15px 5px 0px 5px'>
                                        <strong>Customer :</strong>
                                        
                                    </td>
                                  </tr>
                                  <tr>
                                    <td valign='top' style='color:#404041;font-size:12px;padding:0px 5px 0px 5px'>
                                      <p>
                                        {{ $data->shipping_customer->customer_name }}<br>
                                        {{ $data->shipping_customer->customer_address }}<br>
                                        {{ $data->shipping_customer->customer_district }}<br>
                                        {{ $data->shipping_customer->customer_city }}<br>
                                        {{ $data->shipping_customer->customer_province }}<br>
                                        <strong>Tel: </strong>{{ $data->shipping_customer->customer_phone }}
                                      </p>
                                    </td>
                                  </tr>
                              </tbody>
                            </table>
                          </td>
                          <td width="35%" align='left' valign='top' style='padding:0px 5px 0px 0px'>
                            <table height='140' width='100%' border='0' cellpadding='3' cellspacing='3'>
                              <tbody>
                                <tr>
                                  <td height='16' valign='top' style='color:#404041;font-size:13px;padding:15px 5px 0px 5px'>
                                    <strong>Deliver to:</strong>
                                  </td>
                                </tr>
                                <tr>
                                  <td valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:0px 5px 0px 5px'>
                                    <p>
                                      {{ $data->shipping_destination->consignee_name }}<br>
                                      {{ $data->shipping_destination->consignee_address }}<br>
                                      {{ $data->shipping_destination->consignee_district }}<br>
                                      {{ $data->shipping_destination->consignee_city }}<br>
                                      {{ $data->shipping_destination->consignee_province }}<br>
                                      <strong>Tel: </strong>{{ $data->shipping_destination->consignee_phone }}
                                    </p>
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
                                                <tr>
                                                  <td width='15'>&nbsp;</td>
                                                  <td colspan='2' width='100' align='left' valign='top' style='color:#404041;font-size:12px;padding:20px 5px 0px 5px'>
                                                      <strong>Delivery method :</strong> {{ $data->shipping_method }}
                                                  </td>
                                                  
                                                </tr>
                                                <tr>
                                                  <td width='15'>&nbsp;</td>
                                                  <td colspan='2' width='100' align='left' valign='top' style='color:#404041;font-size:12px;padding:5px 5px 10px 5px'>
                                                      <strong>Delivery Type :</strong>
                                                      @if ($data->shipping_method == 'default')
                                                        {{ $data->default_type }}
                                                      @elseif ($data->shipping_method == 'vendor')
                                                        {{ $data->vendor_type }}
                                                      @endif
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
                    <table width='48%' border='0' align='left' cellpadding='0' cellspacing='0'>
                      <tbody>
                        @if($data->time_period != null)
                        <tr style="background-color:#f2f2f2">
                          <td colspan="2" style="padding:10px 5px 3px 10px; font-size:13px;">
                            <strong>Time Period </strong>{{ $data->time_period }} Days
                          </td>
                        </tr>
                        <tr style="background-color:#f2f2f2;padding-bottom: 20px">
                          <td colspan="2" style="padding:5px 10px 10px 10px; font-size:13px;">
                            <strong>Due Date </strong> {{ $due_date }}
                          </td>
                        </tr>
                        <tr style="padding-bottom: -50px;">
                          <td colspan="2">
                            <span><h4 style='color: #848484; font-family: arial,sans-serif; font-weight: 200; padding-top: 20px;'>Banking Details</h4></span>
                          </td>
                        </tr>
                        <tr>
                          <td width='0' align='left' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:0px 0px 3px 0px'>
                              <strong>Bank Name:</strong>
                          </td>
                          <td width='0' align='right' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:0px 5px 3px 5px'>
                              {{$bank[0]['bank_name']}}
                          </td>
                        </tr>
                        <tr>
                          <td align='left' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:5px 0px 3px 0px;'>
                              <strong>Bank Account:</strong>
                          </td>
                          <td width='62' align='right' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:5px 5px 3px 5px;'>
                            {{$bank[0]['bank_account']}}
                          </td>
                        </tr>
                        <tr>
                          <td align='left' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:5px 0px 3px 0px;'>
                            <strong>Bank Number:</strong>
                          </td>
                          <td width='62' align='right' valign='top' style='color:#404041;font-size:12px;line-height:16px;padding:5px 5px 3px 5px;'>
                            {{$bank[0]['bank_number']}}
                          </td>
                        </tr>
                        @endif
                      </tbody>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td>
                    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                      <tbody>
                        <tr>
                          <td style='color:#404041;font-size:12px;line-height:16px;padding:15px 5px 5px 10px'>
                              For more information on your shipping please call us on <a href='tel:0318076110' value='+62318076110' target='_blank'>(031) 807 6110</a>, <a href='tel:03171625334' value='+623171625334' target='_blank'>((031) 716 25334</a>, or mail us at
                              <a href='mailto:admn@jujurperkasa.tk'>admin@jujurperkasa.tk</a>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td>
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
