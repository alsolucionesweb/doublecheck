@extends('../layouts.backoffice')

@section('title', 'Dashboard')
@section('subtitle', 'Para tomar decisiones acertadas, es fundamental analizar los resultados obtenidos hasta ahora.')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">¿Como está el rendimiento de las campañas?</h5>
            <p class="card-text mb-3">Evaluar el rendimiento de las campañas nos permite identificar qué estrategias están generando mejores resultados, detectar oportunidades de mejora y tomar decisiones basadas en datos para optimizar futuros esfuerzos.</p>

            <div id="carouselExample" class="carousel slide mt-5" data-bs-ride="carousel" data-bs-interval="5000">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>                    
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row m-auto">
                            @for ($i = 0; $i <= 4; $i++)
                                <div class="col">
                                    <div class="candidato-box">        
                                        <h3>{{$candidatos[$i]->name}}</h3>
                                        <div class="circle" style="background: conic-gradient(#facc15 {{($candidatos[$i]->puntuacion/(5/100))}}%, #e5e7eb 0%)">
                                            <div class="circle-content">
                                                <img class="imgTablaCandidato" src="{{ url('/') }}{{$candidatos[$i]->imagen}}" alt="">                                            
                                            </div>
                                        </div>     
                                        <div class="puntuacion">
                                            {{ $candidatos[$i]->puntuacion }} <i class="fa-solid fa-star text-warning"></i>
                                        </div>   
                                    </div>                                    
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row m-auto">
                            @for ($i = 5; $i <= 9; $i++)
                                <div class="col">
                                    <div class="candidato-box">        
                                        <h3>{{$candidatos[$i]->name}}</h3>
                                        <div class="circle" style="background: conic-gradient(#facc15 {{($candidatos[$i]->puntuacion/(5/100))}}%, #e5e7eb 0%)">
                                            <div class="circle-content">
                                                <img class="imgTablaCandidato" src="{{ url('/') }}{{$candidatos[$i]->imagen}}" alt="">                                            
                                            </div>
                                        </div>    
                                        <div class="puntuacion">
                                            {{ $candidatos[$i]->puntuacion }} <i class="fa-solid fa-star text-warning"></i>
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
            
        </div>
    </div>
</div>
@endsection