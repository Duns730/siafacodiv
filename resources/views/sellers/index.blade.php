@extends('layouts.admin')
@section('title','Vendedores')

@section('content')
            <div class="row" style="display: block;">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    
                    <ul class="nav navbar-right panel_toolbox">
                      @can('sellers.create')
                      <li >
                        <a href="{{route('sellers.create')}}" data-toggle="tooltip" data-placement="top" title data-original-title="Nuevo vendedor">
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
                            <th class="column-title">Nombre </th>
                            <th class="column-title">Teléfonos </th>
                            <th class="column-title">Estado </th>
                            <th class="column-title"  style="width:140px">Acciones </th>
                            </th>
                          </tr>
                        </thead>

                        <tbody class="small">
                          @foreach($sellers as $seller)
                          <tr class="even pointer">
                            <td class=" ">{{ $seller->id }}</td>
                            <td class=" ">{{ $seller->name }} </td>
                            <td class=" ">{{ $seller->phones }} </td>
                            <td class=" ">{{-- $seller->address->state->name --}} </td>
                            <td>
                              @can('sellers.show')
                                <a href="{{ route('sellers.show', $seller->id) }}" class="btn btn-primary btn-sm">
                                 <i class="success fa fa-eye"></i>
                                </a>
                              @endcan
                              @can('sellers.edit')
                                <a href="{{ route('sellers.edit', $seller->id) }}" class="btn btn-success btn-sm">
                                 <i class="success fa fa-edit"></i>
                                </a>
                              @endcan
                              @can('sellers.edit')
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target=".modal-delete{{ $seller->id }}"><i class="success fa fa-trash-o"></i></button>
                              
                                <div class="modal fade modal-delete{{ $seller->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                  {!! Form::open(['route'=>['sellers.destroy',$seller->id], 'method'=>'DELETE']) !!}
                                  <div class="modal-dialog modal-sm">
                                    <div class="modal-content">

                                      <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel2">Eliminar</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <h4>Eliminar Vendedor</h4>
                                        <p>¿Esta seguro que desea Eliminar a <b> {{ $seller->name }} {{ $seller->surname }} </b>?</p>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary">Confirmar</button>
                                      </div>
                                    </div>
                                  </div>
                                  {!! Form::close() !!}
                                @endcan
                              </div>
                             </td>
                          </tr>
                          @endforeach


                        </tbody>
                      </table>
                    </div>
                  {{ $sellers->links() }}
							       
						
                  </div>
                </div>
              </div>
            </div>

@endsection