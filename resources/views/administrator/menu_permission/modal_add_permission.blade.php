<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel">New Permission</h4>
        </div>
        <div class="modal-body">
            {!! Form::open(array('class' => 'form-horizontal', 'id' => 'form-permission')) !!}
              <div class="row">
                <div class="alert alert-danger fade in m-b-15" id="permission-allert" hidden>
                  <strong>Whoops!</strong> There were some problems with your input.
                  <span class="close" data-dismiss="alert">×</span>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                          <label class="col-md-3 control-label">Name</label>
                          <div class="col-md-9">
                            {!! Form::text('name', null, ['placeholder' => 'Name','class' => 'form-control']) !!}
                          </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Display Name</label>
                            <div class="col-md-9">
                              {!! Form::text('display_name', null, ['placeholder' => 'Display Name','class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Description</label>
                            <div class="col-md-9">
                              {!! Form::textarea('description', null, ['placeholder' => 'Description','class' => 'form-control', 'size' => '30x5']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Child Menu</label>
                            <div class="col-md-9">
                              {!! Form::select('child_menu', ['' => '-- Please Select --'] + $child_menu,[], array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                  </div>
              </div>
              {!! Form::close() !!}
             <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-save" onclick="save_permission_data()">Save changes</button>
                <input type="hidden" id="task_id" name="task_id" value="0">
            </div>
        </div>
    </div>
</div>
