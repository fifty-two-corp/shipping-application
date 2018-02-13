<div class="tab-pane" id="shipping{{ $data->id }}">
	<div class="panel-body">
		<div class="invoice">
      <div class="invoice-company">
        <a href="javascript:;" class="btn btn-sm btn-warning" onclick="show_modal_update_shipping()">Update</a>
        @permission('delete-shipping')
	       <a href="javascript:;" class="btn btn-sm btn-danger" onclick="delete_shipping()">Delete</a>
        @endpermission
	      <a href="{{ url('shipping/pdf/invoice/'.$data->id) }}" class="btn btn-sm btn-info"><i class="fa fa-download"></i> Invoice</a>
	      <a href="{{ url('shipping/pdf/do/'.$data->id) }}" class="btn btn-sm btn-info"><i class="fa fa-download"></i> DO</a>
	      <a href="javascript:;" class="btn btn-sm btn-info" onclick="getManifest()"><i class="fa fa-download"></i> Manifest</a>
	      <span class="pull-right hidden-print">
	        @if ($data->status == 'Pending') <span class='label label-warning'>{{ $data->status }}</span>
          @elseif ($data->status == 'On Process') <span class='label label-primary'>{{ $data->status }}</span>
          @elseif ($data->status == 'Complete') <span class='label label-success'>{{ $data->status }}</span>
          @elseif ($data->status =='Cancel') <span class='label label-danger'>{{ $data->status }}</span>
          @endif
        </span>
      </div>
      <div class="invoice-header">
        <div class="invoice-from">
          <small>Customer</small>
          <address class="m-t-5 m-b-5">
              <strong>{{ $data->shipping_customer->customer_name }}</strong><br />
              {{ $data->shipping_customer->customer_address }}, {{ $data->shipping_customer->customer_district }}<br />
              {{ $data->shipping_customer->customer_city }}, {{ $data->shipping_customer->customer_province }}<br />
              Phone: {{ $data->shipping_customer->customer_phone }}<br />
          </address>
        </div>
        <div class="invoice-to">
          <small>Deliver to</small>
          <address class="m-t-5 m-b-5">
              <strong>{{ $data->shipping_destination->consignee_name }}</strong><br />
              {{ $data->shipping_destination->consignee_address }}, {{ $data->shipping_destination->consignee_district }}<br />
              {{ $data->shipping_destination->consignee_city }}, {{ $data->shipping_destination->consignee_province }}<br />
              Phone: {{ $data->shipping_destination->consignee_phone }}<br />
          </address>
        </div>
        <div class="invoice-date">
        	#{{ $data->transaction_number }}
          <div class="date m-t-5">{{ $date }}</div>
          <div class="invoice-detail">
              <br />
              Shipping Method <span class="text text-primary" >{{ $data->shipping_method }}</span><br />
              Shipping Type <span class="text text-primary">
              	@if ($data->shipping_method == 'default')
                  {{ $data->default_type }}
                @elseif ($data->shipping_method == 'vendor')
                  {{ $data->vendor_type }}
                @endif
              </span><br />
              Shipping By <span class="text text-primary">
              	@if ($data->shipping_method == 'default')
              		@if ($data->shipping_vehicle != null)
                  	{{ $data->shipping_vehicle->vehicle_driver }} / {{ $data->shipping_vehicle->vehicle_plat_number }}
                  @else
                  	-
                  @endif
                @elseif ($data->shipping_method == 'vendor')
                  {{ $data->shipping_vendor->vendor_name }}
                @endif
              </span>

          </div>
        </div>
      </div>
      <div class="invoice-content">
          <div class="table-responsive">
              <table class="table table-invoice">
                  <thead>
                      <tr>
                          <th>ITEM</th>
                          <th>QUANTITY</th>
                          <th>DIMENSION</th>
                      </tr>
                  </thead>
                  <tbody>
                  	@foreach($data->load_list as $item)
                      <tr>
                          <td>
                            {{ $item->item }}
                          </td>
                          <td width="10%">{{ $item->quantity }}</td>
                          <td width="15%">{{ $item->dimension }}</td>
                      </tr>
                     @endforeach
                  </tbody>
              </table>
          </div>
          <div class="invoice-price">
              <div class="invoice-price-left">
                  <div class="invoice-price-row">
                      <div class="sub-price">
                          <small>DELIVERY COST</small>
                          Rp.
                          @if ($data->shipping_method == 'default')
                            {{ number_format($data->default_cost) }}
                          @elseif ($data->shipping_method == 'vendor')
                            {{ number_format($data->vendor_cost) }}
                          @endif
                      </div>
                      <div class="sub-price">
                          <i class="fa fa-plus"></i>
                      </div>
                      <div class="sub-price">
                          <small>TAX ({{ $data->tax_value }}%)</small>
                          Rp. {{ number_format($data->tax_cost) }}
                      </div>
                  </div>
              </div>
              <div class="invoice-price-right">
                  <small>GRAND TOTAL</small> Rp. {{ number_format($data->cost) }}
              </div>
          </div>
      </div>
      <div>
          * Operational Cost : Rp. {{ number_format($data->operational_cost) }}<br />
          @if($data->termin != null)
          	* Termin : {{ $data->time_period }} Days<br />
          	* Due Date : {{ $due_date }}<br />
          @endif
      </div>
      <div class="invoice-footer text-muted">
          <p class="text-center">
              <span class="m-r-10">Created by {{$data->created_by}} at {{date_format($data->created_at, "d-m-Y")}}</span>
              @if($data->updated_by != null)
              <span class="m-r-10">Updated by {{ $data->updated_by }} at {{date_format($data->updated_at, "d-m-Y")}}</span>
              @endif
          </p>
      </div>
    </div>
	</div>
