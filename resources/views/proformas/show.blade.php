@extends('layouts.admin')
@section('title','Proforma')

@section('content')

<div class="clearfix"></div>
<div class="row">
	<div class='col-md-12 col-sm-12' >
		<div class="x_panel">
			<div class="x_title">
				<h2> <i class="fa fa-file-text"></i>  Proforma Nro {{ $proforma->id }}</h2>
        <ul class="nav navbar-right panel_toolbox">
          @can('proformas.edit')
          <li >
              <a href="{{ $proforma->provisional && isset($proforma->clientPurchaseProforma->id) ? route('proformas.edit.provisional', $proforma->id) : route('proformas.edit', $proforma->id)}}" data-toggle="tooltip" data-placement="top" title data-original-title="Editar proforma">
                <i class="fa fa-edit"></i> Editar
              </a>
          </li>
          @endcan
          @can('proformas.debug')
          <li >
              <a href="{{ $proforma->provisional && isset($proforma->clientPurchaseProforma->id) ? route('proformas.debug.provisional', $proforma->id) :route('proformas.debug', $proforma->id)}}" data-toggle="tooltip" data-placement="top" title data-original-title="Depurar proforma">
                <i class="fa fa-bug"></i> Depurar
              </a>
          </li>
          @endcan
          @can('proformas.invoicing')
          <li >
              <a href="{{ $proforma->provisional && isset($proforma->clientPurchaseProforma->id) ? route('proformas.invoicing.provisional', $proforma->id) :route('proformas.invoicing', $proforma->id)}}" data-toggle="tooltip" data-placement="top" title data-original-title="Facturar proforma">
                <i class="fa fa-file-text"></i> Facturar
              </a>
          </li>
          @endcan
          @can('proformas.print')
          <li >
              <a href="{{route('proformas.print', $proforma->id)}}" target="_bank" data-toggle="tooltip" data-placement="top" title data-original-title="Imprimir proforma">
                <i class="fa fa-print"></i> Imprimir
              </a>
          </li>
          @endcan
          @can('proformas.destroy')
          <li data-toggle="modal" data-target=".modal-delete">
              <a href="#" data-toggle="tooltip" data-placement="top" title data-original-title="Eliminar proforma">
                <i class="fa fa-trash-o"></i> Eliminar
              </a>
          </li>
          @endcan
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
                    <td>{{ $proforma->negotiationProformas->negotiation->client->name }}</td>
                  </tr>
                  <tr>
                    <th>Negociación</th>
                    <td>
                        <a href="{{ route('negotiations.show', $proforma->negotiationProformas->negotiation->id) }}">
                          {{ $proforma->negotiationProformas->negotiation->title }}
                          <i class="fa fa-link"></i>
                        </a>
                    </td>
                  </tr>
                  <tr>
                    <th>Factor de Cambio</th>
                    <td>{{ number_format($proforma->factor, 2, ',', '.') }} Bs.</td>
                  </tr>
                   <tr>
                    <th>Provisional</th>
                    <td>{{$proforma->provisional ? "SI":"NO" }}</td>
                  </tr>
                  <tr>
                    <th>Total Items</th>
                    <td>{{ $proforma->total_items }}</td>
                  </tr>
                  <tr>
                    <th>Vendedor</th>
                    <td>{{ $proforma->negotiationProformas->negotiation->client->seller->name }}</td>
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
                    <td>$ {{ number_format($proforma->tax_base_dollar, 2, ',', '.')  }}</td>
                    <td>{{ number_format($proforma->tax_base_bolivar, 2, ',', '.')  }} Bs.</td>
                  </tr>
                  <tr>
                    <th>IVA (16%)</th>
                    <td>$ {{ number_format($proforma->iva_dollar, 2, ',', '.')  }}</td>
                    <td>{{ number_format($proforma->iva_bolivar, 2, ',', '.')  }} Bs.</td>
                  </tr>
                  <tr>
                    <th>Total de Operación:</th>
                    <td>$ {{ number_format($proforma->total_operation_dollar, 2, ',', '.')  }}</td>
                    <td>{{ number_format($proforma->total_operation_bolivar, 2, ',', '.')  }} Bs.</td>
                  </tr>
                </tbody>
              </table>
            </div>
      </div>


        <div class="table-responsive">
          <table class="table table-striped jambo_table small">
            <thead>
              <tr class="headings">
                <th>#</th>
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
            @foreach($proforma->proformaProducts as $product)
              <tr>
                <td>{{ $product->position }}</td>
                <td>{{ $product->product->reference }}</td>
                <td>{{ $product->product->description }}</td>
                <td>{{ $product->product->brand }}</td>
                <td>{{ $product->quantity }}</td>
                <td>{{ number_format($product->unit_price_bolivar / $proforma->factor, 2, ',', '.')  }}</td>
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
<div class="modal fade modal-delete" tabindex="-1" role="dialog" aria-hidden="true">
  {!! Form::open(['route'=>['proformas.destroy',$proforma->id], 'method'=>'DELETE']) !!}
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel2">Eliminar</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <h4>Eliminar proforma</h4>
        <p>¿Esta seguro que desea Eliminar la proforma id <b> {{ $proforma->id }} </b>?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Confirmar</button>
      </div>
    </div>
  </div>
  {!! Form::close() !!}
</div>
@endsection
@section('scripts')
 
@endsection