 <div class="row">
    <div class="col-md-12">
    	@if($payment_classification == 'iva')
	        <app-process-payments-iva 
	          :payment="{
	            'positive_balance': '0'
	          }"
	        ></app-process-payments-iva>
	    @else
	    	<app-process-payments-tax-base 
	          :payment="{
	            'positive_balance': '0',
	          }"
	        ></app-process-payments-tax-base>
    	@endif
    </div>
</div>

