@extends('layouts.layout')
@section('content')
<div id="content" class="content">        
    <h1 class="page-header">Transaction <small></small></h1>
    <div class="row">
      <div class="panel panel-inverse" data-sortable-id="form-stuff-5">
          <div class="panel-heading">
              <div class="panel-heading-btn">
                  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
              </div>
              <h4 class="panel-title">Create Shipping</h4>
          </div>
          <div class="panel-body">
            {!! Form::open(array('url' => '#', 'class' => 'form-horizontal', 'id' => 'form-create-shipping', 'novalidate')) !!}
            <fieldset>
              <legend>Customer</legend>
              <div class="row">
                <div class="col-md-6">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                      <label class="col-md-4 control-label">No. Customer :</label>
                      <div class="col-md-8">
                        {!! Form::text('customer_number', null, ['placeholder' => '-','class' => 'form-control no-border no-extras', 'id' => 'customer_number', 'disabled']) !!}
                      </div>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label class="col-md-4 control-label">Name :</label>
                        <div class="col-md-8">
                          {!! Form::select('customer',['' => '-- Please Select --'] + $customer_list ,[], ['class' => 'form-control', 'id' => 'customer_list', 'onchange' => 'get_customer_data()', 'required']) !!}
                          <div class="help-block with-errors"></div>
                        </div>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                      <label class="col-md-4 control-label">Phone :</label>
                      <div class="col-md-8">
                        {!! Form::text('customer_phone', null, ['placeholder' => '-','class' => 'form-control no-border no-extras', 'id' => 'customer_phone','disabled']) !!}
                      </div>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                      <label class="col-md-4 control-label">NPWP :</label>
                      <div class="col-md-8">
                        {!! Form::text('customer_npwp', null, ['placeholder' => '-','class' => 'form-control no-border no-extras', 'id' => 'customer_npwp','disabled']) !!}
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                      <label class="col-md-4 control-label">Address :</label>
                      <div class="col-md-8">
                        {!! Form::textarea('customer_address', null, ['placeholder' => '-','class' => 'form-control no-border no-extras', 'size' => '30x5', 'id' => 'customer_address','disabled']) !!}
                      </div>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                      <label class="col-md-4 control-label">Province :</label>
                      <div class="col-md-8">
                        {!! Form::text('customer_province', null, ['placeholder' => '-','class' => 'form-control no-border no-extras', 'id' => 'customer_province','disabled']) !!}
                      </div>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                      <label class="col-md-4 control-label">City :</label>
                      <div class="col-md-8">
                        {!! Form::text('customer_city', null, ['placeholder' => '-','class' => 'form-control no-border no-extras', 'id' => 'customer_city','disabled']) !!}
                      </div>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                      <label class="col-md-4 control-label">District :</label>
                      <div class="col-md-8">
                        {!! Form::text('customer_district', null, ['placeholder' => '-','class' => 'form-control no-border no-extras', 'id' => 'customer_district','disabled']) !!}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </fieldset>

            <fieldset>
              <legend>Destination</legend>
              <div class="row">
                <div class="col-md-6">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                      <label class="col-md-4 control-label">Name</label>
                      <div class="col-md-8">
                        {!! Form::text('consignee_name', null, ['placeholder' => 'Name','class' => 'form-control', 'id' => 'consignee_name', 'required']) !!}
                      </div>
                    </div>
                  </div>

                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                      <label class="col-md-4 control-label">Address</label>
                      <div class="col-md-8">
                        {!! Form::textarea('consignee_address', null, ['placeholder' => 'Address','class' => 'form-control', 'size' => '30x5', 'id' => 'consignee_address', 'required']) !!}
                      </div>
                    </div>
                  </div>

                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                      <label class="col-md-4 control-label">Phone</label>
                      <div class="col-md-8">
                        {!! Form::text('consignee_phone', null, ['placeholder' => 'Phone','class' => 'form-control', 'id' => 'consignee_phone', 'required']) !!}
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label class="col-md-4 control-label">Province</label>
                        <div class="col-md-8">
                          {!! Form::select('consignee_province',['' => '-- Please Select --'] + $provinces ,[], ['class' => 'form-control', 'id' => 'consignee_province', 'required']) !!}
                        </div>
                    </div>
                  </div>

                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label class="col-md-4 control-label">City</label>
                        <div class="col-md-8">
                          {!! Form::select('consignee_city',['' => '-- Please Select --'] ,[], ['class' => 'form-control', 'id' => 'consignee_city', 'required']) !!}
                        </div>
                    </div>
                  </div>

                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label class="col-md-4 control-label">District</label>
                        <div class="col-md-8">
                          {!! Form::select('consignee_district',['' => '-- Please Select --'] ,[], ['class' => 'form-control', 'id' => 'consignee_district', 'required']) !!}
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </fieldset>

            <fieldset >
              <legend>Load List</legend>
                  <div class="col-xs-12 col-sm-12 col-md-12" id="load-list-field">
                    <div class="form-group">
                      <div class="col-md-12">
                        <div class="input-group">
                          <span class="input-group-addon">Item</span>
                          <input type="text" class="form-control" size="95%" name="load_item[]" placeholder="Item Name">
                          <span class="input-group-addon">Quantity</span>
                          <input type="text" class="form-control" size="1%" name="load_quantity[]">
                          <span class="input-group-addon">Dimension</span>
                          <input type="text" class="form-control" size="1%" name="load_dimension[]">
                          <span class="btn btn-success input-group-addon" id="add-list">+</span>
                        </div>
                      </div>
                  </div>
                </div>
            </fieldset>

            <div id="shipping_method_field">
              <fieldset >
                <legend>Shipping Method 
                  <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-default"><input type="radio" name="method" value="default" id="default" required>Default</label>
                    <label class="btn btn-default"><input type="radio" name="method" value="vendor" id="vendor" required>Vendor</label>
                  </div>
                </legend>
                <div class="row" id="shipping_method_form"></div>
              </fieldset>
            </div>

            <fieldset >
              <legend>Payment 
                <div class="btn-group" data-toggle="buttons">
                  <label class="btn btn-default"><input type="radio" name="payment" value="pay_off" id="pay_off" required>Pay Off</label>
                  <label class="btn btn-default"><input type="radio" name="payment" value="installment" id="installment" required>Installment</label>
                </div>
              </legend>
              <div class="row" id="installment_form"></div>
            </fieldset>

            <div class="row" id="vendor_form"></div>
              <div class="invoice-price">
                <div class="invoice-price-left">
                  <div class="invoice-price-row" id="detail_cost">
                    <div class="sub-price">
                      <small>SUBTOTAL</small>
                      Rp. <span id="subtotal_cost">0</span>
                    </div>
                    <div class="sub-price">
                      <i class="fa fa-plus"></i>
                    </div>
                    <div class="sub-price">
                      <small>TAX (<span id="tax">0%</span>)</small>
                      Rp. <span id="tax_cost">0</span>
                    </div>
                  </div>
                </div>
                <div class="invoice-price-right">
                  <small>TOTAL</small> Rp. <span id="total_cost">0</span>
                </div>
              </div>
            <br>
            <div align="center"><button type="submit" class="btn btn-primary btn-lg" id="btn-save">Save Shipping</button></div>
            {!! Form::close() !!}
          </div>
      </div>
    </div>
