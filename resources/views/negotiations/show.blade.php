@extends('layouts.admin')
@section('title','Detalles de negociación')

@section('content')

<div class="clearfix"></div>
<div class="row">
	<div class="col-md-6 col-sm-6 ">
		<div class="x_panel">
			<div class="x_title">
				<h2> <i class="fa fa-th-list"></i>  Detalles</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="  profile_left">
               
          <h4> {{ $negotiation->title }}</h4>

          <ul class="list-unstyled user_data">
          	<li>
              <i class="fa fa-user user-profile-icon"></i>
              Cliente <a href="{{ route('clients.show', $negotiation->client_id) }}">{{ $negotiation->client->name }}<i class="fa fa-link"></i></a>
            </li>
            <li>
              <i class="fa fa-user user-profile-icon"></i>
              Usuario {{ $negotiation->user->name }}
            </li>
            <li>
              <i class="fa fa-th-list user-profile-icon"></i>
              Detalles:
                <ul>
                  <li>{{ $negotiation->payment_installments*$negotiation->days_interval }} días de credito con pagos cada {{ $negotiation->days_interval }} días</li>
                  <li>{{ $negotiation->details }}</li>
                </ul>
            </li>
            <li>
              <i class="fa fa-calculator user-profile-icon"></i>
              Porcentaje de pago:
              <ul>
                <li>Efectivo: {{ $negotiation->effective_percentage}}%</li>
                <li>Transferencia: {{ $negotiation->transfer_percentage}}%</li>
              </ul>
            </li>
             <li>
              <i class="fa fa-user user-profile-icon"></i>
              Monto Inicial {{ $negotiation->starting_amount }}
            </li>
            <li>
              <i class="fa fa-calendar user-profile-icon"></i>
              Estatus
              <ul>
                <li>Creado: {{ $negotiation->created_at->format('d/m/Y h:i a') }}</li>
                
                <li>Actualizado: {{ $negotiation->updated_at->format('d/m/Y  h:i a') }}</li>
                
                <li>Proformado: {{ empty($negotiation->proformed_date) ? $negotiation->proformed_date : date('d/m/Y  h:i a', strtotime($negotiation->proformed_date)) }}</li>
                
                  <selection-warehouse 
                      :data="{
                        date: '{{ empty($negotiation->selection_warehouse_date) ? $negotiation->selection_warehouse_date : date('d/m/Y  h:i a', strtotime($negotiation->selection_warehouse_date)) }}',
                        negotiation_id: '{{ $negotiation->id }}',
                        user_id: '{{ Auth::id() }}',
                      }"
                  >
                  </selection-warehouse>

                <li>Proforma depurada: {{ empty($negotiation->debug_date) ? $negotiation->debug_date :  date('d/m/Y  h:i a', strtotime($negotiation->debug_date)) }}</li>

                <li>Facturado: {{ empty($negotiation->invoice_date) ? $negotiation->invoice_date :  date('d/m/Y  h:i a', strtotime($negotiation->invoice_date)) }}</li>

                <li>IVA Pago: {{ empty($negotiation->iva_payment_date) ? $negotiation->iva_payment_date :  date('d/m/Y', strtotime($negotiation->iva_payment_date)) }}</li>

                <warehouse-packing 
                      :data="{
                        date: '{{ empty($negotiation->warehouse_packing_date) ? $negotiation->warehouse_packing_date : date('d/m/Y  h:i a', strtotime($negotiation->warehouse_packing_date)) }}',
                        negotiation_id: '{{ $negotiation->id }}',
                        user_id: '{{ Auth::id() }}',
                      }"
                  >
                  </warehouse-packing>

                  <warehouse-packed 
                      :data="{
                        date: '{{ empty($negotiation->warehouse_packed_date) ? $negotiation->warehouse_packed_date : date('d/m/Y  h:i a', strtotime($negotiation->warehouse_packed_date)) }}',
                        negotiation_id: '{{ $negotiation->id }}',
                        user_id: '{{ Auth::id() }}',
                      }"
                  >
                  </warehouse-packed>

                <li>Pedido Despachado: {{ empty($negotiation->dispatch_date) ? $negotiation->dispatch_date :  date('d/m/Y  h:i a', strtotime($negotiation->dispatch_date)) }}</li>
<!--               
                <li>Pedido Entregado: {{ empty($negotiation->deliver_date) ? $negotiation->deliver_date :  date('d/m/Y  h:i a', strtotime($negotiation->deliver_date)) }}</li>
