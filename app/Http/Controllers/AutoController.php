<?php

namespace App\Http\Controllers;

use App\Models\Auto;
use Illuminate\Http\Request;

class AutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $autos = Auto::all();
            //convirtiendo a array
            $response = $autos->toArray();
            $i = 0;
            foreach($autos as $auto) {
                $response[$i]["marca"] = $auto->marca->toArray();
                $response[$i]["modelo"] = $auto->modelo->toArray();
                $i++;
            }
            //dd($response);
            return $response;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.autos');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $auto = new Auto();
            $auto->placa = $request->placa;
            $auto->tipo = $request->tipo;
            $auto->anio = $request->anio;
            $auto->precio_alquiler = $request->precio_alquiler;
            $auto->imagen = $request->imagen;
            $auto->estado = $request->estado;
            $auto->marca_id = $request->marca['id'];
            $auto->modelo_id = $request->modelo['id'];
            if ($auto->save() >= 1) {
                return response()->json(['status' => 'ok', 'data' => $auto], 201);
            } else {
                return response()->json(['status' => 'fall', 'data' => null], 409);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $auto = Auto::findOrFail($id);
            $response = $auto->toArray();
            $response["marca"] = $auto->marca->toArray();
            $response["modelo"] = $auto->modelo->toArray();
            //dd($response);
            return $response;
        } catch (\Exception $e) {
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
        try {
            $auto =  Auto::findOrFail($id);
            $auto->placa = $request->placa;
            $auto->tipo = $request->tipo;
            $auto->anio = $request->anio;
            $auto->precio_alquiler = $request->precio_alquiler;
            $auto->imagen = $request->imagen;
            $auto->estado = $request->estado;
            $auto->marca_id = $request->marca['id'];
            $auto->modelo_id = $request->modelo['id'];
            if ($auto->update() >= 1) {
                return response()->json(['status' => 'ok', 'data' => $auto], 201);
            } else {
                return response()->json(['status' => 'fall', 'data' => null], 409);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $auto = Auto::findOrFail($id);
            if ($auto->delete() >= 1) {
                return response()->json(['status' => 'ok', 'data' => null], 201);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
