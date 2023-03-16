<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Negotiation;
use App\NegotiationProformas;
use App\NegotiationInvoices;
use Carbon\Carbon;

class NegotiationController extends Controller
{
    public function listByClient($fragment)
    {
        $date = $this->setDate();
        $date['star']->subMonth(2);
        return response()->json(
            Negotiation::join('clients', 'clients.id', '=', 'negotiations.client_id')
                ->orWhere('clients.name', 'like', '%'.$fragment.'%')
                //->orWhere('', $fragment)
                ->where('negotiations.created_at', '>=', $date['star']->format('Y-m-d'))
                ->where('negotiations.created_at', '<=', $date['end']->format('Y-m-d'))
                ->selectRaw('clients.id as client_id, clients.name, negotiations.id, negotiations.title, negotiations.id')
                ->orderBy('negotiations.created_at', 'desc')
                ->get()
        );
    }
    public function proformasGraph($id) //id de negociación
    {
       // $negotiation = Negotiation::where('id', $id)->with('user', 'client')->firstOrFail();
        $labels = [];
        $data = [];
        $amount = 0;
        $negotiation_proformas = NegotiationProformas::where('negotiation_id', $id)->with('proforma')->get();
        //dd($negotiation_proforma);
        foreach ($negotiation_proformas as $negotiation_proforma) {
            $amount += $negotiation_proforma->proforma->tax_base_dollar;
            array_push($data, $negotiation_proforma->proforma->tax_base_dollar);
            array_push($labels, 'id ' .$negotiation_proforma->proforma->id. " : ");
        }
        for ($i=0; $i < count($data); $i++){
            $labels[$i] .= number_format($data[$i]*100/$amount, 2, ',', '')."% ";
        }
        return response()->json([
                'status' => 201,
                'labels' => $labels,
                'data' => $data,
            ]);
    }

    public function invoicesGraph($id) //id de negociación
    {
        $labels = [];
        $data = [];
        $amount = 0;
        $negotiation_invoices = NegotiationInvoices::join('invoices', 'negotiation_invoices.invoice_id','=','invoices.id')->where('negotiation_id', $id)
                            //->where('invoices.status', 'PENDIENTE')
                            ->get();
        //dd($negotiation_invoice);
        foreach ($negotiation_invoices as $negotiation_invoice) {
            $amount += $negotiation_invoice->invoices->tax_base_dollar;
            array_push($data, $negotiation_invoice->invoices->tax_base_dollar);
            array_push($labels, 'fact ' .$negotiation_invoice->invoices->invoice_number. " : ");
        }
        for ($i=0; $i < count($data); $i++){
            $labels[$i] .= number_format($data[$i]*100/$amount, 2, ',', '')."% ";
        }
        return response()->json([
                'status' => 201,
                'labels' => $labels,
                'data' => $data,
            ]);
    }
 

    public function selectionWarehouseActive(Request $request)
    {
        $user = User::where('id', $request->data['user_id'])->firstOrFail();

        if ($user->hasPermissionTo('negotiations.selection.warehouse') || $user->hasRole('super.admin')){
            $negotiation = Negotiation::where('id', $request->data['negotiation_id'])->firstOrFail();
            if (!empty($negotiation->proformed_date)) {
                $negotiation->selection_warehouse_date = date('Y-m-d H:i:s');
                if ($negotiation->save()) {
                    $starting_amount = $this->calculateInitialAmount($request->data['negotiation_id']);
                    $response = [
                        'status' => 201,
                        'message' => 'Estatus Cambiado correctamente',
                        'date' => date('d/m/Y  h:i a', strtotime($negotiation->selection_warehouse_date))
                    ];

                }
                else{
                    $response = [
                        'status' => 409,
                        'message' => 'No se puedo cambiar el estatus de la negociación, vuelva a intentar',
                    ];
                }
            }
            else{
                $response = [
                        'status' => 406,
                        'message' => 'No puede cambiar el estatus hasta que el pedido esté proformado',
                    ];
            }
        }else{
            $response = [
                'status' => 403,
                'message' => 'Usted no tiene los permisos para ejecutar esta acción',
            ];
        }
        return response()->json($response);

    }

