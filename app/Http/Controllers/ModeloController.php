<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use Illuminate\Http\Request;

class ModeloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //devolver una lista de registros
        try{
            $modelos = Modelo::all();
            return $modelos;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return "Vista para crear marcas";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $modelo = new Modelo();
            $modelo->nombre = $request->nombre;
 
            if($modelo->save() >= 1){
             return response()->json(['status'=>'ok','data'=>$modelo],201);
            }else{
             return response()->json(['status'=>'fall','data'=>null],409);
            }
         }catch(\Exception $e){
             return $e->getMessage();
         }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $modelo = Modelo::findOrFail($id);
            return $modelo;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $modelo = Modelo::findOrFail($id);
            $modelo->nombre = $request->nombre;
            if($modelo->update() >= 1){
             return response()->json(['status'=>'ok','data'=>$modelo],202);
            }
         }catch(\Exception $e){
             return $e->getMessage();
         }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $modelo = Modelo::findOrFail($id);
            if($modelo->delete() >= 1){
             return response()->json(['status'=>'ok','data'=>$modelo],200);
            }
         }catch(\Exception $e){
             return $e->getMessage();
         }
    }
}
