<?php

namespace App\Http\Controllers;

use App\Exceptions\ResourceNotFoundException;
use App\Exceptions\UnauthorizedActionException;
use App\Models\Comment;
use Exception;
use Illuminate\Http\Request;
use App\Interfaces\Constants as C;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $user = Auth::user();
            $request->validate([
                'comment_text' => ['required']
            ]);
            $comment_text = $request->input('comment_text');
            $comment = Comment::find($id);
            if($comment != null){
                if($comment->author_id == $user->id){
                    $comment->comment_text = $comment_text;
                    $comment->save();
                    return response()->json([
                        C::KEY_DONE => true, C::KEY_MESSAGE => "Il commento è stato modificato"
                    ],200,[],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
                }
                throw new UnauthorizedActionException;
            }
            throw new ResourceNotFoundException;
        }catch(UnauthorizedActionException){
            return response()->json([
                C::KEY_DONE => false, C::KEY_MESSAGE => 'Non disponi dei privilegi necessari per poter eseguire questa azione'
            ],401,[],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        }catch(ResourceNotFoundException){
            return response()->json([
                C::KEY_DONE => false, C::KEY_MESSAGE => 'Il commento richiesto non esiste'
            ],404,[],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        }catch(ValidationException){
            return response()->json([
                C::KEY_DONE => true, C::KEY_MESSAGE => 'Inserisci i dati richiesti per modificare il commento'
            ],400,[],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        }catch(Exception $e){
            return response()->json([
                C::KEY_DONE => false, C::KEY_MESSAGE => 'Errore durante la modifica del commento'
            ],500,[],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,string $id)
    {
        try{
            $user = Auth::user();
            $comment = Comment::find($id);
            if($comment != null){
                if($user->id == $comment->author_id){
                    $comment->delete();
                    return response()->json([
                        C::KEY_DONE => true, C::KEY_MESSAGE => 'Il commento è stato cancellato'
                    ],200,[],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
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
