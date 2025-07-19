<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Indicadores;
use App\Models\CandidatoIndicador;
use App\Models\Candidatos;

class HomeController extends Controller
{        
    public function index()
    {   
        $candidatos = Candidatos::where('Estado', true)
        ->orderBy('puntuacion', 'desc')
        ->get();        
        return view('home', ['candidatos' => $candidatos]);
    }

    public function indicadores()    
    {       
        $candidatosIndicadores = Indicadores::all();
        return view('home', ['nombre' => 'Alejandro']);
    }

    public function getCandidato($id)
    {
        return view('home', ['nombre' => 'Alejandro']);
    }
}
