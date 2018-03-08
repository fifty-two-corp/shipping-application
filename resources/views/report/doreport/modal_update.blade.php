<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      <h4 class="modal-title" id="myModalLabel">Update DO Out</h4>
    </div>
    <div class="modal-body">
      {!! Form::model($do_out, ['method' => 'PATCH', 'class' => 'form-horizontal', 'id' => 'form-update-do-out']) !!}
        <div class="row">
          <div class="alert alert-danger fade in m-b-15" id="cutomer-allert" hidden>
            <strong>Whoops!</strong> There were some problems with your input.
            <span class="close" data-dismiss="alert" style="color:red">×</span>
          </div>
         
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label class="col-md-3 control-label">Status</label>
              <div class="col-md-9">
                <div class="toggle-button toggle-button--tuuli">
                  <input id='status_hidden' type='hidden' value='0' name='status'>
                  <input id="status" type="checkbox" value="1" name="status" @if($do_out_status == 1) checked @endif>
                  <label for="status"></label>
                  <div class="toggle-button__icon"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    {!! Form::close() !!}
    <div class="modal-footer">
      <button type="button" class="btn btn-primary" id="btn-save" onclick="save_edit_do_out()">Save changes</button>
    </div>
  </div>
</div>
