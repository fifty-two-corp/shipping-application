@extends('layouts.layout')
@section('content')
<div id="content" class="content">        
    <h1 class="page-header">Master <small></small></h1>
    <div class="row">
      <div class="panel panel-inverse" data-sortable-id="form-stuff-5">
          <div class="panel-heading">
              <div class="panel-heading-btn">
                  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
              </div>
              <h4 class="panel-title">Customer</h4>
          </div>
          <div class="panel-body">
            <div class="email-btn-row">
                <a href="javascript:;" id="btn_new" class="btn btn-sm btn-primary" onclick="show_modal_add_customer()">New Customer</a>
                <a href="javascript:;" id="btn_edit" class="btn btn-sm btn-default disabled btn_dynamic" onclick="show_modal_edit_customer()">Edit</a>
                <a href="javascript:;" id="btn_delete" class="btn btn-sm btn-default disabled btn_dynamic" onclick="delete_customer()">Delete</a>
                <a href="javascript:;" onclick="reload_data()" class="btn btn-sm btn-success"><i class="fa fa-refresh"></i></a>
            </div>
            <hr>
            <div class="table-responsive">
              <table id="customer_table" class="table table-striped display table-bordered responsive nowrap">
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>Name</th>
                          <th>Address</th>
                          <th>Province</th>
                          <th>City</th>
                          <th>District</th>
                          <th>Phone</th>
                          <th>NPWP</th>
                          <th>Discount</th>
                      </tr>
                  </thead>
              </table>
            </div>
            <div class="modal fade" id="modal_customer" tabindex="-1" role="dialog" aria-labelledby="modal_customer" aria-hidden="true"></div>
          </div>
      </div>
    </div>
</div>
@endsection
@push('js')
<script type="text/javascript">
  $('#master-menu').addClass('active');
  $('#customer-menu').addClass('active');
  var listener = new window.keypress.Listener();
  $(document).ready(function() {
  customerTable = $('#customer_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url:'{{ url("customer/get-customer") }}', 
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
      "zeroRecords": "Customer not found...",
      "loadingRecords": "Loading...",
      "processing": "Load Data"
    },
    columns: [
      { data: 'customer_number'},
      { data: 'name'},
      { data: 'address'},
      { data: 'province'},
      { data: 'city'},
      { data: 'districts'},
      { data: 'phone'},
      { data: 'npwp'},
      { data: 'discount'},
    ]
  });

  $("#customer_table tbody").on("click","tr",function() { //highlight on click row
    if ($(this).hasClass("active")) {
      $(this).removeClass("active");
      $("a.btn_dynamic").addClass("disabled");
      $("a#btn_view").removeClass("btn-info");
      $("a#btn_edit").removeClass("btn-warning");
      $("a#btn_delete").removeClass("btn-danger");
      $("a.btn_dynamic").addClass("btn-default");
    }
    else {
      customerTable.$("tr.active").removeClass("active");
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

function show_modal_add_customer() {
  $.ajax({
    type:"GET",
    url: "customer/create",
    success: function(res) {
      $('#modal_customer').html(res);
      $('#modal_customer').modal('show');
    }
  });
}

function show_modal_edit_customer() {
  var data = customerTable.row(".active").data();
  var id = data["id"];
  $.ajax({
    type:"GET",
    url: "customer/"+id+"/edit",
    success: function(res) {
      //console.log(id);
      $('#modal_customer').modal('show');
      $('#modal_customer').html(res);
    }
  });
}

function save_customer_data(){
  $.ajaxSetup({
    header:$('meta[name="_token"]').attr('content')
  })
  $.ajax({
    type:"POST",
    url:'customer/store',
    data:$('#form-customer-add').serialize(),
    dataType: 'json',
    success: function(data){
      //console.log(data);
      $('#modal_customer').modal('hide');
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
};


function save_edit_customer_data(){
  var data = customerTable.row(".active").data();
  var id = data["id"];
  $.ajaxSetup({
    header:$('meta[name="_token"]').attr('content')
  })
  $.ajax({
    type:"PATCH",
    url:'customer/'+id,
    data:$('#form-edit-customer').serialize(),
    
    success: function(data){
      //console.log(data);
      $('#modal_customer').modal('hide');
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
};

function delete_customer() {
  var data = customerTable.row(".active").data();
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
      url:'customer/'+id,
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
  customerTable.ajax.reload(null,false);
  $("a.btn_dynamic").addClass("disabled");
  $("a#btn_view").removeClass("btn-info");
  $("a#btn_edit").removeClass("btn-warning");
  $("a#btn_delete").removeClass("btn-danger");
  $("a.btn_dynamic").addClass("btn-default");
}
</script>
@endpush