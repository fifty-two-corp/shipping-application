<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel">Edit permision</h4>
        </div>
        <div class="modal-body">
            {!! Form::model($permission, ['method' => 'PATCH', 'class' => 'form-horizontal', 'id' => 'form-edit-permission']) !!}
              <div class="row">
                <div class="alert alert-danger fade in m-b-15" id="permision-allert" hidden>
                  <strong>Whoops!</strong> There were some problems with your input.
                  <span class="close" data-dismiss="alert">×</span>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                          <label class="col-md-3 control-label">Name</label>
                          <div class="col-md-9">
                            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                          </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Display Name</label>
                            <div class="col-md-9">
                              {!! Form::text('display_name', null, array('placeholder' => 'Display Name','class' => 'form-control')) !!}
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
                              {!! Form::select('child_menu', $child_menu, $permision_child_menu, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                  </div>
              </div>
              {!! Form::close() !!}
             <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-save" onclick="save_permision_edit_data()">Save changes</button>
                <input type="hidden" id="task_id" name="task_id" value="0">
            </div>
        </div>
    </div>
</div>
