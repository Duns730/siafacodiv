
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title>(FACT {{$invoice->invoice_number}}) {{$invoice->client->name}} (Provisional)</title>

    {!! Html::style('gentelella/vendors/bootstrap/dist/css/bootstrap.min.css') !!}

    <style type="text/css">
    	@page { 
    		size: 21cm 29cm; /*ancho x alto (horizontal) => 29.7cm 21cm*/
    		margin: 0px; 
    	}
		body { 
			margin: 0px; 
			color: #000;
			font-size: 12px;
			font-family: "Times New Roman";
		}
		.table{
			color: #000;
		}
		.arial{
			font-family: "Arial";
		}
    </style>
    

</head>
<body>
	<div class="container-fluid" style="margin:inherit;">

		<div class="" >
			<div class="col-12 mt-3" style="">
				<div class="card">
			     	<img class="card-img" src="{{ config('app.url', 'Laravel') }}/images/Logo_DAC.png" alt="Card image" style="height: 100px; width: 730px; margin-top: 25px">
			    </div>
			</div>
			<div class="col-12" style="margin-top: -5px">
				<p class="text-center small font-weight-bold" style="font-family: Calibri;">
					Urb. Los Tamarindos, Sector 01, calle 06 al final, N° 20 vereda 57, San Fernando de Apure Edo Apure
					<br/>Telefax: (0247) 342.71.43 / 0424-312.78.64 / 0426-945.88.90
					<br/>E-mail:distribuidoraautanacar@gmail.com
				</p>
					
				<hr style="border-top:1px solid #000;">
				<span class="font-weight-bold" style="position:fixed;left: 630px; top: 180px; font-family: calibri">FORMA LIBRE</span>
			</div>
			


			<div class="col-8" style="margin-top: -18px">
				<div class="table-responsive">
				  <table style="font-size: 11px">
				    <tbody>
				      <tr>
				      	<td style="width: 50px; ">Cliente:</td>
				      	<td  style="width: 80px; ">
				      		@php
				      			echo str_pad(strval($invoice->client->id), 12, "0", STR_PAD_LEFT )
				      		@endphp
				      		
				      	</td>
				      	<td style="">
				      		{{ $invoice->client->name }}
				      	</td>
				      </tr>
				      <tr>
				      	<td>RIF:</td>
				      	<td>
				      		{{ $invoice->client->rif }}
				      	</td>
				      </tr>
				      <tr class="align-text-top">
				      	<td>Dirección:</td>
				      	<td colspan="2" style="height: 29px;">
				      		{{ $invoice->client->fiscal_address }}
				      	</td>
				      </tr>
				      <tr>
				      	<td>Teléfonos:</td>
				      	<td colspan="2">
				      		{{ $invoice->client->phones }}
				      	</td>
				      </tr>
				      <tr>
				      	<td>Vendedor:</td>
				      	<td colspan="2">
				      		000{{ $invoice->seller->id }}-{{ $invoice->seller->name }}
				      	</td>
				      </tr>
				    </tbody>
				  </table>
				</div>
			</div>

			<div class="col-3 float-right" style="position:fixed; top: 218px;">
				<div class="table-responsive">
				  <table class="">
				    <tbody>
				    	<tr>
				    		<td></td>
				    	</tr>
				    	<tr>
				    		<td><span style="font-size: 15px; font-weight: bold;">FACTURA No.:</span></td>
				    		<td>
				    			<span style="font-size: 15px; font-weight: bold;">
				    				000{{ $invoice->invoice_number }}
				    			</span>
				    		</td>
				    	</tr>
				    	<tr>
				    		<td>Fecha de Emisión:</td>
				    		<td>
				    			{{ date('d/m/Y', strtotime($invoice->date)) }}
				    		</td>
				    	</tr>
				    	<tr>
				    		<td>Fecha de Vencimiento:</td>
				    		<td>
				    			{{ date('d/m/Y', strtotime($invoice->date)) }}
				    		</td>
				    	</tr>
				    	<tr>
				    		<td>Condiciones de Pago:</td>
				    		<td>Prepagado</td>
				    	</tr>
				    </tbody>
				  </table>
				</div>
			</div>

			<div class="col-12">
				<div class="table-responsive">
				  <table style="width: 100%">
				    <thead  style="font-size: 10px">
				    	<tr>
				    		<th style="width:15%; border-top: 1px solid #000;border-bottom: 1px solid #000;">CODIGO</th>
				    		<th style="width:45%; border-top: 1px solid #000;border-bottom: 1px solid #000;">DESCRIPCIÓN</th>
				    		<th style="width:10%; border-top: 1px solid #000;border-bottom: 1px solid #000;">MARCA</th>
				    		<th style="width:5%; border-top: 1px solid #000;border-bottom: 1px solid #000;">CANTIDAD</th>
				    		<th style="border-top: 1px solid #000;border-bottom: 1px solid #000;" class="text-center">P. UNITARIO</th>
				    		<th style="border-top: 1px solid #000;border-bottom: 1px solid #000;" class="text-center">TOTAL</th>
				    	</tr>
				    </thead>
				    <tbody style="font-size: 10px">
				    	@foreach($products as $product)
				    	<tr>
				    		<td class="" style="padding-top: 3px; padding-bottom: 3px">
						      	{{ substr($product->reference, 0, 18) }}
						    </td>
						    <td  class="" style="padding-top: 3px; padding-bottom: 3px">
						      	{{ substr($product->description, 0, 50) }}
						    </td>
						    <td  class="" style="padding-top: 3px; padding-bottom: 3px">
						      	{{ substr($product->brand, 0, 10) }}
						    </td>
						    <td class="text-right " style="padding-top: 3px; padding-bottom: 3px">
						      	{{ $product->quantity }}
						    </td>
							<td class="text-right " style="padding-top: 3px; padding-bottom: 3px">
						      	{{ number_format($product->unit_price_bolivar, 2, ',', '.')  }}
						    </td>
						    <td class="text-right " style="padding-top: 3px; padding-bottom: 3px">
						      	{{ number_format($product->total_price_bolivar, 2, ',', '.')  }}
						    </td>
				    	</tr>
				    	@endforeach
				    	
				    </tbody>
				  </table>
				</div>
			</div>
			<div class="col-12" style="border:1px solid #000; position: fixed;bottom: 255px;left: 25px;">
				<div class="table-responsive">
				  <table>
				    <tbody>
				    	<tr>
				    		<td style="width:10px;"><span class="font-weight-bold">Nota:</span></td>
				    		<td>
				    			 Favor Efectuar Transferecia a nombre de:
				    		</td>
				    	</tr>
				    	<tr>
				    		<td></td>
				    		<td><span class="font-weight-bold">DISTRIBUIDORA AUTANA CAR, C.A</span></td>
				    	</tr>
				    	<tr>
				    		<td></td>
				    		<td>Depósitos en Banco Venezuela Cta Cte. No. 0102-0466-64-0000322733</td>
				    	</tr>
				    	<tr>
				    		<td></td>
				    		<td>Depósitos en Banco Provincial Cta Cte. No. 0108-0169-91-0100157810</td>
				    	</tr>
				    </tbody>
				  </table>
				</div>
			</div>

			  <table style="position: fixed;bottom: 255px;left: 590px;">
			    <tbody class="font-weight-bold text-right" style="font-size: 11px;">
			    	<tr>
			    		<td class="py-1">Base Imponible:</td>
			    		<td class="py-1">
			    			 {{ number_format($invoice->tax_base_bolivar, 2, ',', '.')  }}
			    		</td>
			    	</tr>
			    	<tr>
			    		<td class="py-1">I.V.A. 16,00%</td>
			    		<td class="py-1">
			    			 {{ number_format($invoice->iva_bolivar, 2, ',', '.')  }}
			    		</td>
			    	</tr>
			    	<tr>
			    		<td class="py-1">Total Operación:</td>
			    		<td class="py-1">
			    			 {{ number_format($invoice->total_operation_bolivar, 2, ',', '.')  }}
			    		</td>
			    	</tr>

			    </tbody>
			  </table>
