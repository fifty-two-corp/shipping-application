@extends('layouts.layout')
@section('content')
<div id="content" class="content">        
    <h1 class="page-header">Master <small></small></h1><!-- page-header -->
    <div class="row"><!-- begin row -->
      <div class="panel panel-inverse" data-sortable-id="form-stuff-5"><!-- begin panel -->
          <div class="panel-heading">
              <div class="panel-heading-btn">
                  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
              </div>
              <h4 class="panel-title">Vehicle</h4>
          </div>
          <div class="panel-body">
            <div class="email-btn-row">
              @permission('add-vehicle')
                <a href="javascript:;" id="btn_new" class="btn btn-sm btn-primary" onclick="show_modal_add_vehicle()">New Vehicle</a>
              @endpermission
              @permission('update-vehicle')
                <a href="javascript:;" id="btn_edit" class="btn btn-sm btn-default disabled btn_dynamic" onclick="show_modal_edit_vehicle()">Edit</a>
              @endpermission
              @permission('delete-vehicle')
                <a href="javascript:;" id="btn_delete" class="btn btn-sm btn-default disabled btn_dynamic" onclick="delete_vehicle()">Delete</a>
              @endpermission
                <a href="javascript:;" onclick="reload_data()" class="btn btn-sm btn-success"><i class="fa fa-refresh"></i></a>
            </div>
            <hr>
            <div class="table-responsive">
              <table id="vehicle_table" class="table table-striped display table-bordered responsive nowrap">
                  <thead>
                      <tr>
                          <th>Plat Number</th>
                          <th>Name</th>
                          <th>Driver</th>
                          <th>Type</th>
                          <th>Merk</th>
                          <th>Color</th>
                          <th>Prod. Year</th>
                          <th>Tax End</th>
                          <th>Status</th>
                      </tr>
                  </thead>
              </table>
            </div>
            <div class="modal fade" id="modal_vehicle" tabindex="-1" role="dialog" aria-labelledby="modal_vehicle" aria-hidden="true"></div>
          </div>
      </div><!-- end panel -->
    </div><!-- end row -->
</div>
@endsection

@push('js')

<!-- datatables -->
<script type="text/javascript">
  $('#master-menu').addClass('active');
  $('#vehicle-menu').addClass('active');
  var listener = new window.keypress.Listener();
  $(document).ready(function() {
  vehicleTable = $('#vehicle_table').DataTable({
    processing: false,
    serverSide: true,
    ajax: {
      url:'{{ url("vehicle/get-vehicle") }}', 
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
      "zeroRecords": "Vehicle not found...",
      "loadingRecords": "Loading...",
      "processing": "Load Data"
    },
    columns: [
      { data: 'plat_number'},
      { data: 'name'},
      { data: 'employees'},
      { data: 'type'},
      { data: 'merk'},
      { data: 'color'},
      { data: 'production_year'},
      { data: 'vehicle_tax'},
      { data: 'status'}
    ]
  });

  $("#vehicle_table tbody").on("click","tr",function() { //highlight on click row
    if ($(this).hasClass("active")) {
      $(this).removeClass("active");
      $("a.btn_dynamic").addClass("disabled");
      $("a#btn_view").removeClass("btn-info");
      $("a#btn_edit").removeClass("btn-warning");
      $("a#btn_delete").removeClass("btn-danger");
      $("a.btn_dynamic").addClass("btn-default");
    }
    else {
      vehicleTable.$("tr.active").removeClass("active");
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


function show_modal_add_vehicle() {
  $.ajax({
    type:"GET",
    url: "vehicle/create",
    success: function(res) {
      $('#modal_vehicle').html(res);
      $('#modal_vehicle').modal('show');
    }
  });
}

function show_modal_edit_vehicle() {
  var data = vehicleTable.row(".active").data();
  var id = data["id"];
  $.ajax({
    type:"GET",
    url: "vehicle/"+id+"/edit",
    success: function(res) {
      $('#modal_vehicle').html(res);
      $('#modal_vehicle').modal('show');
    }
  });
}

function show_modal_view_vehicle() {
  var data = vehicleTable.row(".active").data();
  var id = data["id"];
  $.ajax({
    type:"GET",
    url: "vehicle/"+id,
    success: function(res) {
      $('#modal_vehicle').html(res);
      $('#modal_vehicle').modal('show');
    }
  });
}

function save_vehicle_data(){
  $.ajaxSetup({
    header:$('meta[name="_token"]').attr('content')
  })
  $.ajax({
    type:"POST",
    url:'vehicle/store',
    data:$('#form-vehicle-add').serialize(),
    dataType: 'json',
    success: function(data){
      $('#modal_vehicle').modal('hide');
      swal('Added','','success');
      reload_data();
    },
    error: function(data){
      $('#alert').html('');
      if(data.status == 422) {
        $('.alert').removeAttr('hidden');
        for (var error in data.responseJSON.errors) {$('#alert').append(data.responseJSON.errors[error]+'<br>')};
      } else {
        $('#alert').append('Someting wrong, please contact administrator');
      }
    }
  })
};


function save_vehicle_edit_data(){
  var data = vehicleTable.row(".active").data();
  var id = data["id"];
  $.ajaxSetup({
    header:$('meta[name="_token"]').attr('content')
  })
  $.ajax({
    type:"PATCH",
    url:'vehicle/'+id,
    data:$('#form-edit-vehicle').serialize(),
    success: function(data){
      $('#modal_vehicle').modal('hide');
      swal('Updated','','success');
      reload_data();
    },
    error: function(data){
      $('#alert').html('');
      if(data.status == 422) {
        $('.alert').removeAttr('hidden');
        for (var error in data.responseJSON.errors) {$('#alert').append(data.responseJSON.errors[error]+'<br>')};
      } else {
        $('#alert').append('Someting wrong, please contact administrator');
      }
    }
  })
};

function delete_vehicle() {
  var data = vehicleTable.row(".active").data();
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
      url:'vehicle/'+id,
      dataType: 'json',
      success: function(data){
        //console.log(data);
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
  vehicleTable.ajax.reload(null,false);
  $("a.btn_dynamic").addClass("disabled");
  $("a#btn_view").removeClass("btn-info");
  $("a#btn_edit").removeClass("btn-warning");
  $("a#btn_delete").removeClass("btn-danger");
  $("a.btn_dynamic").addClass("btn-default");
}
</script>
@endpush