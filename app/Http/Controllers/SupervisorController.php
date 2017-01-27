<?php

namespace App\Http\Controllers;

use App\Asignacion;
use App\Oficinas;
use App\Perfilamiento;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class SupervisorController extends Controller
{
    public function getRevisores()
    {
        $revisores = Perfilamiento::where('idPerfil', '!=', 1)->with('getUsuario', 'getNombrePerfil')->get();

        return response()->json($revisores, 200);
    }

    public function getOficinas()
    {
        $oficinas = Oficinas::with('getAsignaciones')->get();
        return response()->json($oficinas, 200);
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
        $asignaciones = Asignacion::with('getOficinasAsignadas', 'getCreador', 'getRealizador', 'getCuestionarioRealizado')->get();

        return response()->json($asignaciones);
    }


    public function getAsignacionesRevisadas()
    {

    }

}
