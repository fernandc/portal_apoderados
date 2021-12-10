<?php
  $rut = Session::get('apoderado')['dni'];
  $nombresparent = NULL;
  $apellido_pparent = NULL;
  $apellido_mparent = NULL;
  $born_date = NULL;
  $legal_civil_status = NULL;
  $current_civil_status = NULL;
  $districtparent = NULL;
  $addressparent = NULL;
  $phoneparent = NULL;
  $cellphoneparent = NULL;
  $emailparent = NULL;
  $educational_level = NULL;
  $work = NULL;
  $work_address = NULL;
  $work_phone = NULL;

  if($dataProxy !=NULL){
    $born_date = $dataProxy[0]["born_date"];
    $nombresparent = $dataProxy[0]["names"];
    $apellido_pparent = $dataProxy[0]["last_f"];
    $apellido_mparent = $dataProxy[0]["last_m"];
    $legal_civil_status = $dataProxy[0]["legal_civil_status"];
    $current_civil_status = $dataProxy[0]["current_civil_status"];
    $districtparent = $dataProxy[0]["district"];
    $addressparent = $dataProxy[0]["address"];
    $phoneparent = $dataProxy[0]["phone"];
    $cellphoneparent = $dataProxy[0]["cellphone"];
    $emailparent = $dataProxy[0]["email"];
    $educational_level = $dataProxy[0]["educational_level"];
    $work = $dataProxy[0]["work"];
    $work_address = $dataProxy[0]["work_address"];
    $work_phone = $dataProxy[0]["work_phone"];
  }
?>


