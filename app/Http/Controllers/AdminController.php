<?php

namespace App\Http\Controllers;

use App\Dimension;
use App\Perfiles;
use App\Pregunta;
use App\Requisito;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class AdminController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('modulos/admin');
    }

    public function initLoad()
    {
        $dimensiones = Dimension::with('getRequisitos')->get();
        return response()->json($dimensiones, 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createDimension(Request $request)
    {

        $ordenDimension = Dimension::orderBy('created_at', 'desc')->value('ordenDimension');
        $dimension = new Dimension();

        if (!$ordenDimension) {
            $dimension->ordenDimension = 1;
            $dimension->dimension = $request->nombreDimension;
            $dimension->estado = false;
            $dimension->save();
            return response()->json(200);
        }

        $dimension->ordenDimension = $ordenDimension + 1;
        $dimension->dimension = $request->nombreDimension;
        $dimension->estado = false;
        $dimension->save();
        return response()->json(200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createRequisito(Request $request)
    {
        $ordenRequisito = Requisito::orderBy('created_at', 'desc')->value('ordenRequisito');
        $requisito = new Requisito();


        if (!$ordenRequisito) {
            $requisito->ordenRequisito = 1;
            $requisito->idDimension = $request->idDimension;
            $requisito->NombreRequisito = $request->nombreRequisito;
            $requisito->estado = false;
            $requisito->save();
            return response()->json(200);
        }

        $requisito->ordenRequisito = $ordenRequisito + 1;
        $requisito->idDimension = $request->idDimension;
        $requisito->NombreRequisito = $request->nombreRequisito;
        $requisito->estado = false;
        $requisito->save();

        return response()->json(200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createPregunta(Request $request)
    {

        $ordenPregunta = Pregunta::orderBy('created_at', 'desc')->value('ordenPreguntas');
        $pregunta = new Pregunta();

        if (!$ordenPregunta) {
            $pregunta->idRequisito = $request->idRequisito;
            $pregunta->ordenPreguntas = 1;
            $pregunta->pregunta = $request->pregunta;
            $pregunta->tecnicaAuditoria = $request->tecnicaAuditoria;
            $pregunta->escrita = $request->escrita;
            $pregunta->numeral = $request->numeral;
            $pregunta->documental = $request->documental;
            $pregunta->estado = false;
            $pregunta->save();

            return response()->json(200);

        }

        $pregunta->idRequisito = $request->idRequisito;
        $pregunta->ordenPreguntas = $ordenPregunta + 1;
        $pregunta->pregunta = $request->pregunta;
        $pregunta->tecnicaAuditoria = $request->tecnicaAuditoria;
        $pregunta->escrita = $request->escrita;
        $pregunta->numeral = $request->numeral;
        $pregunta->documental = $request->documental;
        $pregunta->estado = false;
        $pregunta->save();

        return response()->json(200);


    }

    public function getPreguntas($id)
    {
        $preguntas = Pregunta::where('idRequisito', $id)->orderBy('ordenPreguntas', 'asc')->with('obtenerRequisitos')->get();

        return response()->json($preguntas, 200);
    }


    public function getUsuarios()
    {
        $usuarios = User::with('getPerfil')->get();

        return response()->json($usuarios);


    }

    public function getRoles()
    {
        $roles = Perfiles::all();
        return response()->json($roles);
    }


}
