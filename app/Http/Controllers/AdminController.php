<?php

namespace App\Http\Controllers;

use App\Dimension;
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            return response()->json('Exito', 200);
        }

        $dimension->ordenDimension = $ordenDimension + 1;
        $dimension->dimension = $request->nombreDimension;
        $dimension->estado = false;
        $dimension->save();
        return response()->json($ordenDimension, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
