<div class="modal fade modalPayment" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Procesar saldo positivo</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="row">
            <div class="col-md-12">
              @if($payment_classification == 'iva')
                <app-process-payments-iva 
                  :payment="{
                    'positive_balance': '{{  $payment->amount - $payment->amount_paid }}',
                    'concept':          '{{  $payment->concept }}',
                    'reference':        '{{  $payment->reference }}',
                    'date':             '{{  $payment->date }}',
                    'type':             '{{  $payment->type }}',
                    'bank':             '{{  $payment->bank->id }}',
                  }"
                ></app-process-payments-iva>
              @else
                  <app-process-payments-tax-base 
                  :payment="{
                    'positive_balance': '{{  $payment->amount - $payment->amount_paid }}',
                    'concept':          '{{  $payment->concept }}',
                    'reference':        '{{  $payment->reference }}',
                    'date':             '{{  $payment->date }}',
                    'type':             '{{  $payment->type }}',
                    'bank':             '{{  $payment->bank->id }}',
                  }"
                ></app-process-payments-tax-base>
              @endif
                
            </div>
        </div>


      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>