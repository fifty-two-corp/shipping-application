<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="modal_role">New Roles</h4>
        </div>
        <div class="modal-body">
            {!! Form::open(array('class' => 'form-horizontal','method'=>'POST', 'id' => 'form-role-add')) !!}
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
                          {!! Form::textarea('description', null, array('placeholder' => 'Description','class' => 'form-control','style'=>'height:100px')) !!}
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                      <label class="col-md-3 control-label">Permission</label>
                      <div class="col-md-9">
                        <div id="roles">
                          <ul>
                            @foreach($permission as $item)
                            <li>{{ $item->name }}
                              @foreach($item->child_menu as $child_menu)
                              <ul>
                                <li>{{ $child_menu->name }}
                                  @foreach($child_menu->permission as $permission)
                                    <ul id="permission">
                                      <li id="{{ $permission->id }}">{{ $permission->display_name }}</li>
                                    </ul>
                                  @endforeach
                                </li>
                              </ul>
                              @endforeach
                            </li>
                            @endforeach
                          </ul>
                        </div>
                      </div>
                    </div>
                </div>
                <input id="permission-value" type="text" name="permission" hidden>
              </div>
              {!! Form::close() !!}
             <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-save" onclick="save_role_data()">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
  $(document).ready(function() {
    var checked_ids = []; // list for the checked IDs
    $('#roles').jstree({'plugins': ["wholerow", "checkbox"],});
  });
</script>
