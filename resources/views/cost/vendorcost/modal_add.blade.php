<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      <h4 class="modal-title" id="modalService">New Vendor Cost</h4>
    </div>
    <div class="modal-body">
      {!! Form::open(array('class' => 'form-horizontal', 'id' => 'form-vendor-cost')) !!}
        <div class="row">
          <div class="alert alert-danger fade in m-b-15" id="vendor-cost-allert" hidden>
            <strong>Whoops! </strong> There were some problems with your input.
            <span class="close" data-dismiss="alert">×</span>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group has-feedback" id="vendor-field">
              <label class="col-md-3 control-label">Vendor</label>
              <div class="col-md-9">
                {!! Form::select('vendor', ['' => '-- Please Select --'] + $vendor, [], ['class' => 'form-control', 'id' => 'vendor', 'value' => old('vendor') ]) !!}
                <span class="text-danger" id="vendor-error"></span>
              </div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group has-feedback" id="customer-field">
              <label class="col-md-3 control-label">Customer</label>
              <div class="col-md-9">
                {!! Form::select('customer', ['' => '-- Please Select --'] + $customer, [], ['class' => 'form-control', 'id' => 'customer', 'value' => old('customer') ]) !!}
                <span class="text-danger" id="customer-error"></span>
              </div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group has-feedback" id="org_provinces-field">
              <label class="col-md-3 control-label">Origin Province</label>
              <div class="col-md-9">
                {!! Form::select('org_provinces', ['' => '-- Please Select --'] + $province, [], ['class' => 'form-control', 'id' => 'org_province', 'value' => old('org_provinces') ]) !!}
                <span class="text-danger" id="org_provinces-error"></span>
              </div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group has-feedback" id="org_city-field">
              <label class="col-md-3 control-label">Origin City</label>
              <div class="col-md-9">
                {!! Form::select('org_city', ['' => '-- Please Select Origin Province --'], [], ['class' => 'form-control', 'id' => 'org_city', 'value' => old('org_city') ]) !!}
                <span class="text-danger" id="org_city-error"></span>
              </div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group has-feedback" id="dest_provinces-field">
              <label class="col-md-3 control-label">Destination Province</label>
              <div class="col-md-9">
                {!! Form::select('dest_provinces', ['' => '-- Please Select --'] + $province, [], ['class' => 'form-control', 'id' => 'dest_province', 'value' => old('dest_provinces') ]) !!}
                <span class="text-danger" id="dest_provinces-error"></span>
              </div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group has-feedback" id="dest_city-field">
              <label class="col-md-3 control-label">Destination City</label>
              <div class="col-md-9">
                {!! Form::select('dest_city', ['' => '-- Please Select Destination Province --'], [], ['class' => 'form-control', 'id' => 'dest_city', 'value' => old('dest_city') ]) !!}
                <span class="text-danger" id="dest_city-error"></span>
              </div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group has-feedback" id="type-field">
              <label class="col-md-3 control-label">Type</label>
              <div class="col-md-9">
                {!! Form::text('type', null, ['placeholder' => 'Type','class' => 'form-control', 'id' => 'type', 'value' => old('type') ]) !!}
                <span class="text-danger" id="type-error"></span>
              </div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
              <div class="form-group has-feedback" id="cost-field">
                  <label class="col-md-3 control-label">Cost</label>
                  <div class="col-md-9">
                    <div class="input-group">
                      <span class="input-group-addon">Rp.</span>
                      {!! Form::text('cost', null, ['placeholder' => 'Cost','class' => 'form-control', 'id' => 'cost', 'value' => old('cost') ]) !!}
                      <span class="text-danger" id="cost-error"></span>
                    </div>
                  </div>
              </div>
          </div>

      </div>
        {!! Form::close() !!}
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn-save" onclick="save_vendor_cost_data()">Save changes</button>
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
