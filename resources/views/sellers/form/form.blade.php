
<div class="item form-group">
	{!! Form::label('name','Nombre y Apellido', ['class'=>'col-form-label col-md-3 col-sm-3 label-align']) !!}
	<div class="col-md-6 col-sm-6 ">
    	{!! Form::text('name', null, ['class'=>'form-control', 'required'=>'required']) !!} 
    </div> 
 </div>

 <div class="item form-group">
	{!! Form::label('rif','RIF', ['class'=>'col-form-label col-md-3 col-sm-3 label-align']) !!}
	<div class="col-md-6 col-sm-6 ">
    	{!! Form::text('rif', null, ['class'=>'form-control', 'data-inputmask' => '"mask": "*-99999999-9"', 'required'=>'required']) !!} 
    </div> 
 </div>

 <div class="item form-group">
	{!! Form::label('phones','Teléfonos', ['class'=>'col-form-label col-md-3 col-sm-3 label-align']) !!}
	<div class="col-md-6 col-sm-6 ">
    	{!! Form::text('phones', null, ['class'=>'form-control']) !!} 
    </div> 
 </div>

 <div class="item form-group">
	{!! Form::label('email','Email', ['class'=>'col-form-label col-md-3 col-sm-3 label-align']) !!}
	<div class="col-md-6 col-sm-6 ">
    	{!! Form::text('email', null, ['class'=>'form-control']) !!} 
    </div> 
 </div>

  <div class="item form-group">
	{!! Form::label('commission','Comisión (%)', ['class'=>'col-form-label col-md-3 col-sm-3 label-align']) !!}
	<div class="col-md-6 col-sm-6 ">
    	{!! Form::text('commission', null, ['class'=>'form-control', 'required'=>'required']) !!} 
    </div> 
 </div>
 <div class="x_title">
    <h2>
        Dirección
    </h2>
    <div class="clearfix"></div>
</div>
<div class="row" >
    @if(isset($seller->address->state->name))
    @php $display = "none" @endphp
    <div class="col-md-12" id="AddressActualButton">
        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
        <button type="button" class="btn btn-danger pull-right"  id="AddressActualButton">
            <span class="fa fa-times"></span>
        </button>
        <b>Dirección Actual:</b><br>
            {{ $seller->address->location->name }},
            {{ $seller->address->populationcenter->name }},
            {{ $seller->address->municipality->name }},
            {{ $seller->address->state->name }}
        </p>
    </div>
    @else
        @php $display = "block" @endphp
    @endif

</div>  

<address-es id="address-es" style="display: {{ $display }}"></address-es>


