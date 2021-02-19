@if($form == "stuinfo")
<div class="modal-header">
    <h5 class="modal-title" id="staticBackdropLabel">Datos del alumno y curso</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>
<form class="was-validated" action="upd_student" method="GET">
    <div class="modal-body">
          <div class="form-row">
              <div class="form-group col-md-6">
                  <label for="rutalumno">Rut</label>
                  <input id="idstu" class="form-control is-invalid" name="idstu" value="{{$student['id']}}" hidden="">
                  <input id="rutalumno" class="form-control is-invalid" autocomplete="off" name="rut" type="text" value="{{$student['dni']}}" required=""  oninput="checkRut(this)" placeholder="Rut del alumno" minlength="6" maxlength="11">
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
                  <label for="btnapisearch">Nombres</label>
                  <input id="nombres" type="text" class="form-control" value="{{$student['names']}}" required="" name="nombres" minlength="2" placeholder="Nombres">
              </div>
              <div class="form-group col-md-6">
                  <label for="btnapisearch">Apellido Paterno</label>
                  <input id="apellido_p" type="text" class="form-control" value="{{$student['last_f']}}" required="" name="apellido_p" minlength="2" placeholder="Apellido paterno">
              </div>
              <div class="form-group col-md-6">
                  <label for="btnapisearch">Apellido Materno</label>
                  <input id="apellido_m" type="text" class="form-control" value="{{$student['last_m']}}" required="" name="apellido_m" minlength="2" placeholder="Apellido materno">
              </div>
              <div class="form-group col-md-6">
                  <label for="btnapisearch">Género</label>
                  <select id="ddlgenero" class="custom-select mr-sm-2" autocomplete="off" name="ddlgenero" required="">
                      @if($student['sex']=="VAR")
                      <option value="VAR" selected="">Hombre</option>
                      <option value="MUJ">Mujer</option>
                      @else
                      <option value="MUJ" selected="">Mujer</option>
                      <option value="VAR" >Hombre</option>
                      @endif
                  </select>
              </div>
              <div class="form-group col-md-6">
                  <label for="btnapisearch">Nacionalidad</label>
                  <input type="text" class="form-control" required="" value="{{$student['nationality']}}" name="nacionalidad" minlength="4" placeholder="Nacionalidad ">
              </div>
              <div class="form-group col-md-6">
                  <label for="btnapisearch">Etnia</label>
                  <select id="ddletina" class="custom-select mr-sm-2" value="" autocomplete="off" name="ddletina" required="">
                      <option selected="" value="Ninguna">Ninguna</option>
                      <option value="Mapuche">Mapuche</option>
                      <option value="Aimara">Aimara</option>
                      <option value="Atacameña">Atacameña</option>
                      <option value="Diaguita">Diaguita</option>
                      <option value="Otro">Otro</option>
                  </select>
                  @if(isset($student['ethnic']))
                    <script>
                        $( document ).ready(function() {
                            $('#ddletina option[value={{$student["ethnic"]}}').prop('selected', true);
                        });
                    </script>
                  @endif
              </div>
              <div class="form-group col-md-6">
                  <label for="btnapisearch">Fecha de Nacimiento</label>
                  <input id="thedate" class="form-control" value="{{$student['born_date']}}" type="date" name="fecha_nac" value="" required=""/>
              </div>
              <div class="form-group col-md-12">
                  <label for="btnapisearch">Curso al que postula</label>
                  <select id="ddlcurso" class="custom-select mr-sm-2" autocomplete="off" name="ddlcurso" required="">
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
                  <script>
                        $( document ).ready(function() {
                            $('#ddlcurso option[value={{$inscription["grade"]}}]').prop('selected', true);
                        });
                  </script>
              </div>
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-success">Guardar</button>
      </div>
