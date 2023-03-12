<?php

namespace App\Http\Middleware;

use App\Models\Comment;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Interfaces\Constants as C;

class IsLoggedUserOwnerCommentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $comment_id = $request->route('comment');
        $comment = Comment::find($comment_id);
        if($comment != null){
            if($user->id == $comment->author_id){
                $request->request->add(['comment',$comment]);
                return $next($request);
            }
            return response()->json([
                C::KEY_DONE => false,
                C::KEY_MESSAGE =>"Non disponi dei privilegi necessari per eseguire quest'azione"
            ],401,[],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        }//if($comment != null){
        return response()->json([
            C::KEY_DONE => false,
            C::KEY_MESSAGE => "Il commento che hai richiesto non esiste"
        ],404,[],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        
    }
}
