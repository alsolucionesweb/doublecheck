<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Indicadores;
use App\Models\Semana;
use App\Models\Candidatos;
use App\Models\CandidatoIndicador;
use Illuminate\Support\Facades\DB;

class CandidatoIndicadorController extends Controller
{
    private $error = null;
    private $success = null;
    public function index($id)
    {        
        $_SESSION['menu'] = 'administrar';

        $this->flashMessages();

        $candidatos = Candidatos::all();
        $semana = Semana::find($id);
        return view('admin/semana_candidatos', [
            'candidatos' => $candidatos,
            'semana' => $semana,
            'error' => $this->error,
            'success' => $this->success
        ]);
    }

    public function indicadoresCandidato($idSemana, $id)
    {
        $indicadores = Indicadores::leftJoin('candidato_indicador as ci', function($join) use ($idSemana,$id) {
            $join->on('indicadores.id', '=', 'ci.idIndicador')
                ->where('ci.idCandidato', '=', $id)
                ->where('ci.idSemana', '=', $idSemana);
        })
        ->select('indicadores.name', 'indicadores.id as idIndicador','ci.valor')
        ->orderBy('indicadores.id', 'asc')
        ->get();

        return response()->json(['indicadores' => $indicadores]);
    }

    public function post(Request $request)
    {        
        $datos = $request->all();
        //dd($datos);
        $idCandidato = $request->input('idCandidato');
        $idSemana = $request->input('idSemana');

        foreach ($datos as $key => $value) {
            $valIndicador = explode("_", $key);
            if(count($valIndicador) > 1){
                 $indicador = CandidatoIndicador::where('idCandidato', $idCandidato)
                    ->where('idIndicador', $valIndicador[1])
                    ->where('idSemana', $idSemana)
                    ->first();
                if($indicador){
                    $indicador = CandidatoIndicador::find($indicador->id);
                }else{
                    $indicador = new CandidatoIndicador();
                    $indicador->idIndicador = $valIndicador[1];
                    $indicador->idCandidato = $idCandidato;
                    $indicador->idSemana = $idSemana;

                }
                $indicador->valor = $value;
                $indicador->save();                
            }
        }

        $_SESSION['success'] = 'Indicadores guardados correctamente.';
        return redirect('/admin/semanas/'.$idSemana);
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