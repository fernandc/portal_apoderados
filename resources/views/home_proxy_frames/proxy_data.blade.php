<div id="formproxy" class="row" style="font-size: 0.9rem">
    <div class="form-group col-md-6">
        <label for="rutparent">Rut <span class="text-danger">(Importante)</span></label>
        <input id="rutparent" class="form-control is-invalid" autocomplete="off" name="rut" value="" type="text" oninput="checkRut(this)" minlength="1" maxlength="11">
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
    <div class="form-group col-md-4">
        <label for="">Nombres <span class="text-danger">(Importante)</span></label>
        <input id="nombresparent" type="text" class="form-control" name="nombresparent" value="" placeholder="Nombres" minlength="2" required="">
    </div>
    <div class="form-group col-md-4">
        <label for="">Apellido Paterno <span class="text-danger">(Importante)</span></label>
        <input id="apellido_pparent" type="text" class="form-control" name="apellido_pparent" value="" placeholder="Apellido paterno" minlength="2" required="">
    </div>
    <div class="form-group col-md-4">
        <label for="">Apellido Materno <span class="text-danger">(Importante)</span></label>
        <input id="apellido_mparent" type="text" class="form-control" name="apellido_mparent" value="" placeholder="Apellido materno" minlength="2" required="">
    </div>
    <div class="form-group col-md-4">
        <label for="">Fecha de Nacimiento <span class="text-danger">(Importante)</span></label>
        <input class="form-control" type="date" name="fecha_nacparent" value="">
    </div>
    <input type="text" class="form-control" name="ddllive_with" value="Si" hidden="">
    <input type="text" class="form-control" name="visits_per_months" value="0" hidden="">
    <div class="form-group col-md-4">
        <label for="">Estado Civil Legal <span class="text-danger">(Importante)</span></label>
        <select id="ddllegal_civil_status" class="custom-select mr-sm-2" autocomplete="off" name="legal_civil_status">
            <option disabled="" selected="" value="Sin Información">Seleccionar</option>
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
            <option disabled="" selected="" value="Sin información">Seleccionar</option>
            <option value="soltero">Soltero/a</option>
            <option value="convive">Convive</option>
            <option value="separado">Separado/a</option>
            <option value="viudo">Viudo/a</option>
        </select>
                            </div>
    <div class="form-group col-md-6">
        <label>Comuna <span class="text-danger">(Importante)</span></label>
        <input id="districtparent" type="text" class="form-control" name="districtparent" value="" placeholder="Ej: La Florida" minlength="2" required="">
    </div>
    <div class="form-group col-md-6">
        <label>Dirección <span class="text-danger">(Importante)</span></label>
        <input id="addressparent" type="text" class="form-control" name="addressparent" value="" placeholder="Calle #" minlength="2" required="">
    </div>
    <div class="form-group col-md-4">
        <label>Teléfono Casa <span class="text-danger">(Importante)</span></label>
        <input type="text" class="form-control" name="phoneparent" value="" minlength="2" required="">
    </div>
    <div class="form-group col-md-4">
        <label>Celular <span class="text-danger">(Importante)</span></label>
        <input type="text" class="form-control" name="cellphoneparent" value="" minlength="2" required="">
    </div>
    <div class="form-group col-md-4">
        <label>Email <span class="text-danger">(Importante)</span></label>
        <input type="text" class="form-control" name="emailparent" value="" minlength="2" required="">
    </div>
    <div class="form-group col-md-6">
        <label>Nivel de estudios <span class="text-danger">(Importante)</span></label>
        <select id="dlleducational_level" class="custom-select mr-sm-2" autocomplete="off" name="educational_level">
            <option disabled="" selected="" value="Sin Información">Seleccionar</option>
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
        <input type="text" class="form-control" name="work" value="" minlength="2" required="">
    </div>
    <div class="form-group col-md-4">
        <label>Dirección Completa del trabajo </label>
        <input type="text" class="form-control" name="work_address" value="" minlength="2" required="">
    </div>
    <div class="form-group col-md-4">
        <label>Teléfono del trabajo </label>
        <input type="text" class="form-control" name="work_phone" value="" minlength="2" required="">
    </div>
    <div class="form-group col-md-4">
        <label for="btnapisearch2">Guardar los cambios</label>
        <button class="form-control btn btn-success" type="button" id="btnapisearch2">Guardar</button>
    </div>
</div>