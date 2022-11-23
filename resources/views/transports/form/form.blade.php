
<div class="item form-group">
	{!! Form::label('name','Nombre', ['class'=>'col-form-label col-md-3 col-sm-3 label-align']) !!}
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
	{!! Form::label('minimun_freight','Felete minimo', ['class'=>'col-form-label col-md-3 col-sm-3 label-align']) !!}
	<div class="col-md-6 col-sm-6 ">
    	{!! Form::number('minimun_freight', null, ['class'=>'form-control', 'required'=>'required']) !!} 
    </div> 
 </div>
 


