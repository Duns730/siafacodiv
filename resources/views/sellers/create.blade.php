@extends('layouts.admin')
@section('title','Crear Vendedor')

@section('content')

<div class="clearfix"></div>
<div class="row">
	<div class="col-md-12 col-sm-12 ">
		<div class="x_panel">
			<div class="x_title">
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<br />
				{!! Form::open(['route'=>'sellers.store', 'method'=>'POST','files' => true]) !!}

					@include('sellers.form.form')

					<div class="ln_solid"></div>
					<div class="item form-group">
						<div class="col-md-6 col-sm-6 offset-md-3">
							<button class="btn btn-danger" type="button"><a href="{{ url()->previous() }}"> Cancelar</a></button>
							<button type="submit" class="btn btn-success">Guardar</button>
						</div>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

@endsection
@section('scripts')
 {!! Html::script('gentelella/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js') !!}
 {!! Html::script('js/components/State.js') !!}
 {!! Html::script('js/components/Municipality.js') !!}
 {!! Html::script('js/components/PopulationCenter.js') !!}
 {!! Html::script('js/components/location.js') !!}
 {!! Html::script('js/AppAddress.js') !!}
@endsection

    

    
