@extends('../layouts.backoffice')

@section('title', 'Dashboard')
@section('subtitle', 'Para tomar decisiones acertadas, es fundamental analizar los resultados obtenidos hasta ahora.')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">¿Como está el rendimiento de las campañas?</h5>
            <p class="card-text mb-3">Evaluar el rendimiento de las campañas nos permite identificar qué estrategias están generando mejores resultados, detectar oportunidades de mejora y tomar decisiones basadas en datos para optimizar futuros esfuerzos.</p>

            <div class="desktop">
                <div id="carouselDesktop" class="carousel slide mt-5" data-bs-ride="carousel" data-bs-interval="4000">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselDesktop" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselDesktop" data-bs-slide-to="1" aria-label="Slide 2"></button>                    
                        <button type="button" data-bs-target="#carouselDesktop" data-bs-slide-to="2" aria-label="Slide 3"></button>                    
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="row m-auto">
                                @for ($i = 0; $i <= 3; $i++)
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
                                @for ($i = 4; $i <= 7; $i++)
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
                            <div class="row justify-content-md-center">
                                @for ($i = 8; $i <= 9; $i++)
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
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselDesktop" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselDesktop" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <div class="mobile">
                <div id="carouselMobile" class="carousel slide mt-5" data-bs-ride="carousel" data-bs-interval="3000">                    
                    <div class="carousel-inner">
                        @foreach ($candidatos as $candidato)
                            <div class="carousel-item @if ($loop->index == 0) active @endif">
                                <div class="candidato-box" onclick="location.window.href = '/candidato/{{$candidato->id}}'">        
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
                        @endforeach                                        
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselMobile" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselMobile" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

            </div>
            
            
        </div>
    </div>
</div>
<hr>
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Últimas Tendencias</h5>
            <p class="card-text mb-3">
                En un escenario político dinámico como el de las elecciones presidenciales, identificar y analizar las tendencias es fundamental para anticipar comportamientos del electorado, cambios en la opinión pública y variaciones en la intención de voto. Esta sesión tiene como objetivo explorar las principales tendencias que han marcado el desarrollo de la campaña, los factores que influyen en ellas y su posible impacto en los resultados finales.
            </p>
            
            <div class="desktop">
                <div class="row">
                    <div class="col-5">
                        <div class="list-group">
                            @foreach ($tendencias as $tendencia )
                                <button type="button" class="list-group-item list-group-item-action @if ($loop->index == 0) tendenciaSelect @endif" onClick="verTendencia({{$tendencia}})" id="tendencia_{{$tendencia->id}}">
                                    <i class="fa-regular fa-newspaper"></i> {{$tendencia->titulo}}
                                </button>
                            @endforeach                    
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="card">
                            <div class="card-body">
                                <div id="content-tendencia">
                                    @if (count($tendencias) > 0)
                                        {!! $tendencias[0]->contenido !!}
                                    @endif                            
                                </div>
                            </div>
                        </div>
                        
                    </div>

                </div>

                

                

            </div>

            <div class="accordion mobile" id="accordionTendencias">
                @foreach ($tendencias as $tendencia)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{$tendencia->id}}">
                            <button class="accordion-button @if ($loop->index != 0) collapsed @endif" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{$tendencia->id}}" aria-expanded="@if ($loop->index == 0)true @else false @endif" aria-controls="collapse{{$tendencia->id}}">
                                <i class="fa-regular fa-newspaper"></i> {{$tendencia->titulo}}
                            </button>
                        </h2>
                        <div id="collapse{{$tendencia->id}}" class="accordion-collapse collapse @if ($loop->index == 0) show @endif"
                            aria-labelledby="heading{{$tendencia->id}}" data-bs-parent="#accordionTendencias">
                            <div class="accordion-body">
                                {!! $tendencia->contenido !!}
                            </div>
                        </div>
                    </div>
                @endforeach
                
            </div>

            
        </div>
    </div>
</div>

<script src="{{ url('/') }}/js/home.js"></script>
@endsection