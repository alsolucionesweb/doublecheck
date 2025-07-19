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
        $this->flashMessages();

        $semanas = Semanas::all();
        return view('admin/semanas', [
            'semanas' => $semanas,
            'error' => $this->error,
            'success' => $this->success
        ]);
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
