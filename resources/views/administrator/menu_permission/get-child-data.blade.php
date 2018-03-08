<div class="panel-body">
  <div class="email-btn-row">
    @permission('create-permission')
      <a href="javascript:;" id="btn_new_child" class="btn btn-sm btn-primary" onclick="show_modal_child()">New Child Menu</a>
    @endpermission
    @permission('update-permission')
      <a href="javascript:;" id="btn_edit_child" class="btn btn-sm btn-default disabled btn_dynamic_child" onclick="show_modal_edit_child()">Edit</a>
    @endpermission
    @permission('delete-permission')
      <a href="javascript:;" id="btn_delete_child" class="btn btn-sm btn-default disabled btn_dynamic_child" onclick="delete_child()">Delete</a>
    @endpermission
    <a href="javascript:;" onclick="reload_data_child()" class="btn btn-sm btn-success"><i class="fa fa-refresh"></i></a>
  </div>
  <hr>
  <div class="table-responsive">
    <table id="child_menu_table" class="table table-striped display table-bordered responsive nowrap">
        <thead>
            <tr>
                <th>Child Menu</th>
                <th>Link</th>
            </tr>
        </thead>
    </table>
  </div>
  <div class="modal fade" id="modal_child_menu" tabindex="-1" role="dialog" aria-labelledby="modal_child_menu" aria-hidden="true"></div>
</div>
<script>

  $(document).ready(function() {
    var id = {{ $id }}
    childTable = $('#child_menu_table').DataTable({
      processing: false,
      serverSide: true,
      ajax: {
        url:'menu_permission/get-data-child/' + id, 
        searchHighlight: true,
        deferRender: true,
      },
      deferRender: true,
      responsive:true,
      keys: true,
      sorting: [[0,"asc"]],
      pagingType: "full_numbers",
      language: {
        "zeroRecords": "Child menu not found...",
        "loadingRecords": "Loading...",
        "processing": "Load Data"
      },
      columns: [
        { data: 'name' },
        { data: 'link' },
      ]
    });

    $("#child_menu_table tbody").on("click","tr",function() { //highlight on click row
      if ($(this).hasClass("active")) {
        $(this).removeClass("active");
        $("a.btn_dynamic_child").addClass("disabled");
        $("a#btn_view_child").removeClass("btn-info");
        $("a#btn_edit_child").removeClass("btn-warning");
        $("a#btn_delete_child").removeClass("btn-danger");
        $("a.btn_dynamic_child").addClass("btn-default");
        get_permission_default();
      }
      else {
        childTable.$("tr.active").removeClass("active");
        $("a.btn_dynamic_child").addClass("disabled");
        $(this).addClass("active");
        $("a.btn_dynamic_child").removeClass("disabled");
        $("a.btn_dynamic_child").removeClass("btn-default");
        $("a#btn_view_child").addClass("btn-info");
        $("a#btn_edit_child").addClass("btn-warning");
        $("a#btn_delete_child").addClass("btn-danger");
        get_permission_data();
      }
    });
  });
</script>