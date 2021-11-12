<!DOCTYPE html> 
@extends("layouts.mcdn")
@section("title")
Saint Charles Formularios
@endsection

@section("headex")
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script>
        var flag = 0;  
        var flag2 = 0;  
        var flag3 = 0;  
    </script>
@endsection

@section("context")
    @if(Session::has('admin'))
    <div class="container-fluid">
        <div class="container-fluid">            
            <h4 class="mt-3" id="test">Bienvenido al panel de administración.</h4>
            <hr>
            <button class="btn btn-success " type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                Agregar nuevo apoderado
            </button>

            <a class="btn btn-outline-danger text-danger" href="logout">Salir</a>
            <?php
            if(isset($_GET['error'])){
                ?>
                <script type='text/javascript'>alert('Este correo ya existe.');</script>                            
                <?php
            }
            ?>
            <div class="collapse mt-2" id="collapseExample">
                <div class="card card-body">
                    <form class="row" action="add_new_user" method="GET">
                        <div class="form-group col-4">
                            <label for="emailAdd">Rut</label>
                            <input type="text" class="form-control" name="dni" placeholder="Rut" required="">
                        </div>
                        <div class="form-group col-4">
                        </div>
                        <div class="form-group col-4">
                            <label for="emailAdd" style="color: white;">.</label>
                            <button id="sendform" type="submit" class="form-control btn btn-success">Agregar</button>
                        </div>
                        @if(isset($exc))
                            <script>
                            Swal.fire({
                                icon: 'warning',
                                title: 'Oops...',
                                text: '{{$exc}}'
                            })
                            </script>
                        @endif
                    </form>
                </div>
            </div>
            <hr>
            <input type="checkbox" id="switch_proceso_matri" checked data-toggle="toggle" data-on="Activado" data-off="Desactivado" data-onstyle="success" data-offstyle="danger"><b>  Activar/Desactivar proceso de inscripción de alumnos (matrículas).</b>
            @if(isset($stateProcess))
                @if($stateProcess == true)
                    <script>
                        $('#switch_proceso_matri').bootstrapToggle('on');
                    </script>
                @else
                    <script>
                        $('#switch_proceso_matri').bootstrapToggle('off');
                    </script>
                @endif
            @endif
            <hr>
            <input type="checkbox" id="switchEdit" checked data-toggle="toggle" data-on="Activado" data-off="Desactivado" data-onstyle="success" data-offstyle="danger" ><b>  Activar/Desactivar edición de formularios antecedentes de apoderados.</b>
            @if(isset($state))
                @if($state == true)
                    <script>
                        $('#switchEdit').bootstrapToggle('on');
                    </script>
                @else
                    <script>
                        $('#switchEdit').bootstrapToggle('off');
                    </script>
                @endif
            @endif
            <hr>
            <input type="checkbox" id="switch_student_forms" checked data-toggle="toggle" data-on="Activado" data-off="Desactivado" data-onstyle="success" data-offstyle="danger" ><b>  Activar/Desactivar formularios de datos de estudiantes.</b>
            @if(isset($stateStudentForms))
                @if($stateStudentForms == true)
                    <script>
                        $('#switch_student_forms').bootstrapToggle('on');
                    </script>
                @else
                    <script>
                        $('#switch_student_forms').bootstrapToggle('off');
                    </script>
                @endif
            @endif
            <script>
                $('#switchEdit').change(function() {
                    var state = document.getElementById('switchEdit').checked;
                    // console.log("state :" + state);
                    if(flag == 0){
                        Swal.fire({
                        title: 'Estás seguro de realizar este cambio? ',                        
                        icon: 'warning',
                        showCancelButton: true,
                        allowOutsideClick: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, cambiar!'
                        }).then((result) => {
                            // console.log("ResultEDIT: " + result.isConfirmed);
                            if (result.isConfirmed) {
                                $.ajax({
                                    type: "GET",
                                    url: "check_edit_forms",
                                    data: {state},                        
                                    success: function(data)
                                    {
                                        // console.log(data);
                                        if(data != 200){
                                            Swal.fire(
                                                'Error!',
                                                'Se ha producido un error, intente nuevamente y si el error persiste contáctese con soporte.',
                                                'error'
                                            )     
                                        }
                                    }
                                });
                                Swal.fire(
                                'Cambiado!',
                                'Se ha activado/desactivado la edición de los formularios',
                                'success'
                                )
                                                         
                            }else if(result.isConfirmed == false){
                                
                                flag++;
                                if( state == true ){
                                    $('#switchEdit').bootstrapToggle('off');
                                }else{
                                    $('#switchEdit').bootstrapToggle('on');
                                }
                            }
                        })
                    }else{
                        flag = 0;
                    }   
                });
                $('#switch_proceso_matri').change(function() {
                    var stateProcess = document.getElementById('switch_proceso_matri').checked;
                    // console.log("stateprocess :" + stateProcess);
                    if(flag2 == 0){
                        Swal.fire({
                        title: 'Estás seguro de realizar este cambio? ',                        
                        icon: 'warning',
                        showCancelButton: true,
                        allowOutsideClick: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, cambiar!'
                        }).then((result) => {
                            // console.log("ResultMATRI: " + result.isConfirmed);
                            if (result.isConfirmed) {
                                $.ajax({
                                    type: "GET",
                                    url: "check_matri_process",
                                    data: {stateProcess},                        
                                    success: function(data)
                                    {
                                        // console.log(data);
                                        if(data != 200){
                                            Swal.fire(
                                                'Error!',
                                                'Se ha producido un error, intente nuevamente y si el error persiste contáctese con soporte.',
                                                'error'
                                            )     
                                        }
                                    }
                                });
                                Swal.fire(
                                'Cambiado!',
                                'Se ha activado/desactivado el proceso de inscripción de alumnos.',
                                'success'
                                )                              
                            }else if(result.isConfirmed == false){
                                flag2++;
                                if( stateProcess == true ){
                                    $('#switch_proceso_matri').bootstrapToggle('off');
                                }else{
                                    $('#switch_proceso_matri').bootstrapToggle('on');
                                }
                            }
                        })
                    }else{
                        flag2 = 0;
                    }   
                });      
                $('#switch_student_forms').change(function() {
                    var stateStudentForm = document.getElementById('switch_student_forms').checked;
                    // console.log("state :" + state);
                    if(flag3 == 0){
                        Swal.fire({
                        title: 'Estás seguro de realizar este cambio? ',                        
                        icon: 'warning',
                        showCancelButton: true,
                        allowOutsideClick: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, cambiar!'
                        }).then((result) => {
                            // console.log("ResultEDIT: " + result.isConfirmed);
                            if (result.isConfirmed) {
                                $.ajax({
                                    type: "GET",
                                    url: "check_student_forms",
                                    data: {stateStudentForm},                        
                                    success: function(data)
                                    {
                                        console.log(data);
                                        if(data != 200){
                                            Swal.fire(
                                                'Error!',
                                                'Se ha producido un error, intente nuevamente y si el error persiste contáctese con soporte.',
                                                'error'
                                            )     
                                        }
                                    }
                                });
                                Swal.fire(
                                'Cambiado!',
                                'Se ha activado/desactivado la edición de los formularios',
                                'success'
                                )
                                                         
                            }else if(result.isConfirmed == false){
                                
                                flag3++;
                                if( stateStudentForm == true ){
                                    $('#switch_student_forms').bootstrapToggle('off');
                                }else{
                                    $('#switch_student_forms').bootstrapToggle('on');
                                }
                            }
                        })
                    }else{
                        flag3 = 0;
                    }   
                });          
            </script>
            <hr>
            @if ( session('message') )
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            @if ( session('error') )
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <!-- aplicar data table en español -->
            <div class="table-responsive">
                <table class="table table-sm" style="text-align: center;" id="miFormulario">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Rut</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Contraseña</th>
                            <th scope="col">¿Está verificada?</th>
                            <th scope="col">Último ingreso</th>
                            <th scope="col">Matriculados</th>
                            <th scope="col">Completados</th>
                            <th scope="col">Documentos</th>
                            <th scope="col">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($emails as $row)
                            <tr>
                                <td>{{$row["dni"]}}</td>
                                <td>{{$row["email"]}}</td>
                                <td>{{$row["passwd"]}}</td>
                                <td>
                                    @if($row["is_active"]=="TRUE")
                                    <span class="text-success">Verificada</span>
                                    @else 
                                        @if ($row["email"] != "")
                                            <button id="btnactivateemail{{$row["id"]}}" class="btn btn-warning btn-sm" >Verificar Manual</button>
                                            <script>
                                                $("#btnactivateemail{{$row["id"]}}").click(function(){
                                                    $.ajax({
                                                        type: "GET",
                                                        url: "activate_mail_user",
                                                        data: "id={{$row["id"]}}", // serializes the form's elements.
                                                        success: function(data)
                                                        {
                                                            
                                                            $("#btnactivateemail{{$row["id"]}}").removeClass("btn-warning");
                                                            $("#btnactivateemail{{$row["id"]}}").addClass("btn-success");
                                                            $("#btnactivateemail{{$row["id"]}}").html("Verificada");
                                                            $("#btnactivateemail{{$row["id"]}}").removeAttr("id")
                                                        }
                                                    });
                                                });
                                            </script>
                                        @else
                                        <span class="text-warning">No Verificada</span>
                                        @endif
                                    @endif
                                </td> 
                                <td>
                                    @if($row["date_login"]==null)
                                    <span class="text-danger"><span style="color: transparent;">0</span>No ha ingresado.</span>
                                    @else
                                        <span class="text-success">{{$row["date_login"]}}</span>
                                    @endif
                                </td>
                                <td>
                                @if($row["matriculados"]==0)
                                    <span class="text-danger">{{$row["matriculados"]}}</span>                                
                                @else
                                    <span class="text-success">{{$row["matriculados"]}}</span>
                                @endif
                                </td>
                                <td>
                                    @if($row["completados"]==$row["matriculados"] && $row["completados"]!=0)
                                    <span class="text-success">{{$row["completados"]}}</span>                                
                                    @else
                                        <span class="text-danger">{{$row["completados"]}}</span>
                                    @endif
                                </td>
                                <td>
                                    <button id="btnmodal{{$row["id"]}}" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#showmodal{{$row["id"]}}">Ver Estudiantes</button>
                                    <script>
                                        $("#btnmodal{{$row["id"]}}").click(function(){
                                            $.ajax({
                                                type: "GET",
                                                url: "datos_students",
                                                data: "id={{$row["id"]}}", // serializes the form's elements.
                                                success: function(data)
                                                {
                                                    $("#modalbody{{$row["id"]}}").html(data);
                                                }
                                            });
                                        });
                                    </script>
                                    <div class="modal fade" id="showmodal{{$row["id"]}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalScrollableTitle">Alumnos de <span class="text-primary">{{$row["email"]}}</span></h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                              <div id="modalbody{{$row["id"]}}" class="modal-body">
                                              
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </td>
                                
                                <td>
                                    @if($row["status"]=="ACTIVA")
                                        <a href="disable_user?id_user={{$row["id"]}}&method=INACTIVA" class="btn btn-primary btn-sm">Cuenta activada</a>
                                    @else
                                        <a href="disable_user?id_user={{$row["id"]}}&method=ACTIVA" class="btn btn-secondary btn-sm">Cuenta desactivada</a>
                                    @endif
                                </td>
                            </tr>                
                        @endforeach             
                    </tbody>
                </table>
                <script>
                $(document).ready( function () {
                    $('#miFormulario').DataTable({
                        language: {
                            "decimal": "",
                            "emptyTable": "No hay información",
                            "info": "Mostrando _START_ a _END_ de _TOTAL_ Filas",
                            "infoEmpty": "Mostrando 0 to 0 of 0 Filas",
                            "infoFiltered": "(Filtrado de _MAX_ total Filas)",
                            "infoPostFix": "",
                            "thousands": ",",
                            "lengthMenu": "Mostrar _MENU_ Filas",
                            "loadingRecords": "Cargando...",
                            "processing": "Procesando...",
                            "search": "Buscar:",
                            "zeroRecords": "Sin resultados encontrados",
                            "paginate": {
                                "first": "Primero",
                                "last": "Ultimo",
                                "next": "Siguiente",
                                "previous": "Anterior"
                                }
                        },
                    });
                } );
                </script>      
            </div>
        </div>
    </div>
    @else
        <script>
        $( document ).ready(function() {
            window.location.href = "https://saintcharlescollege.cl/apoderados/admin";
        });
        </script>
    @endif               
@endsection
