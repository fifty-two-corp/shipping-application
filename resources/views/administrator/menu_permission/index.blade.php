@extends('layouts.layout')

@section('content')
<div id="content" class="content">        
  <h1 class="page-header">Administrator <small></small></h1>
  <div class="row">
    <div class="panel panel-inverse" data-sortable-id="form-stuff-5">
      <div class="panel-heading">
        <div class="panel-heading-btn">
          <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
          <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
        </div>
        <h4 class="panel-title">Menu</h4>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="panel-body">
            <div class="email-btn-row">
              <a href="javascript:;" id="btn_new_parent" class="btn btn-sm btn-primary" onclick="show_modal_parent()">New Parent Menu</a>
              <a href="javascript:;" id="btn_edit_parent" class="btn btn-sm btn-default disabled btn_dynamic_parent" onclick="show_modal_edit_parent()">Edit</a>
              <a href="javascript:;" id="btn_delete_parent" class="btn btn-sm btn-default disabled btn_dynamic_parent" onclick="delete_parent()">Delete</a>
              <a href="javascript:;" onclick="reload_data_parent()" class="btn btn-sm btn-success"><i class="fa fa-refresh"></i></a>
            </div>
            <hr>
            <div class="table-responsive">
              <table id="parent_menu_table" class="table table-striped display table-bordered responsive nowrap">
                  <thead>
                      <tr>
                          <th>Parent Menu</th>
                          <th>Icon</th>
                      </tr>
                  </thead>
              </table>
            </div>
            <div class="modal fade" id="modal_parent_menu" tabindex="-1" role="dialog" aria-labelledby="modal_parent_menu" aria-hidden="true"></div>
          </div>
        </div>
        <div class="col-md-6" id="child_menu_view"></div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="panel panel-inverse" data-sortable-id="form-stuff-5">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            </div>
            <h4 class="panel-title">Permission Management</h4>
        </div>
        <div class="panel-body" id="permission_view"></div>
    </div><!-- end panel -->
  </div><!-- end row -->
</div>
@endsection

@push('js')

<!-- datatables -->
<script type="text/javascript">
  $('#administrator-menu').addClass('active');
  $('#menu-permission-management').addClass('active');
  var listener = new window.keypress.Listener();
  $(document).ready(function() {
    get_child_menu_default();
    get_permission_default();
    parentTable = $('#parent_menu_table').DataTable({
      processing: false,
      serverSide: true,
      searchHighlight: true,
      ajax: {
        url:'menu_permission/get-parent-menu', 
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
        "zeroRecords": "Parent Menu not found...",
        "loadingRecords": "Loading...",
        "processing": "Load Data"
      },
      columns: [
        { data: 'name' },
        { data: 'icon' }
      ]
    });

    $("#parent_menu_table tbody").on("click","tr",function() { //highlight on click row
      if ($(this).hasClass("active")) {
        $(this).removeClass("active");
        $("a.btn_dynamic_parent").addClass("disabled");
        $("a#btn_view_parent").removeClass("btn-info");
        $("a#btn_edit_parent").removeClass("btn-warning");
        $("a#btn_delete_parent").removeClass("btn-danger");
        $("a.btn_dynamic_parent").addClass("btn-default");
        get_child_menu_default();
        get_permission_default();
      }
      else {
        parentTable.$("tr.active").removeClass("active");
        $("a.btn_dynamic_parent").addClass("disabled");
        $(this).addClass("active");
        $("a.btn_dynamic_parent").removeClass("disabled");
        $("a.btn_dynamic_parent").removeClass("btn-default");
        $("a#btn_view_parent").addClass("btn-info");
        $("a#btn_edit_parent").addClass("btn-warning");
        $("a#btn_delete_parent").addClass("btn-danger");
        get_child_menu_data();
        get_permission_default();
      }
    });

    // permisionTable = $('#permision_table').DataTable({
    //   processing: true,
    //   serverSide: true,
    //   searchHighlight: true,
    //   ajax: {
    //     url:'{{ url("permision/get-permision") }}', 
    //     deferRender: true,
    //   },
    //   deferRender: true,
    //   responsive:true,
    //   keys: true,
    //   sorting: [[0,"asc"]],
    //   pagingType: "full_numbers",
    //   dom:'C<"clear">lfrtip',
    //   stateSave: false,
    //   language: {
    //     "zeroRecords": "Permision not found...",
    //     "loadingRecords": "Loading...",
    //     "processing": "Load Data"
    //   },
    //   columns: [
    //     { data: 'name'},
    //     { data: 'display_name'},
    //     { data: 'description'},
    //     { data: 'child_menu'},
    //   ]
    // });

    // $("#permision_table tbody").on("click","tr",function() { //highlight on click row
    //   if ($(this).hasClass("active")) {
    //     $(this).removeClass("active");
    //     $("a.btn_dynamic").addClass("disabled");
    //     $("a#btn_view").removeClass("btn-info");
    //     $("a#btn_edit").removeClass("btn-warning");
    //     $("a#btn_delete").removeClass("btn-danger");
    //     $("a.btn_dynamic").addClass("btn-default");
    //   }
    //   else {
    //     permisionTable.$("tr.active").removeClass("active");
    //     $("a.btn_dynamic").addClass("disabled");
    //     $(this).addClass("active");
    //     $("a.btn_dynamic").removeClass("disabled");
    //     $("a.btn_dynamic").removeClass("btn-default");
    //     $("a#btn_view").addClass("btn-info");
    //     $("a#btn_edit").addClass("btn-warning");
    //     $("a#btn_delete").addClass("btn-danger");
    //   }
    // });
  });


  function show_modal_parent() {
    $.ajax({
      type:"GET",
      url: "menu_permission/create-parent-menu",
      success: function(res) {
        $('#modal_parent_menu').modal('show');
        $('#modal_parent_menu').html(res);
      }
    });
  }

  function save_parent_data(){
  $.ajaxSetup({
    header:$('meta[name="_token"]').attr('content')
  })
  $.ajax({
    type:"POST",
    url:'menu_permission/store-parent-menu',
    data:$('#form-parent').serialize(),
    dataType: 'json',
    success: function(data){
      $('#modal_parent_menu').modal('hide');
      swal('Added','','success');
      reload_data_parent();
    },
      error: function(data){
        $('#parent-allert').removeAttr('hidden');
    }
  })
}

