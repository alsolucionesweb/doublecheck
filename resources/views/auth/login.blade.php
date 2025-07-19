@extends('../layouts.app')

@section('title', 'Login')

@section('content')

<div class="container">
    <div class="login-card">
      <div class="header">       
        <img src="img/logo.png" alt="">
        <!--p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p-->
      </div>
      <div class="login-form">
        <h2>Iniciar sesión</h2>
        <form method="POST" action="/login">
          <div class="input-group" id="email-group">
            <span class="icon">👤</span>
            <input id="email-input" type="email" name="email" placeholder="cuenta@correo.com" required />
          </div>
          <div class="input-group" id="otp-group" style="display: none;">
            <span class="icon">🔒</span>
            <input type="number" name="OTP" placeholder="xxxxxx" style="text-align: center; font-size: 20px; font-weight: 900;" required />
          </div>
          
          @if (isset($error))
                <div class="alert alert-danger alert-dismissible fade show" style="color: red">
                    {{$error}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="alert alert-danger" id="error-message" style="display: none; color: red">
                <!-- Aquí se mostrará el mensaje de error -->                
            </div>
          <button id="btnEnviar" type="button" class="login-button">Enviar OTP</button>
          <button id="btnValidar" type="submit" class="login-button" style="display:none" onclick="load()">Validar</button>
        </form>
      </div>
    </div>
</div>

@endsection