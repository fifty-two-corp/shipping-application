@extends('layouts.layout')
@section('content')
<div id="content" class="content">        
  <!-- begin page-header -->
  <h1 class="page-header">Cost <small></small></h1>
  <!-- end page-header -->

 <!-- begin row -->
  <div class="col-lg-6">
    <div class="row">
      <!-- begin panel -->
      <div class="panel panel-inverse" data-sortable-id="form-stuff-5">
          <div class="panel-heading">
              <div class="panel-heading-btn">
                  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
              </div>
              <h4 class="panel-title">Province</h4>
          </div>
          <div class="panel-body">
            <div class="email-btn-row">
                <a href="javascript:;" id="btn_edit_province" class="btn btn-sm btn-default disabled btn_dynamic_province" onclick="show_modal_edit_province()">Edit</a>
                <a href="javascript:;" onclick="reload_data_province()" class="btn btn-sm btn-success"><i class="fa fa-refresh"></i></a>
            </div>
            <hr>
            <div class="table-responsive">
              <table id="province_table" class="table table-striped display table-bordered responsive nowrap">
                  <thead>
                      <tr>
                          <th>Name</th>
                          <th>Default Price</th>
                      </tr>
                  </thead>
              </table>
            </div>
          </div>
      </div><!-- end panel -->
    </div>
  </div>
  <div class="col-lg-6">
    <div class="row" id="city-data"></div>
  </div>
  <div class="modal fade" id="modal_city" tabindex="-1" role="dialog" aria-labelledby="modal_city" aria-hidden="true"></div>
</div>

@endsection

@push('js')
<!-- datatables -->
<script type="text/javascript">
  $('#cost-menu').addClass('active');
  $('#city-menu').addClass('active');
  var listener = new window.keypress.Listener();
  $(document).ready(function() {
  get_city_default();
  provinceTable = $('#province_table').DataTable({
    processing: true,
    serverSide: true,
    searchHighlight: true,
    ajax: {
      url:'{{ url("city/get-provinces") }}', 
      deferRender: true,
    },
    deferRender: true,
    responsive:true,
    keys: true,
    sorting: [[0,"asc"]],
    pagingType: "full_numbers",
    stateSave: false,
    language: {
      "zeroRecords": "Province not found...",
      "loadingRecords": "Loading...",
      "processing": "Load Data"
    },
    columns: [
      { data: 'name', name: 'name' },
      { data: 'default_price', name: 'default_price' },
    ]
  });

  $("#province_table tbody").on("click","tr",function() { //highlight on click row
    if ($(this).hasClass("active")) {
      $(this).removeClass("active");
      $("a.btn_dynamic_province").addClass("disabled");
      $("a#btn_view_province").removeClass("btn-info");
      $("a#btn_edit_province").removeClass("btn-warning");
      $("a#btn_delete_province").removeClass("btn-danger");
      $("a.btn_dynamic_province").addClass("btn-default");
      get_city_default();
      
    }
    else {
      provinceTable.$("tr.active").removeClass("active");
      $("a.btn_dynamic_province").addClass("disabled");
      $(this).addClass("active");
      $("a.btn_dynamic_province").removeClass("disabled");
      $("a.btn_dynamic_province").removeClass("btn-default");
      $("a#btn_view_province").addClass("btn-info");
      $("a#btn_edit_province").addClass("btn-warning");
      $("a#btn_delete_province").addClass("btn-danger");
      get_data_city();
    }
  });
});

function show_modal_edit_province() {
  var data = provinceTable.row(".active").data();
  var id = data["id"];
  $.ajax({
    type:"GET",
    url: "city/"+id+"/edit-province",
    success: function(res) {
      $('#modal_city').html(res);
      $('#modal_city').modal('show');
    }
  });
}

function show_modal_view_province() {
  var data = provinceTable.row(".active").data();
  var id = data["id"];
  $.ajax({
    type:"GET",
    url: "city/"+id,
    success: function(res) {
      $('#modal_city').html(res);
      $('#modal_city').modal('show');
    }
  });
}

function save_province_edit_data(){
  var data = provinceTable.row(".active").data();
  var id = data["id"];
  $.ajaxSetup({
    header:$('meta[name="_token"]').attr('content')
  })
  $.ajax({
    type:"PATCH",
    url:'province/'+id,
    data:$('#form-edit-province').serialize(),
    
    success: function(data){
      $('#modal_city').modal('hide');
      swal('Updated','','success');
      reload_data_province();
    },
      error: function(data){
        $('#province-allert').removeAttr('hidden');
    }
  })
};


function reload_data_province() {
  provinceTable.ajax.reload(null,false);
  $("a.btn_dynamic_province").addClass("disabled");
  $("a#btn_view_province").removeClass("btn-info");
  $("a#btn_edit_province").removeClass("btn-warning");
  $("a#btn_delete_province").removeClass("btn-danger");
  $("a.btn_dynamic_province").addClass("btn-default");
  get_city_default();
}


  /*City*/
  function get_city_default() {
    $.ajax({
      type:"GET",
      url: "city/get-city-default",
      success: function(res) {
        $('#city-data').html(res);
      }
    });
  }

  function get_data_city() {
    var data = provinceTable.row(".active").data();
    var id = data["id"];
    $.ajax({
      type:"GET",
      url: "city/get-data-city/"+id,
      success: function(res) {
        $('#city-data').html(res);
      }
    });
  }

  function show_modal_edit_city() {
    var data = cityTable.row(".active").data();
    var id = data["id"];
    $.ajax({
      type:"GET",
      url: "city/"+id+"/edit-city",
      success: function(res) {
        $('#modal_city').html(res);
        $('#modal_city').modal('show');
      }
    });
  }

  function save_city_edit_data(){
    var data = cityTable.row(".active").data();
    var id = data["id"];
    $.ajaxSetup({
      header:$('meta[name="_token"]').attr('content')
    })
    $.ajax({
      type:"PATCH",
      url:'city/'+id,
      data:$('#form-edit-city').serialize(),
      
      success: function(data){
        $('#modal_city').modal('hide');
        swal('Updated','','success');
        reload_data_city();
      },
        error: function(data){
          $('#city-allert').removeAttr('hidden');
      }
    })
  };


  function reload_data_city() {
    cityTable.ajax.reload(null,false);
    $("a.btn_dynamic_city").addClass("disabled");
    $("a#btn_view_city").removeClass("btn-info");
    $("a#btn_edit_city").removeClass("btn-warning");
    $("a#btn_delete_city").removeClass("btn-danger");
    $("a.btn_dynamic_city").addClass("btn-default");
  }
</script>
@endpush