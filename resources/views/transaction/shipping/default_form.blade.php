 <div class="col-md-6" id="default-form">
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
      <label class="col-md-4 control-label">Shipping Type</label>
      <div class="col-md-8">
        {!! Form::select('shipping_type',['' => '-- Please Select --'] + $customer_shipping_type ,[], ['class' => 'form-control', 'id' => 'shipping_type', 'onchange' => 'get_default_calculation_cost()']) !!}
      </div>
    </div>
  </div>
</div>