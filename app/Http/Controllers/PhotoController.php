<?php

namespace App\Http\Controllers;

use App\Exceptions\ResourceNotFoundException;
use App\Models\Photo;
use Exception;
use Illuminate\Http\Request;
use App\Interfaces\Constants as C;
use App\Models\Comment;
use App\Models\User;
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
            $photo_dir = __DIR__."/../../../resources/images";
            $tags = $request->query('tags');
            if($tags && $tags != ""){
                $tags_array = explode(',',$tags);
            }
            else $photos_query = Photo::where('approved',1)->get();
            foreach($photos_query as $photo_query){
                $user = User::firstWhere('id',$photo_query->author_id);
                if($user != null){
                    $image_path = $photo_dir."/{$user->name}/{$photo_query->name}";
                    if(file_exists($image_path)){
                        if(is_file($image_path)){
                            $photos[] = [ 
                                "id" => $photo_query->id,
                                "src" => "/photo_resource/{$user->name}/{$photo_query->name}"
                            ];
                        }//if(is_file($image_path)){
                    }//if(file_exists($image_path)){
                    //else $photo_query->delete();
                }//if($user != null){
            }//foreach($photos_query as $photo_query){
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
                $comments = Comment::where('photo_id',$id)
                    ->orderBy('creation_date')
                    ->get()->toArray();
                    return view('photos.show',[
                            C::KEY_DONE => true,
                            C::KEY_DATA => [
                                'photo' => $photo,
                                'comments' => $comments
                            ]
                    ]);
            }//if($photo != null){
            throw new ResourceNotFoundException;
        }catch(Exception $e){
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
}
