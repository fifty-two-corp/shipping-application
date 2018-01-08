@extends('layouts.layout')
@section('content')
<div id="content" class="content">        
    <!-- begin page-header -->
    <h1 class="page-header">Cost <small></small></h1>
    <!-- end page-header -->

   <!-- begin row -->
    <div class="row">
            <!-- begin panel -->
      <div class="panel panel-inverse" data-sortable-id="form-stuff-5">
          <div class="panel-heading">
              <div class="panel-heading-btn">
                  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
              </div>
              <h4 class="panel-title">Vendor Cost</h4>
          </div>
          <div class="panel-body">
            <div class="email-btn-row">
                <a href="javascript:;" id="btn_new" class="btn btn-sm btn-primary" onclick="show_modal_add_vendor()">New Cost</a>
                <a href="javascript:;" id="btn_edit" class="btn btn-sm btn-default disabled btn_dynamic" onclick="show_modal_edit_vendor_cost()">Edit</a>
                <a href="javascript:;" id="btn_delete" class="btn btn-sm btn-default disabled btn_dynamic" onclick="delete_vendor_cost()">Delete</a>
                <a href="javascript:;" onclick="reload_data()" class="btn btn-sm btn-success"><i class="fa fa-refresh"></i></a>
            </div>
            <hr>
            <div class="table-responsive">
              <table id="vendor_cost_table" class="table table-striped display table-bordered responsive nowrap">
                  <thead>
                      <tr>
                          <th>Vendor</th>
                          <th>Customer</th>
                          <th>Origin</th>
                          <th>Destination</th>
                          <th>Type</th>
                          <th>Cost</th>
                      </tr>
                  </thead>
              </table>
            </div>
            <div class="modal fade" id="modal_vendor_cost" tabindex="-1" role="dialog" aria-labelledby="modal_vendor_cost" aria-hidden="true"></div>
          </div>
      </div>
    </div>
</div>
@endsection

@push('js')

<script type="text/javascript">
  
  $('#cost-menu').addClass('active');
  $('#vendorcost-menu').addClass('active');

  var form = $('#form-vendor-cost');
  var formData = form.serialize();

  $(document).ready(function() {
    vendorcostTable = $('#vendor_cost_table').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url:'{{ url("vendor-cost/get-vendor-cost") }}', 
        searchHighlight: true,
        deferRender: true,
      },
      deferRender: true,
      responsive:true,
      keys: true,
      sorting: [[0,"asc"]],
      pagingType: "full_numbers",
      dom:'C<"clear">lfrtip',
      stateSave: false,
      language: {
        "zeroRecords": "Vendor Cost not found...",
        "loadingRecords": "Loading...",
        "processing": "Load Data"
      },
      columns: [
        { data: 'vendor'},
        { data: 'customer'},
        { data: 'origin_city'},
        { data: 'destination_city'},
        { data: 'type'},
        { data: 'cost'}
      ]
  });

  $("#vendor_cost_table tbody").on("click","tr",function() {
    if ($(this).hasClass("active")) {
      $(this).removeClass("active");
      $("a.btn_dynamic").addClass("disabled");
      $("a#btn_view").removeClass("btn-info");
      $("a#btn_edit").removeClass("btn-warning");
      $("a#btn_delete").removeClass("btn-danger");
      $("a.btn_dynamic").addClass("btn-default");
    }
    else {
      vendorcostTable.$("tr.active").removeClass("active");
      $("a.btn_dynamic").addClass("disabled");
      $(this).addClass("active");
      $("a.btn_dynamic").removeClass("disabled");
      $("a.btn_dynamic").removeClass("btn-default");
      $("a#btn_view").addClass("btn-info");
      $("a#btn_edit").addClass("btn-warning");
      $("a#btn_delete").addClass("btn-danger");
    }
  });
 });

function show_modal_add_vendor() {
  $.ajax({
    type:"GET",
    url: "vendor-cost/create",
    success: function(res) {
      $('#modal_vendor_cost').html(res);
      $('#modal_vendor_cost').modal('show');
    }
  });
}

function show_modal_edit_vendor_cost() {
  var data = vendorcostTable.row(".active").data();
  var id = data["id"];
  $.ajax({
    type:"GET",
    url: "vendor-cost/"+id+"/edit",
    success: function(res) {
      $('#modal_vendor_cost').modal('show');
      $('#modal_vendor_cost').html(res);
    }
  });
}

