<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;

class ClienteController extends Controller
{
    public function index()
    {

        $cliente = Cliente::all();

        $json = array(
            'status' => http_response_code(),
            'registros' => count($cliente),
            'clientes' => $cliente 
        );
        //return json_encode($json, true);
        return $json;
    }
}
