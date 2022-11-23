


<div class="item form-group">
    {!! Form::label('title','Título', ['class'=>'col-form-label col-md-2 col-sm-2 label-align']) !!}
    <div class="col-md-5 col-sm-5 ">
        {!! Form::text('title', null, ['class'=>'form-control', 'required'=>'required']) !!} 
    </div> 
</div> 
<div class="item form-group">
    {!! Form::label('client_id','Cliente', ['class'=>'col-form-label col-md-2 col-sm-2 label-align']) !!}
    <div class="col-md-7 col-sm-7 ">
        <show-select-clients
            :client="{
                    'id' : '{{ empty($negotiation->client_id) ? '' : $negotiation->client_id }}',
                    'name' : '{{ empty($negotiation->client->name) ? 'Seleccione un cliente' : $negotiation->client->name }}',
                    }"
        ></show-select-clients>
    </div>
    <div class="col-md-2 col-sm-2">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".modalSelectClient">
            <i class="fa fa-plus-square"></i>
        </button>
    </div>
 </div>

 <div class="item form-group">
	{!! Form::label('days_interval','Días de Intervalo', ['class'=>'col-form-label col-md-2 col-sm-2 label-align']) !!}
	<div class="col-md-3 col-sm-3 ">
    	{!! Form::number('days_interval', null, ['class'=>'form-control']) !!} 
    </div> 

    {!! Form::label('payment_installments','Nro de Cuotas', ['class'=>'col-form-label col-md-2 col-sm-2 label-align']) !!}
    <div class="col-md-3 col-sm-3 ">
        {!! Form::number('payment_installments', null, ['class'=>'form-control']) !!} 
    </div>

 </div>

  <div class="item form-group">
	{!! Form::label('percentage','Porcentaje de Pago', ['class'=>'col-form-label col-md-2 col-sm-2 label-align']) !!}
    <payment-percentage
        :percentage="{
                    'effective' : '{{ empty($negotiation->effective_percentage) ? '' : $negotiation->effective_percentage }}',
                    'transfer' : '{{ empty($negotiation->transfer_percentage) ? '' : $negotiation->transfer_percentage }}',
                    }"
    ></payment-percentage> 

 </div>

 <div class="item form-group">
    {!! Form::label('details','Detalles', ['class'=>'col-form-label col-md-2 col-sm-2 label-align']) !!}
    <div class="col-md-8 col-sm-8 ">
        {!! Form::textarea('details', null, ['class'=>'form-control', 'required'=>'required', 'rows'=>'3']) !!} 
    </div> 
 </div>

                  