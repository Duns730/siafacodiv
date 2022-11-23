@extends('layouts.admin')
@section('title','Cargar Productos en la Compra')

@section('content')

<div class="clearfix"></div>
<div class="row">
	<div class="col-md-12 col-sm-12 ">
		<div class="x_panel">
			<div class="x_title">
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row">
					<div class="col-md-7 col-sm-7" >
						<div class="table-responsive">
							<table>
								<tbody>
									  <tr>
									    <th style="width:30%">Título</th>
									    <td>{{ $purchase->title }}</td>
									  </tr>
									  <tr>
									    <th>Nro. de Documento</th>
									    <td>{{ $purchase->document_number }}</td>
									  </tr>
									  <tr>
									    <th>Fecha</th>
									    <td>{{ date('d-m-Y', strtotime($purchase->date)) }}</td>
									  </tr>
									  <tr>
									    <th>Estatus</th>
									    <td>{{ $purchase->status }}</td>
									  </tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-md-12 col-sm-12">
						<load-products :id_purchase="{{$purchase->id}}">
						</load-products>
					</div>
					
				</div>
					

				<div class="ln_solid"></div>
				<div class="item form-group">
					<div class="col-md-6 col-sm-6 offset-md-3">
						<button class="btn btn-danger" type="button"><a href="{{ url()->previous() }}"> Cancelar</a></button>
						<button type="button" class="btn btn-success"
							@click="$store.dispatch('postPurchase', 'save')"
						>Guardar</button>
						<button type="button" class="btn btn-success"
							@click="$store.dispatch('postPurchase', 'totalize')"
						>Totalizar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@include('proformas.partials._modalSelectProducts')
@endsection
@section('scripts')

 {!! Html::script('js/components/PurcahseProductsTable.js') !!}
 {!! Html::script('js/components/SelectProductItem.js') !!}
 {!! Html::script('js/components/SelectProduct.js') !!}
 {!! Html::script('js/AppLoadPoductsPurchase.js') !!}
 
@endsection