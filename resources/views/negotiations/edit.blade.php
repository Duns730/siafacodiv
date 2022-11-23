@extends('layouts.admin')
@section('title','Editar Negociación')

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
    			{!! Form::model($negotiation, ['route'=>['negotiations.update',$negotiation->id],'method'=>'PUT','files' => true]) !!}

					@include('negotiations.form.form')

					<div class="ln_solid"></div>
					<div class="item form-group">
						<div class="col-md-6 col-sm-6 offset-md-3">
							<button class="btn btn-danger" type="button"><a href="{{ url()->previous() }}"> Cancelar</a></button>
							<button type="submit" class="btn btn-success" formnovalidate>Guardar</button>
						</div>
					</div>
				{!! Form::close() !!}
				@include('negotiations.partials._modalSelectClient')
			</div>
		</div>
	</div>
</div>

@endsection
@section('scripts')
    {!! Html::script('js/components/PaymentPercentage.js') !!}
    {!! Html::script('js/components/ShowSelectClients.js') !!}
    {!! Html::script('js/components/SelectClientItem.js') !!}
    {!! Html::script('js/components/SelectClients.js') !!}
    {!! Html::script('js/AppSelectClients.js') !!}

 
@endsection