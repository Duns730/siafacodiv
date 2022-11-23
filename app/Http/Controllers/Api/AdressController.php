<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\State;
use App\Municipality;
use App\PopulationCenter;
use App\Location;
use App\Address;

class AdressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
             'state' => State::orderBy('name', 'ASC')->get()
            ]);
    }

    public function states()
    {
       return response()->json([
             State::orderBy('name', 'ASC')->get()
            ]);
    }

    public function municipalities($state_id)
    {
        return response()->json([
             Municipality::where('state_id', $state_id)->orderBy('name', 'ASC')->get()
            ]);
    }
    public function populationCenters($municipality_id)
    {
        $json = PopulationCenter::where('municipality_id', $municipality_id)->orderBy('name', 'ASC')->get();
        if (count($json) > 0) {
            return response()->json([$json]);
        }
        else{
            return response()->json([
                   [ ['id' => '','name' => 'Cree un registro']]
            ]);
        }
        
    }
    public function locations($populationcenter_id)
    {
        $json = Location::where('population_center_id', $populationcenter_id)->orderBy('name', 'ASC')->get();
        if (count($json) > 0) {
            return response()->json([$json]);
        }
        else{
            return response()->json([
                   [ ['id' => '','name' => 'Cree un registro']]
            ]);
        }
    }

    public function storePopulationCenter(Request $request)
    {
        $populationCenter = new PopulationCenter;
        $populationCenter->name = strtoupper(e($request->data['name']));
        $populationCenter->municipality_id = e($request->data['municipality_id']);
        if ($populationCenter->save()) {
            return response()->json([
            'status' => 201,
            'id' => $populationCenter->id,
            'name' => $populationCenter->name
            ]);
        } 
    }

    public function storeLocations(Request $request)
    {
        $location = new Location;
        $location->name = strtoupper(e($request->data['name']));
        $location->population_center_id = e($request->data['population_center_id']);
        if ($location->save()) {
            return response()->json([
            'status' => 201,
            'id' => $location->id,
            'name' => $location->name
            ]);
        } 
    }

    public function store(Request $request)
    {
         //
    }

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
