@extends('../../layouts.backoffice')

@section('title', 'Indicadores por semana')
@section('subtitle', 'En esta sesión configuraremos los candidatos que participarán en el proceso, asignándoles los indicadores correspondientes para su evaluación. Este paso es clave para asegurar una medición precisa y estructurada del desempeño de cada participante.')

@section('content')

<div class="col-12">
    <div class="card">
        <div class="card-body">
            <nav id="navbar-example2" class="navbar bg-danger-subtle px-3 mb-3">
                <div class="navbar-brand">Configuración de Indicadores para la semana: {{$semana->name}}</div>
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
                          <th class="text-center" scope="col">INDICADORES</th>
                      </tr>
                  </thead>
                  <tbody class="table-group-divider">
                      @foreach ($candidatos as $candidato)
                          <tr>
                              <th scope="row">{{ $candidato->id }}</th>
                              <td class="text-center">
                                <img class="imgTablaCandidato" src="{{ url('/') }}{{$candidato->imagen}}" alt="">
                                {{ $candidato->name }}
                              </td>                              
                              
                              <td class="text-center">
                                <button type="button" class="btn btn-primary" onclick="verIndicadoresCandidato({{ $candidato }}, {{$semana->id}})">
                                      <i class="fa-solid fa-eye"></i>
                                  </button>
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

<!-- Modal Indicadores -->
<div class="modal fade" id="modalIndicadores" tabindex="-1" aria-labelledby="modalIndicadoresLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalIndicadoresLabel">Indicadores</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="{{ url('/') }}/admin/indicadores/candidato">
        <input type="hidden" id="idCandidato" name="idCandidato">
        <input type="hidden" id="idSemana" name="idSemana">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead class="table-light">
              <tr>
                <th>Indicador</th>
                <th>Valor</th>
              </tr>
            </thead>
            <tbody id="listIndicadores">
              
            </tbody>
          </table>
        </div>
        
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" data-bs-dismiss="modal" onclick="load()">Guardar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>        
      </div>
      </form>
    </div>
  </div>
</div>

<script src="{{ url('/') }}/js/candidato.js"></script>
@endsection