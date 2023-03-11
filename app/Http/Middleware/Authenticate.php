<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use App\Interfaces\Constants as C;
use Closure;
use Illuminate\Support\Facades\Log;

class Authenticate extends Middleware
{

    public function handle($request, Closure $next, ...$guards)
    {
        echo "Authenticate handle\r\n";
        parent::handle($request,$next,$guards);
    }


    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }

    protected function unauthenticated($request, array $guards)
    {
        if($request->expectsJson())
            abort(response()->json([
                C::KEY_DONE => false, 
                C::KEY_MESSAGE => 'Accedi con il tuo account per effettuare questa azione'        
            ],401,[],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE));
        parent::unauthenticated($request,$guards);
    }
}
