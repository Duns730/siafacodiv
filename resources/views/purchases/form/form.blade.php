
<div class="item form-group">
    {!! Form::label('document_number','Nro. de Documento', ['class'=>'col-form-label col-md-2 col-sm-2 label-align']) !!}
    <div class="col-md-8 col-sm-8 ">
        {!! Form::text('document_number', null, ['class'=>'form-control', 'required'=>'required']) !!} 
    </div> 
</div> 
<div class="item form-group">
	{!! Form::label('title','Título', ['class'=>'col-form-label col-md-2 col-sm-2 label-align']) !!}
	<div class="col-md-8 col-sm-8">
    	{!! Form::text('title', null, ['class'=>'form-control', 'required'=>'required']) !!} 
    </div> 
 </div>

 <div class="item form-group">
	{!! Form::label('date','Fecha', ['class'=>'col-form-label col-md-2 col-sm-2 label-align']) !!}
	<div class="col-md-3 col-sm-3 ">
    	{!! Form::date('date', null, ['class'=>'form-control']) !!} 
    </div> 

 </div>
@if(isset($purchase->status))
<div class="item form-group">
    {!! Form::label('status','Cerrada', ['class'=>'col-form-label col-md-2 col-sm-2 label-align']) !!}
    <div class="col-md-1 col-sm-1 ">
        <label>

            <input type="checkbox" name="status" class="js-switch" {{ $purchase->status == 'OPEN' ? "checked" : ""}}  />
        </label>
    </div> 
    {!! Form::label('status','Abierta', ['class'=>'col-form-label col-md-1 col-sm-1 ']) !!}

</div>
@endif