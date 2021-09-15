<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;

#Mails
use App\Mail\VerifyEmail;

#Models
use App\Models\User;

#Dates
use Carbon\Carbon;

#Mail
use Mail;

class RegisterController extends ApiController
{
    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required|same:password'
        ];

        $messages = [
            'nombre.required' => 'Es necesario asignar un nombre al usuario',
            'email.required' => 'Por favor escribe un correo electronico',
            'email.email' => 'Formato invalido de correo electronico',
            'password.required' => 'Por favor asigna una contraseña',
            'password.confirmed' => 'Es necesario que confirmes tu password',
            'password_confirmation.required' => 'Por favor confirma tu password',
            'password_confirmation.same' => 'Las contraseñas no concuerdan',
        ];

        $this->validate($request,$rules,$messages);


        $user = new User();
        $user->name = $request->nombre;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->rol = 'client';
        $user->save();

        verifyEmail($user->email_verified_at,$user->id,$user->email);


        return $this->successResponse('El usuario se registro exitosamente',$user,200);
    }
}

function verifyEmail($email_verified_at,$id,$email){

    if($email_verified_at == NULL){
        Auth::loginUsingId($id);
        $url = URL::temporarySignedRoute(
            'verify.email.custom',
            Carbon::now()->addMinutes(60),
            [
                'id' => Auth::user()->getKey(),
                'hash' => Hash::make(Auth::user()->getEmailForVerification()),
            ]
        );

        Mail::to($email)
            ->queue(new VerifyEmail($url));
    }
}
