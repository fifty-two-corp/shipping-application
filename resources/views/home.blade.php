@extends('layouts.layout')
@section('content')
<div id="content" class="content">        
    <!-- begin page-header -->
    <h1 class="page-header">Dashboard <small></small></h1>
    <!-- end page-header -->

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    Welcome <strong>{{ Auth::user()->name }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        Dashboard.init();
    });
</script>
@endpush
