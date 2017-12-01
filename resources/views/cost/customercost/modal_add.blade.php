<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      <h4 class="modal-title" id="modalService">New Cutomer Cost</h4>
    </div>
    <div class="modal-body">
      {!! Form::open(array('class' => 'form-horizontal', 'id' => 'form-customer-cost-add')) !!}
        <div class="row">
          <div class="alert alert-danger fade in m-b-15" id="customer-cost-allert" hidden>
            <strong>Whoops! </strong> There were some problems with your input.
            <span class="close" data-dismiss="alert">×</span>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label class="col-md-3 control-label">Customer</label>
              <div class="col-md-9">
                {!! Form::select('customer', ['0' => '-- Please Select --'] + $customer->toArray(), [], array('class' => 'form-control', 'id' => 'customer')) !!}
              </div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label class="col-md-3 control-label">Origin Province</label>
              <div class="col-md-9">
                {!! Form::select('org_provinces', ['0' => '-- Please Select --'] + $province->toArray(), [], array('class' => 'form-control', 'id' => 'org_province')) !!}
              </div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label class="col-md-3 control-label">Destination Province</label>
              <div class="col-md-9">
                {!! Form::select('dest_provinces', ['0' => '-- Please Select --'] + $province->toArray(), [], array('class' => 'form-control', 'id' => 'dest_province')) !!}
              </div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label class="col-md-3 control-label">Type</label>
              <div class="col-md-9">
                {!! Form::text('type', null, ['placeholder' => 'Type','class' => 'form-control', 'id' => 'type']) !!}
              </div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
              <div class="form-group">
                  <label class="col-md-3 control-label">Cost</label>
                  <div class="col-md-9">
                    <div class="input-group">
                      <span class="input-group-addon">Rp.</span>
                      {!! Form::text('cost', 0, ['placeholder' => 'Cost','class' => 'form-control', 'id' => 'cost']) !!}
                    </div>
                  </div>
              </div>
          </div>

      </div>
        {!! Form::close() !!}
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn-save" onclick="save_customer_cost_data()">Save changes</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function () {
    $('#type').keyup(function() {
        this.value = this.value.toUpperCase();
    });
    $('#cost').priceFormat({
      prefix: '',
      thousandsSeparator:'.',
      centsLimit: 0
    });
});
</script>
