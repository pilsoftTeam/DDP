<?php

namespace App\Http\Controllers;

use App\Asignacion;
use App\Dimension;
use App\Perfilamiento;
use App\Regiones;
use Chumper\Zipper\Facades\Zipper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class SupervisorController extends Controller
{

    public function getRevisores()
    {
        $revisores = Perfilamiento::where('idPerfil', '!=', 1)->with('getUsuario', 'getNombrePerfil')->get();

        return response()->json($revisores, 200);
    }

    public function getOficinas()
    {
        $oficinasRegiones = Regiones::with('getComunas')->get();
        return response()->json($oficinasRegiones, 200);
    }

    public function createAsignacion(Request $request)
    {

        $asignacion = new Asignacion();
        $asignacion->idUsuarioAsignado = $request->idUsuario;
        $asignacion->idUsuarioAsignador = Auth::user()->id;
        $asignacion->idOficinaAsignada = $request->idOficina;
        $asignacion->estado = 'asignado';
        $asignacion->save();

        return response()->json(200);
    }

    public function getAsignaciones()
    {
        $asignaciones = Asignacion::where('estado', '!=', 'rechazado')->with('getOficinasAsignadas', 'getCreador', 'getRealizador', 'getCuestionarioRealizado')->get();
        return response()->json($asignaciones);
    }


    public function getAsignacionesRevisadas()
    {
        $preguntas = Dimension::with('getRequisitos')->get();
        $asignacion = Asignacion::where('estado', 'revisado')->with('getOficinasAsignadas', 'getCreador', 'getRealizador', 'getCuestionarioRealizado')->get();


        return response()->json([$asignacion, $preguntas], 200);
    }

    public function getDocs(Request $request)
    {
        $files = glob(storage_path() . '/app/' . $request->ruta . '/*');
        Zipper::make(storage_path() . '/app/zip.zip')->add($files)->close();

        return response()->download(storage_path() . '/app/zip.zip')->deleteFileAfterSend(true);


    }

    public function end(Request $request)
    {

        if ($request->opcion === 'aprobado') {
            Asignacion::where('id', $request->idAsignacion)->update([
                'estado' => 'terminado',
                'idSupervisorRevisor' => Auth::user()->id,
                'observaciones' => $request->observacion

            ]);
        } else {
            Asignacion::where('id', $request->idAsignacion)->update([
                'estado' => 'rechazado',
                'idSupervisorRevisor' => Auth::user()->id,
                'observaciones' => $request->observacion
            ]);
        }


        return response()->json(200);
    }


}
