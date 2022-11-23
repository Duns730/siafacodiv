<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Configuration;

class ConfigurationController extends Controller
{
    public function update(Request $request)
    {
    	$configuration = Configuration::where('id', $request->data['id'])->firstOrFail();
    	$configuration->value = $request->data['value'];
    	//dd($request->data['value']);
        if ($configuration->save()) {
            return response()->json([
            'status' => 201
            ]);
        }
    }
}
