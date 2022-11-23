@extends('layouts.admin')

@section('title','Carga masiva de productos')

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

				<massive-load-products></massive-load-products>

				<div class="ln_solid"></div>
				<div class="item form-group">
					<div class="col-md-6 col-sm-6 offset-md-3">
						<button class="btn btn-danger" type="button"><a href="{{ url()->previous() }}"> Cancelar</a></button>
						<button type="submit" class="btn btn-success" formnovalidate @click="$store.dispatch('postProducts')">Guardar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
@section('scripts')
 {!! Html::script('js/AppMassiveLoad.js') !!}


 
@endsection