<?php

namespace App\Http\Controllers;

use App\Dimension;
use App\Oficinas;
use App\Pregunta;
use App\Requisito;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class CuestionarioController extends Controller
{
    public $oficina;
    public $dimension;
    public $requisito;
    public $pregunta;


    public function files(Request $request)
    {
        $this->oficina = Oficinas::where('id', $request->data)->value('region');
        $datosPregunta = Pregunta::where('id', $request->idPregunta)->with('obtenerRequisitos')->get();


        foreach ($datosPregunta as $dato) {
            $this->pregunta = $dato->pregunta;
            $idRequisito = $dato->idRequisito;
        }
        $idParaDimension = Requisito::where('id', $idRequisito)->get();
        foreach ($idParaDimension as $id) {
            $this->requisito = $id->nombreRequisito;
            $idDimension = $id->idDimension;
        }
        $this->dimension = Dimension::where('id', $idDimension)->value('dimension');
        $dimension = preg_replace("/[^a-zA-Z0-9]+/", " ", $this->dimension);
        $nombreRequisito = preg_replace("/[^a-zA-Z0-9]+/", " ", $this->requisito);
        $pregunta = preg_replace("/[^a-zA-Z0-9]+/", " ", $this->pregunta);
        Storage::makeDirectory($this->oficina . '/' . $dimension . '/' . $nombreRequisito . '/' . $pregunta);


        $fileName = $request->documentos->getClientOriginalName();
        $request->documentos->storeAs($this->oficina . '/' . $dimension . '/' . $nombreRequisito . '/' . $pregunta, $fileName);


        return response()->json([$request->idPregunta, $this->oficina . '/' . $dimension . '/' . $nombreRequisito . '/' . $pregunta], 200);
    }

}
