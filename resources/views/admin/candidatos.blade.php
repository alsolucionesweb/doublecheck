@extends('../../layouts.backoffice')

@section('title', 'Candidatos')
@section('subtitle', 'En esta sesión configuraremos los candidatos que participarán en el proceso, asignándoles los indicadores correspondientes para su evaluación. Este paso es clave para asegurar una medición precisa y estructurada del desempeño de cada participante.')

@section('content')

<div class="col-12">
    <div class="card">
        <div class="card-body">
            <nav id="navbar-example2" class="navbar bg-danger-subtle px-3 mb-3">
                <div class="navbar-brand">Configuración de Candidatos</div>
                <ul class="nav nav-pills">                    
                    <li class="nav-item">
                        <a class="nav-link" role="button" data-bs-toggle="modal" data-bs-target="#modalCrear">Crear</a>
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
                      @foreach ($candidatos as $candidato)
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
                              <td class="text-center">
                                <button type="button" class="btn btn-primary" onclick="verIndicadoresCandidato({{ $candidato }})">
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

<!-- Modal Crear -->

<div class="modal fade" id="modalCrear" tabindex="-1" aria-labelledby="modalCrearLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalCrearLabel">Nuevo Candidato</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="{{ url('/') }}/admin/candidatos" enctype="multipart/form-data">
        <div class="modal-body">        
          <div class="row">
              <div class="col-12 col-md-6">
                  <div class="mb-3">
                      <label for="name" class="form-label">Nombre y Apellido</label>
                      <input type="text" class="form-control" name="name" aria-describedby="nameHelp">
                      <div id="nameHelp" class="form-text">Escribe el nombre completo del candidato.</div>
                  </div>                                        
                  <div class="mb-3">
                      <label for="puntaje" class="form-label">Clasificación</label>
                      <input type="number" step="0.01" class="form-control" name="puntuacion">
                  </div>
                  <div class="mb-3 form-check form-switch">
                      <input type="checkbox" class="form-check-input" role="switch" name="activo" checked>
                      <label class="form-check-label" for="activo">Activo</label>
                  </div>
              </div>
              <div class="col-12 col-md-6">
                  <img class="imgTablaCandidato" src="{{ url('/') }}/img/preview.jpg" alt="" id="previewImagenCrear">
                  <div class="mb-3">
                      <label for="imagen" class="form-label">Imagen</label>
                      <input class="form-control" type="file" id="imagenCrear" name="imagen" accept="image/*">
                  </div>
              </div>            
          </div>      
        </div>
        <div class="modal-footer">          
          <button type="submit" class="btn btn-outline-danger" onclick="load()" data-bs-dismiss="modal">Guardar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </form>
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
        <input type="hidden" id="idCandidato" name="id">
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

<!-- Modal Editar-->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalEditarLabel">Editar candidato</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="{{ url('/') }}/admin/candidatos/editar" enctype="multipart/form-data">
        <div class="modal-body">        
          <div class="row">
              <div class="col-12 col-md-6">
                  <input type="hidden" name="id" id="id">
                  <div class="mb-3">
                      <label for="name" class="form-label">Nombre y Apellido</label>
                      <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp">
                      <div id="nameHelp" class="form-text">Escribe el nombre completo del candidato.</div>
                  </div>                                        
                  <div class="mb-3">
                      <label for="puntaje" class="form-label">Clasificación</label>
                      <input type="number" step="0.01" class="form-control" id="puntuacion" name="puntuacion">
                  </div>
                  <div class="mb-3 form-check form-switch">
                      <input type="checkbox" class="form-check-input" role="switch" id="activo" name="activo" checked>
                      <label class="form-check-label" for="activo">Activo</label>
                  </div>
              </div>
              <div class="col-12 col-md-6">
                  <img class="imgTablaCandidato" src="{{ url('/') }}/img/preview.jpg" alt="" id="previewImagenActualizar">
                  <div class="mb-3">
                      <label for="imagen" class="form-label">Imagen</label>
                      <input class="form-control" type="file" id="imagenActualizar" name="imagen" accept="image/*">
                  </div>
              </div>
          </div>      
        </div>
        <div class="modal-footer">          
          <button type="submit" class="btn btn-outline-danger" onclick="load()" data-bs-dismiss="modal">Editar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Eliminar-->
<div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalEliminarLabel">Eliminar candidato</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="{{ url('/') }}/admin/candidatos/eliminar">
        <input type="hidden" name="id" id="idEliminar">
        <div class="modal-body text-center">
          ¿Confirma que desea eliminar este candidato?
          <img class="imgTablaCandidato mt-3" src="{{ url('/') }}/img/preview.jpg" alt="" id="imagenEliminar">
          <b class="text-center" id="candidato"></b>
        </div>
        <div class="modal-footer">        
          <button type="submit" class="btn btn-success" onclick="load()" data-bs-dismiss="modal">Si</button>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
        </div>
      </form>
      
    </div>
  </div>
</div>

<script src="{{ url('/') }}/js/candidato.js"></script>
@endsection