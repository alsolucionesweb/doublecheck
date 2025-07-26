<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidatos;
use App\Models\CandidatoIndicador;
use App\Models\Semana;

class SemanaController extends Controller
{
    private $error = null;
    private $success = null;
    public function index()
    {
        $_SESSION['menu'] = 'administrar';
        
        $this->flashMessages();

        $semanas = Semana::all();
        return view('admin/semanas', [
            'semanas' => $semanas,
            'error' => $this->error,
            'success' => $this->success
        ]);
    }

    public function post(Request $request)
    {        
        //validar indicador repetido

        $valSemana = Semana::where('name', $request->input('name'))->first();
        if ($valSemana) {            
            $_SESSION['error'] = 'Semana ya existe.';
            return redirect('/admin/semanas');
        }
        
        //Validar si la semana queda activa
        $activo = true;
        if( $request->input('activo') != 'on') {
            $activo = false;
        }

        //Guardar la semana
        $semana = new Semana();
        $semana->name = $request->input('name');
        $semana->fecha_inicio = $request->input('inicio');
        $semana->fecha_fin = $request->input('fin');
        $semana->estado = $activo; // Por defecto, estado es 1 (activo)
        $semana->save();

        if($semana){
            $_SESSION['success'] = 'Semana creada correctamente.';
        }else{
            $_SESSION['error'] = 'No se pudo crear la semana, por favor intentelo más tarde.';
        }
        
        return redirect('/admin/semanas');
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
