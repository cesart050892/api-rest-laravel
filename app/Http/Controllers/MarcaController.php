<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Marca;

class MarcaController extends Controller
{
    
    public function index()
    {

        $marcas = Marca::all();

        $json = array(
            'status' => http_response_code(),
            'registros' => count($marcas),
            'marcas' => $marcas 
        );
        //return json_encode($json, true);
        return $json;
    }
}
