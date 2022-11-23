@extends('layouts.admin')
@section('title','Bancos')

@section('content')
            <div class="row" style="display: block;">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    
                    <ul class="nav navbar-right panel_toolbox">
                      @can('banks.create')
                      <li >
                        <a href="{{route('banks.create')}}" data-toggle="tooltip" data-placement="top" title data-original-title="Nuevo vendedor">
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
                            <th class="column-title">Moneda </th>
                            <th class="column-title">Estatus </th>
                            <th class="column-title"  style="width:150px">Acciones </th>
                            </th>
                          </tr>
                        </thead>

                        <tbody class="small">
                          @foreach($banks as $bank)
                          <tr class="even pointer">
                            <td class=" ">{{ $bank->id }}</td>
                            <td class=" ">{{ $bank->name }} </td>
                            <td class=" ">{{ $bank->currency}} </td>
                            <td class=" ">
                              <span class="btn btn-sm btn-info"> 
                                  <i class="fa {{ $bank->status ? "fa-check-square-o" : "fa-square"}}"></i>
                              </span> 
                            <td>
                              @can('banks.show')
<!--
                              <a href="{{ route('banks.show', $bank->id) }}" class="btn btn-primary btn-sm">
                               <i class="success fa fa-eye"></i>
                              </a>
-->
                              @endcan
                              @can('banks.edit')
                              <a href="{{ route('banks.edit', $bank->id) }}" class="btn btn-success btn-sm">
                               <i class="success fa fa-edit"></i>
                              </a>
                              @endcan
                              @can('banks.destroy')
                              <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target=".modal-delete{{ $bank->id }}"><i class="success fa fa-trash-o"></i></button>
                              <div class="modal fade modal-delete{{ $bank->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                {!! Form::open(['route'=>['banks.destroy',$bank->id], 'method'=>'DELETE']) !!}
                                <div class="modal-dialog modal-sm">
                                  <div class="modal-content">

                                    <div class="modal-header">
                                      <h4 class="modal-title" id="myModalLabel2">Eliminar</h4>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <h4>Eliminar Banco</h4>
                                      <p>¿Esta seguro que desea Eliminar a <b> {{ $bank->name }} </b>?</p>
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

                      <div class="col-md-4 col-sm-4 offset-3">
                        {{ $banks->links() }}
                      </div>

                  </div>
                </div>
              </div>
            </div>
@endsection
@section('scripts')

@endsection