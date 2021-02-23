<div class="row">
    <div class="col-md-6">
        <div class="card bg-primary mb-1" >
            <div class="card-body">
                <h5 class="card-title text-white">Datos del Alumno Año Escolar 2021</h5>
                <p class="card-text text-white">Se requiere completar los formularios y aceptar las condiciones mencionadas.</p>
                <button class="btn btn-light btn-sm" data-toggle="modal" data-target="#staticBackdrop">Crear nuevo registro</button>
                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Datos del Alumno Año Escolar 2021</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <form class="was-validated" action="add_student" method="GET">
                            <div class="modal-body">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="rutalumno">Rut</label>
                                        <input id="rutalumno" class="form-control is-invalid" autocomplete="off" name="rut" type="text" required=""  oninput="checkRut(this)" placeholder="Rut del alumno" minlength="6" maxlength="11">
                                        <script>
                                            function checkRut(rut) {
                                                $("#btnapisearch").removeClass("btn-secondary");
                                                $("#btnapisearch").removeClass("btn-success");
                                                $("#btnapisearch").addClass("btn-primary");
                                                $("#btnapisearch").attr("disabled",false);
                                                $("#btnapisearch").html("Autocompletar");
                                                var valor = rut.value.replace('.','');
                                                valor = valor.replace('-','');
                                                cuerpo = valor.slice(0,-1);
                                                dv = valor.slice(-1).toUpperCase();
                                                rut.value = cuerpo + '-'+ dv
                                                if(cuerpo.length < 7) { rut.setCustomValidity("RUT Incompleto"); return false;}
                                                suma = 0;
                                                multiplo = 2;
                                                for(i=1;i<=cuerpo.length;i++) {
                                                    index = multiplo * valor.charAt(cuerpo.length - i);
                                                    suma = suma + index;
                                                    if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }
                                                }
                                                dvEsperado = 11 - (suma % 11);
                                                dv = (dv == 'K')?10:dv;
                                                dv = (dv == 0)?11:dv;
                                                if(dvEsperado != dv) { rut.setCustomValidity("RUT Inválido"); return false; }
                                                rut.setCustomValidity('');
                                            }
                                        </script>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="btnapisearch">Buscar datos por el rut</label>
                                        <button class="form-control btn btn-primary" type="button" id="btnapisearch">Autocompletar</button>
                                        <script>
                                        $("#btnapisearch").click(function(){
                                            $("#btnapisearch").html("Cargando");
                                            $("#btnapisearch").attr("disabled",true);
                                            var rut = $("#rutalumno").val();
                                            var res = rut.substring(0,2)+"."+rut.substring(2,5)+"."+rut.substring(5,10);
                                            $.ajax({
                                                type: "GET",
                                                url: "get_info/",
                                                data: "rut="+res,
                                                success: function(data)
                                                {
                                                    if(data.length > 10){
                                                        var obj = JSON.parse(data);
                                                        var res = obj.full_name.split(" ");
                                                        var names = "";
                                                        for (i = 0; i < res.length; i++) {
                                                            if(i==0){
                                                                $("#apellido_p").val(res[i]);
                                                            }else if(i==1){
                                                                $("#apellido_m").val(res[i]);
                                                            }else{
                                                                names = names + " " + res[i];
                                                            }
                                                        }
                                                        $("#nombres").val(names);
                                                        $('#ddlgenero option[value="'+obj.gender+'"]').attr("selected", "selected");
                                                        $("#btnapisearch").attr("disabled",true);
                                                        $("#btnapisearch").removeClass("btn-primary");
                                                        $("#btnapisearch").removeClass("btn-secondary");
                                                        $("#btnapisearch").addClass("btn-success");
                                                        $("#btnapisearch").html("Actualizado");
                                                    }else{
                                                        $("#btnapisearch").removeClass("btn-primary");
                                                        $("#btnapisearch").addClass("btn-secondary");
                                                        $("#btnapisearch").attr("disabled",true);
                                                        $("#btnapisearch").html("No encontrad@ :(");
                                                    }
                                                },
                                                error: function(data2){
                                                    Swal.fire('Error! B', '', 'error')
                                                }
                                            });
                                        });
                                        </script>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="btnapisearch">Nombres</label>
                                        <input id="nombres" type="text" class="form-control" required="" name="nombres" minlength="2" placeholder="Nombres">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="btnapisearch">Apellido Paterno</label>
                                        <input id="apellido_p" type="text" class="form-control" required="" name="apellido_p" minlength="2" placeholder="Apellido paterno">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="btnapisearch">Apellido Materno</label>
                                        <input id="apellido_m" type="text" class="form-control" required="" name="apellido_m" minlength="2" placeholder="Apellido materno ">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="btnapisearch">Género</label>
                                        <select id="ddlgenero" class="custom-select mr-sm-2" autocomplete="off" name="ddlgenero" required="">
                                            <option disabled="" selected="" value="">Seleccionar</option>
                                            <option value="VAR">Hombre</option>
                                            <option value="MUJ">Mujer</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="btnapisearch">Nacionalidad</label>
                                        <input type="text" class="form-control" required="" name="nacionalidad" minlength="4" placeholder="Nacionalidad ">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="btnapisearch">Etnia</label>
                                        <select class="custom-select mr-sm-2" autocomplete="off" name="ddletina" required="">
                                            <option selected="">Ninguna</option>
                                            <option>Mapuche</option>
                                            <option>Aimara</option>
                                            <option>Atacameña</option>
                                            <option>Diaguita</option>
                                            <option>Otro</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="btnapisearch">Fecha de Nacimiento</label>
                                        <input id="thedate" class="form-control" type="date" name="fecha_nac" value="" required=""/>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="btnapisearch">Edad</label>
                                        <input id="age" class="form-control" type="text" value="" readonly=""/>
                                        <script>
                                            $('#thedate').change(function () {
                                                var date = $("#thedate").val();
                                                dob = new Date(date);
                                                var today = new Date();
                                                var age = Math.floor((today - dob) / (365.25 * 24 * 60 * 60 * 1000));
                                                $('#age').val(age);
                                            });
                                        </script>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="btnapisearch">Curso año 2021</label>
                                        <select class="custom-select mr-sm-2" autocomplete="off" name="ddlcurso" required="">
                                            <option disabled="" selected="" value="">Seleccionar</option>
                                            <option value="1">Pre-Kinder</option>
                                            <option value="2">Kinder</option>
                                            <option value="3">Primero Básico</option>
                                            <option value="4">Segundo Básico</option>
                                            <option value="5">Tercero Básico</option>
                                            <option value="6">Cuarto Básico</option>
                                            <option value="7">Quinto Básico</option>
                                            <option value="8">Sexto Básico</option>
                                            <option value="9">Séptimo Básico</option>
                                            <option value="10">Octavo Básico</option>
                                            <option value="11">Primero Medio</option>
                                            <option value="12">Segundo Medio</option>
                                            <option value="13">Tercero Medio</option>
                                            <option value="14">Cuarto Medio</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-success">Guardar</button>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- REGISTROS -->
    @foreach($matriculas as $row)
    <div id="card{{$row["id_stu"]}}" class="col-md-6">
        <div class="card mb-1" >
            <div class="card-body">
                <h5 >{{$row["nombre_stu"]}}</h5>
                <p class="card-text">
                    <hr class="mrnull">
                    Curso : <span class="text-success">{{$row["curso"]}} - {{$row["para_periodo"]}}</span>
                    
                    <hr class="mrnull">
                    <a class="triggmodal{{$row["id_stu"]}}" data="stuinfo" href="#">Información del estudiante y curso {{$row["para_periodo"]}}</a>
                    <span class="badge badge-success">Completada</span> 
                    
                    <hr class="mrnull">
                    <a class="triggmodal{{$row["id_stu"]}}" data="stuback" href="#">Antecedentes del estudiante</a>
                    @if($row["antecedentes"] == 0)
                    <span class="badge badge-warning">Pendiente</span> 
                    @else
                    <span class="badge badge-success">Completada</span>
                    @endif
                    
                    <hr class="mrnull">
                    @if($row["antecedentes"] == 0)
                        <span class="text-secondary" >Antecedentes de la Madre </span>
                    @else
                        <a class="triggmodal{{$row["id_stu"]}}" data="proxys&parent=m" href="#">Antecedentes de la Madre </a>
                    @endif
                    @if($row["a_madre"] == 0)
                    <span class="badge badge-warning">Pendiente</span> 
                    @else
                    <span class="badge badge-success">Completada</span>
                    @endif

                    <br>
                    @if($row["a_madre"] == 0)
                        <span class="text-secondary" >Antecedentes del Padre </span>
                    @else
                        <a class="triggmodal{{$row["id_stu"]}}" data="proxys&parent=f" href="#">Antecedentes del Padre </a>
                    @endif
                    @if($row["a_padre"] == 0)
                    <span class="badge badge-warning">Pendiente</span> 
                    @else
                    <span class="badge badge-success">Completada</span>
                    @endif
                    <br>

                    @if($row["a_padre"] == 0)
                        <span class="text-secondary" >Apoderado </span>
                    @else
                    <a class="triggmodal{{$row["id_stu"]}}" data="proxys&parent=p" href="#">Apoderado </a>
                    @endif

                    @if($row['apoderado'] != "" && $row['apoderado'] != null)
                    <span class="badge badge-primary">{{$row['apoderado']}}</span>
                    <span class="badge badge-success">Completada</span>
                    @else
                    <span class="text-danger">[No Definido]</span>
                    <span class="badge badge-warning">Pendiente</span>
                    @endif

                    <hr class="mrnull">
                    @if($row['apoderado'] != "" && $row['apoderado'] != null)
                        <a class="triggmodal{{$row["id_stu"]}}" data="circle" href="#">Información adicional importante</a>
                    @else
                        <span class="text-secondary" >Información adicional importante</span>
                    @endif

                    @if($row["misc"] == 0)
                    <span id="lastone{{$row["id_stu"]}}" class="badge badge-warning">Pendiente</span> 
                    @else
                    <span class="badge badge-success">Completada</span>
                    @endif
                    <hr>
                    @if($row["antecedentes"] != 0 && $row["a_madre"] !=0 && $row["a_padre"] !=0 && $row["apoderado"] != "" && $row["apoderado"] != NULL && $row["confirmado"] != "1")
                        
                        <button class="btn btn-success" id="send{{$row["id_stu"]}}">Enviar datos</button>
                    @elseif($row["confirmado"]== "1")
                        <button class="btn btn-success" id="send{{$row["id_stu"]}}">Reenviar datos</button>
                    @else
                        <button class="btn btn-success disabled" id="">Enviar datos</button>
                    @endif
                    <button id="del{{$row["id_stu"]}}" class="btn btn-outline-danger rounded float-right"><i class="fas fa-trash-alt"></i></button>
                    <script>
                        $("#del{{$row["id_stu"]}}").click(function(){
                            Swal.fire({
                                title: '¿Quieres eliminar a {{$row["nombre_stu"]}}?',
                                showDenyButton: true,
                                showCancelButton: true,
                                confirmButtonText: `Eliminar`,
                                confirmButtonColor: '#d33',
                                denyButtonText: `Cancelar`,
                                }).then((result) => {
                                /* Read more about isConfirmed, isDenied below */
                                    if (result.isConfirmed) {                                     
                                        $.ajax({
                                            type: "GET",
                                            url: "del_inscription/",
                                            data: "stu={{$row["id_stu"]}}",     
                                            success: function(data)
                                            {
                                                if(data == "OK"){
                                                    $("#card{{$row["id_stu"]}}").remove();
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: 'Matricula Eliminada',
                                                        text: 'La matricula ha sido eliminada pero los datos han sido guardados'
                                                    });
                                                }else{
                                                    Swal.fire('Error! A', data, 'error')
                                                }
                                            },
                                            error: function(data2){
                                                Swal.fire('Error! B', '', 'error')
                                            }
                                        });
                                    } else if (result.isDenied) {
                                        Swal.fire('No se realizaron cambios.', '', 'info')
                                    }
                                })
                        });
                        $("#send{{$row["id_stu"]}}").click(function (){
                            Swal.fire({
                                title: '¿Quieres enviar los datos de {{$row["nombre_stu"]}}?',
                                showDenyButton: true,
                                showCancelButton: true,
                                confirmButtonText: `Enviar`,
                                confirmButtonColor: '#28a745',
                                denyButtonText: `Cancelar`,
                            }).then((result) => {
                                /* Read more about isConfirmed, isDenied below */
                                    if (result.isConfirmed) {
                                        var sweet_loader = '<div class="sweet_loader"><i class="fas fa-circle-notch fa-spin" style="font-size:45pt;"></i></div>';
                                        $.ajax({
                                            type: "GET",
                                            url: "sendInscription/",
                                            data: "student={{$row["id_stu"]}}",
                                            beforeSend: function(){
                                                Swal.fire({
                                                    html: '<h5>Enviando datos...</h5>',
                                                    showConfirmButton:false,
                                                    onRender: function(){
                                                        $('.swal2-content').prepend(sweet_loader);
                                                    }

                                                });
                                            },
                                            success: function(data)
                                            {
                                                if(data == "OK"){
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: 'Datos Enviados',
                                                        text: 'Se ha enviado una copia de la información ingresada a su correo electrónico.'
                                                    });
                                                }else{
                                                    Swal.fire('Error! A', data, 'error')
                                                }
                                            },
                                            error: function(data2){
                                                Swal.fire('Error! B', '', 'error')
                                            }
                                        });
                                    } else if (result.isDenied) {
                                        Swal.fire('No se realizaron cambios.', '', 'info')
                                    }
                                })
                        })
                    </script>
                        <div id="globmod{{$row["id_stu"]}}" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                                <div id="datamodal{{$row["id_stu"]}}" class="modal-content">
                                    
                                </div>
                            </div>
                        </div>
                        <script>
                            $(".triggmodal{{$row["id_stu"]}}").click(function(){
                                $("#datamodal{{$row["id_stu"]}}").html('<div class="d-flex justify-content-center" style="margin: 1rem;"><div class="spinner-border text-primary" role="status" ><span class="sr-only">Loading...</span></div></div>');
                                        var meth = $(this).attr("data")
                                        $('#globmod{{$row["id_stu"]}}').modal('show');
                                        $.ajax({
                                            type: "GET",
                                            url: "modal_data",
                                            data:"stu={{$row["id_stu"]}}&data="+meth+"&id_apo={{$id_apo}}",
                                            success: function(data)
                                            {
                                                $("#datamodal{{$row["id_stu"]}}").html(data);
                                            },
                                error: function(data2){
                                    Swal.fire('Error! B', '', 'error')
                                }
                            });
                        });
                    </script>
                </p>
            </div>
        </div>
    </div>
    @endforeach
</div>