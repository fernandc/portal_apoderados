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