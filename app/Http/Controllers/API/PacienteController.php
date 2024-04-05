<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActualizarPacienteRequest;
use App\Http\Requests\GuardarPacienteRequest;
use App\Http\Resources\PacienteResource;
use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return PacienteResource::collection(Paciente::paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuardarPacienteRequest $request)
    {
        $validatedData = $request->validated();

        try {
            
            return (new PacienteResource(Paciente::create($validatedData)))->additional(['msg' => 'Paciente registrado']);

        } catch (\Exception $e) {
            return response()->json([
                'res' => false,
                'msg' => 'Hubo un problema al guardar el paciente: ' . $e->getMessage()
            ], 500);
        }

        /*         return response()->json([
            'res' => true,
            'msg' => 'Guardado correctamente'
        ]); */
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $paciente = Paciente::find($id);

        if (!$paciente) {
            return response()->json(["res" => false, "error" => "Paciente no encontrado"], 404);
        }

        /*         return response()->json([
            'res' => true,
            'paciente' => $paciente
        ]);    */

        return new PacienteResource($paciente);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(ActualizarPacienteRequest $request, Paciente $paciente)
    {
        /*         return response()->json([
            'res' => true,
            'mensaje' => 'paciente actualizado',
            'paciente' => $paciente
        ]); */

        $paciente->update($request->all());
        return (new PacienteResource($paciente))
                ->additional(['msg' => 'Los datos del paciente han sido actualizados'])
                ->response()
                ->setStatusCode(202);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paciente $paciente)
    {
        $paciente->delete();
        return (new PacienteResource($paciente))->additional(['msg' => 'El paciente ha sido borrado']);
        /*         return response()->json([
            'res' => true,
            'mensaje' => 'paciente eliminado',
        ]); */
    }
}
