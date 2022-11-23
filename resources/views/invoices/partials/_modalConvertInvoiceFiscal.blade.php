<div class="modal fade modalConvertInvoiceFiscal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Conversión</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Convertir proforma provisional de Nro factura {{ $invoice->invoice_number }} en proforma fiscal</p>
        <br>
        {!! Form::model($invoice, ['route'=>['invoices.convertfiscal',$invoice->id], 'method'=>'POST']) !!}
	         <div class="item form-group">
			        <label for="number_invoice" class="col-form-label col-md-4 col-sm-4 label-align">Número de  Factura</label>
			        <div class="col-md-7 col-sm-7 ">
			          <input type="number" name="invoice_number" class="form-control" required="">
			        </div>
			      </div>
            <div class="item form-group">
              <label for="number_invoice" class="col-form-label col-md-4 col-sm-4 label-align">Número de Control</label>
              <div class="col-md-7 col-sm-7 ">
                <input type="text" name="control_number" class="form-control" value="{{ $invoice->control_number }}" required="">
              </div>
            </div>

			      <div class="item form-group">
			        <label for="number_invoice" class="col-form-label col-md-4 col-sm-4 label-align">Fecha</label>
			        <div class="col-md-7 col-sm-7 ">
			          <input type="date" name="date" class="form-control" required="">
			        </div>
			      </div>
            <div class="item form-group">
              <label for="number_invoice" class="col-form-label col-md-4 col-sm-4 label-align">Factor de Cambio</label>
              <div class="col-md-7 col-sm-7 ">
                <input type="number" name="factor" class="form-control" value="0" step="0.01">
              </div>
            </div>
		     </div>


      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Aceptar</button>

      </div>
      {!! Form::close() !!}

    </div>
  </div>
</div>