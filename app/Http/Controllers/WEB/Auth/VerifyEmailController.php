<?php

namespace App\Http\Controllers\WEB\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

#Models
use App\Models\User;

#Dates
use Carbon\Carbon;

class VerifyEmailController extends Controller
{
    public function index(Request $request)
    {
        $expires = Carbon::createFromTimestamp($request->expires)->toDateTimeString();
        $now = Carbon::now();
        $diff = $now->gt($expires);

        if($diff)
        {
            return redirect()->route('verification.notice')->with('expiro','Lo sentimos su token expiro, por favor solicite otro.');
        }
        
        $user = User::find($request->id);
        Auth::login($user);

        if(Hash::check($user->email,$request->hash)){
            if ($user->hasVerifiedEmail()) {
                return redirect()->route('dashboard');
            }

            if ($user->markEmailAsVerified()) {
                return redirect()->route('dashboard');
            }
            
        }
        else{
            return redirect()->route('verification.notice');
        }
    }

    public function verify()
    {
        dd('vista again send verify');
    }
}
