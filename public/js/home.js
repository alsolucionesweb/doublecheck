function verTendencia(e) {    

    document.querySelector('.tendenciaSelect').classList.remove('tendenciaSelect');
    document.getElementById('tendencia_'+e.id).classList.add('tendenciaSelect');
    document.getElementById('content-tendencia').innerHTML = e.contenido;
}