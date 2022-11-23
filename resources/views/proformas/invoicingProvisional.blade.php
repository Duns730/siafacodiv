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
    			<create-proforma-provisional
					:proforma="{
			            'id' : '{{ empty($proforma->id) ? '' : $proforma->id }}',
			            'client_id' : '{{ empty($proforma->negotiationProformas->negotiation->client_id) ? '' : $proforma->negotiationProformas->negotiation->client_id }}',
			            'client_name' : '{{ empty($proforma->negotiationProformas->negotiation->client->name) ? '' : $proforma->negotiationProformas->negotiation->client->name }}',
			            'seller_id' : '{{ empty($proforma->negotiationProformas->negotiation->client->seller->id) ? '' : $proforma->negotiationProformas->negotiation->client->seller->id }}',
			            'negotiation_id' : '{{ empty($proforma->negotiationProformas->negotiation->id) ? '' : $proforma->negotiationProformas->negotiation->id }}',
			            'negotiation_proforma_id' : '{{ empty($proforma->negotiationProformas->id) ? '' : $proforma->negotiationProformas->id }}',
			        	'purchase_proforma_id' : '{{ empty($proforma->clientPurchaseProforma->purchase_id) ? '' : $proforma->clientPurchaseProforma->purchase_id }}',
			            'factor' : '{{ empty($proforma->factor) ? 0 : $proforma->factor }}',
			            'price_select' : '{{ empty($proforma->type_price) ? 0 : $proforma->type_price }}',
			            'total_items' : '{{ empty($proforma->total_items) ? 0 : $proforma->total_items }}',
			            'type_price' : '{{ empty($proforma->type_price) ? '' : $proforma->type_price }}',
			            }"
				></create-proforma-provisional>
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
				@include('negotiations.partials._modalSelectClient')
				@include('proformas.partials._modalSelectProducts')
				@include('proformas.partials._modalInvoiceProforma')
				@include('clientPurchaseProforma.partials._modalSelectPurchase')
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
    {!! Html::script('js/components/SelectPurchase.js') !!}
    {!! Html::script('js/AppCreateProformaProvisional.js') !!}
    <script type="text/javascript">
    	$('.modalSelecPurchase').modal('show')
    </script>
@endsection