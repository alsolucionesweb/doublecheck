
function editarDescargable(params) {
    console.log('Editar descargable:', params);    

    document.getElementById('id').value = params.id;
    document.getElementById('name').value = params.name;
    
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

function eliminarDescargable(params) {
    console.log('Eliminar descargable:', params);  
    
    document.getElementById('idEliminar').value = params.id;
    document.getElementById('descargable').textContent = params.name;     
    
    const modalEliminar = new bootstrap.Modal('#modalEliminar', {
        keyboard: false
    })
    modalEliminar.show();
}