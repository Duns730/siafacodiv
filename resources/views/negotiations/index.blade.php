@extends('layouts.admin')
@section('title','Negociaciones')
@section('style')
    {!! Html::style('gentelella/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') !!}
@endsection
@section('content')
<div class="row" style="display: block;">
        <div class="col-md-12 col-sm-12  ">
          <div class="x_panel">
            <div class="x_title">
              
              <ul class="nav navbar-right panel_toolbox">
                @can('negotiations.create')
                <li >
                  <a href="{{route('negotiations.create')}}" data-toggle="tooltip" data-placement="top" title data-original-title="Nueva negociación">
                    <i class="fa fa-plus-square"></i> Nueva
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
                      <th class="column-title" style="width: 20px">Creado </th>
                      <th class="column-title" style="width: 200px">Título </th>
                      <th class="column-title" style="width: 200px">Cliente </th>
                      <th class="column-title">Status </th>
                      
                      <th class="column-title"  style="width:150px">Acciones </th>
                    </tr>
                  </thead>

                  <tbody class="small">
                    @foreach($negotiations as $negotiation)
                    <tr class="even pointer">
                      <td class=" ">{{ $negotiation->created_at->format('d/m/Y') }}</td>
                      <td class=" ">{{ $negotiation->title }} </td>
                      <td class=" ">{{ $negotiation->client->name }} </td>
                      <td class=" ">
                        <negotiations-status
                          :dates="{'1' : '{{ $negotiation->created_at->format('d/m/Y  h:i a') }}',
                                    '2' : '{{ empty($negotiation->proformed_date) ? '' : date('d/m/Y  h:i a', strtotime($negotiation->proformed_date)) }}',
                                    '3' : '{{ empty($negotiation->selection_warehouse_date) ? '' :  date('d/m/Y  h:i a', strtotime($negotiation->selection_warehouse_date)) }}',
                                    '4' : '{{ empty($negotiation->debug_date) ? '' :  date('d/m/Y  h:i a', strtotime($negotiation->debug_date)) }}',
                                    '5' : '{{ empty($negotiation->invoice_date) ? '' :  date('d/m/Y  h:i a', strtotime($negotiation->invoice_date)) }}',
                                    '6' : '{{ empty($negotiation->iva_payment_date) ? '' :  date('d/m/Y', strtotime($negotiation->iva_payment_date)) }}',
                                    '7' : '{{ empty($negotiation->warehouse_packing_date) ? '' :  date('d/m/Y  h:i a', strtotime($negotiation->warehouse_packing_date)) }}',
                                    '8' : '{{ empty($negotiation->warehouse_packed_date) ? '' :  date('d/m/Y  h:i a', strtotime($negotiation->warehouse_packed_date)) }}',
                                    '9' : '{{ empty($negotiation->dispatch_date) ? '' :  date('d/m/Y  h:i a', strtotime($negotiation->dispatch_date)) }}',
                                    '10' : '{{ empty($negotiation->deliver_date) ? '' :  date('d/m/Y  h:i a', strtotime($negotiation->deliver_date)) }}',
                                     '11' : '{{ empty($negotiation->full_payment) ? '' :  date('d/m/Y  h:i a', strtotime($negotiation->full_payment)) }}'}"
                        ></negotiations-status>
                      </td>
                      <td>
                        @can('negotiations.show')
                        <a href="{{ route('negotiations.show', $negotiation->id) }}" class="btn btn-primary btn-sm">
                         <i class="success fa fa-eye"></i>
                        </a>
                        @endcan
                        @can('negotiations.edit')
                        <a href="{{ route('negotiations.edit', $negotiation->id) }}" class="btn btn-success btn-sm">
                         <i class="success fa fa-edit"></i>
                        </a>
                        @endcan
                        @can('negotiations.destroy')
                        @if(empty($negotiation->invoice_date))
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target=".modal-delete{{ $negotiation->id }}"><i class="success fa fa-trash-o"></i></button>
                        <div class="modal fade modal-delete{{ $negotiation->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                          {!! Form::open(['route'=>['negotiations.destroy',$negotiation->id], 'method'=>'DELETE']) !!}
                          <div class="modal-dialog modal-sm">
                            <div class="modal-content">

                              <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel2">Eliminar</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <h4>Eliminar negotiatione</h4>
                                <p>¿Esta seguro que desea Eliminar a <b> {{ $negotiation->title }} </b>?</p>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Confirmar</button>
                              </div>
                            </div>
                          </div>
                          {!! Form::close() !!}
                        </div>
                        @endif
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
      <div class="col-md-4 col-sm-4 offset-3">
        {{ $negotiations->links() }}
      </div>
</div>
@include('negotiations.partials._modalSearchNegotiations')

@endsection

@section('scripts')
    {!! Html::script('gentelella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') !!}
    {!! Html::script('js/NegotiationsStatus.js') !!}
@endsection
