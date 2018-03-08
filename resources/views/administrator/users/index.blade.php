@extends('layouts.layout')

@section('content')
<div id="content" class="content">        
    <!-- begin page-header -->
    <h1 class="page-header">Administrator <small></small></h1>
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
              <h4 class="panel-title">Users Management</h4>
          </div>
          <div class="panel-body">
            <div class="email-btn-row">
              @permission('create-user')
                <a href="javascript:;" id="btn_new" class="btn btn-sm btn-primary" onclick="show_modal_users()">New User</a>
              @endpermission
              @permission('update-user')
                <a href="javascript:;" id="btn_edit" class="btn btn-sm btn-default disabled btn_dynamic" onclick="show_modal_edit_users()">Edit</a>
              @endpermission
              @permission('delete-user')
                <a href="javascript:;" id="btn_delete" class="btn btn-sm btn-default disabled btn_dynamic" onclick="delete_users()">Delete</a>
              @endpermission
                <a href="javascript:;" onclick="reload_data()" class="btn btn-sm btn-success"><i class="fa fa-refresh"></i></a>
            </div>
            <hr>
            <div class="table-responsive">
              <table id="users_table" class="table table-striped display table-bordered responsive nowrap">
                  <thead>
                      <tr>
                          <th>Name</th>
                          <th>Username</th>
                          <th>Email</th>
                          <th>Roles</th>
                      </tr>
                  </thead>
              </table>
            </div>
            <div class="modal fade" id="modal_users" tabindex="-1" role="dialog" aria-labelledby="modal_users" aria-hidden="true"></div>
          </div>
      </div><!-- end panel -->
    </div><!-- end row -->
</div>
@endsection

@push('js')

<!-- datatables -->
<script type="text/javascript">
  $('#administrator-menu').addClass('active');
  $('#user-management-menu').addClass('active');
  var listener = new window.keypress.Listener();
  $(document).ready(function() {
  userTable = $('#users_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url:'{{ url("users/get-user") }}', 
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
      "zeroRecords": "User not found...",
      "loadingRecords": "Loading...",
      "processing": "Load Data"
    },
    columns: [
      { data: 'name' },
      { data: 'username' },
      { data: 'email' },
      { data: 'roles' }
    ]
  });

  $("#users_table tbody").on("click","tr",function() { //highlight on click row
    if ($(this).hasClass("active")) {
      $(this).removeClass("active");
      $("a.btn_dynamic").addClass("disabled");
      $("a#btn_view").removeClass("btn-info");
      $("a#btn_edit").removeClass("btn-warning");
      $("a#btn_delete").removeClass("btn-danger");
      $("a.btn_dynamic").addClass("btn-default");
    }
    else {
      userTable.$("tr.active").removeClass("active");
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


function show_modal_users() {
  $.ajax({
    type:"GET",
    url: "users/create",
    success: function(res) {
      $('#modal_users').modal('show');
      $('#modal_users').html(res);
    }
  });
}

function show_modal_edit_users() {
  var data = userTable.row(".active").data();
  var id = data["id"];
  $.ajax({
    type:"GET",
    url: "users/"+id+"/edit",
    success: function(res) {
      $('#modal_users').modal('show');
      $('#modal_users').html(res);
    }
  });
}

function save_users_data(){
  $.ajaxSetup({
    header:$('meta[name="_token"]').attr('content')
  })
  //e.preventDefault(e);
  $.ajax({
    type:"POST",
    url:'users/store',
    data:$('#form-users').serialize(),
    dataType: 'json',
    success: function(data){
      $('#modal_users').modal('hide');
      reload_data();
    },
    error: function(data){
      $('#alert').html('');
      if(data.status == 422) {
        for (var error in data.responseJSON) {
          $('#alert').append('<div class="alert alert-warning fade in m-b-15"  role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+ data.responseJSON[error] +'</div>');
        }
      } else {
        $('#alert').append('<div class="alert alert-danger fade in m-b-15"  role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Someting wrong, please contact administrator</div>');
      }
    }
  })
};


function save_users_edit_data(){
  var data = userTable.row(".active").data();
  var id = data["id"];
  $.ajaxSetup({
    header:$('meta[name="_token"]').attr('content')
  })
  $.ajax({
    type:"PATCH",
    url:'users/'+id,
    data:$('#form-edit-users').serialize(),
    dataType: 'json',
    success: function(data){
      $('#modal_users').modal('hide');
      swal('Updated','','success');
      reload_data();
    },
    error: function(data){
      $('#alert').html('');
      if(data.status == 422) {
        for (var error in data.responseJSON) {
          $('#alert').append('<div class="alert alert-warning fade in m-b-15"  role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+ data.responseJSON[error] +'</div>');
        }
      } else {
        $('#alert').append('<div class="alert alert-danger fade in m-b-15"  role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Someting wrong, please contact administrator</div>');
      }
    }
  })
}

function delete_users() {
  var data = userTable.row(".active").data();
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
      url:'users/'+id,
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
  userTable.ajax.reload(null,false);
  $("a.btn_dynamic").addClass("disabled");
  $("a#btn_view").removeClass("btn-info");
  $("a#btn_edit").removeClass("btn-warning");
  $("a#btn_delete").removeClass("btn-danger");
  $("a.btn_dynamic").addClass("btn-default");
}
</script>
@endpush