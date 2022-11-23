<div class="item form-group">
    {!! Form::label('reference','Referencia', ['class'=>'col-form-label col-md-2 col-sm-2 label-align']) !!}
    <div class="col-md-3 col-sm-3 ">
        {!! Form::text('reference', null, ['class'=>'form-control', 'required'=>'required']) !!} 
    </div> 

    {!! Form::label('brand','Marca', ['class'=>'col-form-label col-md-2 col-sm-2 label-align']) !!}
    <div class="col-md-3 col-sm-3 ">
        {!! Form::text('brand', null, ['class'=>'form-control']) !!} 
    </div> 

</div> 
<div class="item form-group">
	{!! Form::label('description','descripción', ['class'=>'col-form-label col-md-2 col-sm-2 label-align']) !!}
	<div class="col-md-8 col-sm-8">
    	{!! Form::text('description', null, ['class'=>'form-control', 'required'=>'required']) !!} 
    </div> 
 </div>

  <div class="item form-group">
	{!! Form::label('minimum_amount','Cantidad mínima para venta', ['class'=>'col-form-label col-md-2 col-sm-2 label-align']) !!}
	<div class="col-md-3 col-sm-3 ">
    	{!! Form::number('minimum_amount', null, ['class'=>'form-control']) !!} 
    </div> 

    {!! Form::label('list','Lista', ['class'=>'col-form-label col-md-2 col-sm-2 label-align']) !!}
    <div class="col-md-3 col-sm-3 ">
        {!! Form::select('list', [1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>7] , null,  ['class'=>'form-control', 'required'=>'required']) !!} 
    </div>
 </div>
 <div class="item form-group">
    {!! Form::label('images','Imagenes', ['class'=>'col-form-label col-md-2 col-sm-2 label-align']) !!}
    <div class="col-md-8 col-sm-8">
        <input type="file" name="images[]" class='form-control'  lang="es" multiple accept='image/*'>
        <small class="form-text text-muted">
            Solo archivos de imágenes con un ancho de 575px.
        </small>
    </div> 
 </div>
<br>
@if(isset($product->images[0]))
 <div class="row">
@foreach($product->images as $image)
    <div class="col-md-3">
        <image-galery :image_props="{
                                'id' : '{{$image->id}}',
                                'url' : '{{$image->url}}',
                                }"  
        ></image-galery>
    </div>
@endforeach
</div>
@endif
