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
              <h4 class="panel-title">Service</h4>
          </div>
          <div class="panel-body">
            <div class="email-btn-row">
                <a href="javascript:;" id="btn_new" class="btn btn-sm btn-primary" onclick="show_modal_add_service()">New Service</a>
                <a href="javascript:;" id="btn_edit" class="btn btn-sm btn-default disabled btn_dynamic" onclick="show_modal_edit_service()">Edit</a>
                <a href="javascript:;" id="btn_delete" class="btn btn-sm btn-default disabled btn_dynamic" onclick="delete_service()">Delete</a>
                <a href="javascript:;" onclick="reload_data()" class="btn btn-sm btn-success"><i class="fa fa-refresh"></i></a>
            </div>
            <hr>
            <div class="table-responsive">
              <table id="service_table" class="table table-striped display table-bordered responsive nowrap">
                  <thead>
                      <tr>
                          <th>Type Service</th>
                          <th>Unit</th>
                          <th>Unit Price</th>
                      </tr>
                  </thead>
              </table>
            </div>
            <div class="modal fade" id="modal_service" tabindex="-1" role="dialog" aria-labelledby="modal_service" aria-hidden="true"></div>
          </div>
      </div><!-- end panel -->
    </div><!-- end row -->
</div>
@endsection

@push('js')

<!-- datatables -->
<script type="text/javascript">
  $('#cost-menu').addClass('active');
  $('#service-menu').addClass('active');
  var listener = new window.keypress.Listener();
  $(document).ready(function() {
  serviceTable = $('#service_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url:'{{ url("service/get-service") }}', 
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
      "zeroRecords": "Service not found...",
      "loadingRecords": "Loading...",
      "processing": "Load Data"
    },
    columns: [
      { data: 'type_service', name: 'type_service' },
      { data: 'unit', name: 'unit' },
      { data: 'unit_price', name: 'unit_price' }
    ]
  });

  $("#service_table tbody").on("click","tr",function() { //highlight on click row
    if ($(this).hasClass("active")) {
      $(this).removeClass("active");
      $("a.btn_dynamic").addClass("disabled");
      $("a#btn_view").removeClass("btn-info");
      $("a#btn_edit").removeClass("btn-warning");
      $("a#btn_delete").removeClass("btn-danger");
      $("a.btn_dynamic").addClass("btn-default");
    }
    else {
      serviceTable.$("tr.active").removeClass("active");
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


function show_modal_add_service() {
  $.ajax({
    type:"GET",
    url: "service/create",
    success: function(res) {
      $('#modal_service').html(res);
      $('#modal_service').modal('show');
    }
  });
}

function show_modal_edit_service() {
  var data = serviceTable.row(".active").data();
  var id = data["id"];
  $.ajax({
    type:"GET",
    url: "service/"+id+"/edit",
    success: function(res) {
      //console.log(res);
      $('#modal_service').modal('show');
      $('#modal_service').html(res);
    }
  });
}

function save_service_data(){
  $.ajaxSetup({
    header:$('meta[name="_token"]').attr('content')
  })
  $.ajax({
    type:"POST",
    url:'service/store',
    data:$('#form-service-add').serialize(),
    dataType: 'json',
    success: function(data){
      //console.log(data);
      $('#modal_service').modal('hide');
      swal('Added','','success');
      reload_data();
    },
      error: function(data){
        $('#service-allert').removeAttr('hidden');
    }
  })
};


function save_service_edit_data(){
  var data = serviceTable.row(".active").data();
  var id = data["id"];
  $.ajaxSetup({
    header:$('meta[name="_token"]').attr('content')
  })
  $.ajax({
    type:"PATCH",
    url:'service/'+id,
    data:$('#form-edit-service').serialize(),
    
    success: function(data){
      //console.log(data);
      $('#modal_service').modal('hide');
      swal('Updated','','success');
      reload_data();
    },
      error: function(data){
        $('#service-allert').removeAttr('hidden');
    }
  })
};

function delete_service() {
  var data = serviceTable.row(".active").data();
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
      url:'service/'+id,
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
  serviceTable.ajax.reload(null,false);
  $("a.btn_dynamic").addClass("disabled");
  $("a#btn_view").removeClass("btn-info");
  $("a#btn_edit").removeClass("btn-warning");
  $("a#btn_delete").removeClass("btn-danger");
  $("a.btn_dynamic").addClass("btn-default");
}
</script>
@endpush