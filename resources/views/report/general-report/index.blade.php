@extends('layouts.layout')
@section('content')
<div id="content" class="content">        
    <h1 class="page-header">Report <small></small></h1>
    <div class="row">
      <div class="panel panel-inverse" data-sortable-id="form-stuff-5">
          <div class="panel-heading">
              <div class="panel-heading-btn">
                  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
              </div>
              <h4 class="panel-title">General Report</h4>
          </div>
          <div class="panel-body">
            <div class="email-btn-row">
              <form class="form-horizontal">
                <div class="form-group">
                  <label class="control-label col-md-2 pull-left">Date Ranges</label>
                  <div class="col-md-4">
                    <div class="input-group">
                      <input type="text" name="report-daterange" id="report-daterange" class="form-control" value="" placeholder="click to select the date range" />
                      <span class="input-group-btn">
                        <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                      </span>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <hr>
            <div id="report-result"></div>
            <div class="modal fade" id="modal_customer" tabindex="-1" role="dialog" aria-labelledby="modal_customer" aria-hidden="true"></div>
          </div>
      </div>
    </div>
</div>
@endsection
@push('js')
<script type="text/javascript">
  $('#report-menu').addClass('active');
  $('#general_report-menu').addClass('active');
  var listener = new window.keypress.Listener();
  $(function() {
    $("#report-daterange").daterangepicker({
      format:"DD-MM-YYYY",
      separator:" to ",
      startDate:moment().subtract(29,"days"),
      endDate:moment(),
      minDate:"01/01/2017"},
      function(a,t){$("#report-daterange").val(a.format("MMMM D, YYYY")+" - "+t.format("MMMM D, YYYY"))}
    );
  });
  $(function() {
    $('.applyBtn').click(function(){
      var date_start = $("input[name='daterangepicker_start']").val();
      var date_end = $("input[name='daterangepicker_end']").val();
      $.ajaxSetup({
        header:$('meta[name="_token"]').attr('content')
      })
      $.ajax({
        type:"POST",
        url:'general-report/post-report-data',
        data: {date_start: date_start, date_end: date_end},
        //dataType: 'json',
        success: function(data){
           $("#report-result").html('');
           $("#report-result").html(data);
        },
        error: function(jqxhr, status, exception){
          console.log('Exception:', exception);
          swal('Error','Please Check Your Data','error');
        }
      })
    });
  });
</script>
@endpush