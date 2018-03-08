@extends('layouts.layout')
@section('content')
<div id="content" class="content">        
    <h1 class="page-header">Administrator <small></small></h1><!-- begin page-header -->
    <div class="row"><!-- begin row -->
      <div class="panel panel-inverse" data-sortable-id="form-stuff-5"><!-- begin panel -->
          <div class="panel-heading">
              <div class="panel-heading-btn">
                  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
              </div>
              <h4 class="panel-title">Activity Log</h4>
          </div>
          <div class="panel-body">
            <div class="email-btn-row">
              @permission('view-log')
                <a href="javascript:;" id="btn_view" class="btn btn-sm btn-default disabled btn_dynamic" onclick="view_log_details()">View Details</a>
              @endpermission
              @permission('delete-log')
                <a href="javascript:;" id="btn_delete" class="btn btn-sm btn-default disabled btn_dynamic" onclick="delete_log()">Delete</a>
              @endpermission
              @permission('clear-log')
                <a href="javascript:;" id="btn_clean" class="btn btn-sm btn-warning" onclick="clean_old_log()">Clean old Log</a>
              @endpermission
                <a href="javascript:;" onclick="reload_data()" class="btn btn-sm btn-success"><i class="fa fa-refresh"></i></a>
            </div>
            <hr>
            <div class="table-responsive">
              <table id="logs_table" class="table table-striped display table-bordered responsive nowrap">
                <thead>
                  <tr>
                    <th>Log Name</th>
                    <th>Description</th>
                    <th>Subject</th>
                    <th>User</th>
                    <th>Log Time</th>
                  </tr>
                </thead>
              </table>
            </div>
            <div class="modal fade" id="modal_log" tabindex="-1" role="dialog" aria-labelledby="modal_log" aria-hidden="true"></div>
          </div>
      </div><!-- end panel -->
    </div><!-- end row -->
</div>
@endsection
@push('js')
<script type="text/javascript">
  $('#administrator-menu').addClass('active');
  $('#activity-log-menu').addClass('active');
  $(document).ready(function() {
  logsTable = $('#logs_table').DataTable({
    processing: false,
    serverSide: true,
    ajax: {
      url:'{{ url("activitylog/get-logs") }}', 
      searchHighlight: true,
      deferRender: true,
    },
    deferRender: true,
    responsive:true,
    keys: true,
    sorting: [[4,"desc"]],
    pagingType: "full_numbers",
    dom:'C<"clear">lfrtip',
    stateSave: false,
    language: {
      "zeroRecords": "Log not found...",
      "loadingRecords": "Loading...",
      "processing": "Load Data"
    },
    columns: [
      { data: 'log_name'},
      { data: 'description'},
      { data: 'subject_type'},
      { data: 'causer_id'},
      { data: 'created_at'}
    ]
  });

  $("#logs_table tbody").on("click","tr",function() {
    if ($(this).hasClass("active")) {
      $(this).removeClass("active");
      $("a.btn_dynamic").addClass("disabled");
      $("a#btn_view").removeClass("btn-info");
      $("a#btn_edit").removeClass("btn-warning");
      $("a#btn_delete").removeClass("btn-danger");
      $("a.btn_dynamic").addClass("btn-default");
    }
    else {
      logsTable.$("tr.active").removeClass("active");
      $("a.btn_dynamic").addClass("disabled");
      $(this).addClass("active");
      $("a.btn_dynamic").removeClass("disabled");
      $("a.btn_dynamic").removeClass("btn-default");
      $("a#btn_view").addClass("btn-info");
      $("a#btn_edit").addClass("btn-warning");
      $("a#btn_delete").addClass("btn-danger");
    }
  });

  logsTable.on("draw",function () {
    var body = $(logsTable.table().body());
    body.unhighlight();
    body.highlight(logsTable.search());
  });
});

function view_log_details() {
  var data = logsTable.row(".active").data();
  var id = data["id"];
  $.ajax({
    type:"GET",
    url: "activitylog/get-logs-details/"+id,
    success: function(res) {
      $('#modal_log').modal('show');
      $('#modal_log').html('');
      $('#modal_log').html(res);
    }
  });
}

function delete_log() {
  var data = logsTable.row(".active").data();
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
      url:'activitylog/delete-logs/'+id,
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

function clean_old_log() {
  $.ajax({
    type:"GET",
    url: "activitylog/clean-logs",
    success: function(res) {
      swal('Log Clean!',res,'success');
    }
  });
}

function reload_data() {
  logsTable.ajax.reload(null,false);
  $("a.btn_dynamic").addClass("disabled");
  $("a#btn_view").removeClass("btn-info");
  $("a#btn_edit").removeClass("btn-warning");
  $("a#btn_delete").removeClass("btn-danger");
  $("a.btn_dynamic").addClass("btn-default");
}
</script>
@endpush