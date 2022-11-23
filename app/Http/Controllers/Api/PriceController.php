<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Price;

class PriceController extends Controller
{
    public function show($id)
    {
        return response()->json(
            Price::where('product_id', $id)->firstOrFail()
            );
    }

    public function update(Request $request)
    {
        $prices = Price::where('id', $request->data['prices']['id'])->firstOrFail();
        $prices->price_a = number_format($request->data['prices']['price_a'], 2, '.', '');
        $prices->price_b = number_format($request->data['prices']['price_b'], 2, '.', '');
        $prices->price_c = number_format($request->data['prices']['price_c'], 2, '.', '');
        $prices->price_d = number_format($request->data['prices']['price_d'], 2, '.', '');
        $prices->price_e = number_format($request->data['prices']['price_e'], 2, '.', '');
        $prices->price_f = number_format($request->data['prices']['price_f'], 2, '.', '');
        $prices->price_g = number_format($request->data['prices']['price_g'], 2, '.', '');
        $prices->price_h = number_format($request->data['prices']['price_h'], 2, '.', '');
        $prices->price_i = number_format($request->data['prices']['price_i'], 2, '.', '');
        $prices->price_j = number_format($request->data['prices']['price_j'], 2, '.', '');
        $prices->price_k = number_format($request->data['prices']['price_k'], 2, '.', '');
        $prices->price_l = number_format($request->data['prices']['price_l'], 2, '.', '');
        $prices->price_m = number_format($request->data['prices']['price_m'], 2, '.', '');
        $prices->price_n = number_format($request->data['prices']['price_n'], 2, '.', '');
        $prices->price_o = number_format($request->data['prices']['price_o'], 2, '.', '');
        $prices->price_p = number_format($request->data['prices']['price_p'], 2, '.', '');
        $prices->price_q = number_format($request->data['prices']['price_q'], 2, '.', '');
        $prices->price_r = number_format($request->data['prices']['price_r'], 2, '.', '');
        if ($prices->save()) {
            return response()->json([
            'status' => 201,
            ]);
        } 
    }
}
