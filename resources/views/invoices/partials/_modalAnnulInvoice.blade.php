<div class="modal fade modalAnnulInvoice" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Anular Proforma</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <h5>¿Desea anular esta proforma facturada?</h5>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <a href="{{route('invoices.annul', $invoice->id)}}" class="btn btn-primary" >
          Aceptar
        </a>
      </div>
      <div class="modal-footer">
        
      </div>

    </div>
  </div>
</div>