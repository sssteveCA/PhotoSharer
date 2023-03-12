<?php

namespace App\Http\Controllers;

use App\Exceptions\ResourceNotFoundException;
use App\Models\Photo;
use Exception;
use Illuminate\Http\Request;
use App\Interfaces\Constants as C;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $photos = [];
            $tags_array = [];
            $tags = $request->query('tags');
            if($tags && $tags != ""){
                $tags_array = explode(',',$tags);
            }
            $photos_query = Photo::all();
            Log::debug("PhotoController index => ".var_export($tags_array,true));
            $photos = $this->setPhotosArray($photos_query,$tags_array);
            return response()->view('welcome',[
                C::KEY_DONE => true,
                C::KEY_DATA => [
                    'photos' => $photos
                ]
            ]);
        }catch(Exception $e){
            Log::error("PhotoController Exception => ".$e->getMessage());
            return response()->view('welcome',[
                C::KEY_DONE => false, C::KEY_MESSAGE => 'Errore durante il caricamento delle immagini'
            ],500);
        }
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
        try{
            $photo = Photo::find($id);
            if($photo != null){
                $user = User::find($photo->author_id);
                if($user != null){
                    $comments = Comment::where('photo_id',$id)
                        ->orderBy('creation_date')
                        ->get()->toArray();
                    $this->addCommentAuthorName($comments);
                    return view('photos.show',[
                            C::KEY_DONE => true,
                            C::KEY_DATA => [
                                'author' => $user->name,
                                'comments' => $comments,
                                'photo' => $photo,
                                'src' => "/photo_resource/{$user->name}/{$photo->name}"
                            ]
                    ]);
                }//if($user != null){
            }//if($photo != null){
            throw new ResourceNotFoundException;
        }catch(Exception $e){
            Log::error("PhotoController show Exception => ".$e->getMessage());
            session()->put('redirect','1');
            return redirect()->route('fallback');
        }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function addCommentAuthorName(array &$comments){
        foreach($comments as $n => $comment){
            $comment_author = User::where('id',$comment['author_id'])->first();
            if($comment_author != null){
                $comments[$n]['author_name'] = $comment_author->name;
            }  
        }
    }

    private function setPhotosArray(Collection $photos_query, array $tags = []): array{
        $photos = [];
        $photo_dir = __DIR__."/../../../resources/images";
        foreach($photos_query as $photo_query){
            $user = User::firstWhere('id',$photo_query->author_id);
            if($user != null){
                $image_path = $photo_dir."/{$user->name}/{$photo_query->name}";
                if(file_exists($image_path)){
                    if(is_file($image_path)){
                        $auth_user = Auth::user();
                        if($photo_query->approved == 1 || 
                        ($auth_user != null && ($auth_user->role == "admin" || $photo_query->approved == 0 && $auth_user->id == $photo_query->author_id))){
                            if(empty($tags)){
                                $photos[] = [ 
                                    "id" => $photo_query->id,
                                    "src" => "/photo_resource/{$user->name}/{$photo_query->name}"
                                ];
                            }//if(empty($tags)){
                            else{
                                $photo_tags = json_decode($photo_query->tags_list,true);
                                if(empty(array_diff($tags,$photo_tags))){
                                    $photos[] = [ 
                                        "id" => $photo_query->id,
                                        "src" => "/photo_resource/{$user->name}/{$photo_query->name}"
                                    ];
                                }
                            }//else of if(empty($tags)){
                        }//if($photo_query->approved == 1 || $auth_user->role == "admin" || ($photo_query->approved == 0 && $auth_user->id == $photo_query->author_id)){
                        
                    }//if(is_file($image_path)){
                }//if(file_exists($image_path)){
                //else $photo_query->delete();
            }//if($user != null){
        }//foreach($photos_query as $photo_query){
        return $photos;
    }

}
