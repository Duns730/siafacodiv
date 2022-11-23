@extends('layouts.admin')
@section('title','Notas de Crédito')

@section('content')
            <div class="row" style="display: block;">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    
                    <ul class="nav navbar-right panel_toolbox">
                      @can('creditnotes.create')
                      <li >
                        <a href="{{route('creditnotes.create')}}" data-toggle="tooltip" data-placement="top" title data-original-title="Nueva nota">
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
                            <th class="column-title">Fecha </th>
                            <th class="column-title">Número de Nota </th>
                            <th class="column-title">Facuras </th>
                            <th class="column-title">Monto $ </th>
                            <th class="column-title"  style="width:150px">Acciones </th>
                            </th>
                          </tr>
                        </thead>

                        <tbody class="small">
                          @foreach($creditnotes as $creditnote)
                          <tr class="even pointer">
                            <td class=" ">{{ $creditnote->id }} </td>
                            <td class=" ">{{ $creditnote->date }} </td>
                            <td class=" ">{{ $creditnote->note_number }} </td>
                            <td class=" ">{{ $creditnote->invoices }} </td>
                            <td class=" ">{{ $creditnote->total_operation_dollar }} </td>
                            <td>
                              @can('creditnotes.show')
                              <a href="{{ route('creditnotes.show', $creditnote->id) }}" class="btn btn-primary btn-sm">
                               <i class="fa fa-eye"></i>
                              </a>
                              @endcan
                             </td>
                          </tr>
                          @endforeach

                        </tbody>
                      </table>
                    </div>
  							     
                      <div class="col-md-4 col-sm-4 offset-3">
                        {{ $creditnotes->links() }}
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