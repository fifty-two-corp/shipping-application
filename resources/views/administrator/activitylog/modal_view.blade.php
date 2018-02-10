<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title" id="myModalLabel">Log Details</h4>
        </div>
        <div class="modal-body">
          @foreach ($log_properties as $key => $log)
            <strong>{{ $key }} : </strong><br>
            @foreach ($log as $key => $logs)
              <span style="padding-left: 20px">{{ $key .' = '. $logs }} </span><br>
            @endforeach
            <br>
          @endforeach
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
