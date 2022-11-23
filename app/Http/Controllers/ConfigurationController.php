<?php

namespace App\Http\Controllers;

use App\Configuration;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $configurations = Configuration::orderBy('id', 'ASC')->paginate(30);
        return view('configurations.index', compact('configurations'));
    }

    public function set($configurations)
    {
        return array_combine(array_column($configurations, 'key'), array_column($configurations, 'value'));
    }
}
