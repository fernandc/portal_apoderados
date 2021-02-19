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
                $homeC = "";
                $profC = "";
                $matrC = "";
                $circle_data = "";
                if (isset($_GET["active"])) {
                    $active = $_GET["active"];
                    if($active == "home"){$home = "active"; $homeC = "show active";}
                    elseif ($active == "info") {$prof = "active"; $profC = "show active";}
                    elseif ($active == "matricula") {$matr = "active"; $matrC = "show active";}
                    else {
                        $home = "active";
                        $prof = "";
                        $matr = "";
                        $homeC = "show active";
                        $home_circle = "show active";
                        $profC = "";
                        $matrC = "";
                    }
                }else{
                    $home = "active";
                    $prof = "";
                    $matr = "";
                    $circle_data = "show active";
                    $circle_dataC = "show active";
                    $profC = "";
                    $matrC = "";
                }
            @endphp
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{$home}}" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Mis Datos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{$prof}}" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Mi Información</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{$circle_data}}" id="circle-tab" data-toggle="tab" href="#circle" role="tab" aria-controls="circle" aria-selected="false">Mi círculo Familiar</a>
                </li>
                <li class="nav-item">
                   
                    <a class="nav-link" id="matriculas-tab" data-toggle="tab" href="#matriculas" role="tab" aria-controls="matriculas" aria-selected="false">Mis Alumnos matriculados</a>
                    
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
                        Debe completar formulario <a href="/apoderados/home?active=info">Mi información</a> para proceder a matrículas de estudiantes <i class="fas fa-anchor"></i> 
                    </div>
                @endif
                <div class="tab-pane fade {{$homeC}}" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="card">
                        <div class="card-body">
                            <p><strong>Nombre:</strong> {{$var["names"]}} {{$var["last_p"]}} {{$var["last_m"]}}</p>
                            <p><strong>Teléfono Celular:</strong> {{$var["cell_phone"]}}</p>
                            <p><strong>Email:</strong> {{$var["email"]}}</p>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade {{$profC}}" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    @include('home_proxy_frames.proxy_data')
                </div>
                <div class="tab-pane fade {{$circle_dataC}}" id="profile" role="tabpanel" aria-labelledby="profile-tab">
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