</div>
<div class="modal fade" id="modal_shipping" tabindex="-1" role="dialog" aria-labelledby="modal_shipping" aria-hidden="true"></div>
<script>

	function show_modal_update_shipping() {
	  var id = '{{ $data->id }}';
	  $.ajax({
	    type:"GET",
	    url: id+"/edit",
	    success: function(res) {
	      $('#modal_shipping').modal('show');
	      $('#modal_shipping').html('');
	      $('#modal_shipping').append(res);
	    }
	  });
	}

	function save_update_shipping_data(){
	  var id = '{{ $data->id }}';
	  var transaction_number = '{{ $data->transaction_number }}';
  	var element_shipping = document.getElementById("#shipping"+id);
	  $.ajaxSetup({
	    header:$('meta[name="_token"]').attr('content')
	  })
	  $.ajax({
	    type:"PATCH",
	    url:'{{ url("shipping") }}'+'/'+ id,
	    data:$('#form-update-shipping').serialize(),
	    success: function(data){
	      $('#modal_shipping').modal('hide');
	      //swal('Updated','','success');
	      $.gritter.add({
	        title:"Updated",
	        text:"Your succsess update data shipping",
	        image:"{{ url('public/img/success.png') }}",
	        sticky:false,
	        time:""
	      });
	      $.ajax({
			    type:"GET",
			    url: "details/" + id,
			    success: function(res) {
		        $('.tab-content [id=shipping'+id+']').html(res);
			    }
			  });
			  reload_data();
	    },
	      error: function(data){
	        console.log(data);
	        swal('Error','Someting Wrong','error');
	    }
	  })
	};

	function downloadInvoice(id) {
	  $.ajax({
	    type:"GET",
	    url: "pdf/invoice/" + id,
	    success: function(res) {
	    	$.gritter.add({
	        title:"Downloaded",
	        text:"Your downloaded invoice shipping, please check download folder",
	        image:"{{ url('public/img/success.png') }}",
	        sticky:false,
	        time:""
	      });
	    }
	  });
	}

	function getDO() {
	  swal('Sorry','Page under maintenance','warning');
	}

	function getManifest() {
	  swal('Sorry','Page under maintenance','warning');
	}

	function delete_shipping() {
	  var data = shippingTable.row(".active").data();
	  var name = data["transaction_number"];
	  var id = data["id"];
	  swal({
	    title: 'Are you sure?',
	    text: "You won't be able to revert this!",
	    type: 'warning',
	    showCancelButton: true,
	    confirmButtonColor: '#3085d6',
	    cancelButtonColor: '#d33',
	    confirmButtonText: 'Yes, delete it!'
	  }).then(function () {
	      $.ajax({
	      type:"DELETE",
	      url:'{{ url("shipping") }}'+'/'+ id,
	      dataType: 'json',
	      success: function(data){
	      	close_tab(id);
	        reload_data();
	        $.gritter.add({
		        title:"Deleted",
		        text:"Your succsess delete data shipping",
		        image:"{{ url('public/img/success.png') }}",
		        sticky:false,
		        time:""
		      });
	      },
	      error: function(data){
	        swal('Error','Someting Wrong','error');
	      }
	    })
	  })
	}
</script>