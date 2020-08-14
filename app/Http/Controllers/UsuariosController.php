<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Usuarios;
class UsuariosController extends Controller
{
    //Metodos Http

    public function index()
    {
        $json = array(
            "Detalle"=>"No encontrado"
        );
        return json_encode($json,true);
    }

    public function store(Request $request){
        $datos = array(
            "nombre"=>$request->input("nombre"),
            "apellido"=>$request->input("apellido"),
            "correo"=>$request->input("email")
        );

        $validator = Validator::make($datos, [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'correo' => 'required|string|email|unique:usuario|max:255'
        ]);

        if ($validator->fails()) {
            $json = array(
                "Datos"=>"No validos"
            );
            return json_encode($json,true);
        }else{

            $usuario = new Usuarios();
            $usuario->nombre = $datos['nombre'];
            $usuario->apellido =$datos['apellido'];
            $usuario->correo = $datos['correo'];
            $usuario->id_usuario = Hash::make($datos['nombre'].$datos['apellido'].$datos['correo']);
            $usuario->llave_secreta = Hash::make($datos['correo'].$datos['apellido'].$datos['nombre'],['rounds' => 12,]);

            $usuario->save();

            $json = array(
                "Registro"=>"Exitoso!"
            );
            return json_encode($json,true);
        }

    }
}
