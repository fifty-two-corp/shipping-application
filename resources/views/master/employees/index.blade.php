@extends('layouts.layout')
@section('content')
<div id="content" class="content"><!-- begin content -->
    <h1 class="page-header">Master <small></small></h1><!-- page-header -->
    <div class="row"><!-- begin row -->
      <div class="panel panel-inverse" data-sortable-id="form-stuff-5"><!-- begin panel -->
          <div class="panel-heading">
              <div class="panel-heading-btn">
                  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
              </div>
              <h4 class="panel-title">Employees</h4>
          </div>
          <div class="panel-body">
            <div class="email-btn-row">
              @permission('add-employees')
                <a href="javascript:;" id="btn_new" class="btn btn-sm btn-primary" onclick="show_modal_add_employees()">New Employees</a>
              @endpermission
              @permission('update-employees')
                <a href="javascript:;" id="btn_edit" class="btn btn-sm btn-default disabled btn_dynamic" onclick="show_modal_edit_employees()">Edit</a>
              @endpermission
              @permission('delete-employees')
                <a href="javascript:;" id="btn_delete" class="btn btn-sm btn-default disabled btn_dynamic" onclick="delete_employees()">Delete</a>
              @endpermission
                <a href="javascript:;" onclick="reload_data()" class="btn btn-sm btn-success"><i class="fa fa-refresh"></i></a>
            </div>
            <hr>
            <div class="table-responsive">
              <table id="employees_table" class="table table-striped display table-bordered responsive nowrap">
                  <thead>
                      <tr>
                          <th>Employees Number</th>
                          <th>Name</th>
                          <th>Address</th>
                          <th>Province</th>
                          <th>City</th>
                          <th>Districts</th>
                          <th>Phone</th>
                          <th>ID</th>
                          <th>ID Number</th>
                      </tr>
                  </thead>
              </table>
            </div>
            <div class="modal fade" id="modal_employees" tabindex="-1" role="dialog" aria-labelledby="modal_employees" aria-hidden="true"></div>
          </div>
      </div><!-- end panel -->
    </div><!-- end row -->
</div><!-- end content -->
@endsection
@push('js')
<script type="text/javascript">
  $('#master-menu').addClass('active');
  $('#employees-menu').addClass('active');
  var listener = new window.keypress.Listener();
  $(document).ready(function() {
  employeesTable = $('#employees_table').DataTable({
    processing: false,
    serverSide: true,
    ajax: {
      url:'{{ url("employees/get-employees") }}', 
      searchHighlight: true,
      deferRender: true,
    },
    deferRender: true,
    responsive:true,
    keys: true,
    sorting: [[1,"asc"]],
    pagingType: "full_numbers",
    dom:'C<"clear">lfrtip',
    stateSave: false,
    language: {
      "zeroRecords": "Employees not found...",
      "loadingRecords": "Loading...",
      "processing": "Load Data"
    },
    columns: [
      { data: 'employees_number'},
      { data: 'name'},
      { data: 'address'},
      { data: 'province'},
      { data: 'city'},
      { data: 'districts'},
      { data: 'phone'},
      { data: 'identity_method'},
      { data: 'identity_number'} 
    ]
  });
  $("#employees_table tbody").on("click","tr",function() { //highlight on click row
    if ($(this).hasClass("active")) {
      $(this).removeClass("active");
      $("a.btn_dynamic").addClass("disabled");
      $("a#btn_view").removeClass("btn-info");
      $("a#btn_edit").removeClass("btn-warning");
      $("a#btn_delete").removeClass("btn-danger");
      $("a.btn_dynamic").addClass("btn-default");
    }
    else {
      employeesTable.$("tr.active").removeClass("active");
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

function show_modal_add_employees() {
  $.ajax({
    type:"GET",
    url: "employees/create",
    success: function(res) {
      $('#modal_employees').html(res);
      $('#modal_employees').modal('show');
    }
  });
}

function show_modal_edit_employees() {
  var data = employeesTable.row(".active").data();
  var id = data["id"];
  $.ajax({
    type:"GET",
    url: "employees/"+id+"/edit",
    success: function(res) {
      $('#modal_employees').modal('show');
      $('#modal_employees').html(res);
    }
  });
}

function save_employees_data(){
  $.ajaxSetup({
    header:$('meta[name="_token"]').attr('content')
  })
  $.ajax({
    type:"POST",
    url:'employees/store',
    data:$('#form-employees-add').serialize(),
    dataType: 'json',
    success: function(data){
      //console.log(data);
      $('#modal_employees').modal('hide');
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

function save_edit_employees_data(){
  var data = employeesTable.row(".active").data();
  var id = data["id"];
  $.ajaxSetup({
    header:$('meta[name="_token"]').attr('content')
  })
  $.ajax({
    type:"PATCH",
    url:'employees/'+id,
    data:$('#form-edit-employees').serialize(),
    success: function(data){
      $('#modal_employees').modal('hide');
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

function delete_employees() {
  var data = employeesTable.row(".active").data();
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
      url:'employees/'+id,
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
  employeesTable.ajax.reload(null,false);
  $("a.btn_dynamic").addClass("disabled");
  $("a#btn_view").removeClass("btn-info");
  $("a#btn_edit").removeClass("btn-warning");
  $("a#btn_delete").removeClass("btn-danger");
  $("a.btn_dynamic").addClass("btn-default");
}
</script>
@endpush