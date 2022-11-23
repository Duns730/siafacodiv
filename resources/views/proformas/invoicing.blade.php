@extends('layouts.admin')
@section('title','Facturar Proforma')

@section('content')

<div class="clearfix"></div>
<div class="row">
	<div class="col-md-12 col-sm-12 ">
		<div class="x_panel">
			<div class="x_title">
				<h2> <i class="fa fa-file-text"></i>  Proforma Nro {{ $proforma->id }}</h2>
				<div class="clearfix align-text-top"></div>
			</div>
			<div class="x_content">
				<br />
    			{!! Form::model($proforma, ['route'=>['proformas.update',$proforma->id],'method'=>'PUT','files' => true]) !!}

					@include('proformas.form.form')

					<div class="ln_solid"></div>
					<div class="item form-group">
						<div class="col-md-6 col-sm-6 offset-md-3">
							<button class="btn btn-danger" type="button"><a href="{{ url()->previous() }}"> Cancelar</a></button>
							<button type="button" class="btn btn-success" 
							data-toggle="modal" data-target=".modalInvoiceProforma"
						>
							Facturar
						</button>
						</div>
					</div>
				{!! Form::close() !!}
				@include('negotiations.partials._modalSelectClient')
				@include('proformas.partials._modalSelectProducts')
				@include('proformas.partials._modalInvoiceProforma')
			</div>
		</div>
	</div>
</div>

@endsection
@section('scripts')
    {!! Html::script('js/components/TotalizeProforma.js') !!}
    {!! Html::script('js/components/ProformaProductsTable.js') !!}
    {!! Html::script('js/components/SelectProductItem.js') !!}
    {!! Html::script('js/components/SelectProduct.js') !!}
    {!! Html::script('js/components/ShowSelectClients.js') !!}
    {!! Html::script('js/components/SelectClientItem.js') !!}
    {!! Html::script('js/components/SelectClients.js') !!}
    {!! Html::script('js/AppCreateProforma.js') !!}
@endsection