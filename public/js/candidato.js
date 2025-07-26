document.getElementById('imagenCrear').addEventListener('change', function (event) {
  const input = event.target;
  const preview = document.getElementById('previewImagenCrear');
  previewImage(input, preview);  
});

document.getElementById('imagenActualizar').addEventListener('change', function (event) {
  const input = event.target;
  const preview = document.getElementById('previewImagenActualizar');
  previewImage(input, preview);  
});

function previewImage(input, preview) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function (e) {
        preview.src = e.target.result;
        preview.style.display = 'block';
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function verIndicadoresCandidato(params, idSemana) {
    console.log('Ver indicadores del candidato:', params);
    
    document.getElementById('idCandidato').value = params.id;
    document.getElementById('idSemana').value = idSemana;
    

    //Cargar indicadores del candidato

    loader.style.display = 'block'; // Mostrar el loader
    const host = location.protocol+'//'+location.host;
    fetch(host+'/indicadores/candidato/'+idSemana+'/'+params.id, {
        method: 'GET',
        headers: {
        'Content-Type': 'application/json'
        }
    })
    .then(response => {
        loader.style.display = 'none'; // Ocultar el loader
        if (!response.ok) {
        throw new Error(`Error: ${response.status}`);
        }
        return response.json(); // o response.text() según el backend
    })
    .then(data => {
        console.log('Respuesta del servidor:', data); 
        
        //Abrir modal con resultados
        const modalIndicadores = new bootstrap.Modal('#modalIndicadores', {
            keyboard: false
        })

        const indicadores = data.indicadores;
        const lista = document.getElementById('listIndicadores');
        lista.innerHTML = '';

        indicadores.forEach(e => {

            const inputName = 'ind_'+e.idIndicador;
            // 1. Crear fila
            const tr = document.createElement('tr');

            // 2. Crear celda con texto del indicador
            const tdIndicador = document.createElement('td');
            tdIndicador.textContent = e.name;

            // 3. Crear celda con input
            const tdInput = document.createElement('td');
            const input = document.createElement('input');
            input.type = 'number';
            input.name = inputName;
            const valor = e.valor != null? e.valor: 0;
            input.value = valor;

            tdInput.appendChild(input);

            // 4. Agregar celdas al tr
            tr.appendChild(tdIndicador);
            tr.appendChild(tdInput);

            // 5. Insertar en la tabla            
            lista.appendChild(tr);
        });

        loader.style.display = 'none';
        modalIndicadores.show();
    })
    .catch(error => {
        loader.style.display = 'none'; // Ocultar el loader
        console.error('Error al cargar lista de indicadores para el candidato '+params.name+':', error);       
    });
    
}

function verContenido(params) {
    
    document.querySelector('#candidatoPreviewContenido').innerHTML = params.name;
    document.querySelector('#contenidoPreview').innerHTML = params.contenido;

    const modal = new bootstrap.Modal('#modalContenidoPreview', {
        keyboard: false
    })
    modal.show();
}

function editarCandidato(params) {
    console.log('Editar candidato:', params);    

    document.getElementById('id').value = params.id;
    document.getElementById('name').value = params.name;
    document.getElementById('puntuacion').value = params.puntuacion;
    document.querySelector('#editor-editar .ql-editor').innerHTML = params.contenido;

    const host = location.protocol+'//'+location.host;
    document.getElementById('previewImagenActualizar').src = host+params.imagen;
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

function eliminarCandidato(params) {
    console.log('Eliminar candidato:', params);  
    
    document.getElementById('idEliminar').value = params.id;
    document.getElementById('candidato').textContent = params.name;    

    const host = location.protocol+'//'+location.host;
    document.getElementById('imagenEliminar').src = host+params.imagen;
    
    const modalEliminar = new bootstrap.Modal('#modalEliminar', {
        keyboard: false
    })
    modalEliminar.show();
}