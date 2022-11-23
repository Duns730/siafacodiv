@extends('layouts.admin')
@section('title','Proforma Facturada')

@section('content')


<div class="clearfix"></div>
<div class="row">
	<div class='col-md-12 col-sm-12' >
		<div class="x_panel">
			<div class="x_title">
				<h2> <i class="fa fa-file-text"></i>  Factura Nro {{ $invoice->invoice_number }}</h2>
        <ul class="nav navbar-right panel_toolbox">
          @can('proformas.provisional.convert.fiscal')
          @if($invoice->provisional) 
          <li data-toggle="modal" data-target=".modalConvertInvoiceFiscal">
              <a href="#" data-toggle="tooltip" data-placement="top" title data-original-title="Convertir a fiscal"
              >
                <i class="fa fa-refresh"></i> Fiscal
              </a>
          </li>
          @endif
          @endcan
          @if(true) 
          <li>
              <a href="{{ route('invoices.print.provisional', $invoice->id) }}" target="_back" data-toggle="tooltip" data-placement="top" title data-original-title="Descargar factura provisional"
              >
                <i class="fa fa-download"></i> Factura
              </a>
          </li>
          @endif
          <li >
              <a href="{{ route('invoices.print', $invoice->id) }}" target="_back" data-toggle="tooltip" data-placement="top" title data-original-title="Descargar proforma">
                <i class="fa fa-download"></i> Proforma
              </a>
          </li>
          @can('proformas.invoices.annul')
          @if($invoice->status <> 'ANULADA') 
          <li data-toggle="modal" data-target=".modalAnnulInvoice">
              <a href="#" data-toggle="tooltip" data-placement="top" title data-original-title="Anular proforma"
              >
                <i class="fa fa-close"></i> Anular
              </a>
          </li>
          @endif
          @endcan
          <li>
              <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
        </ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
          @if($invoice->status == 'ANULADA') 
            <h1 style="color:red; position: fixed; top: 300px;right: 400px;font-size: 100px;">ANULADA</h1>
          @endif

      <div class="col-md-7 col-sm-7" >
          <div class="table-responsive">
              <table>
                <tbody>
                  <tr>
                    <th style="width:30%">Cliente</th>
                    <td>{{ $invoice->negotiationInvoices->negotiation->client->name }}</td>
                  </tr>
                  <tr>
                    <th>Negociación</th>
                    <td>
                      <a href="{{ route('negotiations.show', $invoice->negotiationInvoices->negotiation->id) }}">
                      {{ $invoice->negotiationInvoices->negotiation->title }}
                          <i class="fa fa-link"></i>
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <th>Fecha</th>
                    <td>{{ date('d-m-Y', strtotime($invoice->date)) }}</td>
                  </tr>
                  <tr>
                    <th>Factor de Cambio</th>
                    <td>{{ number_format($invoice->factor, 2, ',', '.') }} Bs.</td>
                  </tr>
                   <tr>
                    <th>Provisional</th>
                    <td>{{$invoice->provisional ? "SI":"NO" }}</td>
                  </tr>
                  <tr>
                    <th>Número de Control</th>
                    <td>{{ $invoice->control_number }}</td>
                  </tr>
                  <tr>
                    <th>Vendedor</th>
                    <td>{{ $invoice->seller->name }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
      </div>
      <div class="col-md-5 col-sm-5">
            <div class="table-responsive">
              <table class="table">
                <tbody>
                  <tr>
                    <th>Base Imponible:</th>
                    <td>$ {{ number_format($invoice->tax_base_dollar, 2, ',', '.')  }}</td>
                    <td>{{ number_format($invoice->tax_base_bolivar, 2, ',', '.')  }} Bs.</td>
                  </tr>
                  <tr>
                    <th>IVA (16%)</th>
                    <td>$ {{ number_format($invoice->iva_dollar, 2, ',', '.')  }}</td>
                    <td>{{ number_format($invoice->iva_bolivar, 2, ',', '.')  }} Bs.</td>
                  </tr>
                  <tr>
                    <th>Total de Operación:</th>
                    <td>$ {{ number_format($invoice->total_operation_dollar, 2, ',', '.')  }}</td>
                    <td>{{ number_format($invoice->total_operation_bolivar, 2, ',', '.')  }} Bs.</td>
                  </tr>
                </tbody>
              </table>
            </div>
      </div>

        <div class="table-responsive">
          <table class="table table-striped jambo_table small">
            <thead>
              <tr class="headings">
                <th>Referencia</th>
                <th>Descripción</th>
                <th>Marca</th>
                <th>Cantidad</th>
                <th>Prec. Unit. $</th>
                <th>Subtotal $</th>
                <th>Prec. Unit. Bs.</th>
                <th>Subtotal Bs.</th>
                </th>
              </tr>
            </thead>
            <tbody class="">
            @foreach($invoice->invoiceProducts as $product)
              <tr>
                <td>{{ $product->reference }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->brand }}</td>
                <td>{{ $product->quantity }}</td>
                <td>{{ number_format($product->unit_price_dollar, 2, ',', '.')  }}</td>
                <td>{{ number_format($product->total_price_dollar, 2, ',', '.')  }}</td>
                <td>{{ number_format($product->unit_price_bolivar, 2, ',', '.')  }}</td>
                <td>{{ number_format($product->total_price_bolivar, 2, ',', '.')  }}</td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
			</div>
		</div>
	</div>
</div>
@include('invoices.partials._modalAnnulInvoice')
@include('invoices.partials._modalConvertInvoiceFiscal')


@endsection
@section('scripts')

@endsection