</div>
@endsection
@push('js')
<script type="text/javascript">
  $('#transaction-menu').addClass('active');
  $('#shipping-menu').addClass('active');

  $( "#consignee_province" ).change(function() {
    getShippingMethodField();
    $('#consignee_city option').remove();
    $('#consignee_city').append('<option value="">-- Please Select --</option>');
    $('#consignee_district option').remove();
    $('#consignee_district').append('<option value="">-- Please Select City --</option>');
    var ids = $('#consignee_province').val();
    if (ids != 0 ) {
      $.ajax({
        type:"GET",
        url: "get-city"+ "/" + ids,
        success: function(city) {
          var data_city = city;
          $.each(data_city, function (i, item) {
            $('#consignee_city').append($('<option>', {
              value: item.id,
              text : item.name
            }));
          });
          getShippingMethodField();
          clearCost();
        }
      });
    } else {
      $('#consignee_city option').remove();
      $('#consignee_city').append('<option value="">-- Please Select Province --</option>');
      $('#consignee_district option').remove();
      $('#consignee_district').append('<option value="">-- Please Select Province --</option>');
    }
  });

  $( "#consignee_city" ).change(function() {
    $('#consignee_district option').remove();
    $('#consignee_district').append('<option value="">-- Please Select --</option');
    var ids = $('#consignee_city').val();
    if (ids != 0 ) {
      $.ajax({
        type:"GET",
        url: "get-district"+ "/" + ids,
        success: function(district) {
          var data_district = district;
          $.each(data_district, function (i, item) {
            $('#consignee_district').append($('<option>', { 
              value: item.id,
              text : item.name
            }));
          });
          getShippingMethodField();
          clearCost();
        }
      });
    } else {
      $('#consignee_district option').remove();
      $('#consignee_district').append('<option value="">-- Please Select City --</option');
    }
  });

  $( "#shipping_method" ).change(function() {
      getCalculationCost();
  });

  $('#add-list').click(function() {
    var inp = $('#load-list-field');
    var i = $('.load-list').size() + 1;
    $('<div class="form-group load-list" ><div class="col-md-12"><div class="input-group"><span class="input-group-addon">Item</span><input type="text" class="form-control" size="95%" name="load_item[]" placeholder="Item Name"><span class="input-group-addon">Quantity</span><input type="text" class="form-control" size="1%" name="load_quantity[]"><span class="input-group-addon">Dimension</span><input type="text" class="form-control" size="1%" name="load_dimension[]"><span class="btn btn-danger input-group-addon" id="remove-list">-</span></div></div>').appendTo(inp);
    i++;
  });

  $('body').on('click','#remove-list',function(){
    $(this).parents('.load-list').remove();
  });

  $('#form-create-shipping').validator().on('submit', function (e) {
    e.preventDefault();
    $.ajaxSetup({
      header:$('meta[name="_token"]').attr('content')
    })
    $.ajax({
      type:"POST",
      url:'shipping/store',
      data:$('#form-create-shipping').serialize(),
      dataType: 'json',
      success: function(data){
        window.location.replace('{{ URL("shipping/shipping-list?created_shipping") }}');
      },
        error: function(data){
          swal('Error','Please Check Your Data','error');
      }
    })
  });

  $('input[type=radio][name=payment]').change(function() {
      if (this.value == 'installment') {
        $.ajax({
          type:"GET",
          url: "shipping/installment-form",
          success: function(data) {
            $("#installment_form").html('');
            $("#installment_form").append(data);
          }
        });
      } else {
        $("#installment_form").html('');
      }
   });

  function get_customer_data() {
    var id = $('#customer_list').val();
    if (id != '') {
      $.ajax({
        type:"GET",
        url: "shipping/get-customer-data/" + id,
        success: function(data) {
          $('#customer_number').val(data.customer_number);
          $('#customer_phone').val(data.phone);
          $('#customer_npwp').val(data.npwp);
          $('#customer_address').val(data.address);
          $('#customer_province').val(data.province.name);
          $('#customer_city').val(data.city.name);
          $('#customer_district').val(data.districts.name);
          reload_shipping_method();
          clearCost();
        }
      });
    } else {
      $('#customer_number').val('-');
      $('#customer_phone').val('-');
      $('#customer_npwp').val('-');
      $('#customer_address').val('-');
      $('#customer_province').val('-');
      $('#customer_city').val('-');
      $('#customer_district').val('-');
    }
  }

  function getShippingMethodField() {
    clearCost();
    city = $("#consignee_city").val();
    customer = $("#customer_list").val();
    $.ajax({
      type:"GET",
      url:'shipping/get-shipping-mehod-field',
      success: function(data){
        $("#shipping_method_field").html('');
        $("#shipping_method_field").append(data);
      }
    })
  }

  function get_default_calculation_cost() {
    var id = $('#shipping_type').val();
    clearCost();
      $.ajax({
      type:"GET",
      url: "shipping/get-calculation-default-cost/"+id,
      success: function(data) {
        $('#subtotal_cost').html(data.cost);
        $('#tax').html(data.tax);
        $('#tax_cost').html(data.tax_cost);
        $('#total_cost').html(data.total_cost);
      }
    });
  }

  function get_vendor_calculation_cost() {
    var id = $('#vendor_shipping_type').val();
    clearCost();
      $.ajax({
      type:"GET",
      url: "shipping/get-calculation-vendor-cost/"+id,
      success: function(data) {
        $('#subtotal_cost').html(data.cost);
        $('#tax').html(data.tax);
        $('#tax_cost').html(data.tax_cost);
        $('#total_cost').html(data.total_cost);
      }
    });
  }

  function reload_shipping_method() {
    method = $('input[type=radio][name=method]');
    for (var i = 0, length = method.length; i < length; i++) {
      if (method[i].checked) {
        if (method[i].value === 'default') {
          getDefaultForm();
        } else if (method[i].value === 'vendor') {
          getVendorForm();
        }
      }
    }
  }

  function clearCost() {
    $('#subtotal_cost').html('0');
    $('#tax').html('0%');
    $('#tax_cost').html('0');
    $('#total_cost').html('0');
  }

</script>
@endpush