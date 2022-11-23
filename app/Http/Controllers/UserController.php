<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
       // $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'ASC')->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([    
            'name' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'password' => ['required', 'string', 'min:8',],
        ]);

        $user =  User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

    if ($user) {
            $user->givePermissionTo('clients.index','sellers.index','negotiations.index','products.index','proformas.index');
            return redirect()->route('users.edit', $user->id)->with('info', 'Vendedor creado correctamente');
        }
        else{
            return redirect()->route('users.index')->with('info', 'Error, intente de nuevo');
        }
   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::where('id', $id)->firstOrFail();
        return view('users.edit', compact('user'));
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
        $user = User::where('id', $id)->firstOrFail();

         if ($request->email === $user->email) 
            {$ruleEmail = ['required','email'];}
        else
            {$ruleEmail = ['required','unique:users','email'];}


        $request->validate([    
            'name' => ['required', 'string', 'max:20'],
            'email' => $ruleEmail,
        ]);

        $user->name = e($request->name);
        $user->email = e($request->email);

        if (!empty($request->password)) 
            {$user->password = Hash::make($request['password']);}

        if ($user->save()) {
            return redirect()->route('users.index')->with('info', 'Vendedor creado correctamente');
        }
        else{
            return redirect()->route('users.index')->with('info', 'Error, intente de nuevo');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (User::findOrFail($id)->delete()) {
              return back()->with('info', 'Borrado con exito');
          } 
        else{
            return back()->with('info', 'Error, intente de nuevo');
        }
    }
}
