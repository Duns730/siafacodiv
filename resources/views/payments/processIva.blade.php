@extends('layouts.admin')
@section('title','Procesar pago de IVA')
@section('styles')

@endsection

@section('content')

<div class="clearfix"></div>
<div class="row">
	<div class="col-md-12 col-sm-12">
		@php  $payment_classification = 'iva'; @endphp
		@include('payments.form.form')
		
	</div>
</div>
@include('negotiations.partials._modalSelectClient')
@include('payments.partials._modalProcessPayment')

@endsection
@section('scripts')
	{!! Html::script('js/components/LoadPaymentIva.js') !!}
	{!! Html::script('js/components/ShowSelectClients.js') !!}
    {!! Html::script('js/components/SelectClientItem.js') !!}
    {!! Html::script('js/components/SelectClients.js') !!}
	{!! Html::script('js/AppProcessPaymentsIva.js') !!}
@endsection

    

    
