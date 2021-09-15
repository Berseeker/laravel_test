<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
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

class VerifyMailController extends Controller
{
    public function index()
    {
        $user = User::findOrFail(Auth::user()->id);
        dd($user);
        if($user->email_verified_at == NULL)
        {
            $url = URL::temporarySignedRoute(
                'verify.email.custom',
                Carbon::now()->addMinutes(60),
                [
                    'id' => Auth::user()->getKey(),
                    'hash' => Hash::make(Auth::user()->getEmailForVerification()),
                ]
            );
    
            Mail::to($user->email)
                ->queue(new VerifyEmail($url));

            return $this->successResponse('El correo se envio de manera correcta, favor de verficar su email.',null,200);
        }
    }
}
