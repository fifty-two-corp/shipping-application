
  <div class="panel panel-inverse" data-sortable-id="form-stuff-5">
    <div class="panel-heading">
      <div class="panel-heading-btn">
        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
      </div>
      <h4 class="panel-title">City</h4>
    </div>
    <div class="panel-body">
      <div class="email-btn-row">
        <a href="javascript:;" id="btn_edit_city" class="btn btn-sm btn-default disabled btn_dynamic_city" onclick="show_modal_edit_city()">Edit</a>
        <a href="javascript:;" onclick="reload_data_city()" class="btn btn-sm btn-success"><i class="fa fa-refresh"></i></a>
      </div>
      <hr>
      <div class="table-responsive">
        <table id="city_table" class="table table-striped display table-bordered responsive nowrap">
          <thead>
            <tr>
              <th>Name</th>
              <th>Unit Price</th>
            </tr>
          </thead>
        </table>
      </div> 
    </div>
  </div>
<script>

  $(document).ready(function() {
    var id = {{ $id }}
    cityTable = $('#city_table').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url:'{{ url("city/get-city") }}' + '/'+ id, 
        searchHighlight: true,
        deferRender: true,
      },
      deferRender: true,
      responsive:true,
      keys: true,
      sorting: [[0,"asc"]],
      pagingType: "full_numbers",
      language: {
        "zeroRecords": "city not found...",
        "loadingRecords": "Loading...",
        "processing": "Load Data"
      },
      columns: [
        { data: 'name', name: 'name' },
        { data: 'unit_price', name: 'unit_price' },
      ]
    });

    $("#city_table tbody").on("click","tr",function() { //highlight on click row
      if ($(this).hasClass("active")) {
        $(this).removeClass("active");
        $("a.btn_dynamic_city").addClass("disabled");
        $("a#btn_view_city").removeClass("btn-info");
        $("a#btn_edit_city").removeClass("btn-warning");
        $("a#btn_delete_city").removeClass("btn-danger");
        $("a.btn_dynamic_city").addClass("btn-default");
      }
      else {
        cityTable.$("tr.active").removeClass("active");
        $("a.btn_dynamic_city").addClass("disabled");
        $(this).addClass("active");
        $("a.btn_dynamic_city").removeClass("disabled");
        $("a.btn_dynamic_city").removeClass("btn-default");
        $("a#btn_view_city").addClass("btn-info");
        $("a#btn_edit_city").addClass("btn-warning");
        $("a#btn_delete_city").addClass("btn-danger");
      }
    });
  });
</script>