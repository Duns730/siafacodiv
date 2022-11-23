<div class="modal fade modalSelecPurchase" tabindex="-1" role="dialog" aria-hidden="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header " style="font-size: 15px; font-weight: bold;">
        <h4 class="modal-title" id="myModalLabel">Selecionar Compra</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">

        <select-purchase></select-purchase>

      </div>
      <div class="modal-footer">
        <button class="btn btn-danger" type="button"><a href="{{ url()->previous() }}"> Cancelar</a></button>
        <button type="button" class="btn btn-primary" data-dismiss="modal"
          @click="$store.dispatch('getPurchaseSelect')"
        >
          Cargar
        </button>
      </div>

    </div>
  </div>
</div>