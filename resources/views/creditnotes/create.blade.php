@extends('layouts.admin')
@section('title','Nueva Nota de Crédito')

@section('content')

<div class="clearfix"></div>
<div class="row">
	<div class="col-md-12 col-sm-12">
		<div class="x_panel">
			<div class="x_title">
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<br />
				<form>
					<create-credit-note></create-credit-note>
					
				</form>

					<div class="ln_solid"></div>
					<div class="item form-group">
						<div class="col-md-6 col-sm-6 offset-md-3">
							<button class="btn btn-danger" type="button"><a href="{{ url()->previous() }}"> Cancelar</a></button>
							<button type="button" class="btn btn-success" 
								@click="$store.dispatch('postCreditNote')"
							>
								Guardar
							</button>
						</div>
					</div>
					@include('negotiations.partials._modalSelectClient')
					@include('proformas.partials._modalSelectProducts')

			</div>
		</div>
	</div>
</div>

@endsection
@section('scripts')

    {!! Html::script('js/components/CreditNoteProductsTable.js') !!}
    {!! Html::script('js/components/SelectProductItem.js') !!}
    {!! Html::script('js/components/SelectProduct.js') !!}
    {!! Html::script('js/components/ShowSelectClients.js') !!}
    {!! Html::script('js/components/SelectClientItem.js') !!}
    {!! Html::script('js/components/SelectClients.js') !!}
    {!! Html::script('js/AppCreateCreditNote.js') !!}

 
@endsection

    

    
