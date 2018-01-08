@extends('layouts.layout')
@section('content')
<div id="content" class="content">        
  <h1 class="page-header">Transaction <small></small></h1>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-inverse">
        <div class="panel-heading">
          <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
          </div>
          <h4 class="panel-title">Create Shipping</h4>
        </div>
        <div class="panel-body">
        <form action="http://seantheme.com/" method="POST" data-parsley-validate="true" name="form-wizard">
          <div id="wizard">
            <ol>
              <li>TEST <small></small></li>
              <li>Destination<small></small></li>
              <li>Method<small></small></li>
              <li>Cost  <small></small></li>
              <li>Invoice<small></small></li>
            </ol>
            <div class="wizard-step-1">
              <fieldset>
                <legend class="pull-left width-full">Customer</legend>
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
                            {!! Form::select('customer',['' => '-- Please Select --'] + $customer_list ,[], ['class' => 'form-control', 'id' => 'customer_list', 'onchange' => 'get_customer_data()', 'data-parsley-group' => 'wizard-step-1', 'required']) !!}
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
                          {!! Form::text('customer_address', null, ['placeholder' => '-','class' => 'form-control no-border no-extras', 'id' => 'customer_address','disabled']) !!}
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
              </fieldset>
            </div>
            <div class="wizard-step-2">
              <fieldset>
                <legend class="pull-left width-full">Destination</legend>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group block1">
                        <label>Name</label>
                        {!! Form::text('consignee_name', null, ['placeholder' => 'Name','class' => 'form-control', 'id' => 'consignee_name', 'data-parsley-group' => 'wizard-step-2']) !!}
                      </div>
                      <div class="form-group">
                        <label>Address</label>
                        {!! Form::textarea('consignee_address', null, ['placeholder' => 'Address','class' => 'form-control', 'size' => '30x5', 'id' => 'consignee_address']) !!}
                      </div>
                      <div class="form-group">
                        <label >Phone</label>
                        {!! Form::text('consignee_phone', null, ['placeholder' => 'Phone','class' => 'form-control', 'id' => 'consignee_phone']) !!}
                      </div>
                    </div>                    
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Province</label>
                        {!! Form::select('consignee_province',['' => '-- Please Select --'] + $provinces ,[], ['class' => 'form-control', 'id' => 'consignee_province']) !!}
                      </div>
                      <div class="form-group">
                        <label>City</label>    
                        {!! Form::select('consignee_city',['' => '-- Please Select --'] ,[], ['class' => 'form-control', 'id' => 'consignee_city']) !!}
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 control-label">District</label>    
                        {!! Form::select('consignee_district',['' => '-- Please Select --'] ,[], ['class' => 'form-control', 'id' => 'consignee_district']) !!}    
                      </div>
                    </div>
                  </div>
              </fieldset>
            </div>
            <div class="wizard-step-3">
              <fieldset>
                <legend>
                  <div class="row">
                    <div class="form-group">
                      <label class="col-md-4 control-label">Shipping Method</label>
                      <div class="col-md-4">
                        <label class="radio-inline"><input type="radio" name="optionsRadios" value="option1" checked="">Default</label>
                      </div>
                      <div class="col-md-4">
                        <label class="radio-inline"><input type="radio" name="optionsRadios" value="option1" >Vendor</label>
                      </div>
                    </div>
                  </div>
                </legend>
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                    <label class="col-md-4 control-label">Shipping Type</label>
                    <div class="col-md-8">
                      {!! Form::select('shipping_method',['0' => '-- Please Select --'] ,[], ['class' => 'form-control', 'id' => 'shipping_method']) !!}
                    </div>
                  </div>
                  </div>
                </div>
              </fieldset>
            </div>
            <div class="wizard-step-4">
              <fieldset>
                <legend></legend>
                <div class="row">
                  <div class="invoice-price">
              <div class="invoice-price-left">
                <div class="invoice-price-row invisible" id="detail_cost">
                  <div class="sub-price">
                    <small>SUBTOTAL</small>
                    Rp. <span id="subtotal_cost">0</span>
                  </div>
                  <div class="sub-price">
                    <i class="fa fa-minus"></i>
                  </div>
                  <div class="sub-price">
                    <small>Discount (<span id="customer_discount">0%</span>)</small>
                    Rp. <span id="discount_cost">0</span>
                  </div>
                </div>
              </div>
              <div class="invoice-price-right">
                <small>TOTAL</small> Rp. <span id="total_cost">0</span>
              </div>
            </div>
                </div>
              </fieldset>
            </div>
            <div>
              <div class="jumbotron m-b-0 text-center">
                <h1>Login Successfully</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris consequat commodo porttitor. Vivamus eleifend, arcu in tincidunt semper, lorem odio molestie lacus, sed malesuada est lacus ac ligula. Aliquam bibendum felis id purus ullamcorper, quis luctus leo sollicitudin. </p>
                <p><a class="btn btn-success btn-lg" role="button">Proceed to User Profile</a></p>
              </div>
            </div>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@push('js')
