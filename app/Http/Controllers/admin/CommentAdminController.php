<?php

namespace App\Http\Controllers\admin;

use App\Exceptions\ResourceNotFoundException;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Interfaces\Constants as C;
use App\Models\Comment;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CommentAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $request->validate([
                'approved' => ['required',Rule::in([0,1])]
            ]);
            $approved = $request->input('approved');
            $comment = Comment::find($id);
            $comment->approved = $approved; 
            $comment->save();
            $status = $approved == 1 ? "approvato" : "non approvato";
            $message = "Lo stato del commento è stato modificato in {$status}";
            return response()->json([
                C::KEY_DONE => true, C::KEY_MESSAGE => $message
            ],200,[],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        }catch(ValidationException){
            return response()->json([
                C::KEY_DONE => true, C::KEY_MESSAGE => 'Inserisci i dati richiesti per modificare il commento'
            ],400,[],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        }catch(ResourceNotFoundException){
            return response()->json([
                C::KEY_DONE => true, C::KEY_MESSAGE => 'Il commento richiesto non esiste'
            ],404,[],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        }catch(Exception $e){
            return response()->json([
                C::KEY_DONE => false, C::KEY_MESSAGE => 'Errore durante la modifica del commento'
            ],500,[],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $comment = Comment::find($id);
            if($comment != null){
                $comment->delete();
                return response()->json([
                    C::KEY_DONE => true, C::KEY_MESSAGE => 'Il commento è stato cancellato'
                ],200,[],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
            }
            throw new ResourceNotFoundException;
        }catch(ResourceNotFoundException){
            return response()->json([
                C::KEY_DONE => true, C::KEY_MESSAGE => 'Il commento richiesto non esiste'
            ],404,[],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        }catch(Exception $e){
            return response()->json([
                C::KEY_DONE => false, C::KEY_MESSAGE => 'Errore durante la cancellazione del commento'
            ],500,[],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        }
    }
}
