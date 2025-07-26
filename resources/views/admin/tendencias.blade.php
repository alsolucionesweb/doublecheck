@extends('../../layouts.backoffice')

@section('title', 'Tendencias')
@section('subtitle', 'En un escenario político dinámico como el de las elecciones presidenciales, identificar y analizar las tendencias es fundamental para anticipar comportamientos del electorado, cambios en la opinión pública y variaciones en la intención de voto. Esta sesión tiene como objetivo explorar las principales tendencias que han marcado el desarrollo de la campaña, los factores que influyen en ellas y su posible impacto en los resultados finales.')

@section('content')

<div class="col-12">
    <div class="card">
        <div class="card-body">
            <nav id="navbar-example2" class="navbar bg-danger-subtle px-3 mb-3">
                <div class="navbar-brand">Configuración de tendencias</div>
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
                          <th scope="col">TITULO</th>
                          <th scope="col">CONTENIDO</th>
                          <th class="text-center" scope="col">ESTADO</th>
                          <th class="text-center" scope="col">ACCIONES</th>
                      </tr>
                  </thead>
                  <tbody class="table-group-divider">
                      @foreach ($tendencias as $tendencia)
                          <tr>
                              <th scope="row">{{ $tendencia->id }}</th>
                              <td>                                
                                {{ $tendencia->titulo }}
                              </td>       
                              <td>
                                <button type="button" class="btn btn-primary" onclick="verContenido({{ $tendencia }})">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                              </td>                       
                              <td class="text-center">@if ($tendencia->estado)
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
                                  <a href="#" class="btn btn-outline-warning" onclick="editarTendencia({{ $tendencia }})">
                                      <i class="fa-solid fa-pencil"></i>
                                  </a>
                                  <a href="#" class="btn btn-outline-danger" onclick="eliminarTendencia({{ $tendencia }})">
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
  <div class="modal-dialog max-w">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalCrearLabel">Nueva Tendencia</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="{{ url('/') }}/admin/tendencias" onsubmit="return prepararEnvio();">
        <div class="modal-body">        
          <div class="row">
              <div class="col-12">
                  <div class="mb-3">
                      <label for="name" class="form-label">Tendencia</label>
                      <input type="text" class="form-control" name="titulo" aria-describedby="nameHelp">
                      <div id="nameHelp" class="form-text">Escribe el titulo de la tendencia.</div>
                  </div> 
                  <div class="mb-3">
                    <span>Contenido</span>
                    <div id="editor-toolbar" class="mb-2">
                      <!-- Puedes personalizar las herramientas -->
                      <button class="ql-bold"></button>
                      <button class="ql-italic"></button>
                      <button class="ql-underline"></button>
                      <button class="ql-link"></button>
                    </div>

                    <div class="editorHTML" id="editor" style="height: 200px; background-color: #fff;"></div>

                    <!-- Campo oculto para enviar el contenido -->                    
                    <textarea name="contenido" id="editor-content" class="d-none"></textarea>
                    
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
  <div class="modal-dialog max-w">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalEditarLabel">Editar Tendencia</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="{{ url('/') }}/admin/tendencias/editar" onsubmit="return prepararEnvioEditar();">
        <div class="modal-body">        
          <div class="row">
              <div class="col-12">
                  <input type="hidden" name="id" id="id">
                  <div class="mb-3">
                      <label for="name" class="form-label">Tendencia</label>
                      <input type="text" class="form-control" id="titulo" name="titulo" aria-describedby="nameHelp">
                      <div id="nameHelp" class="form-text">Escribe el titulo de la tendencia.</div>
                  </div> 
                  <div class="mb-3">
                    <h5>Contenido</h5>
                    <div id="editor-toolbar-editar" class="mb-2">
                      <!-- Puedes personalizar las herramientas -->
                      <button class="ql-bold"></button>
                      <button class="ql-italic"></button>
                      <button class="ql-underline"></button>
                      <button class="ql-link"></button>
                    </div>

                    <div class="editorHTML" id="editor-editar" style="height: 200px; background-color: #fff;"></div>

                    <!-- Campo oculto para enviar el contenido -->                    
                    <textarea name="contenido" id="editor-content-editar" class="d-none"></textarea>
                    
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
        <h1 class="modal-title fs-5" id="modalEliminarLabel">Eliminar Tendencia</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="{{ url('/') }}/admin/tendencias/eliminar">
        <input type="hidden" name="id" id="idEliminar">
        <div class="modal-body text-center">
          ¿Confirma que desea eliminar esta tendencia?          
          <b class="text-center d-block" id="tendencia"></b>
        </div>
        <div class="modal-footer">        
          <button type="submit" class="btn btn-success" onclick="load()" data-bs-dismiss="modal">Si</button>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
        </div>
      </form>
      
    </div>
  </div>
</div>

<!-- Modal verContenidoPreview -->
<div class="modal fade" id="modalContenidoPreview" tabindex="-1" aria-labelledby="modalContenidoPreviewLabel" aria-hidden="true">
  <div class="modal-dialog max-w">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalContenidoPreviewLabel">Contenido</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>        
      <div class="modal-body">
        <div class="card">
          <div class="card-body">
            <h5 class="card-header mb-3" id="tendenciaPreviewContenido"></h5>
            <div id="contenidoPreview"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer">        
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>        
      </div>      
    </div>
  </div>
</div>

<script src="{{ url('/') }}/js/editorHTML.js"></script>
<script src="{{ url('/') }}/js/tendencias.js"></script>

@endsection