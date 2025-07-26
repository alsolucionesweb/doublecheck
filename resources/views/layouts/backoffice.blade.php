<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Double Check - @yield('title', '')</title>      

    <!-- Bootstrap -->  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

    <!-- Quill -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    
    <!-- Css Style -->
    <link rel="stylesheet" href="{{ url('/') }}/css/style.css" />

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome - Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <!--link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css"-->
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css">

    <!-- Estos CSS únicos del Layer Backoffice -->
    <style>
        body {
            display: block;
            background: linear-gradient(135deg, #e3e4e8e8, #f2e7c4), url(/img/fondo_elecciones.jpg);
            background-size: 100%;
        }
    </style>

    <!-- Quill JS -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
        
</head>
<body>  
    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
        <symbol id="check-circle-fill" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </symbol>
        <symbol id="info-fill" viewBox="0 0 16 16">
            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
        </symbol>
        <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </symbol>
    </svg>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{ url('/') }}/img/logo.png" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link @if ($_SESSION['menu'] == 'home') active @endif" aria-current="page" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if ($_SESSION['menu'] == 'indicadores') active @endif" href="{{ url('/') }}/indicadores">Indicadores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}/descargar">Descargar reporte</a>
                    </li>
                    
                    @if ($_SESSION['user']['is_admin'])
                    <li class="nav-item dropdown @if ($_SESSION['menu'] == 'administrar') active @endif">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Administrar
                        </a>
                        <ul class="dropdown-menu">                            
                            <li><a class="dropdown-item disabled" href="{{ url('/') }}/admin/usuarios" disabled>Usuarios</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{ url('/') }}/admin/candidatos">Candidatos</a></li>
                            <li><a class="dropdown-item" href="{{ url('/') }}/admin/indicadores">Indicadores</a></li>
                            <li><a class="dropdown-item" href="{{ url('/') }}/admin/tendencias">Tendencias</a></li>
                            <li><a class="dropdown-item" href="{{ url('/') }}/admin/semanas">Semanas</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{ url('/') }}/admin/descargable">Descargable</a></li>
                        </ul>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link btn-logout" href="{{ url('/') }}/logout">Salir</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="content container-fluid  p-4 pt-0 pb-0">
        <div class="row">            
            <div class="col py-3">

                @if(isset($error))
                    <div class="alert alert-danger alert-dismissible d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                        <div>
                            {{$error}}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(isset($success))
                    <div class="alert alert-success alert-dismissible d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                        <div>
                            {{$success}}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($_SESSION['user']['is_admin'])

                <div class="title-container">
                    <h3>@yield('title', 'Default')</h3>
                    <p class="text-muted">@yield('subtitle', 'Default')</p>                    
                </div>
                
                @endif
                
                <div class="row g-3 row-cols-1 row-cols-12">                    
                    @yield('content')
                </div>          
            
            </div>
        </div>
    </div>    

    <div id="load" style="display: none;">
        <div class="loader"></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    
    <script src="{{ url('/') }}/js/event.js"></script>
    
</body>
</html>
