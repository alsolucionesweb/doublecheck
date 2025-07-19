@extends('../../layouts.backoffice')

@section('title', 'Indicadores')
@section('subtitle', 'En el contexto de las elecciones presidenciales, los indicadores juegan un papel clave para comprender el comportamiento del electorado, el impacto de las campañas y las tendencias del momento. Esta sesión está orientada a analizar y presentar los principales indicadores que permiten evaluar el rendimiento de los candidatos, la respuesta ciudadana y otros factores decisivos en el proceso electoral.')

@section('content')

<div class="col-12">
    <div class="card">
        <div class="card-body">
            <nav id="navbar-example2" class="navbar bg-danger-subtle px-3 mb-3">
                <div class="navbar-brand">Configuración de indicadores</div>
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
                          <th scope="col">INDICADOR</th>
                          <th class="text-center" scope="col">ESTADO</th>
                          <th class="text-center" scope="col">ACCIONES</th>
                      </tr>
                  </thead>
                  <tbody class="table-group-divider">
                      @foreach ($indicadores as $indicador)
                          <tr>
                              <th scope="row">{{ $indicador->id }}</th>
                              <td>                                
                                {{ $indicador->name }}
                              </td>                              
                              <td class="text-center">@if ($indicador->estado)
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
                                  <a href="#" class="btn btn-outline-warning" onclick="editarIndicador({{ $indicador }})">
                                      <i class="fa-solid fa-pencil"></i>
                                  </a>
                                  <a href="#" class="btn btn-outline-danger" onclick="eliminarIndicador({{ $indicador }})">
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
        <h1 class="modal-title fs-5" id="modalCrearLabel">Nuevo Indicador</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="{{ url('/') }}/admin/indicadores" enctype="multipart/form-data">
        <div class="modal-body">        
          <div class="row">
              <div class="col-12">
                  <div class="mb-3">
                      <label for="name" class="form-label">Indicador</label>
                      <input type="text" class="form-control" name="name" aria-describedby="nameHelp">
                      <div id="nameHelp" class="form-text">Escribe el titulo del indicador.</div>
                  </div> 
                  <div class="mb-3 form-check form-switch">
                      <input type="checkbox" class="form-check-input" role="switch" name="activo" checked>
                      <label class="form-check-label" for="activo">Activo</label>
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

<!-- Modal Editar-->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalEditarLabel">Editar Indicador</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="{{ url('/') }}/admin/indicadores/editar" enctype="multipart/form-data">
        <div class="modal-body">        
          <div class="row">
              <div class="col-12">
                  <input type="hidden" name="id" id="id">
                  <div class="mb-3">
                      <label for="name" class="form-label">Indicador</label>
                      <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp">
                      <div id="nameHelp" class="form-text">Escribe el titulo del indicador.</div>
                  </div> 
                  <div class="mb-3 form-check form-switch">
                      <input type="checkbox" class="form-check-input" role="switch" id="activo" name="activo" checked>
                      <label class="form-check-label" for="activo">Activo</label>
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
        <h1 class="modal-title fs-5" id="modalEliminarLabel">Eliminar Indicador</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="{{ url('/') }}/admin/indicadores/eliminar">
        <input type="hidden" name="id" id="idEliminar">
        <div class="modal-body text-center">
          ¿Confirma que desea eliminar este indicador?          
          <b class="text-center d-block" id="indicador"></b>
        </div>
        <div class="modal-footer">        
          <button type="submit" class="btn btn-success" onclick="load()" data-bs-dismiss="modal">Si</button>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
        </div>
      </form>
      
    </div>
  </div>
</div>

<script src="{{ url('/') }}/js/indicadores.js"></script>

@endsection