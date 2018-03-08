@extends('layouts.layout')
@section('content')
<div id="content" class="content">        
  <h1 class="page-header">Installment Reports <small></small></h1>
  <div class="row">
    <div class="panel panel-inverse panel-with-tabs">
      <div class="panel-heading p-0">
        <div class="panel-heading-btn m-r-10 m-t-10">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-expand"><i class="fa fa-expand"></i></a>
        </div>
        <div class="tab-overflow">
            <ul class="nav nav-tabs nav-tabs-inverse" id="tabs">
                <li class="active"><a href="#reservation-list" data-toggle="tab">Installment List</a></li>
            </ul>
        </div>
      </div>
      <div class="tab-content">
        <div class="tab-pane fade active in" id="reservation-list">
          <div class="panel-body">
            <div class="email-btn-row">
              @permission('view-termin')
                <a href="javascript:;" id="btn_view" class="btn btn-sm btn-default disabled btn_dynamic" onclick="show_details()">Details</a>
              @endpermission
                <a href="javascript:;" onclick="reload_data()" class="btn btn-sm btn-success"><i class="fa fa-refresh"></i></a>
                <!-- <div class="col-md-2 pull-right"> 
                    <select class="form-control" id="filter_select_reservation">
                        <option value="" selected="selected">All</option>
                        <option value="Canceled">Cancel</option>
                        <option value="Cancel Request">Cancel Request</option>
                        <option value="Complete">Complete</option>
                        <option value="Expired">Expired</option>
                        <option value="Payment Request">Payment Request</option>
                        <option value="Verified">Verified</option>
                        <option value="Waiting Payment">Waiting Payment</option>

                    </select>
                </div> -->
            </div>
            <hr>
            <div class="table-responsive">
              <table width="100%" id="termin_table" class="table table-striped display table-bordered responsive nowrap">
                <thead>
                  <tr>
                    <th width="1%">#</th>
                    <th>Customer</th>
                    <th>Cost</th>
                    <th>Payment</th>
                    <th>Remaining Payment</th>
                    <th>Time Period</th>
                    <th>Due Date</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@push('js')
<script type="text/javascript">
  $('#transaction-menu').addClass('active');
  $('#termin_list-menu').addClass('active');
  var listener = new window.keypress.Listener();
  var urlParams = new URLSearchParams(window.location.search);

  $(document).ready(function() {
  terminTable = $('#termin_table').DataTable({
    processing: false,
    serverSide: true,
    ajax: {
      url:'{{ url("termin/get-termin-list") }}', 
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
      "zeroRecords": "Termin not found...",
      "loadingRecords": "Loading...",
    },
    columns: [
      { data: 'transaction_number'},
      { data: 'termin_customer_name'},
      { data: 'cost'},
      { data: 'payment'},
      { data: 'remaining_payment'},
      { data: 'time_period'},
      { data: 'due_date'},
    ]
  });

  $("#termin_table tbody").on("click","tr",function() {
    if ($(this).hasClass("active")) {
      $(this).removeClass("active");
      $("a.btn_dynamic").addClass("disabled");
      $("a#btn_view").removeClass("btn-info");
      $("a#btn_edit").removeClass("btn-warning");
      $("a#btn_info").removeClass("btn-info");
      $("a#btn_delete").removeClass("btn-danger");
      $("a.btn_dynamic").addClass("btn-default");
    }
    else {
      terminTable.$("tr.active").removeClass("active");
      $("a.btn_dynamic").addClass("disabled");
      $(this).addClass("active");
      $("a.btn_dynamic").removeClass("disabled");
      $("a.btn_dynamic").removeClass("btn-default");
      $("a#btn_view").addClass("btn-info");
      $("a#btn_edit").addClass("btn-warning");
      $("a#btn_info").addClass("btn-info");
      $("a#btn_delete").addClass("btn-danger");
    }
  });

    terminTable.on("draw",function () {
      var body = $(terminTable.table().body());
      body.unhighlight();
      body.highlight(terminTable.search());
    });
  });

function show_details() {
  var data = terminTable.row(".active").data();
  var id = data["id"];
  var transaction_number = data['transaction_number'];
  var element_shipping = document.getElementById("#termin"+id);
  $.ajax({
    type:"GET",
    url: "termin/details/" + id,
    success: function(res) {
      if (element_shipping !== null) {
        $('#tabs .itab'+id+'').tab('show');
        return false;
      } else if (id === ''){
        return false;
      } else {
        $('<li><a href="#termin'+id+'" data-toggle="tab" id="#termin'+id+'" class="itab'+id+'">'+
            'Termin #'+transaction_number+'&nbsp;&nbsp;&nbsp;<span class="text text-danger" onclick="close_tab('+id+')" id="close_tab'+id+'"><i class="fa fa-times"></i></span></a></li>').appendTo('#tabs');
        $(res).appendTo('.tab-content');
        $('#tabs .itab'+id+'').tab('show');
      }
    }
  });
}

// function getInvoice() {
//   var data = shippingTable.row(".active").data();
//   var id = data["id"];
//   var transaction_number = data['transaction_number'];
//   var element_invoice = document.getElementById("#invoice"+id);
//   $.ajax({
//     type:"GET",
//     url: "invoice/" + id,
//     success: function(res) {
//       if (element_invoice !== null) {
//         $('#tabs .itab'+id+'').tab('show');
//         return false;
//       } else if (id === ''){
//         return false;
//       } else {
//         $('<li><a href="#invoice'+id+'" data-toggle="tab" id="#invoice'+id+'" class="itab'+id+'">'+
//             'Invoice #'+transaction_number+'&nbsp;&nbsp;&nbsp;<span class="text text-danger" onclick="close_tab('+id+')" id="close_tab'+id+'"><i class="fa fa-times"></i></span></a></li>').appendTo('#tabs');
//         $(res).appendTo('.tab-content');
//         $('#tabs .itab'+id+'').tab('show');
//       }
//     }
//   });
// }

function reload_data() {
  terminTable.ajax.reload(null,false);
  $("a.btn_dynamic").addClass("disabled");
  $("a#btn_view").removeClass("btn-info");
  $("a#btn_edit").removeClass("btn-warning");
  $("a#btn_info").removeClass("btn-info");
  $("a#btn_delete").removeClass("btn-danger");
  $("a.btn_dynamic").addClass("btn-default");
}

function close_tab(id) {
  var idx = $('#tabs [id=close_tab'+id+']').parent().get(0).id;
  var anchor = $('#tabs [id=close_tab'+id+']').siblings('a');
  $('.tab-pane' + idx).remove();
  $('#tabs a:first').tab('show');
  $(anchor.attr('href')).remove();
  $('#tabs [id=close_tab'+id+']').parent().remove();
  return false;
}

</script>
@endpush