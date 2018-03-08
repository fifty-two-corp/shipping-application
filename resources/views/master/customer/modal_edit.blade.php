<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      <h4 class="modal-title" id="myModalLabel">Edit Customer</h4>
    </div>
    <div class="modal-body">
      {!! Form::model($customer, ['method' => 'PATCH', 'class' => 'form-horizontal', 'id' => 'form-edit-customer']) !!}
        <div class="row">
          <div class="alert alert-danger fade in m-b-15" role="alert" hidden>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button><div id="alert"></div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label class="col-md-3 control-label">Customer Number</label>
              <div class="col-md-9">
                {!! Form::text('customer_number', null, array('placeholder' => 'Customer Number','class' => 'form-control', 'autofocus')) !!}
              </div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
              <div class="form-group">
                  <label class="col-md-3 control-label">Name</label>
                  <div class="col-md-9">
                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control', 'id' => 'name')) !!}
                  </div>
              </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
              <div class="form-group">
                  <label class="col-md-3 control-label">Address</label>
                  <div class="col-md-9">
                    {!! Form::textarea('address', null, array('placeholder' => 'Address','class' => 'form-control', 'size' => '30x5')) !!}
                  </div>
              </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
              <div class="form-group">
                  <label class="col-md-3 control-label">Province</label>
                  <div class="col-md-9">
                    {!! Form::select('province',['' => '-- Please Select --'] + $province,$customer_province, array('class' => 'form-control', 'id' => 'province')) !!}
                  </div>
              </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
              <div class="form-group">
                  <label class="col-md-3 control-label">City</label>
                  <div class="col-md-9">
                    {!! Form::select('city', ['' => '-- Please Select Province--'] + $city, $city_customer, array('class' => 'form-control', 'id' => 'city')) !!}
                  </div>
              </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
              <div class="form-group">
                  <label class="col-md-3 control-label">District</label>
                  <div class="col-md-9">
                    {!! Form::select('districts', ['' => '-- Please Select City--'] + $districts, $district_customer, array('class' => 'form-control', 'id' => 'districts')) !!}
                  </div>
              </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label class="col-md-3 control-label">Phone</label>
              <div class="col-md-9">
                {!! Form::text('phone', null, ['placeholder' => 'Phone','class' => 'form-control']) !!}
              </div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label class="col-md-3 control-label">NPWP</label>
              <div class="col-md-9">
                {!! Form::text('npwp', null, ['placeholder' => 'NPWP','class' => 'form-control']) !!}
              </div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label class="col-md-3 control-label">User</label>
              <div class="col-md-9">
                {!! Form::select('users', ['' => '-- Please Select --'] + $users, $user_id, array('class' => 'form-control', 'id' => 'users')) !!}
              </div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
              <div class="form-group">
                  <label class="col-md-3 control-label">Discount</label>
                  <div class="col-md-9">
                    <div class="input-group">
                      {!! Form::number('discount', null, ['placeholder' => 'Discount','class' => 'form-control', 'id' => 'discount']) !!}
                      <span class="input-group-addon">%</span>
                    </div>
                  </div>
              </div>
          </div>

        </div>
    </div>
    {!! Form::close() !!}
    <div class="modal-footer">
      <button type="button" class="btn btn-primary" id="btn-save" onclick="save_edit_customer_data()">Save changes</button>
    </div>
  </div>
</div>
</div>
<script>
  $('#name').keyup(function() {
      this.value = this.value.toUpperCase();
  });
  $( "#province" ).change(function() {
    $('#city option').remove();
    $('#city').append('<option value="">-- Please Select --</option');
    $('#districts option').remove();
    $('#districts').append('<option value="">-- Please Select City --</option');
    var ids = $('#province').val();
    if (ids != 0 ) {
      $.ajax({
        type:"GET",
        url: "get-city"+ "/" + ids,
        success: function(city) {
          var data_city = city;
          $.each(data_city, function (i, item) {
            $('#city').append($('<option>', { 
              value: item.id,
              text : item.name 
            }));
          });
        }
      });
    } else {
      $('#city option').remove();
      $('#city').append('<option value="">-- Please Select Province --</option');
      $('#districts option').remove();
      $('#districts').append('<option value="">-- Please Select Province --</option');
    }
   
});

$( "#city" ).change(function() {
    $('#districts option').remove();
    $('#districts').append('<option value="">-- Please Select --</option');
    var ids = $('#city').val();
    if (ids != 0 ) {
      $.ajax({
        type:"GET",
        url: "get-district"+ "/" + ids,
        success: function(district) {
          //console.log(district);
          var data_district = district;
          $.each(data_district, function (i, item) {
            $('#districts').append($('<option>', { 
              value: item.id,
              text : item.name
            }));
          });
        }
      });
    } else {
      $('#districts option').remove();
      $('#districts').append('<option value="">-- Please Select City --</option');
    }
   
});
</script>
