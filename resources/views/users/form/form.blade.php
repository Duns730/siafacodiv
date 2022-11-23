

<div class="item form-group">
	{!! Form::label('name','Nombre', ['class'=>'col-form-label col-md-3 col-sm-3 label-align']) !!}
	<div class="col-md-5 col-sm-5">
    	{!! Form::text('name', null, ['class'=>'form-control', 'required'=>'required']) !!} 
    </div> 
 </div>

 <div class="item form-group">
    {!! Form::label('email','Email', ['class'=>'col-form-label col-md-3 col-sm-3 label-align']) !!}
    <div class="col-md-5 col-sm-5 ">
        {!! Form::text('email', null, ['class'=>'form-control']) !!} 
    </div>

 </div>

  <div class="item form-group">
	{!! Form::label('password','Contraseña', ['class'=>'col-form-label col-md-3 col-sm-3 label-align']) !!}
	<div class="col-md-5 col-sm-5 ">
    	{!! Form::text('password', '', ['class'=>'form-control']) !!} 
    </div> 
 </div>
  <div class="x_title">
    <h2>
        Asignación de Permisos
    </h2>
    <div class="clearfix"></div>
</div>
 <permission :id_user="{{ isset($user->id ) ? $user->id : ''}}"></permission>