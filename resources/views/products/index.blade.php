@extends('layouts.admin')
@section('title','productos')

@section('content')
            <div class="row" style="display: block;">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    
                    <ul class="nav navbar-right panel_toolbox">
                      @can('products.create')
                      <li >
                        <a href="{{route('products.create')}}" data-toggle="tooltip" data-placement="top" title data-original-title="Nuevo producto">
                          <i class="fa fa-plus-square"></i> Nuevo
                        </a>
                      </li>
                      @endcan
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-upload"></i> Modo Masivo</a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @can('products.massiveload')
                            <a href="{{route('products.massiveload')}}" class="dropdown-item">Crear</a>
                        @endcan
                        @can('products.massiveupdate')
                            <a href="{{route('products.massiveupdate')}}" class="dropdown-item" >Actualización</a>
                        </div>
                        @endcan
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
                            <th class="column-title">Referencia </th>
                            <th class="column-title" style="width:500px">Descripción </th>
                            <th class="column-title">Marca </th>
                            <th class="column-title"  style="width:150px">Acciones </th>
                            </th>
                          </tr>
                        </thead>

                        <tbody class="small">
                          @foreach($products as $product)
                          <tr class="even pointer">
                            <td class=" ">{{ $product->id }}</td>
                            <td class=" ">{{ $product->reference }} </td>
                            <td class=" ">{{ $product->description }} </td>
                            <td class=" ">{{ $product->brand }} </td>
                            <td>
                              @can('products.show')
                              <a href="{{ route('products.show', $product->id) }}" class=" btn btn-primary btn-sm">
                               <i class="success fa fa-eye "></i>
                              </a>
                              @endcan
                              @can(['products.edit'])
                              <a href="{{ route('products.edit', $product->id) }}" class="btn btn-success btn-sm">
                               <i class="success fa fa-edit"></i>
                              </a>
                              @endcan
                              @can('products.destroy')
                              <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target=".modal-delete{{ $product->id }}"><i class="success fa fa-trash-o"></i></button>
                              <div class="modal fade modal-delete{{ $product->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                {!! Form::open(['route'=>['products.destroy',$product->id], 'method'=>'DELETE']) !!}
                                <div class="modal-dialog modal-sm">
                                  <div class="modal-content">

                                    <div class="modal-header">
                                      <h4 class="modal-title" id="myModalLabel2">Eliminar</h4>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <h4>Eliminar producte</h4>
                                      <p>¿Esta seguro que desea Eliminar: <b> {{ $product->description }} </b>?</p>
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
                    <div class="col-md-3 col-sm-3 offset-9">
                          <div class="table-responsive">
                            <table class="table table-sm table-dark">
                              <tbody>
                                <tr>
                                  <th>Total de Productos:</th>
                                  <td> {{ $total_products->count  }}</td>
                                </tr>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                      </div>
							     <div class="col-md-4 col-sm-4 offset-3">
                    {{ $products->links() }}
                  </div>
                  </div>
                </div>
              </div>
            </div>
@include('products.partials._modalSearchProducts')
@endsection
@section('scripts')
 {!! Html::script('js/AppSearchProducts.js') !!}
@endsection