	
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title></title>

    {!! Html::style('gentelella/vendors/bootstrap/dist/css/bootstrap.min.css') !!}

    <style type="text/css">
    	@page { 
    		size: 27cm 21cm; /*ancho x alto (horizontal) => 29.7cm 21cm*/
    		margin: 0px; 
    	}
		body { margin: 0px; }
    </style>
    

</head>
<body>
	<div class="container-fluid" style="margin:inherit;">

		<div class="">
			<div class="col-12">
				<div class="card">
			     	<img class="card-img" src="{{ config('app.url', 'Laravel') }}/images/Logo_DAC.png" alt="Card image" style="height: 100px">
			    </div>
			</div>

			<div class="col-12 small"  style="padding-bottom: : 0px;">
				<div class="table-responsive small">
				  <table class="table">
				    <tbody>
				      <tr>
				        <th style="width: 5%; padding-top: 4px; padding-bottom: 4px">
				        	RIF  
				        </th>
				        <td style="width: 10%; padding-top: 4px; padding-bottom: 4px">
				        	{{ $invoice->negotiationInvoices->negotiation->client->rif }}
				        </td>
				        <th style="width: 6%; padding-top: 4px; padding-bottom: 4px">
				        	Cliente 
				        </th>
				        <td style="padding-top: 4px; padding-bottom: 4px" colspan="3">
				        	{{ $invoice->negotiationInvoices->negotiation->client->name }}
				        </td>
					  </tr>
				      <tr>
				        <th style="padding-top: 4px; padding-bottom: 4px">
				        	Factura
				        </th>
				        <td style="padding-top: 4px; padding-bottom: 4px">
				        	{{ $invoice->invoice_number }}
				        </td>
				      
				        <th style="padding-top: 4px; padding-bottom: 4px">
				        	Fecha 
				        </th>
				        <td style="width: 10%; padding-top: 4px; padding-bottom: 4px">
				        	{{ date('d-m-Y', strtotime($invoice->date)) }}
				        </td>
				        <th style="width: 12%;padding-top: 4px; padding-bottom: 4px">
				        	Factor de cambio
				        </th>
				        <td style="padding-top: 4px;padding-bottom: 4px">
				        		{{ number_format($invoice->factor, 2, ',', '.')  }}
				        </td>
				      </tr>
				      <tr>
				         <th style="padding-top: 4px; padding-bottom: 4px">
				        	
				        </th>
				        <td style="padding-top: 4px;padding-bottom: 4px" colspan="5">
				        		
				        </td>
				      </tr>
				    </tbody>
				  </table>
				</div>
			</div>


			<div class="col-12 small">
				<div class="table-responsive small">
					<table class="table table-striped jambo_table bulk_action small" style="font-size: 9px">
					  <thead>
					    <tr>
					      <th style="width: 14%;padding-top: 4px; padding-bottom: 4px;">
					      	Referencia
					      </th>
					      <th style="width: 35%;padding-top: 4px; padding-bottom: 4px;">
					      	Descripción
					      </th>
					      <th style="width: 9%;padding-top: 4px; padding-bottom: 4px;">
					      	Marca
					      </th>
					      <th style="width: 4%;padding-top: 4px; padding-bottom: 4px;">
					      	Cantidad
					      </th>
					      <th style="width: 10%;padding-top: 4px; padding-bottom: 4px;">
					      	Prec. Unit. $
					      </th>
					      <th style="width: 8%;padding-top: 4px; padding-bottom: 4px;">
					      	Subtotal $
					      </th>
					      <th style="width: 10%;padding-top: 4px; padding-bottom: 4px;">
					      	Prec. Unit. Bs.
					      </th>
					      <th style="width: 10%;padding-top: 4px; padding-bottom: 4px;">
					      	Subtotal Bs.
					      </th>
					    </tr>
					  </thead>
					  <tbody style="font-weight: bold;">
					  	@foreach($products as $product)
					    <tr>
					      <td  style="padding-left: 4px; padding-top: 5px; padding-bottom: 5px">
					      	{{ substr($product->reference, 0, 21) }}
					      </td>
					      <td  style="padding-top: 4px; padding-bottom: 4px">
					      	{{ substr($product->description, 0, 55) }}
					      </td>
					      <td  style="padding-left: 4px; padding-top: 4px; padding-bottom: 4px">
					      	{{ substr($product->brand, 0, 10) }}
					      </td>
					      <td style="text-align: center; padding-top: 4px; padding-bottom: 4px">
					      		{{ $product->quantity }}
					      </td>
					      <td class="text-right"  style="text-align: center; padding-top: 4px; padding-bottom: 4px">
					      	{{ number_format($product->unit_price_dollar, 2, ',', '.')  }}
					      </td>
					      <td class="text-right"   style="padding-top: 4px; padding-bottom: 4px">
					      	{{ number_format($product->total_price_dollar, 2, ',', '.')  }}
					      </td>
					      <td class="text-right"   style="padding-top: 4px; padding-bottom: 4px">
					      	{{ number_format($product->unit_price_bolivar, 2, ',', '.')  }}
					      </td>
					      <td class="text-right" style="padding-top: 4px; padding-bottom: 4px">
					      	{{ number_format($product->total_price_bolivar, 2, ',', '.')  }}
					      </td>

					    </tr>
					    @endforeach
					  </tbody>
					</table>
				</div>

			<div class="col-md-5 offset-7" style="position:fixed; bottom: 2cm;"> 
				<div class="table-responsive small">
				  <table class="table text-right">
				    <tbody  style="font-weight: bold;">
				      <tr>
				        <th style="width:40%; padding-top: 4px; padding-bottom: 4px;">
				        	Base Imponible:
				        </th>
				        <td style="padding-top: 4px; padding-bottom: 4px"> 
				        	$ {{ number_format($invoice->tax_base_dollar, 2, ',', '.')  }} 
				        </td>
				        
				        <td style="padding-top: 4px; padding-bottom: 4px"> 
				        	{{ number_format($invoice->tax_base_bolivar, 2, ',', '.')  }} Bs.
				        </td>
				      </tr>
				      <tr>
				        <th style="padding-top: 4px; padding-bottom: 4px">
				        	IVA (16%)
				        </th>
				        <td style="padding-top: 4px; padding-bottom: 4px"> 
				        	$ {{ number_format($invoice->iva_dollar, 2, ',', '.')  }} 
				        </td>
				        <td style="padding-top: 4px; padding-bottom: 4px">
				        	{{ number_format($invoice->iva_bolivar, 2, ',', '.')  }} Bs.
				        </td>
				      </tr>
				      <tr>
				        <th style="padding-top: 4px; padding-bottom: 4px">
				        	Total de Operación:
				        </th>
				        <td style="padding-top: 4px; padding-bottom: 4px"> 
				        	$ {{ number_format($invoice->total_operation_dollar, 2, ',', '.') }}
				        </td>
				        <td style="padding-top: 4px; padding-bottom: 4px">
				        	{{ number_format($invoice->total_operation_bolivar, 2, ',', '.') }} Bs.
				        </td>
				      </tr>
				    </tbody>
				  </table>
				</div>
			</div>

			<div class="col-md-12" style="position:fixed; bottom: 1.7cm;">
				<p class=" well well-sm no-shadow">
					{{ config('app.name', 'Laravel') }}<br>
					Proforma de Factura Nro {{ $invoice->invoice_number }}<br> 
					J-40125958-8 Distribuidora Autana Car, C.A.

				</p>
			</div>

		</div>

	</div>
	
</body>
</html>


