<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="modal_role">View Roles</h4>
        </div>
        <div class="modal-body">
              <div class="row">
                <div class="form-horizontal">               
                  <label class="col-xs-4 control-label">Name: </label>
                  <p class="form-control-static">{{ $role->name }}</p>             
                  <label class="col-xs-4 control-label">Display Name:</label>
                  <p class="form-control-static">{{ $role->display_name }}</p>              
                  <label class="col-xs-4 control-label">Description:</label>
                  <p class="form-control-static">{{ $role->description }}</p>             
                  <label class="col-xs-4 control-label">Created at:</label>
                  <p class="form-control-static">{{ $role->created_at }}</p>            
                  <label class="col-xs-4 control-label">Updated at</label>
                  <p class="form-control-static">{{ $role->updated_at }}</p>  
                  <label class="col-xs-4 control-label">Permission</label>
                  <p class="form-control-static">
                    @foreach($role_permission as $item)
                      <span class="label label-success">{{$item}}</span>
                    @endforeach
                  </p>               
              </div>
              </div>
             <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>