@extends('layouts.layout')
@section('content')
<div id="content" class="content">        
    <!-- begin page-header -->
    <h1 class="page-header">Master <small></small></h1>
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
              <h4 class="panel-title">Vendor</h4>
          </div>
          <div class="panel-body">
            <div class="email-btn-row">
                <a href="javascript:;" id="btn_new" class="btn btn-sm btn-primary" onclick="show_modal_add_vendor()">New Vendor</a>
                <a href="javascript:;" id="btn_edit" class="btn btn-sm btn-default disabled btn_dynamic" onclick="show_modal_edit_vendor()">Edit</a>
                <a href="javascript:;" id="btn_delete" class="btn btn-sm btn-default disabled btn_dynamic" onclick="delete_vendor()">Delete</a>
                <a href="javascript:;" onclick="reload_data()" class="btn btn-sm btn-success"><i class="fa fa-refresh"></i></a>
            </div>
            <hr>
            <div class="table-responsive">
              <table id="vendor_table" class="table table-striped display table-bordered responsive nowrap">
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>Name</th>
                          <th>Address</th>
                          <th>Province</th>
                          <th>City</th>
                          <th>District</th>
                          <th>Phone</th>
                      </tr>
                  </thead>
              </table>
            </div>
            <div class="modal fade" id="modal_vendor" tabindex="-1" role="dialog" aria-labelledby="modal_vendor" aria-hidden="true"></div>
          </div>
      </div><!-- end panel -->
    </div><!-- end row -->
</div>
@endsection

@push('js')

<!-- datatables -->
<script type="text/javascript">
  $('#master-menu').addClass('active');
  $('#vendor-menu').addClass('active');
  var listener = new window.keypress.Listener();
  $(document).ready(function() {
  vendorTable = $('#vendor_table').DataTable({
    processing: false,
    serverSide: true,
    ajax: {
      url:'{{ url("vendors/get-vendor") }}', 
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
      "zeroRecords": "Vendor not found...",
      "loadingRecords": "Loading...",
      "processing": "Load Data"
    },
    columns: [
      { data: 'vendor_number', name: 'vendor_number' },
      { data: 'name', name: 'name' },
      { data: 'address', name: 'address' },
      { data: 'province', name: 'province' },
      { data: 'city', name: 'city' },
      { data: 'districts', name: 'districts' },
      { data: 'phone', name: 'phone' }
    ]
  });

  $("#vendor_table tbody").on("click","tr",function() { //highlight on click row
    if ($(this).hasClass("active")) {
      $(this).removeClass("active");
      $("a.btn_dynamic").addClass("disabled");
      $("a#btn_view").removeClass("btn-info");
      $("a#btn_edit").removeClass("btn-warning");
      $("a#btn_delete").removeClass("btn-danger");
      $("a.btn_dynamic").addClass("btn-default");
    }
    else {
      vendorTable.$("tr.active").removeClass("active");
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

function show_modal_add_vendor() {
  $.ajax({
    type:"GET",
    url: "vendors/create",
    success: function(res) {
      $('#modal_vendor').html(res);
      $('#modal_vendor').modal('show');
    }
  });
}

function show_modal_edit_vendor() {
  var data = vendorTable.row(".active").data();
  var id = data["id"];
  $.ajax({
    type:"GET",
    url: "vendors/"+id+"/edit",
    success: function(res) {
      //console.log(id);
      $('#modal_vendor').modal('show');
      $('#modal_vendor').html(res);
    }
  });
}

function save_vendor_data(){
  $.ajaxSetup({
    header:$('meta[name="_token"]').attr('content')
  })
  $.ajax({
    type:"POST",
    url:'vendors/store',
    data:$('#form-vendor-add').serialize(),
    dataType: 'json',
    success: function(data){
      console.log(data);
      $('#modal_vendor').modal('hide');
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


function save_edit_vendor_data(){
  var data = vendorTable.row(".active").data();
  var id = data["id"];
  $.ajaxSetup({
    header:$('meta[name="_token"]').attr('content')
  })
  $.ajax({
    type:"PATCH",
    url:'vendors/'+id,
    data:$('#form-edit-vendor').serialize(),
    
    success: function(data){
      $('#modal_vendor').modal('hide');
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

function delete_vendor() {
  var data = vendorTable.row(".active").data();
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
      url:'vendors/'+id,
      dataType: 'json',
      success: function(data){
        console.log(data);
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
  vendorTable.ajax.reload(null,false);
  $("a.btn_dynamic").addClass("disabled");
  $("a#btn_view").removeClass("btn-info");
  $("a#btn_edit").removeClass("btn-warning");
  $("a#btn_delete").removeClass("btn-danger");
  $("a.btn_dynamic").addClass("btn-default");
}
</script>
@endpush