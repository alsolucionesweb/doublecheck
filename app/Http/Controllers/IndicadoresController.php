<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Indicadores;
use App\Models\CandidatoIndicador;


class IndicadoresController extends Controller
{    
    private $error = null;
    private $success = null;
    public function index()
    {
        $_SESSION['menu'] = 'administrar';
        
        $this->flashMessages();

        $indicadores = Indicadores::all();
        return view('admin/indicadores', [
            'indicadores' => $indicadores,
            'error' => $this->error,
            'success' => $this->success
        ]);
    }

    public function post(Request $request)
    {        
        //validar indicador repetido

        $valIndicador = Indicadores::where('name', $request->input('name'))->first();
        if ($valIndicador) {            
            $_SESSION['error'] = 'Indicador ya existe.';
            return redirect('/admin/indicadores');
        }
        
        //Validar si el indicador queda activo
        $activo = true;
        if( $request->input('activo') != 'on') {
            $activo = false;
        }

        //Guardar el indicador
        $indicador = new Indicadores();
        $indicador->name = $request->input('name');
        $indicador->estado = $activo; // Por defecto, estado es 1 (activo)
        $indicador->save();

        if($indicador){
            $_SESSION['success'] = 'Indicador creado correctamente.';
        }else{
            $_SESSION['error'] = 'No se pudo crear el indicador, por favor intentelo más tarde.';
        }
        
        return redirect('/admin/indicadores');
    }

    public function put(Request $request)
    {        
        //validar indicador existe
        $indicador = Indicadores::find($request->input('id'));
        if (!$indicador) {            
            $_SESSION['error'] = 'Indicador no existe.';
            return redirect('/admin/indicadores');
        }
        
        //Validar si el indicador queda activo
        $activo = true;
        if( $request->input('activo') != 'on') {
            $activo = false;
        }

        //Actualizar el indicador        
        $indicador->name = $request->input('name');
        $indicador->estado = $activo; // Por defecto, estado es 1 (activo)
        $indicador->save();

        if($indicador){
            $_SESSION['success'] = 'Indicador actualizado correctamente.';
        }else{
            $_SESSION['error'] = 'No se pudo actualizar el indicador, por favor intentelo más tarde.';
        }
        
        return redirect('/admin/indicadores');
    }

    public function delete(Request $request)
    {
        $indicador = Indicadores::find($request->input('id'));
        if (!$indicador) {            
            $_SESSION['error'] = 'Indicador no existe.';
            return redirect('/admin/indicadores');
        }

        $candidatoIndicadores = CandidatoIndicador::where('idIndicador', $indicador->id)
        ->get();

        if(count($candidatoIndicadores) > 0){            
             $candidatoIndicadores = CandidatoIndicador::where('idIndicador', $indicador->id)
            ->delete();

            if(!$candidatoIndicadores ){
                $_SESSION['error'] = 'No se pudo eliminar el indicador para los candidatos, por favor intentelo más tarde.';
                return redirect('/admin/indicadores');
            }

        }        
        
        $indicador->delete();

        if($indicador){
            $_SESSION['success'] = 'Indicador eliminado correctamente.';
        }else{
            $_SESSION['error'] = 'No se pudo eliminar el indicador, por favor intentelo más tarde.';
        }
        
        return redirect('/admin/indicadores');
    }

    private function flashMessages(){
        if(isset($_SESSION['error'])){
            $this->error = $_SESSION['error'];
            unset($_SESSION['error']);
        }

        if(isset($_SESSION['success'])){
            $this->success = $_SESSION['success'];
            unset($_SESSION['success']);
        }
    }
}