<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Indicadores;
use App\Models\Tendencias;
use App\Models\CandidatoIndicador;
use App\Models\Candidatos;

class HomeController extends Controller
{        
    public function index()
    {   
        $_SESSION['menu'] = 'home';
        $candidatos = Candidatos::where('estado', true)
        ->orderBy('puntuacion', 'desc')
        ->get();        

        $tendencias = Tendencias::where('estado', true)
        ->orderBy('id', 'asc')
        ->get();

        return view('home', [
            'candidatos' => $candidatos,
            'tendencias' => $tendencias
        ]);
    }

    public function indicadores(Request $request)    
    {       
        $_SESSION['menu'] = 'indicadores';
        $idSemana = $request->input('semana', 1);

        // Obtener todos los candidatos
        $candidatos = Candidatos::all();

        // Obtener todos los indicadores
        $indicadores = Indicadores::all();

        // Obtener los valores de los indicadores para esa semana
        $valores = CandidatoIndicador::where('idSemana', $idSemana)
            ->get()
            ->groupBy(function($item) {
                return $item->idIndicador . '-' . $item->idCandidato;
            });

        // Supongamos que estas son las semanas disponibles
        $semanas = \DB::table('candidato_indicador')
            ->select('idSemana')
            ->distinct()
            ->orderBy('idSemana', 'desc')
            ->get();


        return view('indicadores',  compact(
            'candidatos', 'indicadores', 'valores', 'idSemana', 'semanas'
        ));
    }

    
    public function getCandidato($id)
    {
        $idCandidato = $id;
        $candidato = Candidatos::find($id);
        $indicadores = Indicadores::all();
        $semanas = CandidatoIndicador::select('candidato_indicador.idSemana', 'semana.name')
        ->distinct()
        ->join('semana', 'semana.id','candidato_indicador.idSemana' )
        ->where('candidato_indicador.idCandidato', $idCandidato)
        ->orderBy('candidato_indicador.idSemana')
        ->get();
        //->pluck('candidato_indicador.idSemana');

         // Obtener todos los valores de ese candidato
        $valores = CandidatoIndicador::where('idCandidato', $idCandidato)
        ->get()
        ->groupBy(function ($item) {
            return $item->idIndicador . '-' . $item->idSemana;
        });

        return view('candidato', compact(
            'candidato', 'indicadores', 'semanas', 'valores', 'idCandidato'
        ));
    }
}
