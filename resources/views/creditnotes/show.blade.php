@extends('layouts.admin')
@section('title','Nota de Credito')

@section('content')


<div class="clearfix"></div>
<div class="row">
	<div class='col-md-12 col-sm-12' >
		<div class="x_panel">
			<div class="x_title">
				<h2> <i class="fa fa-file-text"></i> Nota Nro {{ $credit_note->note_number }}</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li>
              <a href="{{ route('creditnotes.print.bolivar', $credit_note->id) }}" target="_back" data-toggle="tooltip" data-placement="top" title data-original-title="Descargar Nota de Credito (Bolivares)"
              >
                <i class="fa fa-download"></i> Nota Bs
              </a>
          </li>
          <li >
              <a href="{{ route('creditnotes.print.dollar', $credit_note->id) }}" target="_back" data-toggle="tooltip" data-placement="top" title data-original-title="Descargar Nota de Credito (Dolares)">
                <i class="fa fa-download"></i> Nota $
              </a>
          </li>
          <li>
              <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
        </ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">

      <div class="col-md-7 col-sm-7" >
          <div class="table-responsive">
              <table>
                <tbody>
                  <tr>
                    <th style="width:30%">Cliente</th>
                    <td>{{ $client->client_name }}</td>
                  </tr>
                  <tr>
                    <th>Fecha</th>
                    <td>{{ date('d-m-Y', strtotime($credit_note->date)) }}</td>
                  </tr>
                  <tr>
                    <th>Facturas</th>
                    <td>{{ $credit_note->invoices }}</td>
                  </tr>
                  <tr>
                    <th>Número de Control</th>
                    <td>{{ $credit_note->control_number }}</td>
                  </tr>
                  
                  <tr>
                    <th>Vendedor</th>
                    <td>{{ $client->seller_name }}</td>
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
                    <td>$ {{ number_format($credit_note->tax_base_dollar, 2, ',', '.')  }}</td>
                    <td>{{ number_format($credit_note->tax_base_bolivar, 2, ',', '.')  }} Bs.</td>
                  </tr>
                  <tr>
                    <th>IVA (16%)</th>
                    <td>$ {{ number_format($credit_note->iva_dollar, 2, ',', '.')  }}</td>
                    <td>{{ number_format($credit_note->iva_bolivar, 2, ',', '.')  }} Bs.</td>
                  </tr>
                  <tr>
                    <th>Total de Operación:</th>
                    <td>$ {{ number_format($credit_note->total_operation_dollar, 2, ',', '.')  }}</td>
                    <td>{{ number_format($credit_note->total_operation_bolivar, 2, ',', '.')  }} Bs.</td>
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
            @foreach($credit_note->creditNoteProducts as $product)
              <tr>
                <td>{{ $product->invoiceProducts->reference }}</td>
                <td>{{ $product->invoiceProducts->description }}</td>
                <td>{{ $product->invoiceProducts->brand }}</td>
                <td>{{ $product->quantity }}</td>
                <td>{{ number_format($product->invoiceProducts->unit_price_dollar, 2, ',', '.')  }}</td>
                <td>{{ number_format($product->total_price_dollar, 2, ',', '.')  }}</td>
                <td>{{ number_format($product->invoiceProducts->unit_price_bolivar, 2, ',', '.')  }}</td>
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


@endsection
@section('scripts')

@endsection