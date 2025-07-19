document.addEventListener('DOMContentLoaded', function() {
  const sendOtpButton = document.getElementById('btnEnviar');
    const emailInput = document.getElementById('email-input');
    if (sendOtpButton && emailInput) {
    sendOtpButton.addEventListener('click', function() {
        const email = emailInput.value.trim();
        if (email) {
            sendOtp(email);
        } else {
            const errorMessage = document.getElementById('error-message');
            errorMessage.style.display = 'block';
            errorMessage.textContent = 'Por favor, ingrese un correo electrónico.';
            console.error('Por favor, ingrese un correo electrónico válido.');
            setTimeout(() => {
                errorMessage.style.display = 'none';
            }, 5000);
        }
    
    });

    }
});

const loader = document.getElementById('load');

function load(params) {
    loader.style.display = 'block'; // Mostrar el loader
}

function sendOtp(email) {

  const errorMessage = document.getElementById('error-message');
  loader.style.display = 'block'; // Mostrar el loader
  const host = location.protocol+'//'+location.host;
  fetch(host+'/send-otp', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ email: email })
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
    
    errorMessage.style.display = 'block'; // mostrar mensaje de alerta si se envió

    if(data.error) {
      errorMessage.textContent = data.error; // Mostrar mensaje de error
      setTimeout(() => {
        errorMessage.style.display = 'none';
      }, 10000);
      return;
    }
    // Si no hay error, mostrar mensaje de éxito
    errorMessage.textContent = 'OTP enviado exitosamente. Por favor, verifica tu correo electrónico.';
    const groupOtp = document.getElementById('otp-group');
    groupOtp.style.display = 'block'; // Mostrar el campo OTP

    const btnValidar = document.getElementById('btnValidar');
    btnValidar.style.display = 'inline-block'; // Mostrar el botón de Validar

    const emailGroup = document.getElementById('email-group');
    emailGroup.style.display = 'none'; // Ocultar el campo de correo electrónico    

    const btnEnviar = document.getElementById('btnEnviar');
    btnEnviar.style.display = 'none'; // Ocultar el botón de Enviar

    setTimeout(() => {
        errorMessage.style.display = 'none';
    }, 10000);

  })
  .catch(error => {
    loader.style.display = 'none'; // Ocultar el loader
    console.error('Error al enviar OTP:', error);
    errorMessage.style.display = 'block';
    errorMessage.textContent = 'Error al enviar OTP: ' + error.error;
    setTimeout(() => {
        errorMessage.style.display = 'none';
    }, 10000);
  });
}

//Quill

const quill = new Quill('#editor', {
    theme: 'snow',
    modules: { toolbar: '#editor-toolbar' }
  });

  const quillEditar = new Quill('#editor-editar', {
    theme: 'snow',
    modules: { toolbar: '#editor-toolbar-editar' }
  });

  // Copiar contenido al textarea antes de enviar
  function prepararEnvio() {
    document.getElementById('editor-content').value = quill.root.innerHTML.trim();
    return true; // continuar con el envío
  }

  function prepararEnvioEditar() {
    document.getElementById('editor-content-editar').value = quillEditar.root.innerHTML.trim();
    return true; // continuar con el envío
  }