-->
                <order-delivered 
                      :data="{
                        date: '{{ empty($negotiation->deliver_date) ? $negotiation->deliver_date : date('d/m/Y', strtotime($negotiation->deliver_date)) }}',
                        negotiation_id: '{{ $negotiation->id }}',
                        user_id: '{{ Auth::id() }}',
                      }"
                  >
                  </order-delivered>

                
                <li>Pago Completo: {{ empty($negotiation->full_payment) ? $negotiation->full_payment :  date('d/m/Y  h:i a', strtotime($negotiation->full_payment)) }}</li>
              </ul>
            </li>
          </ul>
          @can('negotiations.edit')
          <a href="{{ route('negotiations.edit', $negotiation->id) }}" class="btn btn-success"><i class="fa fa-edit m-right-xs"></i> Editar</a>
          <br />
          @endcan
        </div>



			</div>
		</div>
	</div>

  @if (!empty($negotiation_proformas[0]->proforma))
  	<div class="col-md-6 col-sm-6 ">
  		<div class="x_panel">
  			<div class="x_title">
  				<h2><i class="fa fa-bar-chart "></i>  Proformas </h2>
  				<div class="clearfix"></div>
  			</div>

  			<div class="x_content">
          <div class="table-responsive">
            <table class="table table-sm">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Id</th>
                  <th>Monto</th>
                  <th>Facto de Cambio</th>
                  <th style="width: 30px"></th>
                </tr>
              </thead>
              <tbody>
                @php 
                  $cont = 0;
                  $total_tax_base_dollar = 0;
                  $total_factor = 0;
                @endphp
                @foreach($negotiation_proformas as $negotiation_proforma)
                <tr>
                  <td>
                    {{ ++$cont }} 
                  </td>
                  <td>{{ $negotiation_proforma->proforma->id }}</td>
                  <td>$ {{ number_format($negotiation_proforma->proforma->tax_base_dollar, 2, ',', '.') }}</td>
                  <td>{{ number_format($negotiation_proforma->proforma->factor, 2, ',', '.') }} Bs.</td>
                  @php $total_tax_base_dollar += $negotiation_proforma->proforma->tax_base_dollar @endphp
                  @php $total_factor += $negotiation_proforma->proforma->factor @endphp
                  <td>
                    @can('proformas.show')
                    <a href="{{ route('proformas.show', $negotiation_proforma->proforma->id) }}" class="btn btn-primary btn-sm">
                     <i class="success fa fa-eye"></i>
                    </a>
                    @endcan
                  </td>
                </tr>
                @endforeach
                <tr>
                  <td></td>
                  <th>Total </th>
                  <th>$ {{ number_format($total_tax_base_dollar, 2, ',', '.') }}</th>
                  <th>
                    @if($cont > 0)
                    {{ number_format($total_factor/$cont, 2, ',', '.') }} Bs.
                    @else
                      0,00
                    @endif
                  </th>
                  <th></th>
                </tr>
              </tbody>
            </table>
          </div>
          <br>
  				  <canvas id="proformasGraph" style="height: 800px"></canvas>
  			</div>

  		</div>
  	</div>
  @endif

  @if (!empty($negotiation_invoices[0]->invoices))
    <div class="col-md-6 col-sm-6 ">
      <div class="x_panel">
        <div class="x_title">
          <h2><i class="fa fa-bar-chart "></i>Facturas</h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="table-responsive">
            <table class="table table-sm">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Factura</th>
                  <th>Monto</th>
                  <th>Facto de Cambio</th>
                  <th style="width: 30px"></th>
                </tr>
              </thead>
              <tbody>
                @php 
                  $cont = 0;
                  $total_tax_base_dollar = 0;
                  $total_factor = 0;
                @endphp
                @foreach($negotiation_invoices as $negotiation_invoice)
                @if($negotiation_invoice->invoices->status == 'ANULADA')
                  <tr style="text-decoration: line-through;color: red">
                    <td></td>
                    <td class="text-nowrap" style="font-kerning: ">{{ $negotiation_invoice->invoices->invoice_number }}</td>
                    <td>$ {{ number_format($negotiation_invoice->invoices->tax_base_dollar, 2, ',', '.') }}</td>
                    <td>{{ number_format($negotiation_invoice->invoices->factor, 2, ',', '.') }} Bs.</td>
                    <td>
                      <a href="{{ route('invoices.show', $negotiation_invoice->invoices->id) }}" class="btn btn-primary btn-sm">
                       <i class="success fa fa-eye"></i>
                      </a>
                    </td>
                  </tr>
                @else
                  <tr>
                    <td>{{ ++$cont }}</td>

                    <td>{{ $negotiation_invoice->invoices->invoice_number }}</td>
                    <td>$ {{ number_format($negotiation_invoice->invoices->tax_base_dollar, 2, ',', '.') }}</td>
                    <td>{{ number_format($negotiation_invoice->invoices->factor, 2, ',', '.') }} Bs.</td>
                    @php $total_tax_base_dollar += $negotiation_invoice->invoices->tax_base_dollar @endphp
                    @php $total_factor += $negotiation_invoice->invoices->factor @endphp
                    <td>
                      <a href="{{ route('invoices.show', $negotiation_invoice->invoices->id) }}" class="btn btn-primary btn-sm">
                       <i class="success fa fa-eye"></i>
                      </a>
                    </td>
                  </tr>
                @endif
                
                @endforeach
                <tr>
                  <td></td>
                  <th>Total </th>
                  <th>$ {{ number_format($total_tax_base_dollar, 2, ',', '.') }}</th>
                  <th>
                    @if($cont > 0)
                    {{ number_format($total_factor/$cont, 2, ',', '.') }} Bs.
                    @else
                      0,00
                    @endif
                  </th>
                  <th></th>
                </tr>
              </tbody>
            </table>
          </div>
          <br>
            <canvas id="invoicesGraph" style="height: 800px" ></canvas>
        </div>
      </div>
    </div>
  @endif