<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="profile-info-tab" data-toggle="tab" href="#profile-info" role="tab" aria-controls="profile-info" aria-selected="false">Actualizar mis datos</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " id="change-pass-tab" data-toggle="tab" href="#change-pass" role="tab" aria-controls="change-pass" aria-selected="false">Cambiar contraseña</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " id="change-proxy-tab" data-toggle="tab" href="#change-proxy" role="tab" aria-controls="change-proxy" aria-selected="false">Cambiar Alumnos de Apoderado</a>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="profile-info" role="tabpanel" aria-labelledby="profile-info-tab">
        <hr>
        <form action="add_proxy_data" method="GET">
            <div id="formproxy" class="row" style="font-size: 0.9rem">
                <div class="col-md-12">
                    <span class="text-danger" style="font-size: large;">
                        Los datos solicitados deben ser relacionados al Rut: <span class="badge badge-warning">{{substr($rut,0,-1)}}</span> , dado que este pertenece al apoderado de los alumnos ingresados.
                        <br>
                        En caso de que dicho rut no sea del apoderado, debe contactarse con el establecimiento.
                    </span>
                    <hr>
                </div>
                <div class="form-group col-md-6" style="display: none">
                    <label for="rutparent">Rut <span class="text-danger">(Importante)</span></label>
                    <input id="rutparent" class="form-control" autocomplete="off" name="rut" value="{{$rut}}" type="text" oninput="checkRut(this)" minlength="1" maxlength="11">
                    <script>
                        $("#rutparent").keyup(function(){
                            $("#btnapisearch2").removeClass("btn-secondary");
                            $("#btnapisearch2").removeClass("btn-success");
                            $("#btnapisearch2").addClass("btn-primary");
                            $("#btnapisearch2").attr("disabled",false);
                            $("#btnapisearch2").html("Autocompletar");
                        });
                        function checkRut(rut) {
                            
                            var valor = rut.value.replace('.','');
                            valor = valor.replace('-','');
                            cuerpo = valor.slice(0,-1);
                            dv = valor.slice(-1).toUpperCase();
                            rut.value = cuerpo + '-'+ dv
                            
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
                            
                            rut.setCustomValidity('');
                        }
                    </script>
                </div>
                <div class="form-group col-md-6" style="display: none">
                    <label for="btnapisearch2">Buscar datos por el rut</label>
                    <button class="form-control btn btn-primary" type="button" id="btnapisearch2">Autocompletar</button>
                    <script>
                    $("#btnapisearch2").click(function(){
                        $("#btnapisearch2").html("Cargando");
                        $("#btnapisearch2").attr("disabled",true);
                        var rut = $("#rutparent").val();
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
                                            $("#apellido_pparent").val(res[i]);
                                        }else if(i==1){
                                            $("#apellido_mparent").val(res[i]);
                                        }else{
                                            names = names + " " + res[i];
                                        }
                                    }
                                    $("#nombresparent").val(names);
                                    $("#addressparent").val(obj.address);
                                    //$('#ddlgenero option[value="'+obj.gender+'"]').attr("selected", "selected");
                                    $("#btnapisearch2").attr("disabled",true);
                                    $("#btnapisearch2").removeClass("btn-primary");
                                    $("#btnapisearch2").removeClass("btn-secondary");
                                    $("#btnapisearch2").addClass("btn-success");
                                    $("#btnapisearch2").html("Actualizado");
                                }else{
                                    $("#btnapisearch2").removeClass("btn-primary");
                                    $("#btnapisearch2").addClass("btn-secondary");
                                    $("#btnapisearch2").attr("disabled",true);
                                    $("#btnapisearch2").html("Rut no encontrado :(");
                                }
                            },
                            error: function(data2){
                                Swal.fire('Error! B', '', 'error')
                            }
                        });
                    });
                    </script>
                </div>
                
                <div class="form-group col-md-4">
                    <label for="">Nombres <span class="text-danger">(Importante)</span></label>
                    <input readonly id="nombresparent" type="text" class="form-control" name="nombresparent" value="{{$nombresparent}}" placeholder="Nombres" minlength="2" required="">
                </div>
                <div class="form-group col-md-4">
                    <label for="">Apellido Paterno <span class="text-danger">(Importante)</span></label>
                    <input readonly id="apellido_pparent" type="text" class="form-control" name="apellido_pparent" value="{{$apellido_pparent}}" placeholder="Apellido paterno" minlength="2" required="">
                </div>
                <div class="form-group col-md-4">
                    <label for="">Apellido Materno <span class="text-danger">(Importante)</span></label>
                    <input readonly id="apellido_mparent" type="text" class="form-control" name="apellido_mparent" value="{{$apellido_mparent}}" placeholder="Apellido materno" minlength="2" required="">
                </div>
                <div class="form-group col-md-4">
                    <label for="">Fecha de Nacimiento <span class="text-danger">(Importante)</span></label>
                    <input readonly id="fecha_nacparent" class="form-control" type="date" name="fecha_nacparent" value="{{$born_date}}">
                </div>
                <input id="ddllive_with" type="text" class="form-control" name="ddllive_with" value="Si" hidden="">
                <input id="visits_per_months" type="text" class="form-control" name="visits_per_months" value="0" hidden="">
                <div class="form-group col-md-4">
                    <label for="">Estado Civil Legal <span class="text-danger">(Importante)</span></label>
                    <select disabled id="ddllegal_civil_status" class="custom-select mr-sm-2" autocomplete="off" name="legal_civil_status">
                        <option disabled="" selected="" value="Sin Información">Seleccionar</option>
                        <option value="soltero">Soltero/a</option>
                        <option value="casado">Casado/a</option>
                        <option value="viudo">Viudo/a</option>
                        <option value="divorciado">Divorciado/a</option>
                        <option value="separado">Separado/a</option>
                    </select>
                    @if(isset($legal_civil_status))
                    <script>
                        $( document ).ready(function() {
                            $('#ddllegal_civil_status option[value={{$legal_civil_status}}]').prop('selected', true);
                        });
                    </script>
                    @endif
                </div>
                <div class="form-group col-md-4">
                    <label for="">Estado Civil Actual (No acorde a lo legal) <span class="text-danger">(Importante)</span></label>
                    <select disabled id="ddlcurrent_civil_status" class="custom-select mr-sm-2" autocomplete="off" name="current_civil_status">
                        <option disabled="" selected="" value="Sin Información">Seleccionar</option>
                        <option value="convive">Convive</option>
						<option value="soltero">Soltero/a</option>
                        <option value="casado">Casado/a</option>
                        <option value="viudo">Viudo/a</option>
                        <option value="divorciado">Divorciado/a</option>
                        <option value="separado">Separado/a</option>
                    </select>
                    @if(isset($current_civil_status))
                    <script>
                        $( document ).ready(function() {
                            $('#ddlcurrent_civil_status option[value={{$current_civil_status}}]').prop('selected', true);
                        });
                    </script>
                    @endif
                </div>
                <div class="form-group col-md-6">
                    <label>Comuna <span class="text-danger">(Importante)</span></label>
                    <input readonly id="districtparent" type="text" class="form-control" name="districtparent" value="{{$districtparent}}" placeholder="Ej: La Florida" minlength="2" required="">
                </div>
                <div class="form-group col-md-6">
                    <label>Dirección <span class="text-danger">(Importante)</span></label>
                    <input readonly id="addressparent" type="text" class="form-control" name="addressparent" value="{{$addressparent}}" placeholder="Calle #" minlength="2" required="">
                </div>
                <div class="form-group col-md-4">
                    <label>Teléfono Casa <span class="text-danger">(Importante)</span></label>
                    <input type="text" class="form-control" name="phoneparent" value="{{$phoneparent}}" minlength="2" >
                </div>
                <div class="form-group col-md-4">
                    <label>Celular <span class="text-danger">(Importante)</span></label>
                    <input type="text" class="form-control" name="cellphoneparent" value="{{$cellphoneparent}}" minlength="2" required="">
                </div>
                <div class="form-group col-md-4">
                    <label>Email <span class="text-danger">(Importante)</span></label>
                    <input type="email" class="form-control" name="emailparent" value="{{$emailparent}}" minlength="2" required="">
                </div>
                <div class="form-group col-md-6">
                    <label>Nivel de estudios <span class="text-danger">(Importante)</span></label>
                    <select disabled id="dlleducational_level" class="custom-select mr-sm-2" autocomplete="off" name="educational_level">
                        <option disabled="" selected="{{$educational_level}}" value="Sin Información">Seleccionar</option>
                        <option value="Básica incompleta">Básica incompleta</option>
                        <option value="Básica completa">Básica completa</option>
                        <option value="Media incompleta">Media incompleta</option>
                        <option value="Media completa">Media completa</option>
                        <option value="Técnico profesional incompleta">Técnico profesional incompleta</option>
                        <option value="Técnico profesional completa">Técnico profesional completa</option>
                        <option value="Superior incompleta">Universidad incompleta</option>
                        <option value="Superior completa">Universidad completa</option>
                    </select>
                    @if(isset($educational_level))
                    <script>
                        $( document ).ready(function() {
                            $('#dlleducational_level option[value="{{$educational_level}}"]').prop('selected', true);
                        });
                    </script>
                    @endif
                </div>
                <div class="form-group col-md-6">
                    <label>Trabajo u ocupación <span class="text-danger">(Importante)</span></label>
                    <input  id="workParent" type="text" class="form-control" name="work" value="{{$work}}" minlength="2" required="">
                </div>
                <div class="form-group col-md-4">
                    <label>Dirección Completa del trabajo </label>
                    <input  id="work_address" type="text" class="form-control" name="work_address" value="{{$work_address}}" minlength="2" >
                </div>
                <div class="form-group col-md-4">
                    <label>Teléfono del trabajo </label>
                    <input  id="work_phone" type="text" class="form-control" name="work_phone" value="{{$work_phone}}" minlength="2" >
                </div>
                <div class="form-group col-md-4">
                    <label>Guardar los cambios</label>
                    <button class="form-control btn btn-success" id="btnguardar" type="submit" >Guardar</button>
                    <script>
                        $("#btnguardar").click(function(){
                            Swal.fire({
                            icon: 'success',
                            title: 'Guardado',
                            text: 'Los datos han sido guardados'
                            })
                        })
                    </script>
                </div>
            </div>
            @if(isset($formsStatus))
                @if($formsStatus == true)
                    <script>
                        // Activos Telefono & Correo 
                        $('#nombresparent').attr("readonly",false);
                        $('#apellido_pparent').attr("readonly",false);
                        $('#apellido_mparent').attr("readonly",false);
                        $('#fecha_nacparent').attr("readonly",false);
                        $('#ddllegal_civil_status').attr("disabled",false);
                        $('#ddlcurrent_civil_status').attr("disabled",false);
                        $('#districtparent').attr("readonly",false);
                        $('#addressparent').attr("readonly",false);
                        $('#dlleducational_level').attr("disabled",false);
                    </script>
                @endif
            @endif
        </form>
    </div>
    <div class="tab-pane fade" id="change-pass" role="tabpanel" aria-labelledby="change-pass-tab">
        <div class="row my-3">
            <div class="col-md-3"></div>
            <div class="col-md-6 col-xs-12">
                <form method="get">
                    <div class="card">
                        <h3 class="text-center my-3" id="test">Reestablecer contraseña</h3>
                        <div class="form-row mx-3 my-3">
                            <div class="form-group col-12">
                                <label for="">Contraseña Actual</label>
                                <input class="form-control" type="password" name="passOld" id="passOld" minlength="6" maxlength="20" required>
                            </div>
                            <div class="form-group col-12">
                                <label for="">Nueva Contraseña</label>
                                <input class="form-control" type="password" name="pass" id="pass" minlength="6" maxlength="20" required>
                                <small id="texth1" class="form-text text-muted">mínimo 6 caracteres</small>
                            </div>
                            <div class="form-group col-12">
                                <label for="">Confirmar contraseña</label>
                                <input class="form-control" type="password" name="passConfirm" minlength="6" maxlength="20" id="passConfirm" required>
                            </div>
                            <div class="form-group col-12">
                                <button class="btn btn-success my-3" type="button" name="btnrecov" id="btnrecov" style="text-align: center">Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
        <script>
            $("#btnrecov").click(function(){
                var oldPass = $("#passOld").val();
                oldPass = oldPass.trim();
                var pass = $("#pass").val();
                pass = pass.trim();
                var passConf = $("#passConfirm").val();
                passConf = passConf.trim();
                if(oldPass == pass){
                    Swal.fire({
                        icon: 'error',
                        title: 'Las antigua contraseña debe ser distinta a la actual.',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
                else if(pass.length == 0 || passConf.length == 0 || oldPass.length == 0 ){
                    Swal.fire({
                        icon: 'error',
                        title: 'Debe rellenar todos los campos.',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
                else if(pass == passConf && pass.length > 5){
                    $.ajax({
                        type: "GET",
                        url: "changeOldPass",
                        data: {pass:pass,oldPass:oldPass},
                        success: function(data)
                        {
                            $("#test").html(data);
                            if(data == "DONE"){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Su contraseña ha sido modificada',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                location.reload();
                            }else if(data == "SAME"){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Las antigua contraseña debe ser distinta a la actual.',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                            }
                            else{
                                $("#test").html(data);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Se ha producido un error',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                            }
                        }
                    });
                }
                else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Las contraseñas deben coincidir',
                        showConfirmButton: false
                    })
                }
            });
        </script>
    </div>
    <div class="tab-pane fade " id="change-proxy" role="tabpanel" aria-labelledby="change-proxy-tab">
        <hr>
        <div id="stepcp1" class="row cpitem">
            <div class="col-md-12" >
                <span style="font-size: larger;">
                    Estimado Apoderado, esta sección es para cambiar de apoderado a uno o más estudiantes. Para su solicitud debe completar las siguientes secciones:
                    <br><br>
                    - Formulario del nuevo apoderado.
                    <br>
                    - Seleccionar el/los alumno(s) a traspasar al nuevo apoderado.
                    <br>
                    - Redactar el motivo de la solicitud.
                    <br><br>
                    Para continuar presione el botón continuar
                </span>
            </div>
            <div class="col-md-12">
                <hr>
                <button type="button" class="btn btn-primary btn-wizzard float-right" data="2">Continuar</button>
            </div>
        </div>
        <div id="stepcp2" class="row cpitem" style="display: none;">
            <div class="col-md-12">
                <h5>Formulario del nuevo apoderado</h5>
            </div>
            <div class="form-group col-md-3">
                <label>Rut <span class="text-danger">(Requerido)</span></label>
                <input id="newaporut" type="text" class="form-control wizard-form" placeholder="XX.XXX.XXX-X" minlength="8" required="">
            </div>
            <div class="form-group col-md-3">
                <label>Nombres <span class="text-danger">(Requerido)</span></label>
                <input id="newaponombre" type="text" class="form-control wizard-form" placeholder="Nombres" minlength="2" required="">
            </div>
            <div class="form-group col-md-3">
                <label >Apellido Paterno <span class="text-danger">(Requerido)</span></label>
                <input id="newapoapellidop" type="text" class="form-control wizard-form" placeholder="Apellido paterno" minlength="2" required="">
            </div>
            <div class="form-group col-md-3">
                <label >Apellido Materno <span class="text-danger">(Requerido)</span></label>
                <input id="newapoapellidom" type="text" class="form-control wizard-form" placeholder="Apellido materno" minlength="2" required="">
            </div>
            <div class="form-group col-md-4">
                <label>Teléfono Casa <span class="text-danger">(Importante)</span></label>
                <input id="newapotelcasa" type="text" class="form-control wizard-form" minlength="2" >
            </div>
            <div class="form-group col-md-4">
                <label>Celular <span class="text-danger">(Requerido)</span></label>
                <input id="newapotelcel" type="text" class="form-control wizard-form" minlength="2" required="">
            </div>
            <div class="form-group col-md-4">
                <label>Email <span class="text-danger">(Requerido)</span></label>
                <input id="newapoemail" type="email" class="form-control wizard-form" minlength="2" required="">
            </div>
            <div class="col-md-12">
                <hr>
                <button type="button" class="btn btn-secondary btn-wizzard float-left" data="1">Cancelar</button>
                <button id="btntostep3" type="button" class="btn btn-primary btn-wizzard float-right" data="3" disabled="">Continuar</button>
            </div>
        </div>
        <div id="stepcp3" class="row cpitem" style="display: none;">
            <div class="col-md-12">
                <h5>Seleccione los Alumnos que pasarán a ser del nuevo apoderado</h5>
            </div>
            <div class="col-md-12">
                @foreach($matriculas as $row)
                <div class="form-check">
                    <input class="form-check-input stuchk" type="checkbox" value="{{$row["dni_stu"]}} - {{$row["nombre_stu"]}} - {{$row["curso"]}}" id="checkbox{{$row["id_stu"]}}">
                    <label class="form-check-label" for="checkbox{{$row["id_stu"]}}">
                        {{$row["nombre_stu"]}} - {{$row["curso"]}}
                    </label>
                </div>
                @endforeach
            </div>
            <div class="col-md-12">
                <hr>
                <h5>Indique cual es el Motivo del cambio de Apoderado</h5>
                <textarea id="argument" class="form-control wizard-form" id="validationTextarea" placeholder="Motivo del cambio de apoderado" required></textarea>
            </div>
            <div class="col-md-12">
                <hr>
                <button type="button" class="btn btn-secondary btn-wizzard float-left" data="2">Volver</button>
                <button id="btntostep4" type="button" class="btn btn-primary btn-wizzard float-right" data="4" disabled="">Continuar</button>
            </div>
        </div>
        <div id="stepcp4" class="row cpitem" style="display: none;">
            <div class="col-md-12">
                <h5>Esta solicitudo será enviada con la siguiente informacion:</h5>
                <hr>
                <h5 id="messagetoshow"></h5>
                <hr>
                <h5>Al precionar "Enviar y Finalizar Solicitud" la institución deberá contactarse con usted y con el nuevo apoderado para validar este cambio.</h5>
            </div>
            <div class="col-md-12">
                <hr>
                <button type="button" class="btn btn-secondary btn-wizzard float-left" data="3">Volver</button>
                <button id="btnEnviarSolicitud" type="button" class="btn btn-success float-right" >Enviar y Finalizar Solicitud</button>
            </div>
        </div>
        <script>
            var newRut = "";
            var newNombre = "";
            var newApellidoP = "";
            var newApellidoM = "";
            var newTelCasa = "";
            var newTelCel = "";
            var newEmail = "";
            var alumnos =  "";
            var messagetoshow = "";
            var argument = "";
            $(".btn-wizzard").click(function(){
                var toshow = $(this).attr("data"); 
                $(".cpitem").hide();
                $("#stepcp"+toshow).show();
            });
            function ValidateEmail(email){
                var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                return mailformat.test(email);
            }
            $(".wizard-form").on("keyup change", function() {
                newRut = $("#newaporut").val();
                newNombre = $("#newaponombre").val();
                newApellidoP = $("#newapoapellidop").val();
                newApellidoM = $("#newapoapellidom").val();
                newTelCasa = $("#newapotelcasa").val();
                newTelCel = $("#newapotelcel").val();
                newEmail = $("#newapoemail").val();
                if(newNombre.trim() != "" && newApellidoP.trim() != "" && newApellidoM.trim() != "" && newTelCel.trim() != "" && newEmail.trim() != "" && newRut.trim() != ""){
                    if(ValidateEmail(newEmail)){
                        $("#btntostep3").prop("disabled",false);
                    }else{
                        $("#btntostep3").prop("disabled",true);
                    }
                }else{
                    $("#btntostep3").prop("disabled",true);
                }
            });
            $(".stuchk , .wizard-form").on("keyup change",function(){
                alumnos =  "";
                argument = $("#argument").val();
                $('input:checkbox.stuchk').each(function () {
                    var sThisVal = (this.checked ? $(this).val() : "");
                    if(sThisVal != ""){
                        alumnos = alumnos + "<b style=\"color: blue\">" + sThisVal+"</b><br>";
                    }
                });
                if(alumnos != "" && argument.trim().length > 10){
                    $("#btntostep4").prop("disabled",false);
                    messagetoshow = "Apoderado <b style=\"color: blue\">{{Session::get('apoderado')["names"]}} {{Session::get('apoderado')["last_p"]}} {{Session::get('apoderado')["last_m"]}} </b> " +
                    "de rut <b style=\"color: blue\">{{$rut}}</b>, con correo <b style=\"color: blue\">{{Session::get('apoderado')["email"]}}</b>, solicita el cambio de apoderado de " +
                    "El/Los Alumno(s): <br> " + alumnos + 
                    "Tendrán como nuevo apoderado a <b style=\"color: blue\"> " + newNombre + " " + newApellidoP + " " + newApellidoM + " </b> con el rut de <b style=\"color: blue\">" + newRut + "</b>, <br>" +
                    "su correo de contacto es: <b style=\"color: blue\">" + newEmail + "</b> <br>" +
                    "y su teléfono celular es: <b style=\"color: blue\">" + newTelCel + "</b>. <br>" +
                    "El motivo del cambio de apoderado es: <br> <span style=\"color: indianred;\">" + argument + "</span>";
                    $("#messagetoshow").html(messagetoshow);
                }else{
                    $("#btntostep4").prop("disabled",true);
                }
            });
            $("#btnEnviarSolicitud").click(function(){
                $.ajax({
                    type: "POST",
                    url: "change_proxy",
                    data: {
                        '_token': "{{csrf_token()}}",
                        'body' : messagetoshow
                    },
                    beforeSend: function(){
                        Swal.fire({
                            html: '<h5>Enviando Solicitud...</h5>',
                            showConfirmButton:false
                        });
                    },
                    success: function(data)
                    {
                        if(data == "OK"){
                            Swal.fire({
                                icon: 'success',
                                title: 'Solicitud Enviada'
                            });
                            location.reload();
                        }
                    },
                    error: function(data2){
                        Swal.fire('Error! CX285012', '', 'error')
                    }
                });
            });
        </script>
    </div>
</div>
