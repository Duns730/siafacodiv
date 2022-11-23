@extends('layouts.admin')
@section('title','Detalles de pago de IVA')

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

          <ul class="list-unstyled user_data">
            <li>
              <i class="fa fa-th-list user-profile-icon"></i>
              Referencia {{ $payment->reference }}
            </li>
            <li>
              <i class="fa fa-th-list user-profile-icon"></i>
              Concepto {{ $payment->concept }}
            </li>
            
            <li>
              <i class="fa fa-calendar user-profile-icon"></i>
              Fecha {{ date('d/m/Y  h:i a', strtotime($payment->date)) }}
            </li>
            <li>
              <i class="fa fa-user user-profile-icon"></i>
              Tipo {{ $payment->type }}
            </li>
            <li>
              <i class="fa fa-bank user-profile-icon"></i>
              Banco {{ $payment->bank->name }}
            </li>
            <li>
              <i class="fa fa-usd user-profile-icon"></i>
              Monto {{ number_format($payment->amount, 2, ',', '.') }} Bs.
            </li>
            <li>
              <i class="fa fa-usd user-profile-icon"></i>
              Positivo {{ number_format(($payment->amount + $payment->amount_paid), 2, ',', '.') }} Bs.
              @if($payment->amount + $payment->amount_paid > 0)
                <span data-toggle="modal" data-target=".modalPayment">
                  <i class="fa fa-external-link user-profile-icon" data-toggle="tooltip" data-placement="top" title data-original-title="Procesar saldo positivo"></i>
                </span>
                
              @endif
            </li>
          </ul>
        </div>



      </div>
    </div>
  </div>

  <div class="col-md-6 col-sm-6 ">
    <div class="x_panel">
      <div class="x_title">
        <h2> <i class="fa fa-th-list"></i>  Facturas pagadas</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="  profile_left">
          <table class="table">
            <thead>
              <tr>
                <th>Factura</th>
                <th class="text-right align-middle">Monto Pagado</th>
                <th></th>
              </tr>
            </thead>
            <tbody>

              @foreach($payment->paymentIva as $payment_iva)
              <tr>
                <th scope="row">{{  $payment_iva->invoice->invoice_number }}</th>
                
                <td class="text-right align-middle">
                  {{  number_format($payment_iva->amount_paid , 2, ',', '.')  }} Bs
                </td>
                <th></th>
              </tr>
              @endforeach
            </tbody>
          </table>

        </div>



      </div>
    </div>
  </div>

</div>

@include('payments.partials._modalPayment')
@include('negotiations.partials._modalSelectClient')
@include('payments.partials._modalProcessPayment')
@endsection
@section('scripts')
    {!! Html::script('js/components/LoadPayment.js') !!}
    {!! Html::script('js/components/ShowSelectClients.js') !!}
    {!! Html::script('js/components/SelectClientItem.js') !!}
    {!! Html::script('js/components/SelectClients.js') !!}
    {!! Html::script('js/AppProcessPayments.js') !!}

@endsection