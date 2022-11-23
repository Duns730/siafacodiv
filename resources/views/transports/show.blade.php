@extends('layouts.admin')
@section('title','Perfil del Transporte')

@section('content')

<div class="clearfix"></div>
  <div class="row">
    <div class="col-md-6 col-sm-12 ">
      <div class="x_panel">
        <div class="x_title">
          <h2> <i class="fa fa-user"></i>  Datos de Empresa</h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="  profile_left">
                 
            <h4> {{ $transport->name }}</h4>

            <ul class="list-unstyled user_data">
              <li>
                <i class="fa fa-briefcase user-profile-icon"></i>
                RIF {{ $transport->rif }}
              </li>
              <li>
                <i class="fa fa-phone user-profile-icon"></i>
                Flete minimo ${{ $transport->minimun_freight }}
              </li>

            </ul>
            @can('clients.edit')
            <a href="{{ route('transports.edit', $transport->id) }}" class="btn btn-success"><i class="fa fa-edit m-right-xs"></i> Editar</a>
            <br />
            @endcan
          </div>


        </div>
      </div>
    </div>


   
    <div class="col-md-6 col-sm-12 ">
      <div class="x_panel">
        <div class="x_title">
          <h2><i class="fa fa-briefcase "></i> Guias</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <br />

        </div>
      </div>
    </div>


    <div class="col-md-6 col-sm-12  ">
      <div class="x_panel">
        <div class="x_title">
          <h2>Conductores</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li  data-toggle="modal" data-target=".modalCreateDriver">
              <a class=""  data-toggle="tooltip" data-placement="top" title data-original-title="Nuevo Conductor">
                <i class="fa fa-plus-square"></i>
              </a>
            </li>
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

          <app-transport-drivers :id_transport="{{ $transport->id }}"></app-transport-drivers>

        </div>
      </div>
    </div>

    <div class="col-md-6 col-sm-12  ">
      <div class="x_panel">
        <div class="x_title">
          <h2>Camiones</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="table-responsive">
            <table class="table table-striped jambo_table">
              <thead>
                <tr class="headings">
                  <th class="column-title">Concepto </th>
                  <th class="column-title" style="">Monto </th>
                  <th class="column-title">Positivo </th>
                  <th class="column-title"  style="">Comisión </th>
                  <th class="column-title"  style="">Ver </th>
                  </th>
                </tr>
              </thead>

              <tbody>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

<div class="row">

  <div class="col-md-6 col-sm-12 "></div>
  
</div>
@include('transports.partials._modalCreateDriver')

@endsection
@section('scripts')
  {!! Html::script('gentelella/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js') !!}
  {!! Html::script('js/AppTransportDrivers.js') !!}
@endsection