<!---->
			<div class="col-12">
				<span class="font-weight-bold" style="font-size: 12px;position: fixed;bottom: 120px;left: 25px;">
					Son: {{ $invoice->amount_in_letters }}
				</span>
			</div>
			
			<span class="font-weight-bold" style="position: fixed;bottom: 73px; left: 50px; font-size: 8px;">
				CONTRIBUYENTE ORDINARIO
			</span>
			<span class="" style="position: fixed;bottom: 73px; left: 280px; font-size: 7px;">
				ORIGINAL BLANCO: Cliente - COPIA : Sin Derecho a Crédito Fiscal
			</span>
			<span class="arial" style="position: fixed;bottom: 82px; left: 490px; font-size: 15px;">
				No. DE CONTROL: 00-
			</span>
			<span class=" font-weight-bold" style="position: fixed;bottom: 82px; left: 645px; font-size: 14px;">
				{{ $invoice->control_number }}
			</span>

			<div class="col-md-12" style="position:fixed; bottom: 65px;">
				<p class="text-center small" style="font-family: Calibri;">
					<span class="font-weight-bold" style="font-size: 8px; font-family: Impact">
						<b>
							L&B IMPRESIONES,C.A. / Telf.:(0247) 8085746 Calle Aramendi, No. 38/San Fdo, Edo Apure/RIF: J-29546932-2 / AUT. No. Provid: /02/00504 del 05/03/2008 'Región LOS LLANOS<br>
						</b>
						
					</span>
					<span class="font-weight-bold" style="font-size: 15px">
						{{ $configurations['assigned_control_numbers'] }}
						<br>Copia no dá derecho a Crédito Fiscal
					</span>
				</p>
			</div>

		</div>

	</div>
	
</body>
</html>


