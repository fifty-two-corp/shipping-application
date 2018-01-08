<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      <h4 class="modal-title" id="myModalLabel">Update Shipping</h4>
    </div>
    <div class="modal-body">
      {!! Form::model($shipping, ['method' => 'PATCH', 'class' => 'form-horizontal', 'id' => 'form-update-shipping']) !!}
        <div class="row">
          <div class="alert alert-danger fade in m-b-15" id="cutomer-allert" hidden>
            <strong>Whoops!</strong> There were some problems with your input.
            <span class="close" data-dismiss="alert" style="color:red">×</span>
          </div>
         
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label class="col-md-3 control-label">Status</label>
              <div class="col-md-9">
                {!! Form::select('status',['Pending' => 'Pending', 'On Process' => 'On Process', 'Complete' => 'Complete', 'Cancel' => 'Cancel'],$status, array('class' => 'form-control', 'id' => 'status')) !!}
              </div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label class="col-md-3 control-label">Operational Cost</label>
              <div class="col-md-9">
                <div class="input-group">
                  <span class="input-group-addon">Rp.</span>
                  {!! Form::text('operational_cost', null, ['placeholder' => 'Operational Cost','class' => 'form-control', 'id' => 'operational_cost']) !!}
                </div>
              </div>
            </div>
          </div>
          @if ($shipping->shipping_method == 'default')
            <div class="col-xs-12 col-sm-12 col-md-12">
              <div class="form-group">
                <label class="col-md-3 control-label">Vehicle</label>
                <div class="col-md-9">
                  {!! Form::select('vehicle', ['' => '-- Please Select --'] + $vehicle, $vehicle_plat_number, array('class' => 'form-control', 'id' => 'vehicle')) !!}
                </div>
              </div>
            </div>
          @endif

        </div>
    </div>
    {!! Form::close() !!}
    <div class="modal-footer">
      <button type="button" class="btn btn-primary" id="btn-save" onclick="save_update_shipping_data()">Save changes</button>
    </div>
  </div>
</div>
</div>
<script>
  $(document).ready(function () {
    $('#cost').priceFormat({
      prefix: 'Rp. ',
      thousandsSeparator:'.',
      centsLimit: 0
    });

    $('#operational_cost').priceFormat({
      prefix: '',
      thousandsSeparator:'.',
      centsLimit: 0
    });
});
</script>
