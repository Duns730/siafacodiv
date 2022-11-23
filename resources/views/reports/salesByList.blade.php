@extends('layouts.admin')
@section('title','Reporte de Ventas por Lista')

@section('content')

<div class="clearfix"></div>
<div class="row">
	<div class="col-md-12 col-sm-12">
		<div class="x_panel">
			<div class="x_title">
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<ul class="nav nav-tabs bar_tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="invoiced-tab" data-toggle="tab" href="#invoiced" role="tab" aria-controls="invoiced" aria-selected="true">Fiscal</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="invoicedProvisional-tab" data-toggle="tab" href="#invoicedProvisional" role="tab" aria-controls="invoicedProvisional" aria-selected="false">Provisional</a>
                  </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                      <div class="tab-pane fade show active" id="invoiced" role="tabpanel" aria-labelledby="invoiced-tab">
                        <report-sales-bylist
						    :date_star="{
				            	'star' : '{{ $date['star']->format('Y-m-d') }}',
				            	'end' : '{{ $date['end']->format('Y-m-d') }}',
				            }"
				            provisional="0"
						></report-sales-bylist> 
                      </div>
                      <div class="tab-pane fade" id="invoicedProvisional" role="tabpanel" aria-labelledby="invoicedProvisional-tab">
                        <report-sales-bylist
						    :date_star="{
				            	'star' : '{{ $date['star']->format('Y-m-d') }}',
				            	'end' : '{{ $date['end']->format('Y-m-d') }}',
				            }"
				            provisional="1"
						></report-sales-bylist> 
                      </div>
                    </div>
				<br /> 
				
			</div>
		</div>
	</div>
</div>

@endsection
@section('scripts')
	{!! Html::script('gentelella/vendors/Chart.js/dist/Chart.min.js') !!}
    {!! Html::script('js/GraphReportSalesByList.js') !!}
    {!! Html::script('js/AppReportSalesByList.js') !!}
    <script type="text/javascript">
      

    </script>
@endsection
