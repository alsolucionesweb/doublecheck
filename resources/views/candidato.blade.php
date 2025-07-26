@extends('../layouts.backoffice')

@section('title', 'Candidato')
@section('subtitle', 'Para tomar decisiones acertadas, es fundamental analizar los resultados obtenidos hasta ahora.')

@section('content')
<div class="col-12">

    
    <div class="row mb-5">
        <div class="col-12 col-md-5">
            <div class="candidato-box zoom">        
                <h3>{{$candidato->name}}</h3>
                <div class="circle" style="background: conic-gradient(#facc15 {{($candidato->puntuacion/(5/100))}}%, #e5e7eb 0%)">
                    <div class="circle-content">
                        <img class="imgTablaCandidato" src="{{ url('/') }}{{$candidato->imagen}}" alt="">                                            
                    </div>
                </div>     
                <div class="puntuacion">
                    {{ $candidato->puntuacion }} <i class="fa-solid fa-star text-warning"></i>
                </div>   
            </div>
        </div>
        <div class="col-12 col-md-7">
            <div class="card content-candidato">
                <div class="card-body">
                    {!! $candidato->contenido !!}
                </div>
            </div>            
        </div>
    </div>
     

    <nav class="navbar navbar-expand-lg navbar-warning bg-warning mb-4">
        <div class="navbar-brand">                        
            <h5 class="card-title">
                <i class="fa-solid fa-chart-line"></i> Analisis de indicadores para candidato: <span>{{$candidato->name}}</span>
            </h5>
        </div>
        <div class="container-fluid justify-content-end">
            <div class="d-flex flex-wrap gap-3">
                
                <!-- Filtro de Semanas -->
                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Semanas
                    </button>
                    <ul class="dropdown-menu p-2" style="max-height: 300px; overflow-y: auto;">
                        @foreach($semanas as $semana)
                            <li>
                                <div class="form-check">
                                    <input class="form-check-input filtro-semana" type="checkbox" value="{{ $semana->name }}" id="semana{{ $semana->id }}">
                                    <label class="form-check-label" for="semana_{{ $semana->id }}">
                                        {{ $semana->name }}
                                    </label>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Filtro de Indicadores -->
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Indicadores
                    </button>
                    <ul class="dropdown-menu p-2" style="max-height: 300px; overflow-y: auto;">
                        @foreach($indicadores as $indicador)
                            <li>
                                <div class="form-check">
                                    <input class="form-check-input filtro-indicador" type="checkbox" value="{{ $indicador->name }}" id="indicador_{{ $indicador->id }}">
                                    <label class="form-check-label" for="indicador_{{ $indicador->id }}">
                                        {{ $indicador->name }}
                                    </label>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </nav>


    <div class="d-flex justify-content-end mb-2">
        <div id="botonesExportacion"></div>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="tablaIndicadores" class="display nowrap table table-bordered table-light table-striped-columns table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Indicadores</th>
                        @foreach($semanas as $semana)
                            <th>{{ $semana->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach($indicadores as $indicador)
                        <tr>
                            <td>{{ $indicador->name }}</td>
                            @foreach($semanas as $semana)
                                @php
                                    $clave = $indicador->id . '-' . $semana->idSemana;
                                    $valor = isset($valores[$clave]) ? $valores[$clave]->first()->valor : '-';
                                @endphp
                                <td>{{ $valor }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <!-- Botones de DataTables -->
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>

    <!-- Botones de exportación -->
 
    
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script>
$(document).ready(function () {
    const tabla = $('#tablaIndicadores').DataTable({
        scrollX: true,
        dom: 'Bfrtip',
        paging: false,        // 🔴 Desactiva la paginación
        searching: false,
        info: false,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa-solid fa-file-excel"></i> Excel',
                filename: 'Indicadores_Semana_{{$candidato->name}}',
                title: 'Reporte de Indicadores por Semana: {{$candidato->name}}',
                className: 'btn btn-outline-success mb-3'
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa-solid fa-file-pdf"></i> PDF',
                filename: 'Indicadores_Semana_{{$candidato->name}}',
                title: 'Reporte de Indicadores por Semana: {{$candidato->name}}',
                className: 'btn btn-outline-danger mb-3',
                orientation: 'landscape',
                pageSize: 'A4'
            }
        ],
        columnDefs: [
            { targets: 0, width: "200px" }
        ]      
    });

    // Cambiar semana vía radio buttons en dropdown
   
    $('.filtro-semana').on('change', function () {
        const seleccionados = $('.filtro-semana:checked').map(function () {
            return $(this).val();
        }).get();

        tabla.columns().every(function (index) {
            if (index === 0) return;
            const header = $(tabla.column(index).header()).text().trim();
            const visible = seleccionados.length === 0 || seleccionados.includes(header);
            tabla.column(index).visible(visible);
        });
    });

    // 👉 Filtro de Indicadores (filas)
    $('.filtro-indicador').on('change', function () {
        const seleccionados = $('.filtro-indicador:checked').map(function () {
            return $(this).val();
        }).get();

        tabla.rows().every(function () {
            const indicador = this.data()[0];
            const mostrar = seleccionados.length === 0 || seleccionados.includes(indicador);
            $(this.node()).toggle(mostrar);
        });
    });

    
});
</script>

@endsection