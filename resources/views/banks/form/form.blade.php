
<div class="item form-group">
    {!! Form::label('name','Nombre', ['class'=>'col-form-label col-md-2 col-sm-2 label-align']) !!}
    <div class="col-md-5 col-sm-5 ">
        {!! Form::text('name', null, ['class'=>'form-control', 'data-inputmask' => '"mask": "*-99999999-9"', 'required'=>'required']) !!} 
    </div> 
</div> 
<div class="item form-group">
    {!! Form::label('currency','Moneda', ['class'=>'col-form-label col-md-2 col-sm-2 label-align']) !!}
    <div class="col-md-3 col-sm-3 ">
        {!! Form::select('currency', ['bolivar' =>'bolivar', 'dollar' => 'dollar'], null,  ['class'=>'form-control', 'required'=>'required']) !!} 
    </div>
</div>

@if(isset($bank->status))
<div class="item form-group">
    {!! Form::label('status','Estatus', ['class'=>'col-form-label col-md-2 col-sm-2 label-align']) !!}
    <div class="col-md-3 col-sm-3 ">
    	<input type="checkbox" name="status" 
    		{{ $bank->status ? "checked" : ""}}
    	>
    </div>
</div>
@endif
