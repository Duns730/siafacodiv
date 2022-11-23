@extends('layouts.admin')
@section('title','Detalles de Compra')

@section('content')

<div class="clearfix"></div>
<div class="row">
	<div class="col-md-5 col-sm-5 ">
		<div class="x_panel">
			<div class="x_title">
				<h2> <i class="fa fa-user"></i>  Detalles</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="  profile_left">
               
          <h4> {{ $purchase->title }}</h4>

          <ul class="list-unstyled user_data">
          	<li>
              <i class="fa fa-slack user-profile-icon"></i>
              Nro. de Documento {{ $purchase->document_number }}
            </li>
            <li>
              <i class="fa fa-calendar user-profile-icon"></i>
              Fecha {{ date('d-m-Y', strtotime($purchase->date)) }}
            </li>
            <li>
              <i class="fa fa-{{ $purchase->status == 'OPEN' ? "folder-open" : "folder"}} user-profile-icon"></i>
              Estatus {{ $purchase->status == 'OPEN' ? "Abierta" : "Cerrada"}}
            </li>


          </ul>
          @can('purchases.edit')
          <a href="{{ route('purchases.edit', $purchase->id) }}" class="btn btn-success"><i class="fa fa-edit m-right-xs"></i> Editar</a>
          <br />
          @endcan

        </div>


			</div>
		</div>
	</div>



	<div class="col-md-7 col-sm-7 ">
		<div class="x_panel">
			<div class="x_title">
				<h2><i class="fa fa-briefcase "></i> Productos Cargados</h2>
        <ul class="nav navbar-right panel_toolbox">
          @if($purchase->status == 'OPEN')
          @can('purchases.load')
          <li >
            <a href="{{route('purchases.load', $purchase->id)}}" data-toggle="tooltip" data-placement="top" title data-original-title="Cargar Productos">
              <i class="fa fa-plus-square"></i>
            </a>
          </li>
          @endcan
          @can('purchases.massiveload')
          <li >
            <a href="{{route('purchases.massiveload', $purchase->id)}}" data-toggle="tooltip" data-placement="top" title data-original-title="Cargar Masiva de Productos">
              <i class="fa fa-upload"></i>
            </a>
          </li>
          @endcan
          @endif
          </ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">

				<br />
      <div class="table-responsive">
        <table class="table table-striped jambo_table">
          <thead>
            <tr class="headings">
              <th class="column-title"># </th>
              <th class="column-title" style="width: 60%"> Referencia </th>
              <th class="column-title" >Cantidad</th>
              <th class="column-title">Restante </th>
              </th>
            </tr>
          </thead>
          <tbody class="small">
            @php $index = 0; @endphp
            @foreach($purchase->purchaseProducts as $product)
            <tr class="{{ ($product->quantity - $product->quantity_proforma) < 0 ? 'bg-danger' : '' }} " >
              <td> {{ ++$index }} </td>
              <td> {{ $product->product->reference }} </td>
              <td> {{ $product->quantity }} </td>
              <td 
                > 
                {{ $product->quantity - $product->quantity_proforma }} </td>
            </tr>
            @endforeach

          </tbody>
        </table>
      </div>

			</div>
		</div>
	</div>





</div>

<div class="row">

  <div class="col-md-6 col-sm-6 "></div>
  
</div>

@endsection
@section('scripts')

@endsection