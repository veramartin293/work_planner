<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRegisterRequest;
use App\Http\Requests\AuthLoginRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(AuthRegisterRequest $request) {
        try {
            // Check if two password values match
            if ($request->password !== $request->password_verification) {
                $res = ['error' => 'Las contraseñas no coinciden'];
                return response($res, 400);
            }

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            
            $user->save();

            return response($user, 200);
        } catch (Exception $e) {
            $res = [];
            if ($e->getCode() == 23000) {
                $res['error'] = 'Ya existe una cuenta asociada al correo electrónico proporcionado';
            } else {
                $res['error'] = 'Hubo un error en la base de datos, inténtelo más tarde';
            }
            return response($res, 400);
        }
    }

    public function login(AuthLoginRequest $request) {
        
        try {
            $res = []; // response

            // Verify if the user exists
            $user = User::where('email', $request->email)->first();

            // If user does not exist or password is incorrect
            if (!$user || !Hash::check($request->password, $user->password)) {
                $res['error'] = 'No existe el usuraio o la contraseña';
                return response($res, 403);
            }

            // Create the token
            $token = $user->createToken('apptoken')->plainTextToken;

            // Return the response
            $res['user'] = $user;
            $res['token'] = $token;
            return response($res, 200);

        } catch (Exception $e) {
            $res['error'] = 'Hubo un error en la base de datos, inténtelo más tarde.';
            return response($res, 400);
        }

    }

    public function logout() {
        try {
            auth()->user()->currentAccessToken()->delete();
            $res = [];
            $res['user'] = auth()->user();
            return(response($res, 200));

        } catch (Exception $e) {
            $res['error'] = 'Hubo un error en la base de datos, inténtelo más tarde.';
            return response($res, 400);
        }


    }

    public function getAuthenticated() {
        try {
            $authenticatedUser = auth()->user();
            return response($authenticatedUser, 200);
        } catch (Exception $e) {
            $res = [];
            $res['error'] = 'Hubo un error en la base de datos, intentelo mas tarde';
            return response($res, 400);
        }
    }
}
