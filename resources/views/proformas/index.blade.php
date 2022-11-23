@extends('layouts.admin')
@section('title','Proformas')
@section('style')

@endsection
@section('content')
        <div class="row" style="display: block;">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    
                    <ul class="nav navbar-right panel_toolbox">
                      @can('proformas.create')
                      <li >
                        <a href="{{route('proformas.create')}}" data-toggle="tooltip" data-placement="top" title data-original-title="Nueva proforma">
                          <i class="fa fa-plus-square"></i> Nueva
                        </a>
                      </li>
                      @endcan
                      @can('proformas.create.provisional')
                      <li >
                        <a href="{{route('proformas.create.provisional')}}" data-toggle="tooltip" data-placement="top" title data-original-title="Nueva proforma provisional (Compras)">
                          <i class="fa fa-plus-square"></i> Provisional
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
                            <th class="column-title">Id </th>
                            <th class="column-title" style="width: 400px"> Cliente </th>
                            <th class="column-title" >Base Imponible $ </th>
                            <th class="column-title">Factor de Cambio </th>
                            <th class="column-title" style="width:100px;">Cant. Items </th>
                            <th class="column-title" style="width:50px">Provisional </th>
                            <th class="column-title" style="width:50px">Acciones </th>
                            </th>
                          </tr>
                        </thead>

                        <tbody class="small">
                          @php $amount_proformed_provicional = 0; $amount_proformed = 0; $iva_proformed = 0; @endphp
                          @foreach($proformas as $proforma)
                              @if($proforma->provisional)
                                @php
                                  $amount_proformed_provicional += $proforma->tax_base_dollar;
                                @endphp
                              @else
                                @php
                                  $amount_proformed += $proforma->tax_base_dollar;
                                    $iva_proformed += $proforma->iva_bolivar;
                                @endphp
                              @endif
                          <tr class="even pointer">
                            <td class=" ">{{ $proforma->id }}</td>
                          <td class=" ">{{ $proforma->negotiationProformas->negotiation->client->name }} </td>  
                            <td class=" ">$ {{ number_format($proforma->tax_base_dollar, 2, ',', '.')  }} </td>
                            <td class=" ">{{  number_format($proforma->factor, 2, ',', '.') }} Bs. </td>
                            <td class="text-center">{{ $proforma->total_items }} </td>
                            <td class=" "> 
                              <span class="btn btn-sm btn-info"> 
                                  <i class="fa {{ $proforma->provisional ? "fa-check-square-o" : "fa-square"}}"></i>
                              </span> 
                            </td>
                            <td>
                              @can('proformas.show')
                              <a href="{{ route('proformas.show', $proforma->id) }}" class="btn btn-primary btn-sm">
                               <i class="success fa fa-eye"></i>
                              </a>
                              @endcan
                              
                             </td>
                          </tr>
                          @endforeach


                        </tbody>
                      </table>
                    </div>
                    <div class="col-md-5 col-sm-5 offset-7">
                        <div class="table-responsive">
                          <table class="table table-sm table-dark">
                            <tbody  style="text-align: right;">
                              <tr>
                                <th style="width:55%;">Total Proformado (Provisional):</th>
                                <td>$ {{ number_format($amount_proformed_provicional, 2, ',', '.')  }}</td>
                              </tr>
                              <tr>
                                <th>Total Proformado:</th>
                                <td>$ {{ number_format($amount_proformed, 2, ',', '.')  }}</td>
                              </tr>
                              <tr>
                                <th>IVA Proformado:</th>
                                <td>{{ number_format($iva_proformed, 2, ',', '.')  }} Bs.</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 offset-3">
                      {{ $proformas->links() }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
@endsection

@section('scripts')
        
@endsection
