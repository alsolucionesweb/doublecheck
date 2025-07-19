function editarTendencia(params) {
    console.log('Editar tendencia:', params);    

    document.getElementById('id').value = params.id;
    document.getElementById('titulo').value = params.titulo;
    document.getElementById('editor-content-editar').value = params.contenido;
    document.querySelector('#editor-editar .ql-editor').innerHTML = params.contenido;
    
    if(params.estado){
        document.getElementById('activo').setAttribute('checked', 'checked');
    }else{
        document.getElementById('activo').removeAttribute('checked');
    }

    const modalEditar = new bootstrap.Modal('#modalEditar', {
        keyboard: false
    })
    modalEditar.show();
}

function eliminarTendencia(params) {
    console.log('Eliminar tendencia:', params);  
    
    document.getElementById('idEliminar').value = params.id;
    document.getElementById('tendencia').textContent = params.name;     
    
    const modalEliminar = new bootstrap.Modal('#modalEliminar', {
        keyboard: false
    })
    modalEliminar.show();
}