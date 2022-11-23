
<div class="item form-group">
    {!! Form::label('rif','RIF', ['class'=>'col-form-label col-md-2 col-sm-2 label-align']) !!}
    <div class="col-md-3 col-sm-3 ">
        {!! Form::text('rif', null, ['class'=>'form-control', 'data-inputmask' => '"mask": "*-99999999-9"', 'required'=>'required']) !!} 
    </div> 
</div> 
<div class="item form-group">
	{!! Form::label('name','Nombre', ['class'=>'col-form-label col-md-2 col-sm-2 label-align']) !!}
	<div class="col-md-8 col-sm-8">
    	{!! Form::text('name', null, ['class'=>'form-control', 'required'=>'required']) !!} 
    </div> 
 </div>

 <div class="item form-group">
	{!! Form::label('phones','Teléfonos', ['class'=>'col-form-label col-md-2 col-sm-2 label-align']) !!}
	<div class="col-md-3 col-sm-3 ">
    	{!! Form::text('phones', null, ['class'=>'form-control']) !!} 
    </div> 

    {!! Form::label('email','Email', ['class'=>'col-form-label col-md-2 col-sm-2 label-align']) !!}
    <div class="col-md-3 col-sm-3 ">
        {!! Form::text('email', null, ['class'=>'form-control']) !!} 
    </div>

 </div>

  <div class="item form-group">
	{!! Form::label('withholding_tax','Retención (%)', ['class'=>'col-form-label col-md-2 col-sm-2 label-align']) !!}
	<div class="col-md-3 col-sm-3 ">
    	{!! Form::text('withholding_tax', null, ['class'=>'form-control']) !!} 
    </div> 

    {!! Form::label('seller_id','Vendedor', ['class'=>'col-form-label col-md-2 col-sm-2 label-align']) !!}
    <div class="col-md-3 col-sm-3 ">
        {!! Form::select('seller_id', $sellers, null,  ['class'=>'form-control', 'required'=>'required']) !!} 
    </div>
 </div>

 <div class="item form-group">
    {!! Form::label('fiscal_address','Dirección Fiscal', ['class'=>'col-form-label col-md-2 col-sm-2 label-align']) !!}
    <div class="col-md-8 col-sm-8 ">
        {!! Form::textarea('fiscal_address', null, ['class'=>'form-control', 'required'=>'required', 'rows'=>'3']) !!} 
    </div> 

 </div>


 <div class="x_title">
    <h2>
        Dirección de despacho
    </h2>
    <div class="clearfix"></div>
</div>
<div class="row" >
    @if(isset($client->address->state->name))
    @php $display = "none" @endphp
    <div class="col-md-12" id="AddressActualButton">
        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
        <button type="button" class="btn btn-danger pull-right"  id="AddressActualButton">
            <span class="fa fa-times"></span>
        </button>
        <b>Dirección Actual:</b><br>
            {{ $client->address->location->name }},
            {{ $client->address->populationcenter->name }},
            {{ $client->address->municipality->name }},
            {{ $client->address->state->name }}
        </p>
    </div>
    @else
        @php $display = "block" @endphp
    @endif

</div>  

<address-es id="address-es" style="display: {{ $display }}"></address-es>