<!DOCTYPE html> 
@extends("layouts.mcdn")
@section("title")
Saint Charles Formularios
@endsection

@section("headex")
    <style>
        .mrnull{
            margin: 0.2rem 0px !important;
        }
    </style>
    @if(isset($message))
        <script>
            $( document ).ready(function() {
                Swal.fire({
                    icon: '{{$message["typ"]}}',
                    title: '{{$message["tit"]}}',
                    text: '{{$message["mes"]}}'
                })
            });
        </script>
    @endif
@endsection

@section("context")
    @if(Session::has('apoderado'))
        <?php 
            $var = session::get('apoderado');
            $id_apo= session::get('apoderado')['id'];   
        ?>
        <hr>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    
                </div>
                <div class="col-md-4">
                    <h2 style="text-align: center">Bienvenido <br> {{$var["names"]}} {{$var["last_p"]}} {{$var["last_m"]}}</h2>
                </div>
                <div class="col-md-4" style="text-align: right">
                    <a href="logout" class="btn btn-outline-danger text-danger">Salir</a>
                </div>
            </div>
            <hr>
            <!--NEW-->
            @php
                $home = "";
                $prof = "";
                $matr = "";
                $actPass = "";
                $homeC = "";
                $profC = "";
                $matrC = "";
                $actPassC = "";
                $circle_data = "";
                $circle_dataC = "";
                if (isset($_GET["active"])) {
                    $active = $_GET["active"];
                    if($active == "home"){$home = "active"; $homeC = "show active";}
                    elseif ($active == "info") {$prof = "active"; $profC = "show active";}
                    elseif ($active == "circle") {$circle_data = "active"; $circle_dataC = "show active";}
                    elseif ($active == "matricula") {$matr = "active"; $matrC = "show active";}
                    else {
                        $home = "active";
                        $prof = "";
                        $matr = "";
                        $circle_data = "";
                        $homeC = "show active";
                        $circle_dataC = "";
                        $profC = "";
                        $matrC = "";
                    }
                }else{
                    $home = "active";
                    $prof = "";
                    $matr = "";
                    $circle_data = "";
                    $homeC = "show active";
                    $circle_dataC = "";
                    $profC = "";
                    $matrC = "";
                }
            @endphp
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{$home}}" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Resumen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Actualizar mi información</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{$circle_data}}" id="circle-tab" data-toggle="tab" href="#circle" role="tab" aria-controls="circle" aria-selected="false">Mi círculo Familiar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="matriculas-tab" data-toggle="tab" href="#matriculas" role="tab" aria-controls="matriculas" aria-selected="false">Mis Alumnos matriculados 2021</a>
                    <script>
                        @if($dataProxy == NULL)
                            $("#matriculas-tab").remove();
                        @endif 
                    </script>
                </li>
            </ul>
            <hr>
            <div class="tab-content" id="myTabContent">
                @if($dataProxy == NULL)
                    <div class="alert alert-danger" role="alert">
                        Debe completar formulario <a href="/apoderados/home?active=info">Actualizar mi información</a> y <a href="/apoderados/home?active=circle">Mi círculo Familiar</a> para proceder a Ingresar datos de Alumno(s) Año Escolar 2021 <i class="fas fa-exclamation-triangle"></i> 
                    </div>
                @endif
                <div class="tab-pane fade {{$homeC}}" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Últimos Correos</h3>
                            <div>
                                <span class="badge badge-danger">Importante:</span> Estimado Apoderado, es importante que revise su correo ya que, pueden ir documentos adjuntos que no se mostrarán aquí. Si usted no recibe los correos por favor, valide su correo en <span class="text-primary">Actualizar mi información</span> o puede que los correos lleguen a su bandeja de <span class="text-danger">Spam</span>.

                            </div>
                            @if(isset($correos))
                                @foreach ($correos as $correo)
                                <div class="card bg-light mt-2" style="background-color: #f7f2b2 !important;">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-2 text-muted" style="text-align: right;#f7f2b2 !important">
                                            @if ($correo["diff"] == 0)
                                            <span class="badge badge-success">HOY</span>
                                            @elseif($correo["diff"] == 1)
                                            <span class="badge badge-primary">AYER</span>
                                            @else
                                            <span class="badge badge-info">Hace {{$correo["diff"]}} días</span>
                                            @endif
                                            {{$correo["date_in"]}}
                                        </h6>
                                        <h5 class="card-title">{{$correo["subject"]}}</h5>
                                        @php
                                            $mensaje = str_replace("@Apoderado",($var["names"]." ".$var["last_p"]),$correo["message"]);
                                        @endphp
                                        <p class="card-text" style="white-space: pre-wrap;max-height: 190px;overflow-y: auto;">{{$mensaje}}</p>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h3>Últimas Comunicaciones {{getenv("MATRICULAS_PARA")}}</h3>
                            <hr>
                            @if(isset($news))
                                @foreach ($news as $new)
                                <div class="card bg-light mt-2" >
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-2 text-muted" style="text-align: right;">
                                            @if ($new["diff"] == 0)
                                            <span class="badge badge-success">HOY</span>
                                            @elseif($new["diff"] == 1)
                                            <span class="badge badge-primary">AYER</span>
                                            @else
                                            <span class="badge badge-secondary">Hace {{$new["diff"]}} días</span>
                                            @endif
                                            {{$new["date_in"]}}
                                        </h6>
                                        <h5 class="card-title">{{$new["title"]}}</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">{{$new["subtitle"]}}</h6>
                                        <p class="card-text" style="white-space: pre-wrap;max-height: 190px;overflow-y: auto;">{{$new["body"]}}</p>
                                        <a href="{{$new["url"]}}" target="_blank" class="card-link">{{$new["text_url"]}}</a>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade {{$profC}}" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    @include('home_proxy_frames.proxy_data')
                </div>
                <div class="tab-pane fade {{$circle_dataC}}" id="circle" role="tabpanel" aria-labelledby="circle-tab">
                    @include('home_proxy_frames.fam_circle')
                </div>
                <div class="tab-pane fade {{$matrC}}" id="matriculas" role="tabpanel" aria-labelledby="matriculas-tab">
                    @include('home_proxy_frames.matriculas')
                </div>
            </div>
            <!--END-->
        </div>
    @else
        <script>
            $( document ).ready(function() {
                window.location = "/";
            });
        </script>
    @endif
    
@endsection