</form>
@elseif($form == "stuback")
<?php
    $cellphone = null;
    $emergency_data = null;
    $address = null;
    $district = null;
    $has_pie = null;
    $apply_pie_next_year = null;
    $school_origin = null;
    $school_origin_year_in = null;
    $risk_disease = null;
    $medical_treatment = null;
    $medical_treatment_from = null;
    $sensory_difficulties = null;
    $has_special_treatment = null;
    $does_keep_st = null;
    $why_does_keep_st = null;
    if($background != null){
        $cellphone = $background["cellphone"];
        $emergency_data = $background["emergency_data"];
        $address = $background["address"];
        $district = $background["district"];
        $has_pie = $background["has_pie"];
        $apply_pie_next_year = $background["apply_pie_next_year"];
        $school_origin = $background["school_origin"];
        $school_origin_year_in = $background["school_origin_year_in"];
        $risk_disease = $background["risk_disease"];
        $medical_treatment = $background["medical_treatment"];
        $medical_treatment_from = $background["medical_treatment_from"];
        $sensory_difficulties = $background["sensory_difficulties"];
        $has_special_treatment = $background["has_special_treatment"];
        $does_keep_st = $background["does_keep_st"];
        $why_does_keep_st = $background["why_does_keep_st"];
    }
?>
<div class="modal-header">
    <h5 class="modal-title" id="staticBackdropLabel">Antecedentes del Estudiante</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>
<form class="was-validated" action="add_student_background" method="GET">
    <input id="idstu" class="form-control is-invalid" value="{{$id_stu}}" name="student" hidden="">
    <div class="modal-body">
          <div class="form-row">
              <div class="form-group col-md-12">
                  <h3 class="text-primary">En caso de que no posea algúno de los campos mencionados colocar: <span class="text-danger">NO POSEE</span></h3>
              </div>
              <div class="form-group col-md-4">
                  <label >Celular del Estudiante <span class="text-info">(opcional)</span></label>
                  <input type="text" class="form-control" name="cellphone" value="{{$cellphone}}" minlength="2" placeholder="+569...">
              </div>
              <div class="form-group col-md-4">
                  <label >Comuna donde vive <span class="text-danger">(obligatoria)</span></label>
                  <input type="text" class="form-control" name="district" value="{{$district}}"  minlength="2" required="" placeholder="Ej: La Florida">
              </div>
              <div class="form-group col-md-4">
                  <label >Dirección donde vive <span class="text-danger">(obligatoria)</span></label>
                  <input type="text" class="form-control" name="address" value="{{$address}}" minlength="2" required="" placeholder="Calle #">
              </div>
              <div class="form-group col-md-6">
                  <label >Establecimiento anterior <span class="text-danger">(obligatoria)</span></label>
                  <input type="text" class="form-control" name="school_origin" value="{{$school_origin}}"  minlength="2" required="" placeholder="">
              </div>
              <div class="form-group col-md-6">
                  <label>Año en que ingresó al establecimiento anterior<span class="text-danger">(obligatoria)</span></label>
                  <input type="text" class="form-control" name="school_origin_year_in" value="{{$school_origin_year_in}}" minlength="4" maxlength="4" required="" placeholder="">
              </div>
              <div class="form-group col-md-6">
                  <label>Pertenece a PIE {{getenv("MATRICULAS_PARA") -1}} <span class="text-info">(Programa de Integración Escolar)</label>
                  <select id="ddlhas_pie" class="custom-select" name="has_pie"> 
                    <option value="false">No</option>
                    <option value="true">Si</option>
                  </select>
                  <script>
                        $( document ).ready(function() {
                            $('#ddlhas_pie option[value={{$has_pie}}').prop('selected', true)
                        });
                  </script>
              </div>
              <div class="form-group col-md-6">
                  <label>Postula a PIE {{getenv("MATRICULAS_PARA")}} </label>
                  <select id="ddlapply_pie_next_year" class="custom-select" name="apply_pie_next_year"> 
                    <option value="false">No</option>
                    <option value="true">Si</option>
                  </select>
                  <script>
                        $( document ).ready(function() {
                            $('#ddlapply_pie_next_year option[value={{$apply_pie_next_year}}').prop('selected', true)
                        });
                  </script>
              </div>
              <?php
                $str= $emergency_data;
                $pos = strpos($str, " - Fono: ");
                $emergency_fono = substr($str,$pos+9);
                $emergency_name = substr($str,0,$pos);
              ?>
              <div class="form-group col-md-6">
                  <label >Teléfono de Emergencia <span class="text-danger">(Importante)</span></label>
                  <input type="text" class="form-control" name="emergency_data" value="{{$emergency_fono}}" required="" minlength="2">
              </div>
              <div class="form-group col-md-6">
                  <label>Nombre del Contacto de emergencia<span class="text-danger">(Importante)</span></label>
                  <input type="text" class="form-control" name="emergency_data_name" value="{{$emergency_name}}" required="" minlength="2">
              </div>
              <div class="form-group col-md-12">
                  <label>Enfermedades de Riesgo <span class="text-danger">(Importante)</span></label>
                  <textarea class="form-control" name="risk_disease" value="{{$risk_disease}}" rows="2" required="" minlength="2">{{$risk_disease}}</textarea>
              </div>
              <div class="form-group col-md-6">
                  <label>Tratamiento Médico<span class="text-danger">(Importante)</span></label>
                  <textarea class="form-control" name="medical_treatment" value="{{$medical_treatment}}" rows="2" required="" minlength="2">{{$medical_treatment}}</textarea>
              </div>
              <div class="form-group col-md-6">
                  <label>Desde cuando está con tratamiento médico<span class="text-danger">(Importante)</span></label>
                  <input type="date" class="form-control" name="medical_treatment_from" value="{{$medical_treatment_from}}">
              </div>
              <div class="form-group col-md-6">
                  <label>Difucultades o problemas sensoriales <span class="text-danger">(Importante)</span></label>
                  <textarea class="form-control" name="sensory_difficulties" value="{{$sensory_difficulties}}" rows="2" required="" minlength="2">{{$sensory_difficulties}}</textarea>
              </div>
              <div class="form-group col-md-6">
                  <label>Tratamiento especial recibido <span class="text-danger">(Importante)</span></label>
                  <textarea class="form-control" name="has_special_treatment" value="{{$has_special_treatment}}" rows="2" required="" minlength="2">{{$has_special_treatment}}</textarea>
              </div>
              <div class="form-group col-md-12">
                  <label>Sigue con tratamiento especial (?) <span class="text-danger">(Importante)</span></label>
                  <select id="ddldkst" class="custom-select" name="does_keep_st" value="{{$does_keep_st}}"> 
                    <option value="false">No</option>
                    <option value="true">Si</option>
                  </select>
                  <script>
                        $( document ).ready(function() {
                            $('#ddldkst option[value={{$does_keep_st}}').prop('selected', true)
                        });
                  </script>
              </div>
              <div class="form-group col-md-12">
                  <label>Motivo de la Continuidad del tratamiento <span class="text-danger">(Importante)</span></label>
                  <textarea class="form-control" name="why_does_keep_st" value="{{$why_does_keep_st}}" rows="2" required="" minlength="2">{{$why_does_keep_st}}</textarea>
              </div>
          </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-success">Guardar</button>
    </div>
