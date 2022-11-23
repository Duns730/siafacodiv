@extends('layouts.admin')
@section('title','Perfil del Cliente')

@section('content')

<div class="clearfix"></div>
  <div class="row">
  	<div class="col-md-6 col-sm-12 ">
  		<div class="x_panel">
  			<div class="x_title">
  				<h2> <i class="fa fa-user"></i>  Datos Personales</h2>
  				<div class="clearfix"></div>
  			</div>
  			<div class="x_content">
  				<div class="  profile_left">
                 
            <h4> {{ $client->name }}</h4>

            <ul class="list-unstyled user_data">
            	<li>
                <i class="fa fa-briefcase user-profile-icon"></i>
                RIF {{ $client->rif }}
              </li>
              <li>
                <i class="fa fa-phone user-profile-icon"></i>
                Teléfonos {{ $client->phones }}
              </li>
              <li>
                <i class="fa fa-at user-profile-icon"></i>
                {{ $client->email }}
              </li>
              <li>
                <i class="fa fa-calculator user-profile-icon"></i>
                Retención {{   $client->withholding_tax < 1 ? "0" : $client->withholding_tax }}%
              </li>
              <li>
                <i class="fa fa-map-marker user-profile-icon"></i>
                Dirección Fiscal:<br>
                 {{ $client->fiscal_address }}
              </li>
              <li>
              	<i class="fa fa-truck user-profile-icon"></i>
                Dirección de Entrega:<br>
              	 {{ $client->address->location->name }}, {{ $client->address->populationCenter->name }}, {{ $client->address->municipality->name }}, {{ $client->address->state->name }}
              </li>

              <li>
                <i class="fa fa-bullhorn user-profile-icon"></i>
                Vendedor {{ $client->seller->name }}
              </li>
              <li>
                <i class="fa fa-calendar user-profile-icon"></i>
                Creado {{ $client->created_at->format('d/m/Y') }}  /  Actualizado {{ $client->updated_at->format('d/m/Y h:i a') }}
              </li>
            </ul>
            @can('clients.edit')
            <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-success"><i class="fa fa-edit m-right-xs"></i> Editar</a>
            <br />
            @endcan

            <!-- start skills 
            <h4>Skills</h4>
            <ul class="list-unstyled user_data">
              <li>
                <p>Web Applications</p>
                <div class="progress progress_sm">
                  <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50"></div>
                </div>
              </li>
              <li>
                <p>Website Design</p>
                <div class="progress progress_sm">
                  <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="70"></div>
                </div>
              </li>
              <li>
                <p>Automation & Testing</p>
                <div class="progress progress_sm">
                  <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="30"></div>
                </div>
              </li>
              <li>
                <p>UI / UX</p>
                <div class="progress progress_sm">
                  <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50"></div>
                </div>
              </li>
            </ul>
             end of skills -->

          </div>


  			</div>
  		</div>
  	</div>



    

    
  	<div class="col-md-6 col-sm-12 ">
  		<div class="x_panel">
  			<div class="x_title">
  				<h2><i class="fa fa-briefcase "></i> Negociaciones</h2>
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
          @foreach($negotiations as $negotiation)
          <a href="{{ route('negotiations.show', $negotiation->id) }}">
    				<div class="animated flipInY col-lg-10 col-md-10 col-sm-10  ">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-usd"></i>
                </div>
                <div class="count">{{ number_format($negotiation->total_proformed, 2, ',', '.')  }} </div>

                <h4 class="mx-2">{{ $negotiation->title }}</h4>
                <p>{{ $negotiation->payment_installments * $negotiation->days_interval }} días de credito con pagos cada {{ $negotiation->days_interval }} días</p>
                <h5 class="small mx-2 my-0">
                  @if(!empty($negotiation->invoice_date))
                      Facturado
                  @elseif(!empty($negotiation->proformed_date))
                      Proformado
                  @endif
                </h5>
              </div>
            </div>
          </a>
          @endforeach

  			</div>
  		</div>
  	</div>


    <div class="col-md-6 col-sm-12  ">
      <div class="x_panel">
        <div class="x_title">
          <h2>Grafica de Pedidos</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <canvas id="orderGraph"></canvas>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-sm-12  ">
      <div class="x_panel">
        <div class="x_title">
          <h2>Pago Realizados</h2>
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
                          @foreach($payments as $payment)
                          <tr class="even pointer">
                            <td class=" ">{{ $payment->concept }}</td>
                            <td class=" ">{{ number_format($payment->amount, 2, ',', '.') }} </td>
                            <td class=" ">{{ number_format($payment->amount - $payment->amount_paid - $payment->collection_commission, 2, ',', '.') }} </td>
                            <td class=" ">{{number_format($payment->collection_commission, 2, ',', '.') }} </td>
                            <td class=" ">
                              @can('payments.show.taxbase')
                              <a href="{{route('payments.show.taxbase', $payment->id)}}" class="btn btn-primary btn-sm">
                                <i class="fa fa-eye"></i>
                              </a >
                              @endcan
                            </td>
                          </tr>
                          @endforeach


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
@include('clients.partials._modalSearchClients')

@endsection
@section('scripts')
  
    {!! Html::script('gentelella/vendors/Chart.js/dist/Chart.min.js') !!}
    {!! Html::script('js/GraphClients.js') !!}
    <script type="text/javascript">
      getOrderGraph('order', {{ $client->id }})
    </script>
    {!! Html::script('js/AppSearchClients.js') !!}
@endsection