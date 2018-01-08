<fieldset >
	<legend>Shipping Method 
	  <div class="btn-group" data-toggle="buttons">
	    <label class="btn btn-default"><input type="radio" name="method" value="default" id="default" required>Default</label>
	    <label class="btn btn-default"><input type="radio" name="method" value="vendor" id="vendor" required>Vendor</label>
	  </div>
	</legend>
	<div class="row" id="shipping_method_form"></div>
</fieldset>

<script>
	$('input[type=radio][name=method]').change(function() {
	    if (this.value == 'default') {
	      getDefaultForm();
	    }
	    else if (this.value == 'vendor') {
	      getVendorForm();
	    }
 	 });
  
  function getDefaultForm() {
    clearCost();
    city = $("#consignee_city").val();
    customer = $("#customer_list").val();
    $.ajax({
      type:"GET",
      url:'shipping/get-default-form/customer/'+customer+'/destination/'+city,
      success: function(data){
        $("#shipping_method_form").html('');
        $("#shipping_method_form").append(data);
      }
    })
  }

  function get_customer_shipping_type(id) {
    var ids = $('#customer_list').val();
    if (ids != 0 ) {
      $.ajax({
          type:"GET",
          url: "shipping/get-customer-shipping-type/" + id,
          success: function(data) {
             $.each(data, function (i, item) {
              $('#shipping_method').append($('<option>', { 
                value: item,
                text : item
              }));
            });
          }
        });
    } else {
      $('#shipping_method option').remove();
      $('#shipping_method').append('<option value="">-- Please Select --</option>');
    }
  }

  function getVendorForm() {
    clearCost();
    city = $("#consignee_city").val();
    customer = $("#customer_list").val();
    $.ajax({
      type:"GET",
      url:'shipping/get-vendor-form/customer/' + customer + '/province/' + city,
      success: function(data){
        $("#body").LoadingOverlay("show", {size : "20%"});
        $("#shipping_method_form").html('');
        $("#shipping_method_form").append(data);
        $("#body").LoadingOverlay("hide", true);
      }
    })
  }

  function get_vendor_data() {
    var id = $('#vendor_list').val();
    if (id != '0') {
      $.ajax({
        type:"GET",
        url: "shipping/get-vendor-data/" + id,
        success: function(data) {
          $('#vendor_number').val(data.vendor_number);
          $('#vendor_phone').val(data.phone);
          $('#vendor_address').val(data.address);
          $('#vendor_province').val(data.province.name);
          $('#vendor_city').val(data.city.name);
          $('#vendor_district').val(data.districts.name);
          //get_customer_shipping_type(id);
          //getCalculationCost();
        }
      });
    } else {
      $('#vendor_number').val('-');
      $('#vendor_phone').val('-');
      $('#vendor_address').val('-');
      $('#vendor_province').val('-');
      $('#vendor_city').val('-');
      $('#vendor_district').val('-');
    }
    get_vendor_shipping_type();
  }

  function get_vendor_shipping_type() {
    $('#vendor_shipping_type option').remove();
    $('#vendor_shipping_type').append('<option value="">-- Please Select --</option>');
    destination = $("#consignee_city").val();
    customer    = $("#customer_list").val();
    vendor      = $("#vendor_list").val();
    $.ajax({
      type:"GET",
      url:'shipping/get-vendor-shipping-type/customer/'+customer+'/destination/'+destination+'/vendor/'+vendor,
      success: function(data){
          $.each(data, function (i, item) {
            $('#vendor_shipping_type').append($('<option>', { 
              value: item.id,
              text : item.type
            }));
          });
      },
        error: function(data){
          swal('cannot load vendor shipping type','please contact administrator','error');
      }
    })
  }
</script>