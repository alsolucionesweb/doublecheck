@extends('../../layouts.backoffice')

@section('title', 'Usuarios')
@section('subtitle', 'En esta sesión configuraremos los candidatos que participarán en el proceso, asignándoles los indicadores correspondientes para su evaluación. Este paso es clave para asegurar una medición precisa y estructurada del desempeño de cada participante.')

@section('content')

<div class="col-12">
    <div class="card">
        <div class="card-body">
            <nav id="navbar-example2" class="navbar bg-danger-subtle px-3 mb-3">
                <div class="navbar-brand">Configuración de usuarios</div>
                <ul class="nav nav-pills">                    
                    <li class="nav-item">
                        <a class="nav-link" role="button" data-bs-toggle="modal" data-bs-target="#modalCrear">
                          <i class="fa-solid fa-plus"></i> Nuevo
                        </a>
                    </li>                    
                </ul>
            </nav>

            <div class="card card-body">
              <div class="table-responsive">
                <table class="table table-hover align-middle">
                  <thead class="table-light">
                      <tr>
                          <th scope="col">ID</th>
                          <th class="text-center" scope="col">CANDIDATO</th>
                          <th class="text-center" scope="col">CLASIFICACIÓN</th>
                          <th class="text-center" scope="col">ESTADO</th>
                          <th class="text-center" scope="col">INDICADORES</th>
                          <th class="text-center" scope="col">ACCIONES</th>
                      </tr>
                  </thead>
                  <tbody class="table-group-divider">
                      @foreach ($usuarios as $candidato)
                          <tr>
                              <th scope="row">{{ $candidato->id }}</th>
                              <td class="text-center">
                                <img class="imgTablaCandidato" src="{{ url('/') }}{{$candidato->imagen}}" alt="">
                                {{ $candidato->name }}
                              </td>
                              <td class="text-center puntuacion">{{ $candidato->puntuacion }} <i class="fa-solid fa-star text-warning"></i></td>
                              <td class="text-center">@if ($candidato->estado)
                                  <div class="p-3 text-success-emphasis bg-success-subtle border border-success-subtle rounded-3 text-center">
                                    Activo
                                  </div>
                                @else
                                  <div class="p-3 text-danger-emphasis bg-danger-subtle border border-danger-subtle rounded-3 text-center">
                                    Oculto
                                  </div>
                                @endif
                              </td>
                              <td class="text-center"><button type="button" class="btn btn-primary" onclick="verIndicadoresCandidato({{ $candidato->id }})">
                                      <i class="fa-solid fa-eye"></i>
                                  </button>
                              </td>
                              <td class="text-center">                                                
                                  <a href="#" class="btn btn-outline-warning" onclick="editarCandidato({{ $candidato }})">
                                      <i class="fa-solid fa-pencil"></i>
                                  </a>
                                  <a href="#" class="btn btn-outline-danger" onclick="eliminarCandidato({{ $candidato }})">
                                      <i class="fa-solid fa-trash"></i>
                                  </a>
                              </td>
                          </tr>
                      @endforeach
                      
                  </tbody>
                </table>
              </div>
              
          </div>            
        </div>
    </div>
</div>

@endsection