@extends('layouts.admin')
@section('title','Tablero')

@section('content')
<div class="clearfix"></div>
<div class="row">


  <div class="col-md-6 ">
    <div class="x_panel">
      <div class="x_title">

        <h2>Proformado Total <small>(Mes en Curso)</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <canvas id="proformedReportGraphMonth"></canvas>

      </div>
    </div>
  </div>

  <div class="col-md-6 ">
    <div class="x_panel">
      <div class="x_title">
        <h2>Facturación Fiscal <small>(Mes en Curso)</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <canvas id="invoicedReportGraphMonth"></canvas>

      </div>
    </div>
  </div>

  <div class="col-md-6 col-sm-6  ">
    <div class="x_panel">
      <div class="x_title">
         <h2>Proformado por cliente <small>(Mes en Curso)</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">

        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Id</th>
              <th>Cliente</th>
              <th>Monto $</th>
            </tr>
          </thead>
          <tbody class="small">
            @php
              $cont = 1
            @endphp
            @foreach($clients_proformed['clients_proformed'] as  $client_proformed)
            <tr>
              <th>
                {{ $cont++ }}
              </th>
              <th scope="row">{{  $client_proformed->id }}</th>
              <td>{{  $client_proformed->name }}</td>
              <td class="text-right align-middle" style="width: 100px">
                 {{  number_format($client_proformed->amout_total, 2, ',', '.')  }} 
              </td>
            </tr>
            @endforeach
            <tr  class="h6">
              <th></th>
              <th class="text-right">Total Proformado</th>
              <th class="text-right" style="width: 110px">
                 {{  number_format($clients_proformed['total_amount_proformed'], 2, ',', '.')  }} 
              </th>
            </tr>
          </tbody>
        </table>

      </div>
    </div>
  </div>

  <div class="col-md-6 col-sm-6  ">
    <div class="x_panel">
      <div class="x_title">
         <h2>Facturación por cliente <small>(Mes en Curso)</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">

        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Id</th>
              <th>Cliente</th>
              <th>Monto $</th>
            </tr>
          </thead>
          <tbody class="small">
            @php
              $cont = 1
            @endphp
            @foreach($clients_invoiced['clients_invoiced'] as  $client_invoiced)
            <tr>
              <th>
                {{ $cont++ }}
              </th>
              <th scope="row">{{  $client_invoiced->id }}</th>
              <td>{{  $client_invoiced->name }}</td>
              <td class="text-right align-middle" style="width: 100px">
                 {{  number_format($client_invoiced->amout_total, 2, ',', '.')  }} 
              </td>
            </tr>
            @endforeach
            <tr  class="h6">
              <th></th>
              <th class="text-right">Total Facturado</th>
              <th class="text-right" style="width: 110px">
                {{  number_format($clients_invoiced['total_amount_invoiced'], 2, ',', '.')  }} 
              </th>
            </tr>
          </tbody>
        </table>

      </div>
    </div>
  </div>

  <div class="col-md-6 col-sm-6  ">
    <div class="x_panel">
      <div class="x_title">
         <h2>Proformado por cliente<small><small>(Provisional)</small> (Mes en Curso)</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Id</th>
              <th>Cliente</th>
              <th>Monto $</th>
            </tr>
          </thead>
          <tbody class="small">
             @php
              $cont = 1
            @endphp
            @foreach($clients_proformed_provisional['clients_proformed'] as  $client_proformed)
            <tr>
              <th>
                {{ $cont++ }}
              </th>
              <th scope="row">{{  $client_proformed->id }}</th>
              <td>{{  $client_proformed->name }}</td>
              <td class="text-right align-middle" style="width: 100px">
                 {{  number_format($client_proformed->amout_total, 2, ',', '.')  }} 
              </td>
            </tr>
            @endforeach
            <tr  class="h6">
              <th></th>
              <th class="text-right">Total Proformado</th>
              <th class="text-right" style="width: 110px">
                 {{  number_format($clients_proformed_provisional['total_amount_proformed'], 2, ',', '.')  }} 
              </th>
            </tr>
          </tbody>
        </table>

      </div>
    </div>
  </div>

  <div class="col-md-6 col-sm-6  ">
    <div class="x_panel">
      <div class="x_title">
         <h2>Facturación por cliente <small><small>(Provisional)</small> (Mes en Curso)</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">

        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Id</th>
              <th>Cliente</th>
              <th>Monto $</th>
            </tr>
          </thead>
          <tbody class="small">
            @php
              $cont = 1
            @endphp
            @foreach($clients_invoiced_provisional['clients_invoiced'] as  $client_invoiced)
            <tr>
              <th>
                {{ $cont++ }}
              </th>
              <th scope="row">{{  $client_invoiced->id }}</th>
              <td>{{  $client_invoiced->name }}</td>
              <td class="text-right align-middle" style="width: 100px">
                 {{  number_format($client_invoiced->amout_total, 2, ',', '.')  }} 
              </td>
            </tr>
            @endforeach
            <tr class="h6">
              <th></th>
              <th class="text-right">Total Facturado</th>
              <th class="text-right" style="width: 110px">
                 {{  number_format($clients_invoiced_provisional['total_amount_invoiced'], 2, ',', '.')  }} 
              </th>
            </tr>
          </tbody>
        </table>

      </div>
    </div>
  </div>





</div>
@endsection
@section('scripts')
  
    {!! Html::script('gentelella/vendors/Chart.js/dist/Chart.min.js') !!}
    {!! Html::script('js/ReportsDashboard.js') !!}
    <script type="text/javascript">
      ReportGraphMonth('invoiced', 'line')
      ReportGraphMonth('proformed', 'line')
      ReportGraphMonth('statusProformed', 'bar')

    </script>

@endsection