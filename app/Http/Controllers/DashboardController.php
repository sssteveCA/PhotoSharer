<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Interfaces\Constants as C;
use App\Models\Comment;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //

    public function show(Request $request){
        try{
            $user = Auth::user();
            if($user->role == "admin"){
                $user_subscribed = User::whereNotNull('email_verified_at')->get()->toArray();
                $comments = Comment::all();
                $reported_comments = Comment::where('reported',1)
                    ->where('approved',1)->get()->toArray();
                $reported_photos = Photo::where('reported',1)
                    ->where('approved',1)->get()->toArray();
                return response()->view('dashboard',[
                    C::KEY_DONE => true,
                    C::KEY_DATA => [
                        'user_subscribed' => $user_subscribed, 
                        'comments' => $comments, 
                        'reported_comments' => $reported_comments,
                        'reported_photos' => $reported_photos
                    ]
                ]);
            }
            $photos = Photo::where('author_id',$user->id)->get()->toArray();
            return response()->view('dashboard',[
                C::KEY_DONE => true,
                C::KEY_DATA => [
                    'photos' => $photos
                ]
            ]);
        }catch(Exception $e){
            return response()->view('dashboard',[
                C::KEY_DONE => false, 
                C::KEY_MESSAGE => "Si è verificato un errore durante il caricamento del pannello di amministrazione"
            ],500);
        }
    }
}
