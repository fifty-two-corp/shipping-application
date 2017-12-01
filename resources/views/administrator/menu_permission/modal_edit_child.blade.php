<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel">Edit Child Menu</h4>
        </div>
        <div class="modal-body">
            {!! Form::model($child_menu, ['method' => 'PATCH', 'class' => 'form-horizontal', 'id' => 'form-edit-child']) !!}
              <div class="row">
                <div class="alert alert-danger fade in m-b-15" id="child-allert" hidden>
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
                            <label class="col-md-3 control-label">Link</label>
                            <div class="col-md-9">
                              {!! Form::text('link', null, array('placeholder' => 'link','class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                      <div class="form-group">
                        <label class="col-md-3 control-label">Parent Menu</label>
                        <div class="col-md-9">
                          {!! Form::select('parent_menu', ['' => '-- Please Select --'] + $parent_menu, $parent_child_menu, array('class' => 'form-control', 'id' => 'parent_menu')) !!}
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
              {!! Form::close() !!}
             <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-save" onclick="save_child_edit_data()">Save changes</button>
                <input type="hidden" id="task_id" name="task_id" value="0">
            </div>
        </div>
    </div>
</div>
