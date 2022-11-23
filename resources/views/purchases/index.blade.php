@extends('layouts.admin')
@section('title','Compras')

@section('content')
  <div class="row" style="display: block;">
    <div class="col-md-12 col-sm-12  ">
      <div class="x_panel">
        <div class="x_title">
          
          <ul class="nav navbar-right panel_toolbox">
            @can('purchases.create')
            <li >
              <a href="{{route('purchases.create')}}" data-toggle="tooltip" data-placement="top" title data-original-title="Nueva compra">
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
                  <th class="column-title">id </th>
                  <th class="column-title" style="width:350px">Titulo </th>
                  <th class="column-title">Nro. Documento </th>
                  <th class="column-title">Fecha </th>
                  <th class="column-title"  style="width:150px">Acciones </th>
                  </th>
                </tr>
              </thead>

              <tbody class="small">
                @foreach($purchases as $purchase)
                <tr class="even pointer">
                  <td class=" ">{{ $purchase->id }}</td>
                  <td class=" ">{{ $purchase->title }} </td>
                  <td class=" ">{{ $purchase->document_number }}  </td>
                  <td class=" ">{{ date('d-m-Y', strtotime($purchase->date)) }}</td>
                  <td>
                    @can('purchases.show')
                    <a href="{{ route('purchases.show', $purchase->id) }}" class="btn btn-primary btn-sm">
                     <i class="success fa fa-eye"></i>
                    </a>
                    @endcan
                    @can('purchases.edit')
                    <a href="{{ route('purchases.edit', $purchase->id) }}" class="btn btn-success btn-sm">
                     <i class="success fa fa-edit"></i>
                    </a>
                    @endcan
                    @can('purchases.destroy')
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target=".modal-delete{{ $purchase->id }}"><i class="success fa fa-trash-o"></i></button>
                    <div class="modal fade modal-delete{{ $purchase->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                      {!! Form::open(['route'=>['purchases.destroy',$purchase->id], 'method'=>'DELETE']) !!}
                      <div class="modal-dialog modal-sm">
                        <div class="modal-content">

                          <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel2">Eliminar</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <h4>Eliminar Compra</h4>
                            <p>¿Esta seguro que desea Eliminar a <b> {{ $purchase->title }} </b>?</p>
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
              {{ $purchases->links() }}
            </div>
	        
        </div>
      </div>
    </div>
  </div>

@endsection
@section('scripts')

@endsection