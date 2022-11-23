
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title>Nota de Crédito {{$credit_note->note_number}} {{$client->name}} </title>

    {!! Html::style('gentelella/vendors/bootstrap/dist/css/bootstrap.min.css') !!}

    <style type="text/css">
    	@font-face{
	      font-family: 'Arial';
	      src: url('public/storage/font/arial.ttf');
	    }
    	@page { 
    		size: 21cm 14.5cm; /*ancho x alto (horizontal) => 29.7cm 21cm*/
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
    </style>
    

</head>
<body>
	<div class="container-fluid" style="margin:inherit;">

		<div class="" >
			<div class="col-12 mt-3" style="">
				<div class="card">
			     	<img class="card-img" src="{{ config('app.url', 'Laravel') }}/images/Logo_DAC.png" alt="Card image" style="height: 100px; width: 730px; margin-top: 15px">
			    </div>
			</div>


			<div class="col-12" style="margin-top: -5px">
				<p class="text-center small font-weight-bold" style="font-family: Calibri;">
					Urb. Los Tamarindos, Sector 01, calle 06 al final, N° 20 vereda 57, San Fernando de Apure Edo Apure
					<br/>Telefax: (0247) 342.71.43 / 0424-312.78.64 / 0426-945.88.90
					<br/>E-mail:distribuidoraautanacar@gmail.com
				</p>
					
				<span class="font-weight-bold" style="position:fixed;left: 630px; top: 155px; font-family: calibri">FORMA LIBRE</span>
			</div>


			<div class="col-8" style="margin-top: -5px; ">
				<div class="table-responsive">
				  <table style="font-size: 11px; ">
				    <tbody>
				      <tr>
				      	<td style="width: 50px;padding-bottom: 0px; padding-top: 0px;" class="">Cliente:</td>
				      	<td  style="width: 80px; padding-bottom: 0px; padding-top: 0px">
				      		@php
				      			echo str_pad(strval($client->id), 12, "0", STR_PAD_LEFT )
				      		@endphp
				      	</td>
				      	<td style="padding-bottom: 0px; padding-top: 0px;">
				      		{{ $client->name }}
				      	</td>
				      </tr>
				      <tr>
				      	<td style="padding-bottom: 0px; padding-top: 0px;">RIF:</td>
				      	<td style="padding-bottom: 0px; padding-top: 0px;">
				      		{{ $client->rif }}
				      	</td>
				      </tr>
				      <tr class="align-text-top" >
				      	<td style="padding-bottom: 0px; padding-top: 0px;">Dirección:</td>
				      	<td colspan="2" style="height: 29px; padding-bottom: 0px; padding-top: 0px;">
				      		{{ $client->fiscal_address }}
				      	</td>
				      </tr>
				      <tr>
				      	<td style="padding-bottom: 0px; padding-top: 0px;">Teléfonos:</td>
				      	<td colspan="2"style="padding-bottom: 0px; padding-top: 0px;">
				      		{{ $client->phones }}
				      	</td>
				      </tr>
				      <tr>
				      	<td style="padding-bottom: 0px; padding-top: 0px;">Vendedor:</td>
				      	<td colspan="2" style="padding-bottom: 0px; padding-top: 0px;">
				      		000{{ $client->seller_id }}-{{ $client->seller_name }}
				      	</td>
				      </tr>
				    </tbody>
				  </table>
				</div>
			</div>

			<div class="col-3 float-right" style="position:fixed; top: 211px;">
				<div class="table-responsive">
				  <table class="">
				    <tbody>
				    	<tr>
				    		<td style="padding-bottom: 0px; padding-top: 0px;line-height: 0px;" colspan="2">
				    			<span style="font-size: 14px; font-weight: bold;padding-bottom: 0px; padding-top: 0px;">NOTA DE CREDITO NO.:</span>
				    		</td>
				    	</tr>
				    	<tr>
				    		<td style="padding-bottom: 0px; padding-top: 0px;">
				    			<span style="font-size: 14px; font-weight: bold;padding-bottom: 0px; padding-top: 0px;">
				    				0000{{ $credit_note->note_number }}
				    			</span>
				    		</td>
				    	</tr>
				    	<tr>
				    		<td style="padding-bottom: 0px; padding-top: 0px; line-height: 16px;">Fecha de Emisión:</td>
				    		<td style="padding-bottom: 0px; padding-top: 0px; line-height: 16px;" >
				    			{{ date('d/m/Y', strtotime($credit_note->date)) }}
				    		</td>
				    	</tr>
				    	<tr>
				    		<td style="padding-bottom: 0px; padding-top: 0px; line-height: 16px; width: 115px">Fecha de Vencimiento:</td>
				    		<td style="padding-bottom: 0px; padding-top: 0px; line-height: 16px;">
				    			{{ date('d/m/Y', strtotime($credit_note->date)) }}
				    		</td>
				    	</tr>
				    	<tr>
				    		<td style="padding-bottom: 0px; padding-top: 0px; line-height: 16px;">Condiciones de Pago:</td>
				    		<td style="padding-bottom: 0px; padding-top: 0px; line-height: 16px;">Crédito</td>
				    	</tr>
				    </tbody>
				  </table>
				</div>
			</div>




			<div class="col-12" style="top: 5px;">
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
				    	@foreach($credit_note->creditNoteProducts as $product)
				    	<tr>
				    		<td class="" style="padding-top: 0px; padding-bottom: 0px">
						      	{{ substr($product->invoiceProducts->reference, 0, 18) }}
						    </td>
						    <td  class="" style="padding-top: 0px; padding-bottom: 0px">
						      	{{ substr($product->invoiceProducts->description, 0, 50) }}
						    </td>
						    <td  class="" style="padding-top: 0px; padding-bottom: 0px">
						      	{{ substr($product->invoiceProducts->brand, 0, 10) }}
						    </td>
						    <td class="text-right " style="padding-top: 0px; padding-bottom: 0px">
						      	{{ $product->quantity }}
						    </td>
							<td class="text-right " style="padding-top: 0px; padding-bottom: 0px">
						      	{{ number_format($product->invoiceProducts->unit_price_bolivar, 2, ',', '.')  }}
						    </td>
						    <td class="text-right " style="padding-top: 0px; padding-bottom: 0px">
						      	{{ number_format($product->total_price_bolivar, 2, ',', '.')  }}
						    </td>
				    	</tr>
				    	@endforeach
				    	
				    </tbody>

				  </table>
				</div>
			</div>

			
			<div class="col-12" 
				style="
					border-top: 1px solid #000; 
					border-bottom:1px solid #000; 
					height: 40px;
					position: fixed;
					bottom: 88px;
					left: 30px;
				"
			>
				<div class="table-responsive" style="left: -100px;">
				  <table>
				    <tbody>
				    	<tr>
				    		<td style="width:10px;line-height: 13px;">
				    			<span class="font-weight-bold">
				    				Documento Afectado: {{ $credit_note->invoices }}
				    			</span>
				    		</td>
				    			  
				    	</tr>
				    	<tr>
				    		<td><span>DISTRIBUIDORA AUTANA CAR, C.A</span></td>
				    	</tr>
				    </tbody>
				  </table>
				</div>
			</div>

			  <table style="position: fixed;bottom: 130px;left: 590px;">
			    <tbody class=" text-right" style="font-size: 11px;">
			    	<tr>
			    		<td class="py-0" style="line-height: 13px;">Base Imponible:</td>
			    		<td class="py-0" style="line-height: 13px;">
			    			 {{ number_format($credit_note->tax_base_bolivar, 2, ',', '.')  }}
			    		</td>
			    	</tr>
			    	<tr>
			    		<td class="py-0" style="line-height: 13px;">I.V.A. 16,00%</td>
			    		<td class="py-0" style="line-height: 13px;">
			    			 {{ number_format($credit_note->iva_bolivar, 2, ',', '.')  }}
			    		</td>
			    	</tr>
			    	<tr>
			    		<td class="py-0" style="line-height: 13px;">Total Operación:</td>
			    		<td class="py-0" style="line-height: 13px;">
			    			 {{ number_format($credit_note->total_operation_bolivar, 2, ',', '.')  }}
			    		</td>
			    	</tr>

			    </tbody>
			  </table>


			
			<span class="font-weight-bold" style="position: fixed;bottom: 73px; left: 70px; font-size: 8px;">
				CONTRIBUYENTE ORDINARIO
			</span>
			<span class="font-weight-bold" style="position: fixed;bottom: 73px; left: 260px; font-size: 7px;">
				ORIGINAL BLANCO: Cliente - COPIA : Sin Derecho a Crédito Fiscal
			</span>
			<span class="font-weight-bold" style="position: fixed;bottom: 82px; left: 490px; font-size: 15px;">
				No. DE CONTROL: 00-
			</span>
			<span class=" font-weight-bold" style="position: fixed;bottom: 82px; left: 645px; font-size: 14px;">
				No   {{ $credit_note->control_number }}
			</span>

			<div class="col-md-12" style="position:fixed; bottom: 65px;">
				<p class="text-center small">
					<span class="font-weight-bold" style="font-size: 8px; font-family: Arial">
						<b>
							L&B IMPRESIONES,C.A. / Telf.:(0247) 8085746 Calle Aramendi, No. 38/San Fdo, Edo Apure/RIF: J-29546932-2 / AUT. No. Provid: /02/00504 del 05/03/2008 'Región LOS LLANOS<br>
						</b>
					</span>
				</p>
			</div>
			<span class="font-weight-bold" 
				style="position: fixed;bottom: 56px; left: 70px; font-size: 8px;-size: 8px">
				{{ $configurations['assigned_control_numbers_credit_note'] }}
			</span>
			<br>
			<span class="font-weight-bold" 
				style="position: fixed;bottom: 45px; left: 305px; font-size: 15px;font-size: 15px">
				Original Cliente
			</span>



		</div>

	</div>
	
</body>
</html>


