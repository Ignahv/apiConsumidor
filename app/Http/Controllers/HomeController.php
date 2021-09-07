<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\Tramite;
use App\Http\Controllers\Validator;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $response = Http::get('http://168.121.81.28:8080/backend/api/procesos/1/tramites?token=LCl2o5%vZ5Mb%Q@ZyTZPlxDxUS2Qwrq5');
        $tramites = $response->json();
        
        $items = $tramites['tramites']['items'];

        $hola=[];
        for( $i=0; $i<count($items); $i++){
            
            $hola[$i] = $items[$i]['id'];

        }
        

        return response()->json($hola);
    }
}
