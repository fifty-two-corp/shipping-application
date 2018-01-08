<div class="col-md-6">

<div class="col-xs-12 col-sm-12 col-md-12">
  <div class="form-group">
    <label class="col-md-4 control-label">No. Vendor</label>
    <div class="col-md-8">
      {!! Form::text('vendor_number', null, ['placeholder' => '-','class' => 'form-control no-border no-extras', 'id' => 'vendor_number', 'disabled']) !!}
    </div>
  </div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12">
  <div class="form-group">
      <label class="col-md-4 control-label">Name</label>
      <div class="col-md-8">
        {!! Form::select('vendor',['' => '-- Please Select --'] + $vendor,[], ['class' => 'form-control', 'id' => 'vendor_list', 'onchange' => 'get_vendor_data()', 'required']) !!}
      </div>
  </div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12">
  <div class="form-group">
    <label class="col-md-4 control-label">Phone</label>
    <div class="col-md-8">
      {!! Form::text('vendor_phone', null, ['placeholder' => '-','class' => 'form-control no-border no-extras', 'id' => 'vendor_phone','disabled']) !!}
    </div>
  </div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12">
  <div class="form-group">
    <label class="col-md-4 control-label">Shipping Type</label>
    <div class="col-md-8">
      {!! Form::select('shipping_type',['' => '-- Please Select --'],[], ['class' => 'form-control', 'id' => 'vendor_shipping_type', 'onchange' => 'get_vendor_calculation_cost()', 'required']) !!}
    </div>
  </div>
</div>

</div>

<div class="col-md-6">

<div class="col-xs-12 col-sm-12 col-md-12">
  <div class="form-group">
    <label class="col-md-4 control-label">Address</label>
    <div class="col-md-8">
      {!! Form::text('vendor_address', null, ['placeholder' => '-','class' => 'form-control no-border no-extras', 'id' => 'vendor_address','disabled']) !!}
    </div>
  </div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12">
  <div class="form-group">
    <label class="col-md-4 control-label">Province</label>
    <div class="col-md-8">
      {!! Form::text('vendor_province', null, ['placeholder' => '-','class' => 'form-control no-border no-extras', 'id' => 'vendor_province','disabled']) !!}
    </div>
  </div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12">
  <div class="form-group">
    <label class="col-md-4 control-label">City</label>
    <div class="col-md-8">
      {!! Form::text('vendor_city', null, ['placeholder' => '-','class' => 'form-control no-border no-extras', 'id' => 'vendor_city','disabled']) !!}
    </div>
  </div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12">
  <div class="form-group">
    <label class="col-md-4 control-label">District</label>
    <div class="col-md-8">
      {!! Form::text('vendor_district', null, ['placeholder' => '-','class' => 'form-control no-border no-extras', 'id' => 'vendor_district','disabled']) !!}
    </div>
  </div>
</div>