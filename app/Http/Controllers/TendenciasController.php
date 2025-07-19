<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Tendencias;

class TendenciasController extends Controller
{
    private $error = null;
    private $success = null;
    public function index()
    {
        $this->flashMessages();

        $tendencias = Tendencias::all();
        return view('admin/tendencias', [
            'tendencias' => $tendencias,
            'error' => $this->error,
            'success' => $this->success
        ]);
    }

    public function post(Request $request)
    {        
        //validar tendencia repetido

        $valIndicador = Tendencias::where('titulo', $request->input('titulo'))->first();
        if ($valIndicador) {            
            $_SESSION['error'] = 'Tendencia ya existe.';
            return redirect('/admin/tendencias');
        }
        
        //Validar si la tendencia queda activo
        $activo = true;
        if( $request->input('activo') != 'on') {
            $activo = false;
        }

        //Guardar la tendencia
        $tendencia = new Tendencias();
        $tendencia->titulo = $request->input('titulo');
        $tendencia->contenido = $request->input('contenido');
        $tendencia->estado = $activo; // Por defecto, estado es 1 (activo)
        $tendencia->save();

        if($tendencia){
            $_SESSION['success'] = 'Tendencia creada correctamente.';
        }else{
            $_SESSION['error'] = 'No se pudo crear la tendencia, por favor intentelo más tarde.';
        }
        
        return redirect('/admin/tendencias');
    }

    public function put(Request $request)
    {        
        //validar tendencia existe
        $tendencia = Tendencias::find($request->input('id'));
        if (!$tendencia) {            
            $_SESSION['error'] = 'Tendencia no existe.';
            return redirect('/admin/tendencias');
        }
        
        //Validar si la tendencia queda activo
        $activo = true;
        if( $request->input('activo') != 'on') {
            $activo = false;
        }

        //Actualizar el tendencia        
        $tendencia->titulo = $request->input('titulo');
        $tendencia->contenido = $request->input('contenido');
        $tendencia->estado = $activo; // Por defecto, estado es 1 (activo)
        $tendencia->save();

        if($tendencia){
            $_SESSION['success'] = 'Tendencia actualizada correctamente.';
        }else{
            $_SESSION['error'] = 'No se pudo actualizar la tendencia, por favor intentelo más tarde.';
        }
        
        return redirect('/admin/tendencias');
    }

    public function delete(Request $request)
    {
        $tendencia = Tendencias::find($request->input('id'));
        if (!$tendencia) {            
            $_SESSION['error'] = 'Tendencia no existe.';
            return redirect('/admin/tendencias');
        }          
        
        $tendencia->delete();

        if($tendencia){
            $_SESSION['success'] = 'Tendencia eliminada correctamente.';
        }else{
            $_SESSION['error'] = 'No se pudo eliminar la tendencia, por favor intentelo más tarde.';
        }
        
        return redirect('/admin/tendencias');
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