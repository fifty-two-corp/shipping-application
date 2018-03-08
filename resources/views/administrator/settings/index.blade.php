@extends('layouts.layout')
@section('content')
<div id="content" class="content">        
    <h1 class="page-header">Settings <small></small></h1>
    <div class="row">
      <div class="col-md-6 ui-sortable">
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
          <div class="panel-heading">
            <div class="panel-heading-btn">
              <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
              <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
              <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
              <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            </div>
            <h4 class="panel-title">Bank Settings</h4>
          </div>
          <div class="panel-body">

            {!! Form::model($settings, ['method' => 'PATCH', 'class' => 'form-horizontal', 'id' => 'form-bank-settings']) !!}
              <div class="form-group">
                <label class="col-md-3 control-label">Bank Name</label>
                <div class="col-md-9">
                  {!! Form::text('bank_name', $settings[0]['bank_name'], array('placeholder' => 'Bank Name','class' => 'form-control', 'id' => 'bank_name')) !!}
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Bank Account</label>
                <div class="col-md-9">
                  {!! Form::text('bank_account', $settings[0]['bank_account'], array('placeholder' => 'Bank Account','class' => 'form-control', 'id' => 'bank_account')) !!}
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Bank Number</label>
                <div class="col-md-9">
                  {!! Form::text('bank_number', $settings[0]['bank_number'], array('placeholder' => 'Bank Number','class' => 'form-control', 'id' => 'bank_number')) !!}
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label"></label>
                <div class="col-md-9">
                  @permission('update-settings')
                    <button type="button" class="btn btn-sm btn-success" onclick="save_data_bank()">Save</button>
                  @endpermission
                </div>
              </div>
            {!! Form::close() !!}
          </div>
        </div>
        <!-- end panel -->
      </div>
    </div>
</div>
@endsection
@push('js')
  <script>
      $('#administrator-menu').addClass('active');
      $('#settings-menu').addClass('active');
      function save_data_bank(){
          var id = {{$settings[0]->id}};
          $.ajaxSetup({
              header:$('meta[name="_token"]').attr('content')
          })
          $.ajax({
              type:"PATCH",
              url:'settings/bank-settings/' + id,
              data:$('#form-bank-settings').serialize(),
              success: function(data){
                  //console.log(data);
                  swal('Updated','','success');
              },
              error: function(data){
                  swal('Error','','error');
              }
          })
      };
  </script>
@endpush