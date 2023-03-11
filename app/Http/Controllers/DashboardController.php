<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Interfaces\Constants as C;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //

    public function show(Request $request){
        try{
            $user = Auth::user();
            return response()->view('dashboard',[
                C::KEY_DONE => true, 'user' => $user
            ]);
        }catch(Exception $e){
            return response()->view('dashboard',[
                C::KEY_DONE => false, 
                C::KEY_MESSAGE => "Si è verificato un errore durante il caricamento del pannello di amministrazione"
            ],500);
        }
    }
}
