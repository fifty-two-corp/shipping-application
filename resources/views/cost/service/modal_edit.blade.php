<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel">Edit Service</h4>
        </div>
        <div class="modal-body">
            {!! Form::model($service, ['method' => 'PATCH', 'class' => 'form-horizontal', 'id' => 'form-edit-service']) !!}
              <div class="row">
                <div class="alert alert-danger fade in m-b-15" id="service-allert" hidden>
                  <strong>Whoops!</strong> There were some problems with your input.
                  <span class="close" data-dismiss="alert">×</span>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                          <label class="col-md-3 control-label">Type Service</label>
                          <div class="col-md-9">
                            {!! Form::text('type_service', null, array('placeholder' => 'Type Service','class' => 'form-control')) !!}
                          </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Unit</label>
                            <div class="col-md-9">
                              {!! Form::text('unit', null, array('placeholder' => 'Unit','class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Unit Price</label>
                            <div class="col-md-9">
                              <div class="input-group">
                                <span class="input-group-addon">Rp.</span>
                                {!! Form::text('unit_price', null, ['placeholder' => 'Unit Price','class' => 'form-control', 'id' => 'unit_price']) !!}
                              </div>
                            </div>
                        </div>
                    </div>
                  </div>
              </div>
              {!! Form::close() !!}
             <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-save" onclick="save_service_edit_data()">Save changes</button>
                <!-- <input type="hidden" id="task_id" name="task_id" value="0"> -->
            </div>
        </div>
    </div>
</div>
<script>
  $(document).ready(function () {
    $('#unit_price').priceFormat({
      prefix: '',
      thousandsSeparator:'.',
      centsLimit: 0
    });
});
</script>