</form>
@elseif($form=="proxys")
<?php
    $is_p = null;
    //
    $parent_type = null;
    $dni = null;
    $names = null;
    $last_f = null;
    $last_m = null; 
    $born_date = null;
    $kinship = null;
    $is_proxy = null;
    $live_with = null;
    $agree_live_with = null;
    $visits_per_months  = null;
    $legal_civil_status = null;
    $current_civil_status = null;
    $address = null;
    $district = null;
    $phone = null;
    $cellphone = null;
    $email = null;
    $educational_level = null;
    $work = null;
    $work_address = null;
    $work_phone = null;
    //
    if($parent_data != null){
        $parent_type = $parent_data["parent_type"];
        $dni = $parent_data["dni"];
        $names = $parent_data["names"];
        $last_f = $parent_data["last_f"];
        $last_m = $parent_data["last_m"]; 
        $born_date = $parent_data["born_date"];
        $kinship = $parent_data["kinship"];
        $is_proxy = $parent_data["is_proxy"];
        $live_with = $parent_data["live_with"];
        $agree_live_with = $parent_data["agree_live_with"];
        $visits_per_months  = $parent_data["visits_per_months"];
        $legal_civil_status = $parent_data["legal_civil_status"];
        $current_civil_status = $parent_data["current_civil_status"];
        $address = $parent_data["address"];
        $district = $parent_data["district"];
        $phone = $parent_data["phone"];
        $cellphone = $parent_data["cellphone"];
        $email = $parent_data["email"];
        $educational_level = $parent_data["educational_level"];
        $work = $parent_data["work"];
        $work_address = $parent_data["work_address"];
        $work_phone = $parent_data["work_phone"];
        
    }
