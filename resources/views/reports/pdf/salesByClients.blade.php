
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
			<div class="col-12">
				<h3>Reporte de Ventas por Clientes {{ $clients->provisional }}</h3>
			</div>

			<div class="col-8 small"  style="padding-bottom: : 0px;">
				<div class="table-responsive small">
				  <table class="table">
				    <tbody>
				      <tr>
				        <th style="width: 8%; padding-top: 4px; padding-bottom: 4px">
				        	RIF  
				        </th>
				        <td style="width: 15%; padding-top: 4px; padding-bottom: 4px">
				        	J-40125958-8
				        </td>
				        <th style="width: 15%; padding-top: 4px; padding-bottom: 4px">
				        	Empresa 
				        </th>
				        <td style="padding-top: 4px; padding-bottom: 4px"   colspan="3">
				        	Distribuidora Autana Car, C.A.
				        </td>
					  </tr>
				      <tr>
				      	<th style="padding-top: 4px; padding-bottom: 4px"  colspan="2">
				        	Fecha de Descarga 
				        </th>
				        <td style="padding-top: 4px; padding-bottom: 4px">
				        	 {{ $date['now'] }}
				        </td>
				        <th style="padding-top: 4px; padding-bottom: 4px">
				        	Fecha
				        </th>
				        <td style="padding-top: 4px; padding-bottom: 4px">
				        	{{ $date['star'] }} al {{ $date['end'] }}
				        </td>
				      
				      </tr>
				    </tbody>
				  </table>
				</div>
			</div>

			<div class="col-12 small">
				<div class="table-responsive small">
					<table class="table table-striped jambo_table bulk_action small">
					  <thead>
					    <tr>
					      <th style="width: 4%;padding-top: 4px; padding-bottom: 4px;">
					      	Id
					      </th>
					      <th style="width: 40%;padding-top: 4px; padding-bottom: 4px;">
					      	Cliente
					      </th>
					      <th style="width: 10%;padding-top: 4px; text-align: center; padding-bottom: 4px;">
					      	Estado
					      </th>
					      <th style="width: 10%;padding-top: 4px; text-align: center; padding-bottom: 4px;">
					      	Base Imponible
					      </th>
					      <th style="width: 15%;padding-top: 4px; text-align: center; padding-bottom: 4px;">
					      	Vendedor
					      </th>
					    </tr>
					  </thead>
					  <tbody>
					  	@php
					  		$total_tax_base = 0;
					  	@endphp
					  	@foreach($clients as $client)
					    <tr>
					      <td  style="padding-top: 4px; padding-bottom: 4px">
					      	{{ $client->id }}
					      </td>
					      <td  style="padding-top: 4px; padding-bottom: 4px">
					      	{{ substr($client->name, 0, 63) }}
					      </td>
					      <td  style="text-align: center;padding-top: 4px; padding-bottom: 4px">
					      	{{ $client->state }}
					      </td>
					      <td style="text-align: center; padding-top: 4px; padding-bottom: 4px">
					      		{{ number_format($client->total_amount[0]->total_amount, 2, ',', '.') }}
					      		@php $total_tax_base += $client->total_amount[0]->total_amount; @endphp
					      </td>
					      <td  style="text-align: center; padding-top: 4px; padding-bottom: 4px">
					      	{{ $client->seller  }}
					      </td>
					    </tr>
					    @endforeach
					  </tbody>
					</table>
				</div>
				
<!--				<hr style="page-break-before: always;">-->
				<div class="col-md-3 offset-9"> 
				<div class="table-responsive small">
				  <table class="table small">
				    <tbody>
				      <tr>
				        <th style="width:50%; padding-top: 4px; padding-bottom: 4px;">
				        	Base Imponible:
				        </th>
				        <td style="padding-top: 4px; padding-bottom: 4px; text-align: right;"> 
				        	$ {{ number_format($total_tax_base, 2, ',', '.')  }} 
				        </td>
				      </tr>
				      <tr>
				        <th style="padding-top: 4px; padding-bottom: 4px">
				        	IVA (16%)
				        </th>
				        <td style="padding-top: 4px; padding-bottom: 4px; text-align: right;"> 
				        	$ {{ number_format($total_tax_base * 0.16 , 2, ',', '.')  }} 
				        </td>
				      </tr>
				      <tr>
				        <th style="padding-top: 4px; padding-bottom: 4px">
				        	Total de Operación:
				        </th>
				        <td style="padding-top: 4px; padding-bottom: 4px; text-align: right;"> 
				        	$ {{ number_format($total_tax_base + $total_tax_base * 0.16 , 2, ',', '.') }}
				        </td>
				      </tr>
				    </tbody>
				  </table>
				</div>
			</div>

			




			</div>


			
		</div>

		<script type="text/php">
		    if ( isset($pdf) ) {
		        $pdf->page_script('
		            $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
		            $pdf->text(670, 570, "Pagina $PAGE_NUM de $PAGE_COUNT", $font, 10);
		        ');
		    }
		</script>

	</div>

</body>
</html>


