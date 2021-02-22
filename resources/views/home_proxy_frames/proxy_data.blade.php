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



<form action="add_proxy_data" method="GET">
    <div id="formproxy" class="row" style="font-size: 0.9rem">
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
            <input id="nombresparent" type="text" class="form-control" name="nombresparent" value="{{$nombresparent}}" placeholder="Nombres" minlength="2" required="">
        </div>
        <div class="form-group col-md-4">
            <label for="">Apellido Paterno <span class="text-danger">(Importante)</span></label>
            <input id="apellido_pparent" type="text" class="form-control" name="apellido_pparent" value="{{$apellido_pparent}}" placeholder="Apellido paterno" minlength="2" required="">
        </div>
        <div class="form-group col-md-4">
            <label for="">Apellido Materno <span class="text-danger">(Importante)</span></label>
            <input id="apellido_mparent" type="text" class="form-control" name="apellido_mparent" value="{{$apellido_mparent}}" placeholder="Apellido materno" minlength="2" required="">
        </div>
        <div class="form-group col-md-4">
            <label for="">Fecha de Nacimiento <span class="text-danger">(Importante)</span></label>
            <input class="form-control" type="date" name="fecha_nacparent" value="{{$born_date}}">
        </div>
        <input type="text" class="form-control" name="ddllive_with" value="Si" hidden="">
        <input type="text" class="form-control" name="visits_per_months" value="0" hidden="">
        <div class="form-group col-md-4">
            <label for="">Estado Civil Legal <span class="text-danger">(Importante)</span></label>
            <select id="ddllegal_civil_status" class="custom-select mr-sm-2" autocomplete="off" name="legal_civil_status">
                <option disabled="" selected="{{$legal_civil_status}}" value="Sin Información">Seleccionar</option>
                <option value="soltero">Soltero/a</option>
                <option value="casado">Casado/a</option>
                <option value="viudo">Viudo/a</option>
                <option value="divorciado">Divorciado/a</option>
                <option value="separado">Separado/a</option>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="">Estado Civil Actual (No acorde a lo legal) <span class="text-danger">(Importante)</span></label>
            <select id="ddlcurrent_civil_status" class="custom-select mr-sm-2" autocomplete="off" name="current_civil_status">
                <option disabled="" selected="{{$current_civil_status}}" value="Sin información">Seleccionar</option>
                <option value="soltero">Soltero/a</option>
                <option value="convive">Convive</option>
                <option value="separado">Separado/a</option>
                <option value="viudo">Viudo/a</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label>Comuna <span class="text-danger">(Importante)</span></label>
            <input id="districtparent" type="text" class="form-control" name="districtparent" value="{{$districtparent}}" placeholder="Ej: La Florida" minlength="2" required="">
        </div>
        <div class="form-group col-md-6">
            <label>Dirección <span class="text-danger">(Importante)</span></label>
            <input id="addressparent" type="text" class="form-control" name="addressparent" value="{{$addressparent}}" placeholder="Calle #" minlength="2" required="">
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
            <input type="text" class="form-control" name="emailparent" value="{{$emailparent}}" minlength="2" required="">
        </div>
        <div class="form-group col-md-6">
            <label>Nivel de estudios <span class="text-danger">(Importante)</span></label>
            <select id="dlleducational_level" class="custom-select mr-sm-2" autocomplete="off" name="educational_level">
                <option disabled="" selected="{{$educational_level}}" value="Sin Información">Seleccionar</option>
                <option value="Básica incompleta">Básica incompleta</option>
                <option value="Básica completa">Básica completa</option>
                <option value="Media incompleta">Media incompleta</option>
                <option value="Media completa">Media completa</option>
                <option value="Superior incompleta">Superior incompleta</option>
                <option value="Superior completa">Superior completa</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label>Trabajo u ocupación <span class="text-danger">(Importante)</span></label>
            <input type="text" class="form-control" name="work" value="{{$work}}" minlength="2" required="">
        </div>
        <div class="form-group col-md-4">
            <label>Dirección Completa del trabajo </label>
            <input type="text" class="form-control" name="work_address" value="{{$work_address}}" minlength="2" >
        </div>
        <div class="form-group col-md-4">
            <label>Teléfono del trabajo </label>
            <input type="text" class="form-control" name="work_phone" value="{{$work_phone}}" minlength="2" >
        </div>
        <div class="form-group col-md-4">
            <label>Guardar los cambios</label>
            <button class="form-control btn btn-success" type="submit" >Guardar</button>
        </div>
    </div>
</form>