?>
<div class="modal-header">
    <h5 class="modal-title">
    @if($parent == "m")
    Antecedentes de la Madre
    @elseif($parent == "f")
    Antecedentes del Padre
    @elseif($parent == "p")
    <?php $is_p = "display: none;"; ?>
    Apoderado
    @endif
    </h5>
   
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>
<form id="form_data" class="was-validated" action="add_proxy_background" method="GET">
    <input id="idstu" class="form-control is-invalid" value="{{$id_stu}}" name="student" hidden="">
      <div class="modal-body">
          <div class="form-row">
            @if($is_p == null)
                <div class="form-group col-md-12">
                    <h3 class="text-primary">En caso de desconocer la información colocar: <span class="text-danger">SE DESCONOCE</span></h3>
                </div>
            @endif
            @if($parent == "m")
            <input id="parent_type" class="form-control is-invalid" value="m" name="parent_type" hidden="">
            @elseif($parent == "f")
            <input id="parent_type" class="form-control is-invalid" value="f" name="parent_type" hidden="">
            @elseif($parent == "p")
            <div class="form-group col-md-3">
                <label>Parentezco</label>
                <input id="kinship" class="form-control" name="kinship" value="" type="text" minlength="3" required="" >
            </div>
            <div class="form-group col-md-6">
                <label class="text-primary">Declara que el apoderado vive con el estudiante</label>
                <input class="form-control" value="Al guardar usted acepta este término" readonly="" type="text" required="" >
            </div>
            @endif
                @if($parent != "p")
                    <div id="formproxy" class="row" style="{{$is_p}}">
                        <div class="form-group col-md-6">
                            <label for="rutparent">Rut <span class="text-danger">(Importante)</span></label>
                            <input id="rutparent" class="form-control is-invalid" autocomplete="off" name="rut" value="{{$dni}}" type="text" oninput="checkRut(this)" minlength="1" maxlength="11">
                            <script>
                                function checkRut(rut) {
                                    $("#btnapisearch2").removeClass("btn-secondary");
                                    $("#btnapisearch2").removeClass("btn-success");
                                    $("#btnapisearch2").addClass("btn-primary");
                                    $("#btnapisearch2").attr("disabled",false);
                                    $("#btnapisearch2").html("Autocompletar");
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
                        <div class="form-group col-md-6">
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
                                    url: "/get_info/",
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
                                            $("#districtparent").val(obj.commune);
                                            $("#btnapisearch2").attr("disabled",true);
                                            $("#btnapisearch2").removeClass("btn-primary");
                                            $("#btnapisearch2").removeClass("btn-secondary");
                                            $("#btnapisearch2").addClass("btn-success");
                                            $("#btnapisearch2").html("Actualizado");
                                        }else{
                                            $("#btnapisearch2").removeClass("btn-primary");
                                            $("#btnapisearch2").addClass("btn-secondary");
                                            $("#btnapisearch2").attr("disabled",true);
                                            $("#btnapisearch2").html("No encontrad@ :(");
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
                            <label for="">Nombres <span class="text-danger">(Importante)</span></label>
                            <input id="nombresparent" type="text" class="form-control" name="nombresparent" value="{{$names}}" placeholder="Nombres" minlength="2" required="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Apellido Paterno <span class="text-danger">(Importante)</span></label>
                            <input id="apellido_pparent" type="text" class="form-control" name="apellido_pparent" value="{{$last_f}}" placeholder="Apellido paterno" minlength="2" required="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Apellido Materno <span class="text-danger">(Importante)</span></label>
                            <input id="apellido_mparent" type="text" class="form-control" name="apellido_mparent" value="{{$last_m}}" placeholder="Apellido materno" minlength="2" required="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Fecha de Nacimiento <span class="text-danger">(Importante)</span></label>
                            <input class="form-control" type="date" name="fecha_nacparent" value="{{$born_date}}" />
                        </div>
                        @if($parent == "p")
                        <input type="text" class="form-control" name="ddllive_with" value="Si" hidden="">
                        <input type="text" class="form-control" name="visits_per_months" value="0" hidden="">
                        @else
                        <div class="form-group col-md-6">
                            <label for="">¿Vive con el Alumno?</label>
                            <select id="ddllive_with" class="custom-select mr-sm-2" autocomplete="off" name="live_with" required="">
                                <option disabled="" selected="" value="Sin información">Seleccionar</option>
                                <option value="No">No</option>
                                <option value="Si">Si</option>
                            </select>
                            <script>
                                $("#ddllive_with").change(function(){
                                    var value = $(this).val();
                                    if(value == "Si"){
                                        $("#visits_per_months").attr("disabled",true);
                                        $("#visits_per_months").val(0);
                                    }else{
                                        $("#visits_per_months").attr("disabled",false);
                                        $("#visits_per_months").val({{$visits_per_months}});
                                    }
                                });
                            </script>
                            @if(isset($live_with))
                            <script>
                                $( document ).ready(function() {
                                    $('#ddllive_with option[value={{$live_with}}').prop('selected', true);
                                    var value = $("#ddllive_with").val();
                                    if(value == "Si"){
                                        $("#visits_per_months").attr("disabled",true);
                                        $("#visits_per_months").val(0);
                                    }else{
                                        $("#visits_per_months").attr("disabled",false);
                                        $("#visits_per_months").val({{$visits_per_months}});
                                    }
                                });
                            </script>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">En caso de que no viva con el alumno: ¿Cuántas veces lo visita al mes?</label>
                            <input id="visits_per_months" type="text" class="form-control" name="visits_per_months" value="{{$visits_per_months}}" >
                        </div>
                        @endif
                        <div class="form-group col-md-6">
                            <label for="">Estado Civil Legal <span class="text-danger">(Importante)</span></label>
                            <select id="ddllegal_civil_status" class="custom-select mr-sm-2" autocomplete="off" name="legal_civil_status" >
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
                                    $('#ddllegal_civil_status option[value={{$legal_civil_status}}').prop('selected', true);
                                });
                            </script>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Estado Civil Actual (No acorde a lo legal) <span class="text-danger">(Importante)</span></label>
                            <select id="ddlcurrent_civil_status" class="custom-select mr-sm-2" autocomplete="off" name="current_civil_status">
                                <option disabled="" selected="" value="Sin información">Seleccionar</option>
                                <option value="soltero">Soltero/a</option>
                                <option value="convive">Convive</option>
                                <option value="separado">Separado/a</option>
                                <option value="viudo">Viudo/a</option>
                            </select>
                            @if(isset($current_civil_status))
                            <script>
                                $( document ).ready(function() {
                                    $('#ddlcurrent_civil_status option[value={{$current_civil_status}}').prop('selected', true);
                                });
                            </script>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label >Comuna <span class="text-danger">(Importante)</span></label>
                            <input id="districtparent" type="text" class="form-control" name="districtparent" value="{{$district}}" placeholder="Ej: La Florida" minlength="2" required="">
                        </div>
                        <div class="form-group col-md-6">
                            <label >Dirección <span class="text-danger">(Importante)</span></label>
                            <input id="addressparent" type="text" class="form-control" name="addressparent" value="{{$address}}" placeholder="Calle #" minlength="2" required="">
                        </div>
                        <div class="form-group col-md-6">
                            <label >Teléfono Casa <span class="text-danger">(Importante)</span></label>
                            <input type="text" class="form-control" name="phoneparent" value="{{$phone}}" minlength="2" required="">
                        </div>
                        <div class="form-group col-md-6">
                            <label >Celular <span class="text-danger">(Importante)</span></label>
                            <input type="text" class="form-control" name="cellphoneparent" value="{{$cellphone}}" minlength="2" required="">
                        </div>
                        <div class="form-group col-md-6">
                            <label >Email <span class="text-danger">(Importante)</span></label>
                            <input type="text" class="form-control" name="emailparent" value="{{$email}}" minlength="2" required="">
                        </div>
                        <div class="form-group col-md-6">
                            <label >Nivel de estudios <span class="text-danger">(Importante)</span></label>
                            <select id="dlleducational_level" class="custom-select mr-sm-2" autocomplete="off" name="educational_level">
                                <option disabled="" selected="" value="Sin Información">Seleccionar</option>
                                <option value="Básica incompleta">Básica incompleta</option>
                                <option value="Básica completa">Básica completa</option>
                                <option value="Media incompleta">Media incompleta</option>
                                <option value="Media completa">Media completa</option>
                                <option value="Superior incompleta">Superior incompleta</option>
                                <option value="Superior completa">Superior completa</option>
                            </select>
                            @if(isset($current_civil_status))
                            <script>
                                $( document ).ready(function() {
                                    $('#dlleducational_level option[value="{{$educational_level}}"').prop('selected', true);
                                });
                            </script>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label>Trabajo u ocupación <span class="text-danger">(Importante)</span></label>
                            <input type="text" class="form-control" name="work" value="{{$work}}" minlength="2" required="">
                        </div>
                        <div class="form-group col-md-6">
                            <label >Dirección Completa del trabajo </label>
                            <input type="text" class="form-control" name="work_address" value="{{$work_address}}" minlength="2" required="">
                        </div>
                        <div class="form-group col-md-6">
                            <label >Teléfono del trabajo </label>
                            <input type="text" class="form-control" name="work_phone" value="{{$work_phone}}" minlength="2" required="">
                        </div>
                    </div>
                @endif
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-success">Guardar</button>
      </div>
  </form>
