<!DOCTYPE html> 
@extends("layouts.mcdn")
@section("title")
Saint Charles Formularios
@endsection

@section("headex")

@endsection

@section("context")
    @if(Session::has('admin'))
    <div class="container-fluid">
        <div class="container-fluid">            
            <h4 class="mt-3">Bienvenido al panel de administración.</h4>
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
            window.location.href = "https://www.scc.cloupping.com/admin";
        });
        </script>
    @endif               
@endsection
