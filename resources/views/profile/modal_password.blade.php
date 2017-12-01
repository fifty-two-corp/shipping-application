<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      <h4 class="modal-title" id="modalService">Change Password</h4>
    </div>
    <div class="modal-body">
      {!! Form::open(array('class' => 'form-horizontal', 'id' => 'form-password')) !!}
        <div class="row">
          <div class="alert alert-danger fade in m-b-15" id="password-allert" hidden>
            <strong>Whoops! </strong> There were some problems with your input.
            <span class="close" data-dismiss="alert">×</span>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label class="col-md-3 control-label">Current Password</label>
              <div class="col-md-9">
                {!! Form::password('current_password', array('placeholder' => 'Current Password','class' => 'form-control')) !!}
              </div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label class="col-md-3 control-label">New Password</label>
              <div class="col-md-9">
                {!! Form::password('new_password', array('placeholder' => 'New Password','class' => 'form-control')) !!}
              </div>
            </div>
          </div> 

          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label class="col-md-3 control-label">Confirm Password</label>
              <div class="col-md-9">
                {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
              </div>
            </div>
          </div>
      </div>
        {!! Form::close() !!}
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn-save" onclick="save_password()">Save changes</button>
      </div>
    </div>
  </div>
</div>
