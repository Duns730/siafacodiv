@extends('layouts.admin')
@section('title','Editar Usuario')
@section('style')
	{!! Html::style('gentelella/vendors/iCheck/skins/flat/green.css') !!}

 @endsection
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
    			{!! Form::model($user, ['route'=>['users.update',$user->id],'method'=>'PUT','files' => true]) !!}

					@include('users.form.form')

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

 {!! Html::script('js/components/PermissionsItem.js') !!}
 {!! Html::script('js/components/PermissionsItemList.js') !!}
 {!! Html::script('js/Permission.js') !!}

 
@endsection