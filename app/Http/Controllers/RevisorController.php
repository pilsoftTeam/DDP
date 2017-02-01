<?php

namespace App\Http\Controllers;

use App\Asignacion;
use App\Events\SendMail;
use App\Oficinas;
use App\Resultados;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class RevisorController extends Controller
{

    public function getRevisorAsignaciones()
    {
        $asignaciones = Asignacion::where('idUsuarioAsignado', Auth::user()->id)
            ->where('estado', 'asignado')
            ->orWhere('estado', 'rechazado')
            ->with('getOficinasAsignadas')->get();

        return response()->json($asignaciones, 200);
    }

    public function terminar(Request $request)
    {


        $idAsignacion = $request->oficina['id'];
        $idSupervisor = $request->oficina['idUsuarioAsignador'];


        foreach ($request->preguntas as $item) {
            $resultado = new Resultados();
            $resultado->idAsignacion = $idAsignacion;
            $resultado->idPregunta = $item['idPregunta'];
            $resultado->cumplimiento = $item['opcion'];
            $resultado->observacionNumeral = empty($item['inputNumeral']) ? null : $item['inputNumeral'];
            $resultado->observacionEscrita = empty($item['inputEscrito']) ? null : $item['inputEscrito'];
            $resultado->rutaObservacionDocumental = empty($item['rutaObservaciones']) ? null : $item['rutaObservaciones'];
            $resultado->save();

            Asignacion::where('id', $idAsignacion)->update([
                'estado' => 'revisado'
            ]);
        }



        Event::fire(new SendMail($idSupervisor, $request->all()));

        return response()->json(200);

    }
}
