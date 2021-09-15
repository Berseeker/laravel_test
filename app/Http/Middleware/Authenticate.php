<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if(stristr($request->getPathInfo(), 'api'))
            {
                return response()->json([
                    'message'=>'Error',
                    'error'=>'Error al autenticar el usuario',
                    'code'=>401],401);
            }
            return route('login');
        }
    }
}
