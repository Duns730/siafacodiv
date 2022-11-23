@extends('layouts.admin')
@section('title','Cuentas por Cobrar')

@section('content')
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="x_panel">
      <div class="x_title">
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <ul class="nav nav-tabs bar_tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="invoiced-tab" data-toggle="tab" href="#invoiced" role="tab" aria-controls="invoiced" aria-selected="true">Fiscal</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="invoicedProvisional-tab" data-toggle="tab" href="#invoicedProvisional" role="tab" aria-controls="invoicedProvisional" aria-selected="false">Provisional</a>
                  </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="invoiced" role="tabpanel" aria-labelledby="invoiced-tab">

                      <div class="x_content">
                      </div>
                      <div class="table-responsive">
                        <table class="table table-striped jambo_table">
                          <thead>
                            <tr class="headings">
                              <th class="column-title">Id </th>
                              <th class="column-title" style="width:500px">Cliente </th>
                              <th class="column-title text-right">Monto Pendiente </th>
                              <th class="column-title"> </th>

                            </tr>
                          </thead>

                          <tbody>
                            @php
                              $total_accountsReceivable = 0; 
                            @endphp
                            @foreach($clients_fiscal as $client)
                            <tr class="even pointer">
                              <td class=" ">{{ str_pad($client->id, 4, '0', STR_PAD_LEFT)  }}</td>
                              <td class=" ">{{ $client->name }} </td>
                              <td class="text-right">
                                  {{ number_format($client->accountsReceivable, 2, ',', '.')   }} Bs.
                              </td>
                              <td class=" "></td>
                              @php $total_accountsReceivable += $client->accountsReceivable; @endphp
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
                                    <td> {{ number_format($total_accountsReceivable, 2, ',', '.')  }} Bs.</td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                      </div>
                     <div class="col-md-4 col-sm-4 offset-3">
                     </div>



                      </div>
                      <div class="tab-pane fade" id="invoicedProvisional" role="tabpanel" aria-labelledby="invoicedProvisional-tab">
                        <div class="x_content">
                          </div>
                          <div class="table-responsive">
                            <table class="table table-striped jambo_table">
                              <thead>
                                <tr class="headings">
                                  <th class="column-title">Id </th>
                                  <th class="column-title" style="width:500px">Cliente </th>
                                  <th class="column-title text-right">Monto Pendiente </th>
                                  <th class="column-title"> </th>

                                </tr>
                              </thead>

                              <tbody>
                                @php
                                  $total_accountsReceivable = 0; 
                                @endphp
                                @foreach($clients_provisional as $client)
                                <tr class="even pointer">
                                  <td class=" ">{{ str_pad($client->id, 4, '0', STR_PAD_LEFT)  }}</td>
                                  <td class=" ">{{ $client->name }} </td>
                                  <td class="text-right">
                                      {{ number_format($client->accountsReceivable, 2, ',', '.')   }} Bs.
                                  </td>
                                  <td class=" "></td>
                                  @php $total_accountsReceivable += $client->accountsReceivable; @endphp
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
                                        <td> {{ number_format($total_accountsReceivable, 2, ',', '.')  }} Bs.</td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                          </div>
                         <div class="col-md-4 col-sm-4 offset-3">
                         </div>
                      </div>
                    </div>
               <br /> 
        
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
@endsection