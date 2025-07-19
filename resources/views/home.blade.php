@extends('../layouts.backoffice')

@section('title', 'Dashboard')
@section('subtitle', 'Para tomar decisiones acertadas, es fundamental analizar los resultados obtenidos hasta ahora.')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">¿Como está el rendimiento de las campañas?</h5>
            <p class="card-text">Evaluar el rendimiento de las campañas nos permite identificar qué estrategias están generando mejores resultados, detectar oportunidades de mejora y tomar decisiones basadas en datos para optimizar futuros esfuerzos.</p>

            <div id="carouselExample" class="carousel slide">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row w-75 m-auto">
                            <div class="col">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <img class="imgTablaCandidato" src="{{ url('/') }}/img/candidatos/6875c1c925c0e.png" alt="">
                                        Vicky Davila
                                    </div>                            
                                </div>
                            </div>
                            <div class="col">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <img class="imgTablaCandidato" src="{{ url('/') }}/img/candidatos/6875c1c925c0e.png" alt="">
                                        Vicky Davila
                                    </div>                            
                                </div>
                            </div>
                            <div class="col">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <img class="imgTablaCandidato" src="{{ url('/') }}/img/candidatos/6875c1c925c0e.png" alt="">
                                        Vicky Davila
                                    </div>                            
                                </div>
                            </div>
                            <div class="col">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <img class="imgTablaCandidato" src="{{ url('/') }}/img/candidatos/6875c1c925c0e.png" alt="">
                                        Vicky Davila
                                    </div>                            
                                </div>
                            </div>
                            <div class="col">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <img class="imgTablaCandidato" src="{{ url('/') }}/img/candidatos/6875c1c925c0e.png" alt="">
                                        Vicky Davila
                                    </div>                            
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row w-75 m-auto">
                            @for ($i = 1; $i <= 5; $i++)
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <img class="imgTablaCandidato" src="{{ url('/') }}/img/candidatos/6875c1c925c0e.png" alt="">
                                            Vicky Davila
                                        </div>                            
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>                    
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

            <a href="#" class="btn btn-outline-warning">Descargar Reporte</a>
        </div>
    </div>
</div>
@endsection