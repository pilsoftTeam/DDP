<?php

namespace App\Http\Controllers;

use App\Asignacion;
use App\Oficinas;
use App\Resultados;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class RevisorController extends Controller
{

    public function getRevisorAsignaciones()
    {
        $asignaciones = Asignacion::where('idUsuarioAsignado', Auth::user()->id)->with('getOficinasAsignadas')->get();

        return response()->json($asignaciones, 200);
    }

    public function terminar(Request $request)
    {

        foreach ($request->preguntas as $item) {
            $resultado = new Resultados();
            $resultado->idPregunta = $item['idPregunta'];
            $resultado->cumplimiento = $item['opcion'];
            $resultado->observacionNumeral = empty($item['inputNumeral']) ? null : $item['inputNumeral'];
            $resultado->observacionEscrita = empty($item['inputEscrito']) ? null : $item['inputNumeral'];
            $resultado->rutaObservacionDocumental = null;
            $resultado->save();
        }

        Oficinas::where('id', $request->oficina['idOficinaAsignada'])->update([
            'estado' => 'revisado'
        ]);


        return response()->json(200);
    }

}
