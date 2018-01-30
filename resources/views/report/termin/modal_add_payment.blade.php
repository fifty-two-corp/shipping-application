<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      <h4 class="modal-title" id="myModalLabel">Add Payment</h4>
    </div>
    <div class="modal-body">
      {!! Form::open(array('class' => 'form-horizontal', 'id' => 'form-add-payment')) !!}
        <div class="row">
          <div class="alert alert-danger fade in m-b-15" id="cutomer-allert" hidden>
            <strong>Whoops!</strong> There were some problems with your input.
            <span class="close" data-dismiss="alert" style="color:red">×</span>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label class="col-md-3 control-label">Payment Date</label>
              <div class="col-md-9">
                {!! Form::text('payment_date', null, ['placeholder' => 'Payment Date','class' => 'form-control', 'id' => 'payment_date']) !!}
              </div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label class="col-md-3 control-label">Payment</label>
              <div class="col-md-9">
                <div class="input-group">
                  <span class="input-group-addon">Rp.</span>
                  {!! Form::text('payment', null, ['placeholder' => 'Payment','class' => 'form-control', 'id' => 'payment']) !!}
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    {!! Form::close() !!}
    <div class="modal-footer">
      <button type="button" class="btn btn-primary" id="btn-save" onclick="save_add_payment()">Save changes</button>
    </div>
  </div>
</div>
</div>
<script>
  $(document).ready(function () {
    $('#payment').priceFormat({
      prefix: '',
      thousandsSeparator:'.',
      centsLimit: 0
    });
    $("#payment_date").datepicker( {
      format: 'dd-mm-yyyy',
      autoclose: true,
      toggleActive: true,
      clearBtn: true
    });
});
</script>
