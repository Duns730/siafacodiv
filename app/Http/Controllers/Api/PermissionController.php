<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\User;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(
             Permission::orderBy('description', 'ASC')->get()
            );
    }

    public function indexUser($id)
    {
        return response()->json(
            Permission::join('model_has_permissions', 'permissions.id','=','model_has_permissions.permission_id')->select('model_has_permissions.*', 'permissions.name')->where('model_id', $id)->get()
            );
    }

    public function store(Request $request)
    {

        $user = User::where('id', $request->data['id'])->firstOrFail();
        if ($user->givePermissionTo($request->data['name'])) {
            return response()->json([
            'status' => 201,
            'messege' => 'Permiso otorgado con exito'
            ]);
        } 
    }
    
    public function destroy(Request $request)
    {
        $user = User::where('id', $request->data['id'])->firstOrFail();
        if ($user->revokePermissionTo($request->data['name'])) {
            return response()->json([
            'status' => 201,
            'messege' => 'Permiso revocado con exito'
            ]);
        } 
    }
}
