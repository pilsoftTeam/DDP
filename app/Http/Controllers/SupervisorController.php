<?php

namespace App\Http\Controllers;

use App\Asignacion;
use App\Comunas;
use App\Dimension;
use App\Oficinas;
use App\Perfilamiento;
use App\Regiones;
use App\Resultados;
use Carbon\Carbon;
use Chumper\Zipper\Facades\Zipper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;


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

    public function getDataForReportes()
    {
        $data = Oficinas::with('getComuna', 'getReportesAsignaciones')->get();
        return response()->json($data, 200);
    }

    public function getReportesDocs($id)
    {

        $preguntas = Resultados::where('idAsignacion', $id)->with('traerPreguntas')->get();
        $idOficina = Asignacion::where('id', $id)->value('idOficinaAsignada');
        $idComuna = Oficinas::where('id', $idOficina)->value('idComuna');
        $comuna = Comunas::where('id', $idComuna)->value('nombreComuna');
        $idRegion = Comunas::where('id', $idComuna)->value('idRegion');
        $region = Regiones::where('id', $idRegion)->value('nombreRegion');


        Excel::create('Revision_' . $comuna . '_' . $region . '_' . Carbon::now(), function ($excel) use ($preguntas) {

            // Set the title
            $excel->setTitle(Carbon::now());
            $excel->sheet('Revision', function ($sheet) use ($preguntas) {

                $sheet->row(1, array(
                    'Preguntas', 'Cumplimiento', 'requisito', 'Dimension',
                ));
                foreach ($preguntas as $key => $value) {
                    $index = $key + 3;
                    $sheet->row($index, [
                        $value->getPreguntas['pregunta'],
                        $value->cumplimiento == 1 ? 'Cumple' : 'No cumple',
                        $value->getPreguntas->obtenerRequisitos['nombreRequisito'],
                        $value->getPreguntas->obtenerRequisitos->obtenerDimensiones['dimension'],
                    ]);
                    $index + 2;
                }

            });

        })->download('xlsx');

    }


}
