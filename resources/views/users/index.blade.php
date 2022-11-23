@extends('layouts.admin')
@section('title','Usuarios')

@section('content')
            <div class="row" style="display: block;">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    
                    <ul class="nav navbar-right panel_toolbox">
                      <li >
                        <a href="{{route('users.create')}}" data-toggle="tooltip" data-placement="top" title data-original-title="Nuevo Usuario">
                          <i class="fa fa-plus-square"></i> Usuario
                        </a>
                      </li>
                      <li>
                      </li>
                      
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
                            <th class="column-title" style="width:300px">Nombre </th>
                            <th class="column-title">Correo </th>
                            <th class="column-title"  style="width:140px">Acciones </th>
                            </th>
                          </tr>
                        </thead>

                        <tbody class="small">
                          @foreach($users as $user)
                          <tr class="even pointer">
                            <td class=" ">{{ $user->id }}</td>
                            <td class=" ">{{ $user->name }} </td>
                            <td class=" ">{{ $user->email }} </td>
                            <td>
                              <a href="{{ route('users.edit', $user->id) }}" class="btn btn-success btn-sm">
                               <i class="success fa fa-edit"></i>
                              </a>
                              <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target=".modal-delete{{ $user->id }}"><i class="success fa fa-trash-o"></i></button>
                              <div class="modal fade modal-delete{{ $user->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                {!! Form::open(['route'=>['users.destroy',$user->id], 'method'=>'DELETE']) !!}
                                <div class="modal-dialog modal-sm">
                                  <div class="modal-content">

                                    <div class="modal-header">
                                      <h4 class="modal-title" id="myModalLabel2">Eliminar</h4>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <h4>Eliminar Usuario</h4>
                                      <p>¿Esta seguro que desea Eliminar a <b> {{ $user->name }} </b>?</p>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                      <button type="submit" class="btn btn-primary">Confirmar</button>
                                    </div>
                                  </div>
                                </div>
                                {!! Form::close() !!}
                              </div>
                             </td>
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
            
@endsection

@section('scripts')

@endsection
