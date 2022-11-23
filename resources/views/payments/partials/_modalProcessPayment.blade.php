<div class="modal fade modalProcessPayment" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Cargar Pago</h4>
        <button type="button" class="close" data-dismiss="modal" @click="$store.dispatch('resetValues')"><span aria-hidden="true" >×</span>
        </button>
      </div>
      <div class="modal-body">

        
        @if($payment_classification == 'iva')
            <load-payment-iva></load-payment-iva>
        @else
            <load-payment-tax-base></load-payment-tax-base>
        @endif

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" 
          @click="$store.dispatch('resetValues')">Cancelar</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" 
          @click="$store.dispatch('postPayment')">Guardar</button>
      </div>
    </div>
  </div>
</div>