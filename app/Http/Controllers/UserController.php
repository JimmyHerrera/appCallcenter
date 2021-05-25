<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTExceptions;



class UserController extends Controller
{
    public function register(Request $request){
        $user = User::where('email',$request['email'])->first();

        if($user){
            $response['status'] = 0;
            $response['message'] = 'El email ya esta registrado';
            $response['code'] = 409;

        }else{
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            $response['status'] = 1;
            $response['message'] = 'Usuario creado';
            $response['code'] = 200;
        }


        return response()->json($response);
    }

    public function login(Request $request){
        $credentials = $request->only('email','password');
        try{
            if(!JWTAuth::attempt($credentials)){
                $response['status']= 0;
                $response['code']= 401;
                $response['data']= null;
                $response['message']= "Email o Password incorrecto";

                return response()->json($response);

            }
        }catch(JWTExceptions $e){
            $response['data']= null;
            $response['code']= 500;
            $response['message']= "No se pudo crear el Token";

            return response()->json($response);
        }

        $user = auth()->user();
        $data['token'] = auth()->claims([
            'id' =>$user->id,
            'email' =>$user->email
        ])->attempt($credentials);

        $response['data']= $data;
        $response['status']= 1;
        $response['code']= 200;
        $response['message']= "Loggin Successfully";

        return response()->json($response);
    }

}
