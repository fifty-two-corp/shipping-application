<div class="email-btn-row">
    <a href="javascript:;" id="btn_new_permission" class="btn btn-sm btn-primary" onclick="show_modal_permission()">New Permision</a>
    <a href="javascript:;" id="btn_edit_permission" class="btn btn-sm btn-default disabled btn_dynamic_permission" onclick="show_modal_edit_permission()">Edit</a>
    <a href="javascript:;" id="btn_delete_permission" class="btn btn-sm btn-default disabled btn_dynamic_permission" onclick="delete_permission()">Delete</a>
    <a href="javascript:;" onclick="reload_data_permission()" class="btn btn-sm btn-success"><i class="fa fa-refresh"></i></a>
</div>
<hr>
<div class="table-responsive">
  <table id="permission_table" class="table table-striped display table-bordered responsive nowrap">
      <thead>
          <tr>
              <th>Name</th>
              <th>Display Name</th>
              <th>Description</th>
          </tr>
      </thead>
  </table>
</div>
<div class="modal fade" id="modal_permission" tabindex="-1" role="dialog" aria-labelledby="modal_permision" aria-hidden="true"></div>
<script>

  $(document).ready(function() {
    var id = {{ $id }}
    permissionTable = $('#permission_table').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url:'menu_permission/get-data-permission/' + id, 
        searchHighlight: true,
        deferRender: true,
      },
      deferRender: true,
      responsive:true,
      keys: true,
      sorting: [[0,"asc"]],
      pagingType: "full_numbers",
      language: {
        "zeroRecords": "Permission not found...",
        "loadingRecords": "Loading...",
        "processing": "Load Data"
      },
      columns: [
        { data: 'name'},
        { data: 'display_name'},
        { data: 'description'}
      ]
    });

    $("#permission_table tbody").on("click","tr",function() { //highlight on click row
      if ($(this).hasClass("active")) {
        $(this).removeClass("active");
        $("a.btn_dynamic_permission").addClass("disabled");
        $("a#btn_view_permission").removeClass("btn-info");
        $("a#btn_edit_permission").removeClass("btn-warning");
        $("a#btn_delete_permission").removeClass("btn-danger");
        $("a.btn_dynamic_permission").addClass("btn-default");
      }
      else {
        permissionTable.$("tr.active").removeClass("active");
        $("a.btn_dynamic_permission").addClass("disabled");
        $(this).addClass("active");
        $("a.btn_dynamic_permission").removeClass("disabled");
        $("a.btn_dynamic_permission").removeClass("btn-default");
        $("a#btn_view_permission").addClass("btn-info");
        $("a#btn_edit_permission").addClass("btn-warning");
        $("a#btn_delete_permission").addClass("btn-danger");
      }
    });
  });
</script>