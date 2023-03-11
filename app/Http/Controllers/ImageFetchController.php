<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ImageFetchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request,$name,$file)
    {
        try{
            $user = User::where('name',$name)->first();
            if($user != null){
                $photo = Photo::where('author_id',$user->id)
                    ->where('name',$file)
                    ->where('approved',1)->first();
                if($photo != null){
                    $photo_dir = __DIR__."/../../../resources/images";
                    $image_path = $photo_dir."/{$name}/{$file}";
                    if(file_exists($image_path)){
                        if(is_file($image_path)){
                            return response()->file($image_path);
                        }
                    }//if(file_exists($image_path)){
                    else $photo->delete();
                }//if($photo != null){
            }//if($user != null){
            session()->put('redirect','1');
            return redirect()->route('fallback');
        }catch(Exception $e){
            session()->put('redirect','1');
            return redirect()->route('fallback');
        }
        
    }
}
