<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="modalVihicle">New Vehicle</h4>
        </div>
        <div class="modal-body">
            {!! Form::open(array('class' => 'form-horizontal', 'id' => 'form-vehicle-add')) !!}
              <div class="row">
                <div id="alert"></div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                          <label class="col-md-3 control-label">Plat Number</label>
                          <div class="col-md-9">
                            {!! Form::text('plat_number', null, ['placeholder' => 'Plat Number','class' => 'form-control']) !!}
                          </div>
                        </div>
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
                            <label class="col-md-3 control-label">Driver</label>
                            <div class="col-md-9">
                              {!! Form::select('driver', ['' => '-- Please Select --'] + $employees, [], array('class' => 'form-control', 'id' => 'driver')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Type</label>
                            <div class="col-md-9">
                              {!! Form::text('type', null, ['placeholder' => 'Type','class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Merk</label>
                            <div class="col-md-9">
                              {!! Form::text('merk', null, ['placeholder' => 'Merk','class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Color</label>
                            <div class="col-md-9">
                              {!! Form::text('color', null, ['placeholder' => 'Color','class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Production Year</label>
                            <div class="col-md-9">
                              {!! Form::text('production_year', null, ['placeholder' => 'Production Year','class' => 'form-control', 'id' => 'production']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Vehicle Tax</label>
                            <div class="col-md-9">
                              {!! Form::text('vehicle_tax', null, ['placeholder' => 'Vehicle Tax','class' => 'form-control', 'id' => 'tax']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Status</label>
                            <div class="col-md-9">
                              {!! Form::text('status', null, ['placeholder' => 'Status','class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    
                  </div>
              </div>
              {!! Form::close() !!}
             <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-save" onclick="save_vehicle_data()">Save changes</button>
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