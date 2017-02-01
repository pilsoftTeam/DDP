<?php

namespace App\Http\Controllers;

use App\Asignacion;
use App\Dimension;
use App\Http\Requests\UserCreationRequest;
use App\Perfilamiento;
use App\Perfiles;
use App\Pregunta;
use App\Requisito;
use App\Resultados;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

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

    public function rejectedLoad($id)
    {
        $rejectedload = Resultados::where('idAsignacion', $id)->with('traerPreguntas')->get();


        return response()->json($rejectedload, 200);
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


    public function editarRequisito(Request $request)
    {

        Requisito::where('id', $request->idRequisito)->update([
            'nombreRequisito' => $request->nombreRequisito,
            'idDimension' => $request->idDimension
        ]);

        return response()->json(200);
    }

    public function eliminarRequisito($id)
    {
        $pregunta = Pregunta::where('idRequisito', $id)->value('id');
        $idAsignacion = Resultados::where('idPregunta', $pregunta)->value('idAsignacion');


        Resultados::where('idAsignacion', $idAsignacion)->delete();
        Asignacion::where('id', $idAsignacion)->delete();
        Pregunta::where('idRequisito', $id)->delete();
        Requisito::destroy($id);

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

    public function getPreguntasById($id)
    {
        $preguntas = Pregunta::where('id', $id)->with('obtenerRequisitos')->get();

        return response()->json($preguntas);
    }

    public function getRequisito($id)
    {
        $requisito = Requisito::where('id', $id)->get();
        return response()->json($requisito);

    }


    public function getUsuarios()
    {
        $usuarios = User::where('id', '!=', Auth::user()->id)->where('estado', '!=', 0)->with('getPerfil')->get();

        return response()->json($usuarios);


    }

    public function getRoles()
    {
        $roles = Perfiles::all();
        return response()->json($roles);
    }


    public function createUser(UserCreationRequest $request)
    {
        $user = new User();
        $perfilamiento = new Perfilamiento();
        $password = str_random(12);

        $user->name = $request->nombre;
        $user->email = $request->email;
        $user->password = bcrypt($password);
        $user->estado = true;
        $user->save();

        $perfilamiento->idPerfil = $request->rol;
        $perfilamiento->idUsuario = $user->id;
        $perfilamiento->save();

        return response()->json($password, 200);

    }

    public function editUser(Request $request)
    {
        User::where('id', $request->id)->update([
            'name' => $request->nombre,
            'email' => $request->email,
        ]);

        Perfilamiento::where('idUsuario', $request->id)->update([
            'idPerfil' => $request->rol
        ]);

        return response()->json(200);
    }

    public function deleteUser(Request $request)
    {
        User::where('id', $request->id)->update([
            'estado' => false
        ]);
        return response()->json(200);
    }

    public function deletePregunta($id)
    {
        $idAsignacion = Resultados::where('idPregunta', $id)->value('idAsignacion');

        Asignacion::where('id', $idAsignacion)->update([
            'estado' => 'rechazado'
        ]);

        Resultados::where('idPregunta', $id)->delete();
        Pregunta::where('id', $id)->delete();
        return response()->json(200);

    }

    public function editPregunta(Request $request)
    {
        Pregunta::where('id', $request->id)->update([
            'pregunta' => $request->pregunta,
            'idRequisito' => $request->idRequisito,
            'tecnicaAuditoria' => $request->tecnicaAuditoria,
            'escrita' => $request->escrita,
            'numeral' => $request->numeral,
            'documental' => $request->documental,
        ]);

        return response()->json(200);
    }


}
