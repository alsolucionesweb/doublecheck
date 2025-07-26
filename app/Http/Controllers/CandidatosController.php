<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidatos;
use App\Models\CandidatoIndicador;


class CandidatosController extends Controller
{
    private $error = null;
    private $success = null;
    
    public function index()
    {
        $_SESSION['menu'] = 'administrar';
        
        $this->flashMessages();

        $candidatos = Candidatos::all();
        return view('admin/candidatos', [
            'candidatos' => $candidatos,
            'error' => $this->error,
            'success' => $this->success
        ]);
    }

    public function show($id)
    {
        $candidato = Candidatos::findOrFail($id);
        return view('admin/candidatos.show', ['candidato' => $candidato]);
    }
    public function post(Request $request)
    {        
        //validar candidato repetido

        $valCandidato = Candidatos::where('name', $request->input('name'))->first();
        if ($valCandidato) {            
            $_SESSION['error'] = 'Candidato ya existe.';
            return redirect('/admin/candidatos');
        }

        //Proceso imagen

        if (!$request->hasFile('imagen')) {
            $_SESSION['error'] = 'No se envió una imagen.';            
            return redirect('/admin/candidatos');            
        }

        $file = $request->file('imagen');

        if (!$file->isValid()) {  
            $_SESSION['error'] = 'La imagen no es válida.';
            return redirect('/admin/candidatos');
        }

        // Opcional: validar que sea una imagen
        $mime = $file->getMimeType();
        if (!str_starts_with($mime, 'image/')) {
            $_SESSION['error'] = 'El archivo no es una imagen válida.';            
            return redirect('/admin/candidatos');            
        }

        // Nombre único
        $nombre = uniqid() . '.' . $file->getClientOriginalExtension();

        // Guardar en storage/app/public/imagenes
        $ruta = $file->storeAs('', $nombre, 'public_img');

        // Obtener URL accesible
        $url = '/img/candidatos/'.$ruta;
        //dd($url);
        //$url = url(str_replace('public/', 'storage/app/public/', $ruta));

        //Validar si el candidato queda activo
        $activo = true;
        if( $request->input('activo') != 'on') {
            $activo = false;
        }

        //Guardar el candidato
        $candidato = new Candidatos();
        $candidato->name = $request->input('name');
        $candidato->imagen = $url; // Guardar la URL de la imagen
        $candidato->contenido = $request->input('contenido');
        $candidato->puntuacion = $request->input('puntuacion');
        $candidato->estado = $activo; // Por defecto, estado es 1 (activo)
        $candidato->save();

        if($candidato){
            $_SESSION['success'] = 'Candidato creado correctamente.';
        }else{
            $_SESSION['error'] = 'No se pudo crear el candidato, por favor intentelo más tarde.';
        }
        
        return redirect('/admin/candidatos');
    }

    public function put(Request $request)
    {        
        //validar candidato existe
        //dd($request);
        $candidato = Candidatos::find($request->input('id'));
        if (!$candidato) {            
            $_SESSION['error'] = 'Candidato no existe.';
            return redirect('/admin/candidatos');
        }

        //Proceso imagen
        $url = $candidato->imagen;

        if ($request->hasFile('imagen')) {

            $file = $request->file('imagen');

            if (!$file->isValid()) {  
                $_SESSION['error'] = 'La imagen no es válida.';
                return redirect('/admin/candidatos');
            }

            // Opcional: validar que sea una imagen
            $mime = $file->getMimeType();
            if (!str_starts_with($mime, 'image/')) {
                $_SESSION['error'] = 'El archivo no es una imagen válida.';            
                return redirect('/admin/candidatos');            
            }

            // Nombre único
            $nombre = uniqid() . '.' . $file->getClientOriginalExtension();

            // Guardar en storage/app/public/imagenes
            $ruta = $file->storeAs('', $nombre, 'public_img');

            // Obtener URL accesible
            $url = '/img/candidatos/'.$ruta;
        }

        
        //dd($url);
        //$url = url(str_replace('public/', 'storage/app/public/', $ruta));

        //Validar si el candidato queda activo
        $activo = true;
        if( $request->input('activo') != 'on') {
            $activo = false;
        }

        //Actualizar el candidato        
        $candidato->name = $request->input('name');
        $candidato->imagen = $url; // Guardar la URL de la imagen
        $candidato->contenido = $request->input('contenido');
        $candidato->puntuacion = $request->input('puntuacion');
        $candidato->estado = $activo; // Por defecto, estado es 1 (activo)
        $candidato->save();

        if($candidato){
            $_SESSION['success'] = 'Candidato actualizado correctamente.';
        }else{
            $_SESSION['error'] = 'No se pudo actualizar el candidato, por favor intentelo más tarde.';
        }
        
        return redirect('/admin/candidatos');
    }

    public function delete(Request $request)
    {
        $candidato = Candidatos::find($request->input('id'));
        if (!$candidato) {            
            $_SESSION['error'] = 'Candidato no existe.';
            return redirect('/admin/candidatos');
        }

        $candidatoIndicadores = CandidatoIndicador::where('idCandidato', $candidato->id)
        ->get();

        //dd(count($candidatoIndicadores));

        if(count($candidatoIndicadores) > 0){            
             $candidatoIndicadores = CandidatoIndicador::where('idCandidato', $candidato->id)
            ->delete();

            if(!$candidatoIndicadores ){
                $_SESSION['error'] = 'No se pudo eliminar los indicadores del candidato, por favor intentelo más tarde.';
                return redirect('/admin/candidatos');
            }

        }        
        
        $candidato->delete();

        if($candidato){
            $_SESSION['success'] = 'Candidato eliminado correctamente.';
        }else{
            $_SESSION['error'] = 'No se pudo eliminar el candidato, por favor intentelo más tarde.';
        }
        
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

}    // Other methods for CandidatosController can be added here
