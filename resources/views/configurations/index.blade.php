@extends('layouts.admin')
@section('title','Configuraciones')

@section('content')
            <div class="row" style="display: block;">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    
                    <ul class="nav navbar-right panel_toolbox">
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
                            <th class="column-title">Id </th>
                            <th class="column-title">Concepto </th>
                            <th class="column-title" style="width:500px">Valor </th>
                            <th class="column-title"  style="width:150px">Acciones </th>
                            </th>
                          </tr>
                        </thead>

                        <tbody class="small">
                          @foreach($configurations as $configuration)
                          <tr class="even pointer">
                            <td class=" ">{{ $configuration->id }}</td>
                            <td class=" ">{{ $configuration->concept }} </td>
                            <td class=" ">{{ $configuration->value }} </td>
                            <td class=" ">
                              <a href="#" class="btn btn-success btn-sm" 
                                class=" btn btn-primary btn-sm" 
                                data-toggle="modal" 
                                data-target=".modalShowOrEdit"
                                @click="$store.dispatch('getData', {
                                  'id': '{{ $configuration->id }}',
                                  'concept': '{{ $configuration->concept }}', 
                                  'value': '{{ $configuration->value }}', 
                                  'type': '{{ $configuration->type }}', 
                                })"
                              >
                               <i class="success fa fa-edit" ></i>
                              </a>
                              </div>
                             </td>
                          </tr>
                          @endforeach


                        </tbody>
                      </table>
                    </div>

                   <div class="col-md-4 col-sm-4 offset-3">
                    {{ $configurations->links() }}
                  </div>
                  </div>
                </div>
              </div>
            </div>
@include('configurations.partials._modalShowOrEdit')
@endsection
@section('scripts')
  {!! Html::script('js/AppConfigurationsActions.js') !!}
@endsection