    public function warehousePackingActive(Request $request)
    {
        $user = User::where('id', $request->data['user_id'])->firstOrFail();
        

        if ($user->hasPermissionTo('negotiations.warehouse.packing') || $user->hasRole('super.admin')){
            $negotiation = Negotiation::where('id', $request->data['negotiation_id'])->firstOrFail();
            if (!empty($negotiation->invoice_date)) {
                $negotiation->warehouse_packing_date = date('Y-m-d H:i:s');
                if ($negotiation->save()) {
                    $response = [
                        'status' => 201,
                        'message' => 'Estatus Cambiado correctamente',
                        'date' => date('d/m/Y  h:i a', strtotime($negotiation->warehouse_packing_date))
                    ];

                }
                else{
                    $response = [
                        'status' => 409,
                        'message' => 'No se puedo cambiar el estatus de la negociación, vuelva a intentar',
                    ];
                }
            }
            else{
                $response = [
                        'status' => 406,
                        'message' => 'No puede cambiar el estatus hasta que el pedido esté facturado',
                    ];
            }
        }else{
            $response = [
                'status' => 403,
                'message' => 'Usted no tiene los permisos para ejecutar esta acción',
            ];
        }
        return response()->json($response);

    }

    public function warehousePackedActive(Request $request)
    {
        $user = User::where('id', $request->data['user_id'])->firstOrFail();
        
        if ($user->hasPermissionTo('negotiations.warehouse.packed') || $user->hasRole('super.admin')){
            $negotiation = Negotiation::where('id', $request->data['negotiation_id'])->firstOrFail();
            if (!empty($negotiation->warehouse_packing_date)) {
                $negotiation->warehouse_packed_date = date('Y-m-d H:i:s');
                if ($negotiation->save()) {
                    $response = [
                        'status' => 201,
                        'message' => 'Estatus Cambiado correctamente',
                        'date' => date('d/m/Y  h:i a', strtotime($negotiation->warehouse_packed_date))
                    ];

                }
                else{
                    $response = [
                        'status' => 409,
                        'message' => 'No se puedo cambiar el estatus de la negociación, vuelva a intentar',
                    ];
                }
            }
            else{
                $response = [
                        'status' => 406,
                        'message' => 'No puede cambiar el estatus hasta que el pedido se haya enviado a Almacén(Embalaje)',
                    ];
            }
        }else{
            $response = [
                'status' => 403,
                'message' => 'Usted no tiene los permisos para ejecutar esta acción',
            ];
        }
        return response()->json($response);
    }

    public function orderDelivered(Request $request)
    {
        $negotiation = Negotiation::where('id', $request->data['negotiation_id'])->firstOrFail();
        if (!empty($negotiation->warehouse_packed_date)) {
            $negotiation->deliver_date = $request->data['order_delivered'];
            if ($negotiation->save()) {
                $response = [
                        'status' => 201,
                        'message' => 'Estatus Cambiado correctamente',
                        'date' => date('d/m/Y', strtotime($negotiation->deliver_date))
                    ];
            }
            else{
                    $response = [
                        'status' => 409,
                        'message' => 'No se puedo cambiar el estatus de la negociación, vuelva a intentar',
                    ];
                }
        }
        else{
            $response = [
                    'status' => 406,
                    'message' => 'No puede cambiar el estatus hasta que el pedido haya sido Almacén(Embalado)',
                ];
            }
        return response()->json($response);
    }

    public function setDate()//genera las fechas de inicio y fin de mes
    {
        $base = Carbon::now();
        $sub_day_star = Carbon::now()->format('d');
        settype($sub_day_star, 'integer');
        return [
                //'star' => Carbon::now()->subDay($sub_day_star-1),
                'star' => Carbon::create($base->year, $base->month, $base->day - $sub_day_star+1, 0, 0, 0),
                //'end' => Carbon::now()->addMonth()->subDay($sub_day_star),
                'end' => Carbon::create($base->year, $base->month+1, $base->day - $sub_day_star, 23, 59, 59),
                ];
    }

    public function calculateInitialAmount($id)
    {
        $starting_amount = NegotiationProformas::selectRaw('SUM(proformas.tax_base_dollar) as amount')
                ->join('proformas', 'proformas.id', '=', 'negotiation_proformas.proforma_id')
                ->where('negotiation_proformas.negotiation_id', $id)
                ->first();
        $negotiation = Negotiation::where('id', $id)->firstOrFail();
        $negotiation->starting_amount = $starting_amount->amount;
        $negotiation->save();
        return $starting_amount->amount;
        //dd($initial_amount->amount);


    }
}
