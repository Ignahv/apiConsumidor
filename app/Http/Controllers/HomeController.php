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

        for( $i=0; $i<count($items); $i++){
            
            $idtramite = $items[$i]['id'];
            $etapa = $items[$i]['etapas'][0]['estado'];

            $datos = $items[$i]['datos'];
            if(isset($datos)){

                
                foreach ($datos as $fondo){
                    if(isset($fondo['director_fondo'])){
                        $pp = $fondo['director_fondo'];
                    }else{
                        $pp = '0';
                    }
                }
            }else{
                
                $datos[$i] = ['null'];
                $pp = '0';
            }
            
            $value = new Tramite();
            
            $value->idtramites = $tramites->$idtramite;
            $value->etapa = $tramites->$etapa;
            $value->fondo = $tramites->$pp;

            $value->save();
            //Tramite::create([$idtramite, $etapa, $pp]);
           //DB::insert('insert into tramites (idtramite, etapa, fondo)values (?,?,?)', [$idtramite, $etapa, $pp]);
        }

        return response()->json([$idtramite, $etapa, $pp]);
    }
}
 