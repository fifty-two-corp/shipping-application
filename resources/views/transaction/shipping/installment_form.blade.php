 <div class="row">
	 <div class="col-md-6">
	  <div class="col-xs-12 col-sm-12 col-md-12">
	    <div class="form-group">
	      <label class="col-md-4 control-label">Down Payment</label>
	      <div class="col-md-8">
      		<div class="input-group">
            <span class="input-group-addon">Rp.</span>
	        	{!! Form::text('down_payment', 0, ['placeholder' => '-','class' => 'form-control', 'id' => 'down_payment']) !!}
      		</div>
	      </div>
	    </div>
    </div>
  </div>
	<div class="col-md-6">
	  <div class="col-xs-12 col-sm-12 col-md-12">
	    <div class="form-group">
	      <label class="col-md-4 control-label">Time Period</label>
	      <div class="col-md-8">
	      	<div class="input-group">
	        	{!! Form::text('time_period', null, ['class' => 'form-control', 'id' => 'time_period']) !!}
            <span class="input-group-addon">Days</span>
	      	</div>
	    	</div>
	    </div>
	  </div>
	</div>
</div>
<script>
	$(document).ready(function () {
    $('#down_payment').priceFormat({
      prefix: '',
      thousandsSeparator:'.',
      centsLimit: 0
    });
	});
</script>