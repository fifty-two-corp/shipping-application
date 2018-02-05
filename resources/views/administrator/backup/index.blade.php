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
              <h4 class="panel-title">Backup</h4>
          </div>
          <div class="panel-body">
            <div class="email-btn-row">
                <a href="javascript:;" id="btn_new" class="btn btn-sm btn-primary" onclick="backup()">Backup</a>
                <a href="javascript:;" id="btn_delete" class="btn btn-sm btn-default disabled btn_dynamic" onclick="delete_backup()">Delete</a>
                <a href="javascript:;" id="btn_edit" class="btn btn-sm btn-default disabled btn_dynamic" onclick="download_backup()">Download</a>
                <a href="javascript:;" onclick="reload_data()" class="btn btn-sm btn-success"><i class="fa fa-refresh"></i></a>
            </div>
            <hr>
            <div class="table-responsive">
              <table id="backup_table" class="table table-striped display table-bordered responsive nowrap">
                  <thead>
                      <tr>
                          <th>Name</th>
                          <th>Size</th>
                          <th>Type</th>
                          <th>Created</th>
                      </tr>
                  </thead>
              </table>
            </div>
            <div class="modal fade" id="modal_backup" tabindex="-1" role="dialog" aria-labelledby="modal_backup" aria-hidden="true"></div>
          </div>
      </div><!-- end panel -->
    </div><!-- end row -->
</div>
@endsection

@push('js')

<!-- datatables -->
<script type="text/javascript">
  $('#administrator-menu').addClass('active');
  $('#backup-management-menu').addClass('active');
  var listener = new window.keypress.Listener();
  $(document).ready(function() {
  backupTable = $('#backup_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url:'{{ url("backup/get-backup-data") }}', 
      searchHighlight: true,
      deferRender: true,
    },
    deferRender: true,
    responsive:true,
    keys: true,
    sorting: [[0,"desc"]],
    pagingType: "full_numbers",
    dom:'C<"clear">lfrtip',
    stateSave: false,
    language: {
      "zeroRecords": "Backup not found...",
      "loadingRecords": "Loading...",
      "processing": "Load Data"
    },
    columns: [
      { data: 'name'},
      { data: 'size'},
      { data: 'mime'},
      { data: 'last_modified'}
    ]
  });

  $("#backup_table tbody").on("click","tr",function() { //highlight on click row
    if ($(this).hasClass("active")) {
      $(this).removeClass("active");
      $("a.btn_dynamic").addClass("disabled");
      $("a#btn_view").removeClass("btn-info");
      $("a#btn_edit").removeClass("btn-warning");
      $("a#btn_delete").removeClass("btn-danger");
      $("a.btn_dynamic").addClass("btn-default");
    }
    else {
      backupTable.$("tr.active").removeClass("active");
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

function backup(){
  swal({
    title: 'Are you sure?',
    text: "Backup takes some time, don't switch or close the page before backup prosess finished",
    type: 'info',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Backup Now'
  }).then(function () {
      $.ajax({
      type:"GET",
      url:'backup/backup',
      success: function(){
        swal('Success!','Your Application has been backup.','success');
        reload_data();
      },
      error: function(){
        swal('Error','Someting Wrong','error');
      }
    })
  })
};

function download_backup() {
  var data = backupTable.row(".active").data();
  var name = data["name"];
  $.ajax({
    type:"GET",
    url:'backup/download/'+name,
    //dataType: 'json',
    success: function(){
      window.location = 'backup/download/'+name;
    },
    error: function(){
      swal('Error','Someting Wrong','error');
    }
  })
}

function delete_backup() {
  var data = backupTable.row(".active").data();
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
      type:"GET",
      url:'backup/delete/'+name,
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
  backupTable.ajax.reload(null,false);
  $("a.btn_dynamic").addClass("disabled");
  $("a#btn_view").removeClass("btn-info");
  $("a#btn_edit").removeClass("btn-warning");
  $("a#btn_delete").removeClass("btn-danger");
  $("a.btn_dynamic").addClass("btn-default");
}
</script>
@endpush