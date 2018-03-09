@extends('layouts.layout')
@section('content')
<div id="content" class="content">
  <h1 class="page-header">Dashboard <small></small></h1>
  <div class="row">
    <!-- begin col-3 -->
    <div class="col-md-3 col-sm-6">
      <div class="widget widget-stats bg-green">
        <div class="stats-icon"><i class="fa fa-money"></i></div>
        <div class="stats-info">
          <h4>TERMIN TERM DEBT</h4>
          <p>{{ $term_dept }}</p>
        </div>
        <div class="stats-link"><p></p></div>
      </div>
    </div>
    <!-- end col-3 -->
    <!-- begin col-3 -->
    <div class="col-md-2 col-sm-4">
      <div class="widget widget-stats bg-red">
        <div class="stats-icon"><i class="fa fa-calendar"></i></div>
        <div class="stats-info">
          <h4>TERMIN DUE DATE</h4>
          <p>{{ $termin_due_date }}</p>
        </div>
        <div class="stats-link"><p></p></div>
      </div>
    </div>
    <!-- end col-3 -->
    <!-- begin col-3 -->
    <div class="col-md-2 col-sm-4">
      <div class="widget widget-stats bg-red">
        <div class="stats-icon"><i class="fa fa-file-text-o"></i></div>
        <div class="stats-info">
          <h4>DO DUE DATE</h4>
          <p>{{ $do_due_date }}</p>
        </div>
        <div class="stats-link"><p></p></div>
      </div>
    </div>
    <!-- end col-3 -->
    <!-- begin col-3 -->
    <div class="col-md-2 col-sm-4">
      <div class="widget widget-stats bg-orange">
        <div class="stats-icon"><i class="fa fa-truck"></i></div>
        <div class="stats-info">
          <h4>SHIPPING PENDING</h4>
          <p>{{ $shipping_pending }}</p>
        </div>
        <div class="stats-link"><p></p></div>
      </div>
    </div>
    <!-- end col-3 -->
    <!-- begin col-3 -->
    <div class="col-md-3 col-sm-6">
      <div class="widget widget-stats bg-blue">
        <div class="stats-icon"><i class="fa fa-clock-o"></i></div>
        <div class="stats-info">
          <div class='time-frame'>
            <h4 id='date-part'></h4>
            <p id='time-part'></p>
          </div>
        </div>
        <div class="stats-link"><p></p></div>
      </div>
    </div>
    <!-- end col-3 -->
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-inverse" data-sortable-id="index-1">
        <div class="panel-heading">
          <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
          </div>
          <h4 class="panel-title">Monthly Income Grafik</h4>
        </div>
        <div class="panel-body">
          {!! $chartjs->render() !!}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@push('js')
<script>
    $('#dashboard-menu').addClass('active');
    $(document).ready(function() {
        Dashboard.init();
        setInterval(function() {
            var momentNow = moment();
            $('#date-part').html(momentNow.format('dddd')
                .substring(0,3).toUpperCase() + ' ' + momentNow.format('DD MMMM YYYY'));
            $('#time-part').html(momentNow.format('hh:mm:ss A'));
        }, 100);
    });
</script>
@endpush
