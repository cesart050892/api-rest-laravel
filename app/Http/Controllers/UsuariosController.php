<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
//Modelo
use App\Usuarios;

class UsuariosController extends Controller
{
    //Metodos Http

    public function index()
    {
        $json = array(
            'API REST LARAVEL' => [
                'Header' => [
                    'Status' => http_response_code(),
                    'request' => [
                        'field00' => 'nombre',
                        'field01' => 'apellido',
                        'field02' => 'email'
                    ],
                    'url' => 'apirest-laravel.com'
                ],
                'Detalle' => 'Ingrese a la url /registro'
            ]
        );
        //return json_encode($json, true);
        return $json;
    }

    public function store(Request $request)
    {

        $datos = array(
            "nombre" => $request->input("nombre"),
            "apellido" => $request->input("apellido"),
            "correo" => $request->input("email")
        );

        if (!empty($datos)) {

            $validator = Validator::make($datos, [
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'correo' => 'required|string|email|unique:usuario|max:255'
            ]);

            if ($validator->fails()) {
                $json = array(
                    "Datos" => "No validos, con errores"
                );
                //return json_encode($json, true);
                return $json;
            } else {

                $id = Hash::make($datos['nombre'] . $datos['apellido'] . $datos['correo']);
                $llave = Hash::make($datos['correo'] . $datos['apellido'] . $datos['nombre'], ['rounds' => 12,]);

                $id_usuario = str_replace('$','a',$id);
                $llave_secreta = str_replace('$','o',$llave);

                $usuario = new Usuarios();
                $usuario->nombre = $datos['nombre'];
                $usuario->apellido = $datos['apellido'];
                $usuario->correo = $datos['correo'];
                $usuario->id_usuario = $id_usuario;
                $usuario->llave_secreta = $llave_secreta;

                $usuario->save();

                $json = array(
                    "Registros" => "Guardados!",
                    'Usuario' => [
                        'nombre' => $datos['nombre'],
                        'apellido' => $datos['apellido'],
                        'correo' => $datos['correo'],
                    ],
                    "Credenciales" => [
                        'id_usuario' => $id_usuario,
                        'llave_secreta' => $llave_secreta
                    ]
                );
                //return json_encode($json, true);
                return $json;
            }
        } else {
            $json = array(
                "Registros" => "Vacios!"
            );
            //return json_encode($json, true);
            return $json;
        }
    }
}
