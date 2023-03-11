<?php

namespace App\Http\Middleware;

use App\Exceptions\ResourceNotFoundException;
use App\Exceptions\UnauthorizedActionException;
use App\Models\Comment;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Interfaces\Constants as C;

class CommentOwnershipMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        echo "CommentOwnershipMiddleware handle\r\n";
        try{
            $user = Auth::user();
            $comment_id = $request->route()->parameter('comment');
            echo "CommentOwnershipMiddleware comment id => {$comment_id}";
            $comment = Comment::find($comment_id);
            if($comment != null){
                if($user->id == $comment->author_id){
                    $request->merge(['comment' => $comment]);
                    return $next($request);
                }
                throw new UnauthorizedActionException;
            }//if($comment != null){
            throw new ResourceNotFoundException; 
        }catch(ResourceNotFoundException){
            return response()->json([
                C::KEY_DONE => false, C::KEY_MESSAGE => 'Il commento richiesto non esiste'
            ],404,[],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        }catch(UnauthorizedActionException){
            return response()->json([
                C::KEY_DONE => false, C::KEY_MESSAGE => 'Non disponi dei privilegi necessari per poter eseguire questa azione'
            ],401,[],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        }catch(Exception $e){
            return response()->json([
                C::KEY_DONE => false, C::KEY_MESSAGE => 'Errore durante la cancellazione del commento'
            ],500,[],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        }
        
    }
}
