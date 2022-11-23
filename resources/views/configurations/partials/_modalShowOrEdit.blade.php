<div class="modal fade modalShowOrEdit" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Actualizar Configuración</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <configuration-action></configuration-action>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <a href="#" class="btn btn-primary" data-dismiss="modal" @click="$store.dispatch('postConfiguration')">
          Guardar
        </a>
      </div>
      <div class="modal-footer">
        
      </div>

    </div>
  </div>
</div>