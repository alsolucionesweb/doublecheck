<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Indicadores;
use App\Models\CandidatoIndicador;
use Illuminate\Support\Facades\DB;

class CandidatoIndicadorController extends Controller
{
    private $error = null;
    private $success = null;
    public function index()
    {
        //
    }

    public function indicadoresCandidato($id)
    {
        $indicadores = Indicadores::leftJoin('candidato_indicador as ci', function($join) use ($id) {
            $join->on('indicadores.id', '=', 'ci.idIndicador')
                ->where('ci.idCandidato', '=', $id);
        })
        ->select('indicadores.name', 'indicadores.id as idIndicador','ci.valor')
        ->orderBy('indicadores.id', 'asc')
        ->get();

        return response()->json(['indicadores' => $indicadores]);
    }

    public function post(Request $request)
    {        
        $datos = $request->all();
        $idCandidato = $request->input('id');

        foreach ($datos as $key => $value) {
            $valIndicador = explode("_", $key);
            if(count($valIndicador) > 1){
                 $indicador = CandidatoIndicador::where('idCandidato', $idCandidato)
                    ->where('idIndicador', $valIndicador[1])
                    ->first();
                if($indicador){
                    $indicador = CandidatoIndicador::find($indicador->id);
                }else{
                    $indicador = new CandidatoIndicador();
                    $indicador->idIndicador = $valIndicador[1];
                    $indicador->idCandidato = $idCandidato;
                }
                $indicador->valor = $value;
                $indicador->save();                
            }
        }

        $_SESSION['success'] = 'Indicadores actualizados correctamente.';
        return redirect('/admin/candidatos');
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