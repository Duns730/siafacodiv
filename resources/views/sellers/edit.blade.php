@extends('layouts.admin')
@section('title','Editar Vendedor')

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
    			{!! Form::model($seller, ['route'=>['sellers.update',$seller->id],'method'=>'PUT','files' => true]) !!}

					@include('sellers.form.form')

					<div class="ln_solid"></div>
					<div class="item form-group">
						<div class="col-md-6 col-sm-6 offset-md-3">
							<button class="btn btn-danger" type="button"><a href="{{ url()->previous() }}"> Cancelar</a></button>
							<button type="submit" class="btn btn-success" formnovalidate>Guardar</button>
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
 <script type="text/javascript">
	$(document).ready(function() {
		$('#AddressActualButton').click(function() {
			$('#AddressActualButton').attr('style', 'display:none;')
			$('#address-es').attr('style', 'display:block;')
		})
	});

</script>
{!! Html::script('gentelella/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js') !!}
 {!! Html::script('js/components/State.js') !!}
 {!! Html::script('js/components/Municipality.js') !!}
 {!! Html::script('js/components/PopulationCenter.js') !!}
 {!! Html::script('js/components/location.js') !!}
 {!! Html::script('js/AppAddress.js') !!}
 
@endsection