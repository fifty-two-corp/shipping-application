@extends('layouts.layout')
@section('content')
<div id="content" class="content">        
    <h1 class="page-header">Report <small></small></h1>
    <div class="row">
      <div class="panel panel-inverse" data-sortable-id="form-stuff-5">
          <div class="panel-heading">
              <div class="panel-heading-btn">
                  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
              </div>
              <h4 class="panel-title">DO Out Report</h4>
          </div>
          <div class="panel-body">
            <div class="email-btn-row">
              @permission('update-customer')
                <a href="javascript:;" id="btn_edit" class="btn btn-sm btn-default disabled btn_dynamic" onclick="show_modal_edit_do_out()">Update</a>
              @endpermission
                <a href="javascript:;" onclick="reload_data()" class="btn btn-sm btn-success"><i class="fa fa-refresh"></i></a>
            </div>
            <hr>
            <div class="table-responsive">
              <table id="do_table" class="table table-striped display table-bordered responsive nowrap">
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>Customer</th>
                          <th>Destination</th>
                          <th>Load Date</th>
                          <th>Driver</th>
                          <th>Do Time Period</th>
                          <th>Due Date</th>
                      </tr>
                  </thead>
              </table>
            </div>
            <div class="modal fade" id="modal_do_out" tabindex="-1" role="dialog" aria-labelledby="modal_customer" aria-hidden="true"></div>
          </div>
      </div>
    </div>
</div>
@endsection
@push('js')
<script type="text/javascript">
  $('#report-menu').addClass('active');
  $('#do-report-menu').addClass('active');
  var listener = new window.keypress.Listener();
  $(document).ready(function() {
  DOTable = $('#do_table').DataTable({
    processing: false,
    serverSide: true,
    ajax: {
      url:'{{ url("do-report/get-do") }}',
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
      "zeroRecords": "DO not found...",
      "loadingRecords": "Loading...",
      "processing": "Load Data"
    },
    columns: [
      { data: 'transaction_number'},
      { data: 'shipping_customer_name'},
      { data: 'destination'},
      { data: 'load_date'},
      { data: 'driver'},
      { data: 'do_out_time_period'},
      { data: 'due_date'}
    ]
  });

  $("#do_table tbody").on("click","tr",function() { //highlight on click row
    if ($(this).hasClass("active")) {
      $(this).removeClass("active");
      $("a.btn_dynamic").addClass("disabled");
      $("a#btn_view").removeClass("btn-info");
      $("a#btn_edit").removeClass("btn-warning");
      $("a#btn_delete").removeClass("btn-danger");
      $("a.btn_dynamic").addClass("btn-default");
    }
    else {
        DOTable.$("tr.active").removeClass("active");
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


function show_modal_edit_do_out() {
  var data = DOTable.row(".active").data();
  var id = data["id"];
  $.ajax({
    type:"GET",
    url: "do-report/"+id+"/edit",
    success: function(res) {
      //console.log(id);
      $('#modal_do_out').modal('show');
      $('#modal_do_out').html(res);
    }
  });
}


function save_edit_do_out(){
  var data = DOTable.row(".active").data();
  var id = data["id"];
  $.ajaxSetup({
    header:$('meta[name="_token"]').attr('content')
  })
  $.ajax({
    type:"PATCH",
    url:'do-report/'+id,
    data:$('#form-update-do-out').serialize(),
    
    success: function(data){
      //console.log(data);
      $('#modal_do_out').modal('hide');
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


function reload_data() {
    DOTable.ajax.reload(null,false);
  $("a.btn_dynamic").addClass("disabled");
  $("a#btn_view").removeClass("btn-info");
  $("a#btn_edit").removeClass("btn-warning");
  $("a#btn_delete").removeClass("btn-danger");
  $("a.btn_dynamic").addClass("btn-default");
}
</script>
@endpush