<div class="col-md-12 col-sm-12 ">
  <div class="x_panel">
    <div class="x_title">
      <h2><i class="fa fa-cube "></i>  Productos </h2>
      <div class="clearfix"></div>
    </div>

    <div class="x_content">
      <div class="table-responsive">
        <table class="table table-sm table-striped jambo_table small">
          <thead>
            <tr>
              <th>#</th>
              <th>Nro. Doc.</th>
              <th>Referencia</th>
              <th>Descripcion</th>
              <th>Marca</th>
              <th>Lista</th>
              <th>Cantidad</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td colspan="8" class="bg bg-info text-center"> PROFORMADOS </td>
            </tr>
            @php 
              $cont = 0;
            @endphp
            @foreach($proformas_products as $proformas_product)
            <tr>
              <td>
                {{ ++$cont }} 
              </td>
              <td>{{ $proformas_product->proforma_id }}</td>
              <td>{{ $proformas_product->reference }}</td>
              <td>{{ $proformas_product->description }}</td>
              <td>{{ $proformas_product->brand }}</td>
              <td class="text-center">{{ $proformas_product->list }}</td>
              <td class="text-center">{{ $proformas_product->quantity }}</td>
              <td class="text-right">{{ number_format($proformas_product->total_price_dollar, 2, ',', '.') }} </td>

            </tr>
            @endforeach
              <td colspan="8" class="bg bg-info text-center"> FACTURADOS </td>
            @foreach($invoices_products as $invoices_product)
            <tr>
              <td>
                {{ ++$cont }} 
              </td>
              <td>{{ $invoices_product->invoice_number }}</td>
              <td>{{ $invoices_product->reference }}</td>
              <td>{{ $invoices_product->description }}</td>
              <td>{{ $invoices_product->brand }}</td>
              <td class="text-center">{{ $invoices_product->list }}</td>
              <td class="text-center">{{ $invoices_product->quantity }}</td>
              <td class="text-right">{{ number_format($invoices_product->total_price_dollar, 2, ',', '.') }} </td>

            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <br>
    </div>

  </div>
</div>
</div>

@endsection
@section('scripts')
  
    {!! Html::script('gentelella/vendors/Chart.js/dist/Chart.min.js') !!}
    {!! Html::script('js/AppWareHouseDate.js') !!}
    {!! Html::script('js/GraphNegotiation.js') !!}
    <script type="text/javascript">
      @if(!empty($negotiation_proformas[0]->proforma))
        getProformasGraph('proformas', {{ $negotiation->id }})
      @endif

      @if(!empty($negotiation_invoices[0]->invoices))
        getProformasGraph('invoices', {{ $negotiation->id }})
      @endif
    </script>

@endsection