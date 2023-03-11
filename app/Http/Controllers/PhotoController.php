<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Exception;
use Illuminate\Http\Request;
use App\Interfaces\Constants as C;

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

            }
            else $photos = Photo::all()->toArray();
            return response()->view('welcome',[
                C::KEY_DONE => true, 'photos' => $photos
            ]);
        }catch(Exception $e){
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
