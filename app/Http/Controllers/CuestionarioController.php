<?php

namespace App\Http\Controllers;

use App\Requisito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CuestionarioController extends Controller
{


    public function files(Request $request)
    {

        $idDimension = Requisito::where('id', $request->idRequisito)->value('idDimension');
        $ruta = $request->idRegion . '/' . $request->idComuna . '/' . $idDimension . '/' . $request->idRequisito . '/' . $request->idPregunta;
        Storage::makeDirectory($ruta);
        $fileName = $request->documentos->getClientOriginalName();
        $request->documentos->storeAs($ruta, $fileName);
        return response()->json([$request->idPregunta, $ruta], 200);
    }

}
