@extends('layouts.admin')
@section('title','Detalles de Producto')

@section('content')

<div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Producto</a>
                        @can('products.edit')
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ route('products.edit', $product->id) }}">Editar</a>
                        </div>
                        @endcan
                      </li>
                      
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Precios</a>
                        @can('products.prices.edit')
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target=".modalChangeProductPrice">Actualizar</a>
                        </div>
                        @endcan
                      </li>
                      
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>

                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div class="col-md-7 col-sm-7 ">
                      @if(isset($product->images[0]))
                      <div class="animated flipInY col-lg-12 col-md-12 col-sm-12  ">
                        <div class="tile-stats">
                            <div class="product-image" style="width: 575px;height: 448px;">
                              <img id="product-image" src="{{ $product->images[0]->url }}" alt="..." />
                            </div>
                        </div>
                      </div>
                      
                      <div class="product_gallery" style="cursor: pointer;">
                        @foreach($product->images as $image)
                        <a>
                          <img src="{{ $image->url }}" alt="..." />
                        </a>
                        @endforeach
                      </div>
                      @else
                      <div class="animated flipInY col-lg-12 col-md-12 col-sm-12  ">
                        <div class="tile-stats">
                            <div class="product-image" style="width: 575px;height: 448px;">
                              <h1><i class="fa fa-warning"></i> No existen imagenes para mostrar </h1>
                            </div>
                        </div>
                      </div>
                      @endif

                    </div>

                    <div class="col-md-5 col-sm-5 " style="border:0px solid #e5e5e5;">

                      <h3 class="prod_title">{{ $product->reference }}</h3>

                      <p>
                      {{ $product->description }}
                    </p>
                    <br />
                      <h2>Detalles</h2>
                      <div class="">
                        <ul class="list-inline prod_color ">
                          <li>
                            <p>Marca: {{ $product->brand }}</p>
                          </li>
                          <li>
                            <p>Cantidad mínima de venta: {{ $product->minimum_amount }} und</p>
                          </li>
                          <li>
                            <p>Lista {{ $product->list }}</p>
                          </li>
                        </ul>
                      </div>
                      <br />
                      <div class="">
                        <h2>Precios</h2>
                        <prices-product product_id="{{ $product->id }}"></prices-product>
                      </div>
                      <br />
<!--
                      <div class="">
                        <div class="product_price">
                          <h1 class="price">Ksh80.00</h1>
                          <span class="price-tax">Ex Tax: Ksh80.00</span>
                          <br>
                        </div>
                      </div>
-->
                    </div>
                  </div>
                </div>
              </div>
            </div>

@can('products.prices.edit')
  @include('products.partials._modalChangeProductPrice')
@endcan

@endsection
@section('scripts')
 {!! Html::script('js/PricesProduct.js') !!}


 <script type="text/javascript">
   $(document).ready(function() {
      $('a img').click(function() {
        url_image = $(this).attr('src')
        $('#product-image').attr('src', url_image)
      })
   });
 </script>
@endsection