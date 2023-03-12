<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Interfaces\Constants as C;
use App\Models\Comment;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    //

    public function show(Request $request){
        try{
            $user = Auth::user();
            if($user->role == "admin"){
                $user_subscribed = User::whereNotNull('email_verified_at')->get()->toArray();
                $photos = Photo::all()->toArray();
                $reported_photos = $this->filterReportedItems($photos);
                $comments = Comment::all()->toArray();
                $reported_comments = $this->filterReportedItems($comments);
                return response()->view('dashboard',[
                    C::KEY_DONE => true,
                    C::KEY_DATA => [
                        'users_subscribed' => $user_subscribed, 
                        'comments' => $comments, 
                        'reported_comments' => $reported_comments,
                        'reported_photos' => $reported_photos,
                        'role' => $user->role
                    ]
                ]);
            }//if($user->role == "admin"){
            $photos = Photo::where('author_id',$user->id)->get()->toArray();
            return response()->view('dashboard',[
                C::KEY_DONE => true,
                C::KEY_DATA => [
                    'photos' => $photos,
                    'role' => $user->role
                ]
            ]);
        }catch(Exception $e){
            return response()->view('dashboard',[
                C::KEY_DONE => false, 
                C::KEY_MESSAGE => "Si è verificato un errore durante il caricamento del pannello di amministrazione"
            ],500);
        }
    }

    private function filterReportedItems(array $items): array{
        $reported_items = array_filter($items, function($item){
            return ($item->reported == 1 && $item->approved == 1);
        });
        Log::debug("DashboardController filterReportedPhotos => ".var_export($reported_items,true));
        return $reported_items;
    }
}
