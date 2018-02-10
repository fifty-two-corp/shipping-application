@extends('layouts.layout')

@section('content')
<div id="content" class="content">        
    <!-- begin page-header -->
    <h1 class="page-header">Settings <small></small></h1>
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
              <h4 class="panel-title">Environment</h4>
          </div>
          <div class="panel-body">
            <div class="email-btn-row">
                <a href="javascript:;" id="btn_new" class="btn btn-sm btn-primary" onclick="show_modal_add()">Add New</a>
                <a href="javascript:;" id="btn_edit" class="btn btn-sm btn-default disabled btn_dynamic" onclick="show_modal_edit()">Edit</a>
                <a href="javascript:;" id="btn_delete" class="btn btn-sm btn-default disabled btn_dynamic" onclick="delete_env()">Delete</a>
                <a href="javascript:;" onclick="reload_data()" class="btn btn-sm btn-success"><i class="fa fa-refresh"></i></a>
            </div>
            <hr>
            <div class="table-responsive">
              <table id="env_table" class="table table-striped display table-bordered responsive nowrap">
                  <thead>
                      <tr>
                          <th>Name</th>
                          <th>Value</th>
                      </tr>
                  </thead>
              </table>
            </div>
            <div class="modal fade" id="modal_env" tabindex="-1" role="dialog" aria-labelledby="modal_env" aria-hidden="true"></div>
          </div>
      </div><!-- end panel -->
    </div><!-- end row -->
</div>
@endsection

@push('js')

<!-- datatables -->
<script type="text/javascript">
  $('#settings-menu').addClass('active');
  $('#environment-menu').addClass('active');
  var listener = new window.keypress.Listener();
  $(document).ready(function() {
  envTable = $('#env_table').DataTable({
    processing: false,
    serverSide: true,
    ajax: {
      url:'{{ url("environment/get-env") }}', 
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
      "zeroRecords": "Environment not found...",
      "loadingRecords": "Loading...",
      "processing": "Load Data"
    },
    columns: [
      { data: 'name'},
      { data: 'value'}
    ]
  });

  $("#env_table tbody").on("click","tr",function() { //highlight on click row
    if ($(this).hasClass("active")) {
      $(this).removeClass("active");
      $("a.btn_dynamic").addClass("disabled");
      $("a#btn_view").removeClass("btn-info");
      $("a#btn_edit").removeClass("btn-warning");
      $("a#btn_delete").removeClass("btn-danger");
      $("a.btn_dynamic").addClass("btn-default");
    }
    else {
      envTable.$("tr.active").removeClass("active");
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

function show_modal_add() {
  $.ajax({
    type:"GET",
    url: "environment/create",
    success: function(res) {
      $('#modal_env').html(res);
      $('#modal_env').modal('show');
    }
  });
}

function save_env_data(){
  $.ajaxSetup({
    header:$('meta[name="_token"]').attr('content')
  })
  $.ajax({
    type:"POST",
    url:'environment/store',
    data:$('#form-env-add').serialize(),
    dataType: 'json',
    success: function(data){
      //console.log(data);
      $('#modal_env').modal('hide');
      swal('Added','','success');
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

function show_modal_edit() {
  var data = envTable.row(".active").data();
  var name = data["name"];
  var value = data["value"];
  $.ajax({
    type:"GET",
    url: "environment/"+name+"/edit/"+value,
    success: function(res) {
      //console.log(res);
      $('#modal_env').modal('show');
      $('#modal_env').html(res);
    }
  });
}

function save_edit_env() {
  var data = envTable.row(".active").data();
  var name = data["name"];
  $.ajaxSetup({
    header:$('meta[name="_token"]').attr('content')
  })
  $.ajax({
    type:"PATCH",
    url:'environment/'+name,
    data:$('#form-edit-env').serialize(),
    success: function(data){
      //console.log(data);
      $('#modal_env').modal('hide');
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

function delete_env() {
  var data = envTable.row(".active").data();
  var name = data["name"];
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
      type:"GET",
      url:'environment/delete-env/'+name,
      //dataType: 'json',
      success: function(data){
        swal('Deleted!','Your backup data has been deleted.','success');
        reload_data();
      },
      error: function(data){
        swal('Error','Someting Wrong','error');
      }
    })
  })
}

function reload_data() {
  envTable.ajax.reload(null,false);
  $("a.btn_dynamic").addClass("disabled");
  $("a#btn_view").removeClass("btn-info");
  $("a#btn_edit").removeClass("btn-warning");
  $("a#btn_delete").removeClass("btn-danger");
  $("a.btn_dynamic").addClass("btn-default");
}
</script>
@endpush