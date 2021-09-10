<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
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
        $scrap = "";
        $a = 0;

        do {

            $response = Http::get("http://168.121.81.28:8080/backend/api/procesos/1/tramites?token=LCl2o5%vZ5Mb%Q@ZyTZPlxDxUS2Qwrq5&maxResults=1" . $scrap);

            $scrap = $this->scrap($response, $a);
        } while ($scrap != null);
        
        return response()->json($scrap, 201);
    }

    public function scrap($response, $a): string
    {
        $tramiteBody = $response->object();

        //$token = $tramiteBody->tramites->nextPageToken->values();
        if ($a == 0) {
            $token = "&pageToken=NDQ2OA%3D%3D";
            $a = 1;
        } else {
            $token = null;
        }

        $responseItem = $tramiteBody->tramites->items;

        foreach ($responseItem as $item) {
            $tramite = collect($item->datos);
            $idtramite = $item->id;
            $fondo = '0';
            $etapa = $item->etapas[0]->tarea->nombre;
            $rbd = '0';

            for ($i = 0; $i < $tramite->count() ; $i++) { 
                $valida = collect($tramite[$i]);

                if ( $valida->get('director_fondo') ) {
                    $fondo = $valida->values();
                }
                if ( $valida->get('solicitud_rbd') ) {
                    $rbd = $valida->values();
                }
            }

            $this->store($idtramite, $rbd, $etapa, $fondo);
        }

        return $token;
    }

    public function store($id, $rbd, $etapa, $fondo)
    {   
        $value = new Tramite();
            
        $value->idtramites = $id;
        $value->rbd = $rbd;
        $value->estado = $etapa;
        $value->fondo = $fondo;

        $value->save();
    } 

    
    
    

    /*public function noGet($id)
    {
        $update = Tramite::where('idtramites', $id)->firstOrFail();

        if (!isset($si)) {
            $update = Tramite::find($update->id);
        } else {
            $update = false;
        }

        return $update->id;
    } */
    
    
   // {clase($x=null)
    //->&pageToken{$i}}
}
 