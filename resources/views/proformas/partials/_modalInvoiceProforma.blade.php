<div class="modal fade modalInvoiceProforma" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Selecionar productos</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">

        <totalize-proforma></totalize-proforma>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal"
          @click="$store.dispatch('postProforma', 'invoicing')"
        >
          Guardar
        </button>
      </div>

    </div>
  </div>
</div>