
function editarIndicador(params) {
    console.log('Editar indicador:', params);    

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

function eliminarIndicador(params) {
    console.log('Eliminar indicador:', params);  
    
    document.getElementById('idEliminar').value = params.id;
    document.getElementById('indicador').textContent = params.name;     
    
    const modalEliminar = new bootstrap.Modal('#modalEliminar', {
        keyboard: false
    })
    modalEliminar.show();
}