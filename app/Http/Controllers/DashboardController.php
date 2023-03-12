<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Interfaces\Constants as C;
use App\Models\Comment;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
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
                $this->addCommentData($comments);
                $reported_comments = $this->filterReportedItems($comments);
                return response()->view('dashboard',[
                    C::KEY_DONE => true,
                    C::KEY_DATA => [
                        'users_subscribed' => $user_subscribed, 
                        'comments' => $comments,
                        'photos' => $photos,
                        'reported_comments' => $reported_comments,
                        'reported_photos' => $reported_photos,
                        'role' => $user->role,
                        'tags' => $this->getPhotoTags($photos)
                    ]
                ]);
            }//if($user->role == "admin"){
            $photos = Photo::where('author_id',$user->id)->get()->toArray();
            $this->photoTagsJsonDecode($photos);
            return response()->view('dashboard',[
                C::KEY_DONE => true,
                C::KEY_DATA => [
                    'photos' => $photos,
                    'role' => $user->role,
                    'username' => $user->name
                ]
            ]);
        }catch(Exception $e){
            Log::error("DashboardController Exception => ".$e->getMessage());
            return response()->view('dashboard',[
                C::KEY_DONE => false, 
                C::KEY_MESSAGE => "Si è verificato un errore durante il caricamento del pannello di amministrazione"
            ],500);
        }
    }

    private function addCommentData(array &$comments){
        foreach($comments as $n => $comment){
            $comment_author = User::find($comment['author_id']);
            $parent_photo = Photo::find($comment['photo_id']);
            if($comment_author != null){
                $comments[$n]['author_name'] = $comment_author->name;
                $comments[$n]['photo_name'] = $parent_photo->name;
            }  
        }
    }

    private function filterReportedItems(array $items): array{
        $reported_items = array_filter($items, function($item){
            return ($item['reported'] == 1 && $item['approved'] == 1);
        });
        Log::debug("DashboardController filterReportedItem => ".var_export($reported_items,true));
        return $reported_items;
    }

    private function getPhotoTags(array $photos): array{
        $tags = [];
        foreach($photos as $photo){
            $photo_tags = json_decode($photo['tags_list'],true);
            $tags = array_merge($tags,$photo_tags);
        }
        $tags = array_unique($tags);
        uasort($tags, function($str1,$str2){
            return strcmp($str1,$str2);
        });
        Log::info("DashboardController getPhotoTags => ".var_export($tags,true)."\r\n");
        return $tags;
    }

    private function photoTagsJsonDecode(array &$photos){
        foreach($photos as $n => $photo){
            $decoded_tags = json_decode($photo['tags_list'],true);
            $photos[$n]['tags_list'] = $decoded_tags;
        }
    }
}