function save_vendor_cost_data(formData){
  $.ajaxSetup({ header:$('meta[name="_token"]').attr('content') })
  $.ajax({
    type:"POST",
    url:'vendor-cost/store',
    data:$('#form-vendor-cost').serialize(),
    dataType: 'json',
    success: function(data){
      if(data.errors) {
        associate_errors(data.errors);
      }
      if(data.success) {
        $('#modal_vendor_cost').modal('hide');
        swal('Added','','success');
        reload_data();
      }
    }, error: function(response){
        swal('Something Wrong','Please Report Bug to Development Program','error');
    }
  })
};


function save_edit_vendor_cost_data(){
  var data = vendorcostTable.row(".active").data();
  var id = data["id"];
  $.ajaxSetup({
    header:$('meta[name="_token"]').attr('content')
  })
  $.ajax({
    type:"PATCH",
    url:'vendor-cost/'+id,
    data:$('#form-edit-vendor-cost').serialize(),
    success: function(data){
      if(data.errors) {
        associate_errors(data.errors);
      }
      if(data.success) {
        $('#modal_vendor_cost').modal('hide');
        swal('Updated','','success');
        reload_data();
      }
    },
      error: function(data){
        swal('Something Wrong','Please Report Bug to Development Program','error');
    }
  })
};

function delete_vendor_cost() {
  var data = vendorcostTable.row(".active").data();
  var name = data["name"];
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
      url:'vendor-cost/'+id,
      dataType: 'json',
      success: function(data){
        swal('Deleted!','Your data has been deleted.','success');
        reload_data();
      },
      error: function(data){
        swal('Error','Someting Wrong','error');
      }
    })
  })
}

function reload_data() {
  vendorcostTable.ajax.reload(null,false);
  $("a.btn_dynamic").addClass("disabled");
  $("a#btn_view").removeClass("btn-info");
  $("a#btn_edit").removeClass("btn-warning");
  $("a#btn_delete").removeClass("btn-danger");
  $("a.btn_dynamic").addClass("btn-default");
}

function associate_errors(errors) {
  if(errors.vendor){
    $('#vendor-error').html('');
    $('#vendor-field').addClass('has-error');
    $('#vendor-error').html(errors.vendor[0]);
  } else {
    $('#vendor-field').removeClass('has-error');
    $('#vendor-error').html('');
  }
  if(errors.customer){
    $('#customer-error').html('');
    $('#customer-field').addClass('has-error');
    $('#customer-error').html(errors.customer[0]);
  } else {
    $('#customer-field').removeClass('has-error');
    $('#customer-error').html('');
  }
  if(errors.org_provinces){
    $('#org_provinces-error').html('');
    $('#org_provinces-field').addClass('has-error');
    $('#org_provinces-error').html(errors.org_provinces[0]);
  } else {
    $('#org_provinces-field').removeClass('has-error');
    $('#org_provinces-error').html('');
  }
  if(errors.org_city){
    $('#org_city-error').html('');
    $('#org_city-field').addClass('has-error');
    $('#org_city-error').html(errors.org_city[0]);
  } else {
    $('#org_city-field').removeClass('has-error');
    $('#org_city-error').html('');
  }
  if(errors.dest_provinces){
    $('#dest_provinces-error').html('');
    $('#dest_provinces-field').addClass('has-error');
    $('#dest_provinces-error').html(errors.dest_provinces[0]);
  } else {
    $('#dest_provinces-field').removeClass('has-error');
    $('#dest_provinces-error').html('');
  }
  if(errors.dest_city){
    $('#dest_city-error').html('');
    $('#dest_city-field').addClass('has-error');
    $('#dest_city-error').html(errors.dest_city[0]);
  } else {
    $('#dest_city-field').removeClass('has-error');
    $('#dest_city-error').html('');
  }
  if(errors.type){
    $('#type-error').html('');
    $('#type-field').addClass('has-error');
    $('#type-error').html(errors.type[0]);
  } else {
    $('#type-field').removeClass('has-error');
    $('#type-error').html('');
  }
  if(errors.cost){
    $('#cost-error').html('');
    $('#cost-field').addClass('has-error');
    $('#cost-error').html(errors.cost[0]);
  } else {
    $('#cost-field').removeClass('has-error');
    $('#cost-error').html('');
  }
}

</script>
@endpush