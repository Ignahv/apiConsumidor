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

    public function index(Request $request)
    {
        $scrap = "";
        $a = 0;

        do {
            $scrap = $this->scrap($scrap, $a);
        } while ($scrap != null);
        
        return response()->json("", 201);
    }

    public function scrap($scrap, $a)
    {
        $response = Http::get("http://168.121.81.28:8080/backend/api/procesos/1/tramites?token=LCl2o5%vZ5Mb%Q@ZyTZPlxDxUS2Qwrq5&maxResults=20" . $scrap);

        $tramiteBody = $response->object();

        $token = collect($tramiteBody->tramites->nextPageToken)->values();
        $token = str_replace(["[","\"","]"], "", $token);

        if ($a == 0) {
            $nextPage = "&pageToken=" . $token;
            $a = 1;
        } else {
            $nextPage = null;
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

        return $nextPage;
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

        if (!isset($id)) {
            $update = Tramite::find($update->id);
        } else {
            $update = false;
        }

        return $update;
    }*/

    // {clase($x=null)
    //->&pageToken{$i}}
}
 