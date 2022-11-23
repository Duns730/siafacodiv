@extends('layouts.admin')
@section('title','IVAs por cobrar')

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
                            <th class="column-title" style="width:500px">Cliente </th>
                            <th class="column-title text-right">Monto Pendiente </th>
                            <th class="column-title"> </th>

                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          @php
                            $total_pending_iva = 0; 
                          @endphp
                          @foreach($clients as $client)
                          <tr class="even pointer">
                            <td class=" ">{{ str_pad($client->id, 4, '0', STR_PAD_LEFT)  }}</td>
                            <td class=" ">{{ $client->name }} </td>
                            <td class="text-right">
                                {{ number_format($client->pendingIva, 2, ',', '.')   }} Bs.
                            </td>
                            <td class=" "></td>
                            @php $total_pending_iva += $client->pendingIva; @endphp
                          @endforeach


                        </tbody>
                      </table>
                    </div>
                    <div class="col-md-3 col-sm-3 offset-9">
                          <div class="table-responsive">
                            <table class="table table-sm table-dark">
                              <tbody>
                                <tr>
                                  <th>Total:</th>
                                  <td> {{ number_format($total_pending_iva, 2, ',', '.')  }} Bs.</td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                    </div>
							     <div class="col-md-4 col-sm-4 offset-3">
                    {{-- $products->links() --}}
                  </div>
                  </div>
                </div>
              </div>
            </div>
@endsection
@section('scripts')
@endsection