function show_modal_edit_parent() {
  var data = parentTable.row(".active").data();
  var id = data["id"];
  $.ajax({
    type:"GET",
    url: "menu_permission/"+id+"/edit-parent-menu",
    success: function(res) {
      $('#modal_parent_menu').modal('show');
      $('#modal_parent_menu').html(res);
    }
  });
}

function save_parent_edit_data(){
  var data = parentTable.row(".active").data();
  var id = data["id"];
  $.ajaxSetup({
    header:$('meta[name="_token"]').attr('content')
  })
  $.ajax({
    type:"PATCH",
    url:'menu_permission/save-edit-parent-menu/'+id,
    data:$('#form-edit-parent').serialize(),
    dataType: 'json',
    success: function(data){
      $('#modal_parent_menu').modal('hide');
      swal('Updated','','success');
      reload_data_parent();
    },
      error: function(data){
        $('#parent-allert').removeAttr('hidden');
    }
  })
}

function delete_parent() {
  var data = parentTable.row(".active").data();
  var name = data["name"];
  var id = data["id"];

  swal({
    title: 'Are you sure delete'+ name + '?',
    text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then(function () {
      $.ajax({
      type:"DELETE",
      url:'menu_permission/delete-parent-menu/'+id,
      dataType: 'json',
      success: function(data){
        swal('Deleted!','Your data has been deleted.','success');
        reload_data_parent();
      },
      error: function(data){
        swal('Error','Someting Wrong','error');
      }
    })
  })
}

function reload_data_parent() {
  parentTable.ajax.reload(null,false);
  $("a.btn_dynamic_parent").addClass("disabled");
  $("a#btn_view_parent").removeClass("btn-info");
  $("a#btn_edit_parent").removeClass("btn-warning");
  $("a#btn_delete_parent").removeClass("btn-danger");
  $("a.btn_dynamic_parent").addClass("btn-default");
}

//child menu
function get_child_menu_default() {
    $.ajax({
      type:"GET",
      url: "menu_permission/get-child-menu-default",
      success: function(res) {
        $('#child_menu_view').html(res);
      }
    });
  }

  function get_child_menu_data() {
    var data = parentTable.row(".active").data();
    var id = data["id"];
    $.ajax({
      type:"GET",
      url: "menu_permission/get-child-menu-data/" + id,
      success: function(res) {
        $('#child_menu_view').html(res);
      }
    });
  }

  function show_modal_child() {
    $.ajax({
      type:"GET",
      url: "menu_permission/create-child-menu",
      success: function(res) {
        $('#modal_child_menu').modal('show');
        $('#modal_child_menu').html(res);
      }
    });
  }

  function save_child_data(){
  $.ajaxSetup({
    header:$('meta[name="_token"]').attr('content')
  })
  $.ajax({
    type:"POST",
    url:'menu_permission/store-child-menu',
    data:$('#form-child').serialize(),
    dataType: 'json',
    success: function(data){
      $('#modal_child_menu').modal('hide');
      swal('Added','','success');
      reload_data_child();
    },
      error: function(data){
        $('#child-allert').removeAttr('hidden');
    }
  })
}

function show_modal_edit_child() {
  var data = childTable.row(".active").data();
  var id = data["id"];
  $.ajax({
    type:"GET",
    url: "menu_permission/"+id+"/edit-child-menu",
    success: function(res) {
      $('#modal_child_menu').modal('show');
      $('#modal_child_menu').html(res);
    }
  });
}

function save_child_edit_data(){
  var data = childTable.row(".active").data();
  var id = data["id"];
  $.ajaxSetup({
    header:$('meta[name="_token"]').attr('content')
  })
  $.ajax({
    type:"PATCH",
    url:'menu_permission/save-edit-child-menu/'+id,
    data:$('#form-edit-child').serialize(),
    dataType: 'json',
    success: function(data){
      console.log(data);
      $('#modal_child_menu').modal('hide');
      swal('Updated','','success');
      reload_data_child();
    },
      error: function(data){
        $('#childt-allert').removeAttr('hidden');
    }
  })
}

function save_child_edit_data(){
  var data = childTable.row(".active").data();
  var id = data["id"];
  $.ajaxSetup({
    header:$('meta[name="_token"]').attr('content')
  })
  $.ajax({
    type:"PATCH",
    url:'menu_permission/save-edit-child-menu/'+id,
    data:$('#form-edit-child').serialize(),
    dataType: 'json',
    success: function(data){
      $('#modal_child_menu').modal('hide');
      swal('Updated','','success');
      reload_data_child();
    },
      error: function(data){
        $('#child-allert').removeAttr('hidden');
    }
  })
}

function delete_child() {
  var data = childTable.row(".active").data();
  var name = data["name"];
  var id = data["id"];

  swal({
    title: 'Are you sure delete'+ name + '?',
    text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then(function () {
      $.ajax({
      type:"DELETE",
      url:'menu_permission/delete-child-menu/'+id,
      dataType: 'json',
      success: function(data){
        swal('Deleted!','Your data has been deleted.','success');
        reload_data_child();
      },
      error: function(data){
        swal('Error','Someting Wrong','error');
      }
    })
  })
}

function reload_data_child() {
  childTable.ajax.reload(null,false);
  $("a.btn_dynamic_child").addClass("disabled");
  $("a#btn_view_child").removeClass("btn-info");
  $("a#btn_edit_child").removeClass("btn-warning");
  $("a#btn_delete_child").removeClass("btn-danger");
  $("a.btn_dynamic_child").addClass("btn-default");
}

// permission
function get_permission_default() {
  $.ajax({
    type:"GET",
    url: "menu_permission/get-permission-default",
    success: function(res) {
      $('#permission_view').html(res);
    }
  });
}

  function get_permission_data() {
    var data = childTable.row(".active").data();
    var id = data["id"];
    $.ajax({
      type:"GET",
      url: "menu_permission/get-permission-data/" + id,
      success: function(res) {
        $('#permission_view').html(res);
      }
    });
  }

function show_modal_permission() {
  $.ajax({
    type:"GET",
    url: "menu_permission/create-permission",
    success: function(res) {
      $('#modal_permission').modal('show');
      $('#modal_permission').html(res);
    }
  });
}

function save_permission_data(){
  $.ajaxSetup({
    header:$('meta[name="_token"]').attr('content')
  })
  $.ajax({
    type:"POST",
    url:'menu_permission/store-permission',
    data:$('#form-permission').serialize(),
    dataType: 'json',
    success: function(data){
      $('#modal_permission').modal('hide');
      swal('Added','','success');
      reload_data_permission();
    },
      error: function(data){
        $('#permission-allert').removeAttr('hidden');
    }
  })
}

function show_modal_edit_permission() {
  var data = permissionTable.row(".active").data();
  var id = data["id"];
  $.ajax({
    type:"GET",
    url: "menu_permission/"+id+"/edit-permission",
    success: function(res) {
      $('#modal_permission').modal('show');
      $('#modal_permission').html(res);
    }
  });
}

function save_permision_edit_data(){
  var data = permissionTable.row(".active").data();
  var id = data["id"];
  $.ajaxSetup({
    header:$('meta[name="_token"]').attr('content')
  })
  $.ajax({
    type:"PATCH",
    url:'menu_permission/save-edit-permission/'+id,
    data:$('#form-edit-permission').serialize(),
    dataType: 'json',
    success: function(data){
      $('#modal_permission').modal('hide');
      swal('Updated','','success');
      reload_data_permission();
    },
      error: function(data){
        console.log(data.responseText);
        $('#permission-allert').removeAttr('hidden');
    }
  })
};

function delete_permission() {
  var data = permissionTable.row(".active").data();
  var name = data["name"];
  var id = data["id"];

  swal({
    title: 'Are you sure delete'+ name + '?',
    text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then(function () {
      $.ajax({
      type:"DELETE",
      url:'menu_permission/delete-permission/'+id,
      dataType: 'json',
      success: function(data){
        swal('Deleted!','Your data has been deleted.','success');
        reload_data_permission();
      },
      error: function(data){
        swal('Error','Someting Wrong','error');
      }
    })
  })
}

function reload_data_permission() {
  permissionTable.ajax.reload(null,false);
  $("a.btn_dynamic_pemission").addClass("disabled");
  $("a#btn_view_pemission").removeClass("btn-info");
  $("a#btn_edit_pemission").removeClass("btn-warning");
  $("a#btn_delete_pemission").removeClass("btn-danger");
  $("a.btn_dynamic_pemission").addClass("btn-default");
}
</script>
@endpush