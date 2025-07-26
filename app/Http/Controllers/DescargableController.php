<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Descargable;

class DescargableController extends Controller
{
    private $error = null;
    private $success = null;
    public function index()
    {
        $_SESSION['menu'] = 'administrar';
        $this->flashMessages();

        $descargables = Descargable::all();
        return view('admin/descargable', [
            'descargables' => $descargables,
            'error' => $this->error,
            'success' => $this->success
        ]);
    }

    public function post(Request $request)
    {        
        //validar descargable repetido

        $valDescargable = Descargable::where('name', $request->input('name'))->first();
        if ($valDescargable) {            
            $_SESSION['error'] = 'Descargable ya existe.';
            return redirect('/admin/descargable');
        }

        //Proceso archivo descargable

        if (!$request->hasFile('doc')) {
            $_SESSION['error'] = 'No se envió un archivo válido para descargar.';            
            return redirect('/admin/descargable');            
        }

        $file = $request->file('doc');

        if (!$file->isValid()) {  
            $_SESSION['error'] = 'El archivo no es válido para descargar.';
            return redirect('/admin/descargable');
        }        

        // Nombre único
        $nombre = uniqid() . '.' . $file->getClientOriginalExtension();

        // Guardar en storage/app/public/imagenes
        $ruta = $file->storeAs('', $nombre, 'public_doc');

        // Obtener URL accesible
        $url = '/descargable/'.$ruta;        

        //Validar si el descargable queda activo
        $activo = false;
        if( $request->input('activo') == 'on') {
            $oldActive = Descargable::where('estado', true)->first();
            if($oldActive){
                $oldActive = Descargable::find($oldActive->id);
                $oldActive->estado = false;
                $oldActive->save();                
            }
            $activo = true;            
        }

        //Guardar el descargable
        $descargable = new Descargable();
        $descargable->name = $request->input('name');
        $descargable->file = $url; // Guardar la URL de la imagen        
        $descargable->estado = $activo; // Por defecto, estado es 1 (activo)
        $descargable->save();

        if($descargable){
            $_SESSION['success'] = 'Descargable creado correctamente.';
        }else{
            $_SESSION['error'] = 'No se pudo crear el descargable, por favor intentelo más tarde.';
        }
        
        return redirect('/admin/descargable');
    }

    public function put(Request $request)
    {        
        //validar descargable existe
        $descargable = Descargable::find($request->input('id'));
        if (!$descargable) {            
            $_SESSION['error'] = 'Descargable no existe.';
            return redirect('/admin/descargable');
        }

        //Proceso archivo descargable
        $url = $descargable->file;

        if ($request->hasFile('doc')) {

            $file = $request->file('doc');

            if (!$file->isValid()) {  
                $_SESSION['error'] = 'El archivo no es válido.';
                return redirect('/admin/descargable');
            }
            

            // Nombre único
            $nombre = uniqid() . '.' . $file->getClientOriginalExtension();

            // Guardar en public/descargable
            $ruta = $file->storeAs('', $nombre, 'public_doc');

            // Obtener URL accesible
            $url = '/descargable/'.$ruta;
        }      
       
        //Validar si el descargable queda activo
        $activo = false;
        if( $request->input('activo') == 'on') {
            $oldActive = Descargable::where('estado', true)->first();
            if($oldActive){
                $oldActive = Descargable::find($oldActive->id);
                $oldActive->estado = false;
                $oldActive->save();                
            }
            $activo = true;            
        }

        //Actualizar el descargable        
        $descargable->name = $request->input('name');
        $descargable->file = $url; // Guardar la URL del archivo descargable        
        $descargable->estado = $activo; // Por defecto, estado es 1 (activo)
        $descargable->save();

        if($descargable){
            $_SESSION['success'] = 'Descargable actualizado correctamente.';
        }else{
            $_SESSION['error'] = 'No se pudo actualizar el descargable, por favor intentelo más tarde.';
        }
        
        return redirect('/admin/descargable');
    }

    public function delete(Request $request)
    {
        $descargable = Descargable::find($request->input('id'));
        if (!$descargable) {            
            $_SESSION['error'] = 'Descargable no existe.';
            return redirect('/admin/descargable');
        }
        
        $descargable->delete();

        if($descargable){
            $_SESSION['success'] = 'Descargable eliminado correctamente.';
        }else{
            $_SESSION['error'] = 'No se pudo eliminar el descargable, por favor intentelo más tarde.';
        }
        
        return redirect('/admin/descargable');
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