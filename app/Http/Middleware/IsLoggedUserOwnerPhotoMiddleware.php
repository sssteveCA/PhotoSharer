<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Interfaces\Constants as C;
use App\Models\Photo;
use Illuminate\Support\Facades\Auth;

class IsLoggedUserOwnerPhotoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $photo_id = $request->route('photo');
        $photo = Photo::find($photo_id);
        if($photo != null){
            if($user->id == $photo->author_id){
                $request->request->add(['photo',$photo]);
                return $next($request);
            }
            return response()->json([
                C::KEY_DONE => false,
                C::KEY_MESSAGE =>"Non disponi dei privilegi necessari per eseguire quest'azione"
            ],401,[],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        }//if($comment != null){
        return response()->json([
            C::KEY_DONE => false,
            C::KEY_MESSAGE => "La foto che hai richiesto non esiste"
        ],404,[],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
    }
}
