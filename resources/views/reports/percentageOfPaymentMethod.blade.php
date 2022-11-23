@extends('layouts.admin')
@section('title','Reporte de Porcentaje de Forma de pago')

@section('content')

<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="x_panel">
      <div class="x_title">
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <ul class="nav nav-tabs bar_tabs" id="myTab" role="tablist"></ul>

            <report-percentage-payment-method
                :date_star="{
                      'star' : '{{ $date['star']->format('Y-m-d') }}',
                      'end' : '{{ $date['end']->format('Y-m-d') }}',
                    }"
            ></report-percentage-payment-method> 

        <br /> 
      </div>
    </div>
  </div>
</div>

@endsection
@section('scripts')

    {!! Html::script('js/AppReportPercentageOfPaymentMethod.js') !!}

@endsection
