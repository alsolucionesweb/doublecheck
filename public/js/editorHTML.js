//Quill

  const quill = new Quill('#editor', {
    theme: 'snow',
    modules: { toolbar: '#editor-toolbar' }
  });

  // Copiar contenido al textarea antes de enviar
  function prepararEnvio() {
    document.getElementById('editor-content').value = quill.root.innerHTML.trim();
    return true; // continuar con el envío
  }

  const quillEditar = new Quill('#editor-editar', {
    theme: 'snow',
    modules: { toolbar: '#editor-toolbar-editar' }
  });

  function prepararEnvioEditar() {
    document.getElementById('editor-content-editar').value = quillEditar.root.innerHTML.trim();
    return true; // continuar con el envío
  }
