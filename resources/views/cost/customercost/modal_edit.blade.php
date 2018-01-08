<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      <h4 class="modal-title" id="myModalLabel">Edit Customer Cost</h4>
    </div>
    <div class="modal-body">
      {!! Form::model($customercost, ['method' => 'PATCH', 'class' => 'form-horizontal', 'id' => 'form-edit-cutomer-cost']) !!}
        <div class="row">
          <div class="alert alert-danger fade in m-b-15" id="customer-cost-allert" hidden>
            <strong>Whoops!</strong> There were some problems with your input.
            <span class="close" data-dismiss="alert">×</span>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label class="col-md-3 control-label">Customer</label>
              <div class="col-md-9">
                {!! Form::select('customer', $customer, $customer_cost_customer, array('class' => 'form-control', 'id' => 'customer')) !!}
              </div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label class="col-md-3 control-label">Origin Province</label>
              <div class="col-md-9">
                {!! Form::select('org_provinces', $province, $org_provinces, array('class' => 'form-control', 'id' => 'org_province')) !!}
              </div>
            </div>
          </div>

           <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group has-feedback" id="org_city-field">
              <label class="col-md-3 control-label">Origin City</label>
              <div class="col-md-9">
                {!! Form::select('org_city', $city_org, $org_city, array('class' => 'form-control', 'id' => 'org_city')) !!}
                <span class="text-danger" id="org_city-error"></span>
              </div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label class="col-md-3 control-label">Destination Province</label>
              <div class="col-md-9">
                {!! Form::select('dest_provinces', $province, $dest_provinces, array('class' => 'form-control', 'id' => 'dest_province')) !!}
              </div>
            </div>
          </div>

           <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group has-feedback" id="dest_city-field">
              <label class="col-md-3 control-label">Destination City</label>
              <div class="col-md-9">
                {!! Form::select('dest_city', $city_dest, $dest_city, array('class' => 'form-control', 'id' => 'dest_city')) !!}
                <span class="text-danger" id="dest_city-error"></span>
              </div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label class="col-md-3 control-label">Type</label>
              <div class="col-md-9">
                {!! Form::text('type', null, ['placeholder' => 'Type','class' => 'form-control', 'id' => 'type']) !!}
              </div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
              <div class="form-group">
                  <label class="col-md-3 control-label">Cost</label>
                  <div class="col-md-9">
                    <div class="input-group">
                      <span class="input-group-addon">Rp.</span>
                      {!! Form::text('cost', null, ['placeholder' => 'Cost','class' => 'form-control', 'id' => 'cost']) !!}
                    </div>
                  </div>
              </div>
          </div>

        </div>
    </div>
    {!! Form::close() !!}
    <div class="modal-footer">
      <button type="button" class="btn btn-primary" id="btn-save" onclick="save_edit_customer_cost_data()">Save changes</button>
    </div>
  </div>
</div>
</div>
<script>
  $(document).ready(function () {
    $('#type').keyup(function() {
        this.value = this.value.toUpperCase();
    });

    $( "#org_province" ).change(function() {
      $('#org_city option').remove();
      $('#org_city').append('<option value="">-- Please Select --</option');
      var ids = $('#org_province').val();
      if (ids != 0 ) {
        $.ajax({
          type:"GET",
          url: "get-city"+ "/" + ids,
          success: function(city) {
            console.log(city);
            var data_city = city;
            $.each(data_city, function (i, item) {
              $('#org_city').append($('<option>', { 
                value: item.id,
                text : item.name
              }));
            });
          }
        });
      } else {
        $('#org_city option').remove();
        $('#org_city').append('<option value="">-- Please Select Province --</option');
      }
    });

    $( "#dest_province" ).change(function() {
      $('#dest_city option').remove();
      $('#dest_city').append('<option value="">-- Please Select --</option');
      var ids = $('#dest_province').val();
      if (ids != 0 ) {
        $.ajax({
          type:"GET",
          url: "get-city"+ "/" + ids,
          success: function(city) {
            console.log(city);
            var data_city = city;
            $.each(data_city, function (i, item) {
              $('#dest_city').append($('<option>', { 
                value: item.id,
                text : item.name
              }));
            });
          }
        });
      } else {
        $('#dest_city option').remove();
        $('#dest_city').append('<option value="">-- Please Select Province --</option');
      }
    });
    
    $('#cost').priceFormat({
      prefix: '',
      thousandsSeparator:'.',
      centsLimit: 0
    });
});
</script>
