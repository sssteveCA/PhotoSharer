<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Exception;
use Illuminate\Http\Request;
use App\Interfaces\Constants as C;
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
            $tags = $request->query('tags');
            if($tags && $tags != ""){
                $tags_array = explode(',',$tags);
            }
            else $photos_query = Photo::where('approved',1)->get();
            $photos = [];
            $photo_dir = __DIR__."/../../../resources/images";
            foreach($photos_query as $photo_query){
                $user = User::firstWhere('id',$photo_query->author_id);
                if($user != null){
                    $image_path = $photo_dir."/{$user->name}/{$photo_query->name}";
                    if(file_exists($image_path) && is_file($image_path)){
                        $photos[] = [
                            'user' => $user->name, 'file' => $photo_query->name
                        ];
                    }//if(file_exists($image_path) && is_file($image_path)){
                }//if($user != null){
            }//foreach($photos_query as $photo_query){
            return response()->view('welcome',[
                C::KEY_DONE => true, 'photos' => $photos
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
