<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="edit-province">Edit Province - {!! $provinces->name !!}</h4>
    </div>
    <div class="modal-body">
      {!! Form::model($provinces, ['method' => 'PATCH', 'class' => 'form-horizontal', 'id' => 'form-edit-province']) !!}
        <div class="row">
          <div class="alert alert-danger fade in m-b-15" id="province-allert" hidden>
            <strong>Whoops!</strong> There were some problems with your input.
            <span class="close" data-dismiss="alert">×</span>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label class="col-md-3 control-label">Default Price</label>
              <div class="col-md-9">
                <div class="input-group">
                  <span class="input-group-addon">Rp.</span>
                  {!! Form::text('default_price', null, ['placeholder' => 'Default Price','class' => 'form-control', 'id' => 'default_price']) !!}
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
      {!! Form::close() !!}
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn-save" onclick="save_province_edit_data()">Save changes</button>
      </div>
  </div>
</div>
<script>
  $(document).ready(function () {
    $('#default_price').priceFormat({
      prefix: '',
      thousandsSeparator:'.',
      centsLimit: 0
    });
});
</script>
