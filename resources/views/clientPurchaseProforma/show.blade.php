@extends('layouts.admin')
@section('title','Control de Cantidades')

@section('content')

<div class="clearfix"></div>
<div class="row">
	<div class="col-md-12 col-sm-12 p">
		<div class="x_panel">
			<div class="x_title">
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<br />
					<control-quantity></control-quantity>

					<div class="ln_solid"></div>
					@include('clientPurchaseProforma.partials._modalSelectPurchase')

			</div>
		</div>
	</div>
</div>

@endsection
@section('scripts')
    {!! Html::script('js/components/ControlQuantityClient.js') !!}
    {!! Html::script('js/components/SelectPurchase.js') !!}
    {!! Html::script('js/AppControlQuantity.js') !!}
    <script type="text/javascript">
    	$('.modalSelecPurchase').modal('show')
    </script>

 
@endsection

    

    