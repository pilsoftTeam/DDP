<?php

namespace App\Http\Controllers;

use App\Asignacion;
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
}
