@extends('layouts.admin')
@section('title','Pagos')

@section('content')
  <div class="row" style="display: block;">
    <div class="col-md-12 col-sm-12  ">
      <div class="x_panel">
        <div class="x_title">
          <h2>Pagos de IVA</h2>
          <ul class="nav navbar-right panel_toolbox">
            @can('payments.process')
            <li >
              <a href="{{route('payments.process.iva')}}" data-toggle="tooltip" data-placement="top" title data-original-title="Procesar IVA">
                <i class="fa fa-plus-square"></i> Pagos
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
          <div class="table-responsive">
            <table class="table table-striped jambo_table">
              <thead>
                <tr class="headings">
                  <th class="column-title">id </th>
                  <th class="column-title">Fecha </th>
                  <th class="column-title">Concepto </th>
                  <th class="column-title">Banco </th>
                  <th class="column-title text-right">Monto</th>
                  <th class="column-title" >Acción </th>
                  </th>
                </tr>
              </thead>
              <tbody class="small">
                @foreach($payments_iva as $payment)
                <tr class="headings">
                  <td>{{ $payment->id }}  </td>
                  <td>{{ date('d-m-Y', strtotime($payment->date)) }}  </td>
                  <td>{{ $payment->concept }}  </td>
                  <td>
                    {{ $payment->bank->name }}  
                  </td>
                  <td style="text-align: right;">
                      {{ number_format($payment->amount, 2, ',', '.') }}
                     @if($payment->amount - $payment->amount_paid > 0)
                      <span class="badge badge-success" data-toggle="tooltip" data-placement="top" title data-original-title="Saldo positivo">
                        <i class="fa fa-plus"></i>
                      </span>
                    @endif
                  </td>
                  <td >
                    @can('payments.show.iva')
                      <a href="{{ route('payments.show.iva', $payment->id) }}" class="btn btn-primary btn-sm">
                       <i class="success fa fa-eye"></i>
                      </a>
                    @endcan
                  </td>
                  </th>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
  	     <div class="col-md-4 col-sm-4 offset-3">
           {{ $payments_iva->links() }} 
        </div>
        </div>
      </div>
    </div>

    <div class="col-md-12 col-sm-12  ">
      <div class="x_panel">
        <div class="x_title">
          <h2>Pagos de factura</h2>
          <ul class="nav navbar-right panel_toolbox">
            @can('payments.process')
            <li >
              <a href="{{route('payments.process.taxbase')}}" data-toggle="tooltip" data-placement="top" title data-original-title="Procesar pagos">
                <i class="fa fa-plus-square"></i> Pagos
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
          <div class="table-responsive">
            <table class="table table-striped jambo_table">
              <thead>
                <tr class="headings">
                  <th class="column-title">id </th>
                  <th class="column-title">Fecha </th>
                  <th class="column-title">Concepto </th>
                  <th class="column-title">Banco </th>
                  <th class="column-title text-md-right">Monto</th>
                  <th class="column-title" >Acción </th>
                  </th>
                </tr>
              </thead>
              <tbody class="small">
                @foreach($payments_tax_base as $payment)
                <tr class="headings">
                  <td>{{ $payment->id }}  </td>
                  <td>{{ date('d-m-Y', strtotime($payment->date)) }}  </td>
                  <td>{{ $payment->concept }}  </td>
                  <td>{{ $payment->bank->name }}  </td>
                  <td style="text-align: right;">
                    {{ number_format($payment->amount, 2, ',', '.') }}
                    @if($payment->amount - $payment->amount_paid > 0)
                      <span class="badge badge-success" data-toggle="tooltip" data-placement="top" title data-original-title="Saldo positivo">
                        <i class="fa fa-plus"></i>
                      </span>
                    @endif
                  </td>
                  <td>
                    @can('payments.show.taxbase')
                      <a href="{{ route('payments.show.taxbase', $payment->id) }}" class="btn btn-primary btn-sm">
                       <i class="success fa fa-eye"></i>
                      </a>
                    @endcan
                  </td>
                  </th>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
         <div class="col-md-4 col-sm-4 offset-3">
           {{ $payments_tax_base->links() }} 
        </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')

@endsection