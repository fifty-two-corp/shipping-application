<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel">Edit Vehicle</h4>
        </div>
        <div class="modal-body">
            {!! Form::model($vehicle, ['method' => 'PATCH', 'class' => 'form-horizontal', 'id' => 'form-edit-vehicle']) !!}
              <div class="row">
                <div class="alert alert-danger fade in m-b-15" id="vehicle-allert" hidden>
                  <strong>Whoops!</strong> There were some problems with your input.
                  <span class="close" data-dismiss="alert">×</span>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                          <label class="col-md-3 control-label">Plat Number</label>
                          <div class="col-md-9">
                            {!! Form::text('plat_number', null, array('placeholder' => 'Plat Number','class' => 'form-control')) !!}
                          </div>
                        </div>
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
                            <label class="col-md-3 control-label">Driver</label>
                            <div class="col-md-9">
                              {!! Form::select('driver',['' => '-- Please Select --'] + $employees, $vehicle_employees, array('class' => 'form-control', 'id' => 'driver')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Type</label>
                            <div class="col-md-9">
                              {!! Form::text('type', null, array('placeholder' => 'Type','class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Merk</label>
                            <div class="col-md-9">
                              {!! Form::text('merk', null, array('placeholder' => 'Merk','class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Color</label>
                            <div class="col-md-9">
                              {!! Form::text('color', null, array('placeholder' => 'Color','class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Production Year</label>
                            <div class="col-md-9">
                              {!! Form::text('production_year', null, array('placeholder' => 'Production Year','class' => 'form-control', 'id' => 'production')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Vehicle Tax</label>
                            <div class="col-md-9">
                              {!! Form::text('vehicle_tax', $vehicle_tax, array('placeholder' => 'Vehicle Tax','class' => 'form-control', 'id' => 'tax')) !!}
                            </div>
                        </div>
                    </div>
                   
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Status</label>
                            <div class="col-md-9">
                              {!! Form::text('status', null, array('placeholder' => 'Status','class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                    
                  </div>
              </div>
              {!! Form::close() !!}
             <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-save" onclick="save_vehicle_edit_data()">Save changes</button>
            </div>
        </div>
    </div>
</div>
<script>
  $('#tax').datepicker({
    format: "dd-mm-yyyy",
    language: "id",
    calendarWeeks: true,
    autoclose: true,
    todayHighlight: true,
    toggleActive: true
  });

  $("#production").datepicker( {
    format: " yyyy",
    viewMode: "years", 
    minViewMode: "years",
    autoclose: true,
    toggleActive: true
  });
</script>