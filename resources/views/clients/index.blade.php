@extends('layouts.admin')
@section('title','Clientes')

@section('content')
            <div class="row" style="display: block;">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    
                    <ul class="nav navbar-right panel_toolbox">
                      @can('clients.create')
                      <li >
                        <a href="{{route('clients.create')}}" data-toggle="tooltip" data-placement="top" title data-original-title="Nuevo Cliente">
                          <i class="fa fa-plus-square"></i> Nuevo
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
                            <th class="column-title" style="width:400px">Nombre </th>
                            <th class="column-title">Teléfonos </th>
                            <th class="column-title">Vendedor </th>
                            <th class="column-title">Estado </th>
                            <th class="column-title"  style="width:150px">Acciones </th>
                            </th>
                          </tr>
                        </thead>

                        <tbody class="small">
                          @foreach($clients as $client)
                          <tr class="even pointer">
                            <td class=" ">{{ str_pad($client->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td class=" ">{{ $client->name }} </td>
                            <td class=" ">{{ $client->phones }} </td>
                            <td class=" ">{{ $client->seller->name }} </td>
                            <td class=" ">{{ $client->address->state->name }} </td>
                            <td>
                              @can('clients.show')
                              <a href="{{ route('clients.show', $client->id) }}" class="btn btn-primary btn-sm">
                               <i class="fa fa-eye"></i>
                              </a>
                              @endcan
                              @can('clients.edit')
                              <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-success btn-sm">
                               <i class="fa fa-edit"></i>
                              </a>
                              @endcan
                              @can('clients.destroy')
                              <a class="btn btn-danger btn-sm" data-toggle="modal" data-target=".modal-delete{{ $client->id }}"><i class="fa fa-trash-o text-white"></i></a>
                              <div class="modal fade modal-delete{{ $client->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                {!! Form::open(['route'=>['clients.destroy',$client->id], 'method'=>'DELETE']) !!}
                                <div class="modal-dialog modal-sm">
                                  <div class="modal-content">

                                    <div class="modal-header">
                                      <h4 class="modal-title" id="myModalLabel2">Eliminar</h4>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <h4>Eliminar Cliente</h4>
                                      <p>¿Esta seguro que desea Eliminar a <b> {{ $client->name }} </b>?</p>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                      <button type="submit" class="btn btn-primary">Confirmar</button>
                                    </div>
                                  </div>
                                </div>
                                {!! Form::close() !!}
                              </div>
                              @endcan
                             </td>
                          </tr>
                          @endforeach


                        </tbody>
                      </table>
                    </div>
  							     <div class="col-md-3 col-sm-3 offset-9">
                          <div class="table-responsive">
                            <table class="table table-sm table-dark">
                              <tbody>
                                <tr>
                                  <th>Total de Clientes:</th>
                                  <td> {{ $total_clients->count  }}</td>
                                </tr>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                      </div>
                      <div class="col-md-4 col-sm-4 offset-3">
                        {{ $clients->links() }}
                      </div>
						        
                  </div>
                </div>
              </div>
            </div>
@include('clients.partials._modalSearchClients')
@endsection
@section('scripts')
 {!! Html::script('js/AppSearchClients.js') !!}
@endsection