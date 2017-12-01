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
              <h4 class="panel-title">Role Management</h4>
          </div>
          <div class="panel-body">
            <div class="email-btn-row">
                <a href="javascript:;" id="btn_new" class="btn btn-sm btn-primary" onclick="show_modal_add_role()">New Role</a>
                <a href="javascript:;" id="btn_edit" class="btn btn-sm btn-default disabled btn_dynamic" onclick="show_modal_edit_role()">Edit</a>
                <a href="javascript:;" id="btn_delete" class="btn btn-sm btn-default disabled btn_dynamic" onclick="delete_role()">Delete</a>
                <a href="javascript:;" onclick="reload_data()" class="btn btn-sm btn-success"><i class="fa fa-refresh"></i></a>
            </div>
            <hr>
            <div class="table-responsive">
              <table id="roles_table" class="table table-striped display table-bordered responsive nowrap">
                  <thead>
                      <tr>
                          <th>Name</th>
                          <th>Display Name</th>
                          <th>Description</th>
                      </tr>
                  </thead>
              </table>
            </div>
            <div class="modal fade" id="modal_roles" tabindex="-1" role="dialog" aria-labelledby="modal_role" aria-hidden="true"></div>
          </div>
      </div><!-- end panel -->
    </div><!-- end row -->
</div>
@endsection

@push('js')

<!-- datatables -->
<script type="text/javascript">
  $('#administrator-menu').addClass('active');
  $('#role-management-menu').addClass('active');
  var listener = new window.keypress.Listener();
  $(document).ready(function() {
  roleTable = $('#roles_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url:'{{ url("roles/get-roles") }}', 
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
      "zeroRecords": "Role not found...",
      "loadingRecords": "Loading...",
      "processing": "Load Data"
    },
    columns: [
      { data: 'name', name: 'name' },
      { data: 'display_name'},
      { data: 'description'}
    ]
  });

  $("#roles_table tbody").on("click","tr",function() { //highlight on click row
    if ($(this).hasClass("active")) {
      $(this).removeClass("active");
      $("a.btn_dynamic").addClass("disabled");
      $("a#btn_view").removeClass("btn-info");
      $("a#btn_edit").removeClass("btn-warning");
      $("a#btn_delete").removeClass("btn-danger");
      $("a.btn_dynamic").addClass("btn-default");
    }
    else {
      roleTable.$("tr.active").removeClass("active");
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

function show_modal_add_role() {
  $.ajax({
    type:"GET",
    url: "roles/create",
    success: function(res) {
      $('#modal_roles').html(res);
      $('#modal_roles').modal('show');
    }
  });
}

function show_modal_edit_role() {
  var data = roleTable.row(".active").data();
  var id = data["id"];
  $.ajax({
    type:"GET",
    url: "roles/"+id+"/edit",
    success: function(res) {
      //console.log(res);
      $('#modal_roles').modal('show');
      $('#modal_roles').html(res);
    }
  });
}

function save_role_data(){
  var select = $('#roles').jstree(true).get_bottom_selected();
  permission = new Array(select);
  $.ajaxSetup({
    header:$('meta[name="_token"]').attr('content')
  })
  $.ajax({
    type:"POST",
    url:'roles/store',
    data:$('#form-role-add').serialize() + permission,
    dataType: 'json',
    success: function(data){
      $('#modal_roles').modal('hide');
      swal('Added','','success');
      reload_data();
    },
      error: function(data){
        $('#roles-allert').removeAttr('hidden');
    }
  })
};

function save_edit_role_data(){
  var data = roleTable.row(".active").data();
  var id = data["id"];
  var select = $('#roles').jstree(true).get_bottom_selected();
  permission = new Array(select);
  $.ajaxSetup({
    header:$('meta[name="_token"]').attr('content')
  })
  $.ajax({
    type:"PATCH",
    url:'roles/'+id,
    data:$('#form-edit-roles').serialize() + permission,
    success: function(data){
      //console.log(data);
      $('#modal_roles').modal('hide');
      swal('Updated','','success');
      reload_data();
    },
      error: function(data){
        $('#roles-allert').removeAttr('hidden');
    }
  })
};

function delete_role() {
  var data = roleTable.row(".active").data();
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
      url:'roles/'+id,
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
  roleTable.ajax.reload(null,false);
  $("a.btn_dynamic").addClass("disabled");
  $("a#btn_view").removeClass("btn-info");
  $("a#btn_edit").removeClass("btn-warning");
  $("a#btn_delete").removeClass("btn-danger");
  $("a.btn_dynamic").addClass("btn-default");
}
</script>
@endpush