<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Alquiler;
use App\Models\DetalleAlquiler;
use Illuminate\Console\View\Components\Alert;

class AlquilerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $alquileres = Alquiler::all();
            $response = $alquileres->toArray();
            $i=0;
            foreach($alquileres as $alquiler) {
                $response[$i]['user'] = $alquiler->user->toArray();
                $detalle = $alquiler->detalle_alquileres->toArray();
                $f=0;
                foreach($alquiler->detalle_alquileres as $d){
                    $detalle[$f]['auto'] = $d->auto->toArray();
                    $detalle[$f]['auto']['marca'] = $d->auto->marca->toArray();
                    $detalle[$f]['auto']['modelo'] = $d->auto->modelo->toArray();
                    $f++;
                }
                $response[$i]['detalleAlquiler'] = $detalle;
                $i++;
            }
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
        return view('admin.rentas');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $errores = 0;
            DB::beginTransaction();
            //crear la instancia de alquiler
            $alquiler  = new Alquiler();
            $alquiler->correlativo = $this->getCorrelativo();
            $alquiler->fecha_reserva = $request->fechaReserva;
            $alquiler->fecha_alquiler = $request->fechaAlquiler;
            $alquiler->total = $request->total;
            $alquiler->estado = $request->estado;
            $alquiler->observaciones = $request->observaciones;
            $alquiler->user_id = $request->user['id'];
            if($alquiler->save() <=0){
                $errores++;
            }
            //obtener un detalle del alquiler para luego insertarlo en detallealquileres
            $detalle = $request->detalleAlquiler;
            foreach($detalle as $key => $det){
                //creando un objeto de tipo DetalleAlquiler
                $detalleAlquiler = new DetalleAlquiler();
                $detalleAlquiler->dias_alquiler = $det['diasAlquiler'];
                $detalleAlquiler->auto_id = $det['auto']['id'];
                $detalleAlquiler->alquiler_id = $alquiler->id;
                if($detalleAlquiler->save() <=0){
                    $errores++;
                }
            }
            if($errores == 0){
                DB::commit();
                return response()->json(['status' => 'ok', 'data' => $alquiler], 201);
            }else{
                DB::commit();
                return response()->json(['status' => 'fail', 'data' => $alquiler], 409);
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
        try {
            $alquileres = Alquiler::findOrFail($id);
            $response = $alquileres->toArray();
            $i=0;
            foreach($alquileres as $alquiler) {
                $response[$i]['user'] = $alquiler->user->toArray();
                $detalle = $alquiler->detalle_alquileres->toArray();
                $f=0;
                foreach($alquiler->detalle_alquileres as $d){
                    $detalle[$f]['auto'] = $d->auto->toArray();
                    $detalle[$f]['auto']['marca'] = $d->auto->marca->toArray();
                    $detalle[$f]['auto']['modelo'] = $d->auto->modelo->toArray();
                    $f++;
                }
                $response[$i]['detalleAlquiler'] = $detalle;
                $i++;
            }
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
        $errores = 0;
        $alquiler = Alquiler::findOrFail($id);
        if($request->estado == 'A'){
            //cuando se entrega el o los vehiculos al cliente
            $alquiler->estado = $request->estado;
            $alquiler->deposito = $request->deposito;
            $alquiler->observaciones = $request->observaciones;
            if($alquiler->update()<=0){
                $errores++;
            }
            elseif($request->estado == 'D'){
            //cuando el cliente devuelve los vehiculos
            $alquiler->estado = $request->estado;
            $alquiler->fecha_devolucion = $request->fechaDevolucion;
            $alquiler->observaciones = $request->observaciones;
            if($alquiler->update()<=0){
                $errores++;
            }
            $detalle = $request->detalleAlquiler;
            foreach($detalle as $key => $det){
                //creando un objeto de tipo DetalleAlquiler
                $detalleAlquiler = DetalleAlquiler::findOrFail($det['id']);
                $detalleAlquiler->km_salida = $det['kmSalida'];
                $detalleAlquiler->observacion = $det['observacion'];
                if($detalleAlquiler->update()<=0){
                    $errores++;
                }
            }
        }
    }
 }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    //metodo para generar el correlativo del alquiler
    private function getCorrelativo(){
        $result = DB::select("SELECT CONCAT(TRIM(YEAR(CURDATE())),LPAD(TRIM(MONTH(CURDATE())),2,0),LPAD(IFNULL(MAX(TRIM(SUBSTRING(correlativo,7,4))),0)+1,4,0)) as correlativo FROM alquileres WHERE SUBSTRING(correlativo,1,6) = CONCAT(TRIM(YEAR(CURDATE())),LPAD(TRIM(MONTH(CURDATE())),2,0))");
        return $result[0]->correlativo;
    }
    public function showByState(Request $request){
        try{
            $alquileres = Alquiler::where('estado','=',$request->estado)->get();

            $response= $alquileres->toArray();
            $i=0;
            foreach($alquileres as $alquiler){
                $response[$i]['user'] = $alquiler->user->toArray();
                $detalle = $alquiler->detalle_alquileres->toArray();

                $f=0;
                foreach($alquiler->detalle_alquileres as $d){
                    $detalle[$f]['auto'] = $d->auto->toArray();
                    $detalle[$f]['auto']['marca'] = $d->auto->marca->toArray();
                    $detalle[$f]['auto']['modelo'] = $d->auto->modelo->toArray();
                    $f++;
                }
                $response[$i]['detalleAlquiler'] = $detalle;
                $i++;
            }
            return $response;
        }catch(\Exception $e){
            return $e->getMessage();
        }
     
    }
}
