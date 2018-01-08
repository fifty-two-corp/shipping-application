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
              <h4 class="panel-title">Customer Cost</h4>
          </div>
          <div class="panel-body">
            <div class="email-btn-row">
                <a href="javascript:;" id="btn_new" class="btn btn-sm btn-primary" onclick="show_modal_add_customer()">New Cost</a>
                <a href="javascript:;" id="btn_edit" class="btn btn-sm btn-default disabled btn_dynamic" onclick="show_modal_edit_customer_cost()">Edit</a>
                <a href="javascript:;" id="btn_delete" class="btn btn-sm btn-default disabled btn_dynamic" onclick="delete_customer_cost()">Delete</a>
                <a href="javascript:;" onclick="reload_data()" class="btn btn-sm btn-success"><i class="fa fa-refresh"></i></a>
            </div>
            <hr>
            <div class="table-responsive">
              <table id="customer_cost_table" class="table table-striped display table-bordered responsive nowrap">
                  <thead>
                      <tr>
                          <th>Customer</th>
                          <th>Origin</th>
                          <th>Destination</th>
                          <th>Type</th>
                          <th>Cost</th>
                      </tr>
                  </thead>
              </table>
            </div>
            <div class="modal fade" id="modal_customer_cost" tabindex="-1" role="dialog" aria-labelledby="modal_customer_cost" aria-hidden="true"></div>
          </div>
      </div><!-- end panel -->
    </div><!-- end row -->
</div>
@endsection

@push('js')

<script type="text/javascript">
  $('#cost-menu').addClass('active');
  $('#customercost-menu').addClass('active');
  var listener = new window.keypress.Listener();
  $(document).ready(function() {
  customercostTable = $('#customer_cost_table').DataTable({
    processing: false,
    serverSide: true,
    ajax: {
      url:'{{ url("customer-cost/get-customer-cost") }}', 
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
      "zeroRecords": "Customer Cost not found...",
      "loadingRecords": "Loading...",
    },
    columns: [
      { data: 'customer'},
      { data: 'origin_city'},
      { data: 'destination_city'},
      { data: 'type'},
      { data: 'cost'}
    ]
  });

  $("#customer_cost_table tbody").on("click","tr",function() { //highlight on click row
    if ($(this).hasClass("active")) {
      $(this).removeClass("active");
      $("a.btn_dynamic").addClass("disabled");
      $("a#btn_view").removeClass("btn-info");
      $("a#btn_edit").removeClass("btn-warning");
      $("a#btn_delete").removeClass("btn-danger");
      $("a.btn_dynamic").addClass("btn-default");
    }
    else {
      customercostTable.$("tr.active").removeClass("active");
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
    url: "customer-cost/create",
    success: function(res) {
      $('#modal_customer_cost').html(res);
      $('#modal_customer_cost').modal('show');
    }
  });
}

function show_modal_edit_customer_cost() {
  var data = customercostTable.row(".active").data();
  var id = data["id"];
  $.ajax({
    type:"GET",
    url: "customer-cost/"+id+"/edit",
    success: function(res) {
      //console.log(id);
      $('#modal_customer_cost').modal('show');
      $('#modal_customer_cost').html(res);
    }
  });
}

function save_customer_cost_data(){
  $.ajaxSetup({
    header:$('meta[name="_token"]').attr('content')
  })
  $.ajax({
    type:"POST",
    url:'customer-cost/store',
    data:$('#form-customer-cost-add').serialize(),
    dataType: 'json',
    success: function(data){
      console.log(data);
      $('#modal_customer_cost').modal('hide');
      swal('Added','','success');
      reload_data();
    },
      error: function(data){
        console.log(data);
        $('#customer-cost-allert').removeAttr('hidden');
    }
  })
};


function save_edit_customer_cost_data(){
  var data = customercostTable.row(".active").data();
  var id = data["id"];
  $.ajaxSetup({
    header:$('meta[name="_token"]').attr('content')
  })
  $.ajax({
    type:"PATCH",
    url:'customer-cost/'+id,
    data:$('#form-edit-cutomer-cost').serialize(),
    
    success: function(data){
      //console.log(data);
      $('#modal_customer_cost').modal('hide');
      swal('Updated','','success');
      reload_data();
    },
      error: function(data){
        $('#customer-cost-allert').removeAttr('hidden');
    }
  })
};

function delete_customer_cost() {
  var data = customercostTable.row(".active").data();
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
      url:'customer-cost/'+id,
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
  customercostTable.ajax.reload(null,false);
  $("a.btn_dynamic").addClass("disabled");
  $("a#btn_view").removeClass("btn-info");
  $("a#btn_edit").removeClass("btn-warning");
  $("a#btn_delete").removeClass("btn-danger");
  $("a.btn_dynamic").addClass("btn-default");
}
</script>
@endpush