@elseif($form == "circle")
<?php
$time_from_to = null;
$meth_go = null;
$meth_back = null;
$auth_quit = null;

if ($misc != null){
    $time_from_to = $misc["time_from_to"];
    $meth_go = $misc["meth_go"];
    $meth_back = $misc["meth_back"];
    $auth_quit = $misc["auth_quit"];
}
?>
<div class="modal-header" id="test">
    <h5 class="modal-title" id="staticBackdropLabel">Información adicional importante</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>
<form id="current_form" class="was-validated" action="aditional_info" method="GET">
    <input id="idstu" class="form-control is-invalid" value="{{$id_stu}}" name="student" hidden="">
    <div class="modal-body">
        <div class="form-row">
            <div class="form-group col-md-4">
                <label>Tiempo de traslado (casa/colegio) en minutos</label>
                <input id="time_from_to" class="form-control" name="time_from_to" value="{{$time_from_to}}" type="number" min="2" max="520" required="" >
            </div>
            <div class="form-group col-md-4">
                <label>Forma de traslado (ida)</label>
                <input id="meth_go" class="form-control" name="meth_go" value="{{$meth_go}}" type="text" required="" placeholder="A pie, Transporte escolar, Metro...">
            </div>
            <div class="form-group col-md-4">
                <label>Forma de traslado (vuelta)</label>
                <input id="meth_back" class="form-control" name="meth_back" value="{{$meth_back}}" type="text" required="" placeholder="A pie, Transporte escolar, Metro...">
            </div>
            <div class="form-group col-md-12">
                <label>¿Quién está autorizado para retirar al alumno?</label>
                <input id="auth_quit" class="form-control" name="auth_quit" value="{{$auth_quit}}" type="text" required="" >
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button id="cbutton_form{{$id_stu}}" type="button" class="btn btn-success">Guardar</button>
        <script>
            $("#cbutton_form{{$id_stu}}").click(function(e){
                e.preventDefault();
                Swal.fire({
                    icon: 'info',
                    title: 'Cargando...',
                });
                $("#cbutton_form{{$id_stu}}").remove;
                var idstu = $("#idstu").val()
                var time_from_to = $("#time_from_to").val();
                var meth_go = $("#meth_go").val();
                var meth_back = $("#meth_back").val();
                var auth_quit = $("#auth_quit").val();
                var full_names = $("input[name=full_name]").map(function(){
                    return $(this).val();
                }).get().join(",");

                var kinships = $("input[name=kinship]").map(function(){
                    return $(this).val();
                }).get().join(",");
                
                var years_olds = $("input[name=years_old]").map(function(){
                    return $(this).val();
                }).get().join(",");
                
                var same_inss = $("select[name=same_ins]").map(function(){
                    return $(this).val();
                }).get().join(",");
                
                var occupations = $("input[name=occupation]").map(function(){
                    return $(this).val();
                }).get().join(",");
                var url = "aditional_info";
                $.ajax({
                   type: "GET",
                   url: url,
                   data: {student:idstu,time_from_to:time_from_to,meth_go:meth_go,meth_back:meth_back,auth_quit:auth_quit,full_names:full_names,kinships:kinships,years_olds:years_olds,same_inss:same_inss,occupations:occupations}, // serializes the form's elements.
                   success: function(data)
                   {
                       $("#test").html(data);
                       $("#lastone{{$id_stu}}").removeClass("badge-warning");
                       $("#lastone{{$id_stu}}").addClass("badge-success");
                       $("#lastone{{$id_stu}}").html("Completada");
                       $('#globmod{{$id_stu}}').modal('toggle');
                       Swal.fire({
                            icon: 'success',
                            title: 'Datos Guardados',
                            text: 'Los datos fueron guardados correctamente'
                        }); 
                   }
                 });
            });
        </script>
    </div>
    <div id="result" class="modal-footer">
        
    </div>
</form>
@endif