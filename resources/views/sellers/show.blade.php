@extends('layouts.admin')
@section('title','Perfil del Vendedor')

@section('content')

<div class="clearfix"></div>
<div class="row">
	<div class="col-md-4 col-sm-4 ">
		<div class="x_panel">
			<div class="x_title">
				<h2> <i class="fa fa-user"></i>  Datos Personales</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="  profile_left">
               
                      <h4> {{ $seller->name }}</h4>

                      <ul class="list-unstyled user_data">
                      	<li>
                          <i class="fa fa-briefcase user-profile-icon"></i>
                          RIF {{ $seller->rif }}
                        </li>
                        <li>
                          <i class="fa fa-phone user-profile-icon"></i>
                          Teléfonos {{ $seller->phones }}
                        </li>
                        <li>
                          <i class="fa fa-at user-profile-icon"></i>
                          {{ $seller->email }}
                        </li>
                        <li>
                          <i class="fa fa-money user-profile-icon"></i>
                          Comisión {{ $seller->commission }}%
                        </li>
                        <li>
                        	<i class="fa fa-map-marker user-profile-icon"></i>
                          @if(isset($seller->address->location->name))
                        	 {{ $seller->address->location->name }}, {{ $seller->address->populationCenter->name }}, {{ $seller->address->municipality->name }}, {{ $seller->address->state->name }}
                           @endif
                        </li>
                      </ul>
                      @can('sellers.edit')
                      <a href="{{ route('sellers.edit', $seller->id) }}" class="btn btn-success"><i class="fa fa-edit m-right-xs"></i> Editar</a>
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
                      <!-- end of skills -->

                    </div>















			</div>
		</div>
	</div>


	<div class="col-md-8 col-sm-8 ">
		<div class="x_panel">
			<div class="x_title">
				<h2><i class="fa fa-bar-chart "></i>  Estadisticas</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<br />
				
			</div>
		</div>
	</div>
</div>

@endsection
@section('scripts')
 
@endsection