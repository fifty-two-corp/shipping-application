<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="modal_role">New Environment</h4>
        </div>
        <div class="modal-body">
            {!! Form::open(array('class' => 'form-horizontal','method'=>'POST', 'id' => 'form-env-add')) !!}
              <div class="row">
                <div id="alert"></div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                      <label class="col-md-3 control-label">Name</label>
                      <div class="col-md-9">
                        {!! Form::text('name', null, ['placeholder' => 'Name','class' => 'form-control', 'id' => 'name']) !!}
                      </div>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                      <label class="col-md-3 control-label">Value</label>
                      <div class="col-md-9">
                        {!! Form::text('value', null, ['placeholder' => 'Value','class' => 'form-control']) !!}
                      </div>
                  </div>
                </div>
              </div>
              {!! Form::close() !!}
             <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-save" onclick="save_env_data()">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
  $('#name').keyup(function() {
      this.value = this.value.toUpperCase();
      this.value = this.value.replace(/\s/g, "_");
  });
</script>
