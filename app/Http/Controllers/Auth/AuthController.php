<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Roles;

class AuthController extends Controller
{
    public function login(Request $request)
    {       
        $this->validate($request, [
            'email'    => 'required|email',
            'OTP' => 'required'
        ]);
        $user = User::where('email', $request->input('email'))->first();
        
        if (!$user || $request->input('OTP')!= $user->OTP) {  
            return view('auth/login', ['error' => 'Código OTP inválido']);
        }

        $rol = UserRole::where('user_id', $user->id)->first();
        $rol = Roles::find($rol->role_id);
                
        $_SESSION['user'] = [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $rol->name,
            'role_id' => $rol->id,
            'is_admin' => $rol->name === 'Administrador',
            'id' => $user->id
        ];

        return redirect('/');
    }

    public function showLoginForm()
    {           
        return view('auth/login', []);
    }
}