<script type="text/javascript">
  $('#transaction-menu').addClass('active');
  $('#shipping-menu').addClass('active');
  $("#wizard").bwizard({
    validating:function(e,t){
      if(t.index==0){
        if(false===$('form[name="form-wizard"]').parsley().validate("wizard-step-1")){
          return false}
        } else if(t.index==1){
          if(false===$('form[name="form-wizard"]').parsley().validate("wizard-step-2")){
            return false}
          } else if(t.index==2){
            if(false===$('form[name="form-wizard"]').parsley().validate("wizard-step-3")){
              return false
            }
          }
        }
      });
      
  $( "#consignee_province" ).change(function() {
    getCalculationCost()
    $('#consignee_city option').remove();
    $('#consignee_city').append('<option value="0">-- Please Select --</option');
    $('#consignee_district option').remove();
    $('#consignee_district').append('<option value="0">-- Please Select City --</option');
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
        }
      });
    } else {
      $('#consignee_city option').remove();
      $('#consignee_city').append('<option value="0">-- Please Select Province --</option');
      $('#consignee_district option').remove();
      $('#consignee_district').append('<option value="0">-- Please Select Province --</option');
    }
   
  });

  $( "#consignee_city" ).change(function() {
    $('#consignee_district option').remove();
    $('#consignee_district').append('<option value="0">-- Please Select --</option');
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
        }
      });
    } else {
      $('#consignee_district option').remove();
      $('#consignee_district').append('<option value="0">-- Please Select City --</option');
    }
  });

  $( "#shipping_method" ).change(function() {
      getCalculationCost();
  });

  function get_customer_data() {
    $('#shipping_method option').remove();
    $('#shipping_method').append('<option value="0">-- Please Select --</option');
    var id = $('#customer_list').val();
    if (id != '0') {
      $.ajax({
        type:"GET",
        url: "shipping/get-customer-data/" + id,
        success: function(data) {
          console.log(data);
           $('#customer_number').val(data.customer_number);
           $('#customer_phone').val(data.phone);
           $('#customer_npwp').val(data.npwp);
           $('#customer_address').val(data.address);
           $('#customer_province').val(data.province.name);
           $('#customer_city').val(data.city.name);
           $('#customer_district').val(data.districts.name);
          //var customer_province_id = '35';
          get_customer_shipping_type(id);
          //getCalculationCost();
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

  function get_customer_shipping_type(id) {
    var ids = $('#customer_list').val();
    if (ids != 0 ) {
      $.ajax({
          type:"GET",
          url: "shipping/get-customer-shipping-type/" + id,
          success: function(data) {
             $.each(data, function (i, item) {
              $('#shipping_method').append($('<option>', { 
                value: item,
                text : item
              }));
            });
          }
        });
    } else {
      $('#shipping_method option').remove();
      $('#shipping_method').append('<option value="0">-- Please Select --</option');
    }
  }

  function getCalculationCost() {
    //var origin        = $('#customer_province').val();
    var origin        = '35';
    var destination   = $('#consignee_province').val();
    var customer_id   = $('#customer_list').val();
    var type          = $('#shipping_method').val();
    clearCost();
    if (origin == null || origin == '-'){
      return false;
    } else if (customer_id == 0 || customer_id == null) {
      return false;
    } else if (destination == null || destination == 0) {
      return false;
    } else if (type == 0 || type == null) {
      return false;
    } else {
        $.ajax({
        type:"GET",
        url: "shipping/get-calculation-cost/"+origin+'/'+destination+'/'+customer_id,
        success: function(data) {
          if (data.customer_discount != '0%') {
            $('#detail_cost').removeClass('invisible');
          }
          $('#subtotal_cost').html(data.cost);
          $('#customer_discount').html(data.customer_discount);
          $('#discount_cost').html(data.discount);
          $('#total_cost').html(data.total);
        }
      });
    }
  }

  function clearCost() {
    $('#detail_cost').addClass('invisible');
    $('#subtotal_cost').html('0');
    $('#customer_discount').html('0%');
    $('#discount_cost').html('0');
    $('#total_cost').html('0');
  }

  function store(){
    $.ajaxSetup({
    header:$('meta[name="_token"]').attr('content')
  })
  $.ajax({
    type:"POST",
    url:'shipping/store',
    data:$('#form-create-shipping').serialize(),
    dataType: 'json',
    success: function(data){
      console.log(data);
      swal('Added','','success');
    },
      error: function(data){
        swal('Error','Please Check Your Data','error');
    }
  })
  }

</script>
@endpush