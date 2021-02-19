<?php
$full_name = null;
$kinship = null;
$years_old = null;
$occupation = null;
$same_ins = null;
$idgroup = null;
$arr = array(
    "full_name"=>$full_name,
    "kinship"=>$kinship,
    "years_old"=>$years_old,
    "occupation"=>$occupation,
    "same_ins"=>$same_ins,
    "parent_num"=>$idgroup
);
$arrayBase= array();
for($i=0; $i<10; $i++){
    array_push($arrayBase, $arr);
}
$arrayData = array();
if(isset($dataHomeCircle)){
    foreach ($dataHomeCircle as $row) {
        if(isset($row["parent_num"])){
            $arrayBase[intval($row["parent_num"]-1)]["full_name"] = $row["full_name"];
            $arrayBase[intval($row["parent_num"]-1)]["kinship"] = $row["kinship"];
            $arrayBase[intval($row["parent_num"]-1)]["years_old"] = $row["years_old"];
            $arrayBase[intval($row["parent_num"]-1)]["occupation"] = $row["occupation"];
            $arrayBase[intval($row["parent_num"]-1)]["same_ins"] = $row["same_ins"];          
            $arrayBase[intval($row["parent_num"]-1)]["parent_num"] = $row["parent_num"];
        }
    }
}
?>
<div class="container text-center">
    <h4 class="my-3" id="test">Informacion de personas que viven con el/los estudiante/s</h4>
    <form action="" id="form0">
        <div class="card">
            <div class="card-header">
                <h4 class="my-3">Persona 1</h4>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-4"><label for="inName">Nombre</label><input class="form-control" type="text"  name="inName" value="{{$arrayBase[0]["full_name"]}}"></div>
                    <div class="form-group col-md-4"><label for="edad">Edad</label><input class="form-control" type="text" name="edad" value="{{$arrayBase[0]["years_old"]}}"></div>
                    <div class="form-group col-md-4"><label for="parentezco">Parentezco</label><input class="form-control" type="text"name="parentezco" value="{{$arrayBase[0]["kinship"]}}"></div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6"><label for="ocupation">Ocupación</label><input class="form-control" type="text" name="ocupation" value="{{$arrayBase[0]["occupation"]}}"></div>
                    <div class="form-group col-md-6"><label for="sameIns">¿Pertenece al colegio?</label><select class="form-control" name="sameIns" ><option value="SI">Si</option><option value="NO">No</option></select></div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-success btn-submit-ss" id="btn0" type="button">Guardar</button>
            </div>
        </div>
    </form>
    <hr>
    <form action="" id="form1">
        <div class="card">
            <div class="card-header">
                <h4 class="my-3">Persona 2</h4>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-4"><label for="inName">Nombre</label><input class="form-control" type="text"  name="inName" value="{{$arrayBase[1]["full_name"]}}"></div>
                    <div class="form-group col-md-4"><label for="edad">Edad</label><input class="form-control" type="text" name="edad" value="{{$arrayBase[1]["years_old"]}}"></div>
                    <div class="form-group col-md-4"><label for="parentezco">Parentezco</label><input class="form-control" type="text"name="parentezco" value="{{$arrayBase[1]["kinship"]}}"></div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6"><label for="ocupation">Ocupación</label><input class="form-control" type="text" name="ocupation" value="{{$arrayBase[1]["occupation"]}}"></div>
                    <div class="form-group col-md-6"><label for="sameIns">¿Pertenece al colegio?</label><select class="form-control" name="sameIns" ><option value="SI">Si</option><option value="NO">No</option></select></div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-success btn-submit-ss" id="btn1" type="button">Guardar</button>
            </div>
        </div>
    </form>

    <form action="" id="form2">
        <div class="card">
            <div class="card-header">
                <h4 class="my-3">Persona 3</h4>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-4"><label for="inName">Nombre</label><input class="form-control" type="text"  name="inName" value="{{$arrayBase[2]["full_name"]}}"></div>
                    <div class="form-group col-md-4"><label for="edad">Edad</label><input class="form-control" type="text" name="edad" value="{{$arrayBase[2]["years_old"]}}"></div>
                    <div class="form-group col-md-4"><label for="parentezco">Parentezco</label><input class="form-control" type="text"name="parentezco" value="{{$arrayBase[2]["kinship"]}}"></div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6"><label for="ocupation">Ocupación</label><input class="form-control" type="text" name="ocupation" value="{{$arrayBase[2]["occupation"]}}"></div>
                    <div class="form-group col-md-6"><label for="sameIns">¿Pertenece al colegio?</label><select class="form-control" name="sameIns" ><option value="SI">Si</option><option value="NO">No</option></select></div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-success btn-submit-ss" id="btn2" type="button">Guardar</button>
            </div>
        </div>
    </form>

    <form action="" id="form3">
        <div class="card">
            <div class="card-header">
                <h4 class="my-3">Persona 4</h4>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-4"><label for="inName">Nombre</label><input class="form-control" type="text"  name="inName" value="{{$arrayBase[3]["full_name"]}}"></div>
                    <div class="form-group col-md-4"><label for="edad">Edad</label><input class="form-control" type="text" name="edad" value="{{$arrayBase[3]["years_old"]}}"></div>
                    <div class="form-group col-md-4"><label for="parentezco">Parentezco</label><input class="form-control" type="text"name="parentezco" value="{{$arrayBase[3]["kinship"]}}"></div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6"><label for="ocupation">Ocupación</label><input class="form-control" type="text" name="ocupation" value="{{$arrayBase[3]["occupation"]}}"></div>
                    <div class="form-group col-md-6"><label for="sameIns">¿Pertenece al colegio?</label><select class="form-control" name="sameIns" ><option value="SI">Si</option><option value="NO">No</option></select></div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-success btn-submit-ss" id="btn3" type="button">Guardar</button>
            </div>
        </div>
    </form>

    <form action="" id="form4">
        <div class="card">
            <div class="card-header">
                <h4 class="my-3">Persona 5</h4>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-4"><label for="inName">Nombre</label><input class="form-control" type="text"  name="inName" value="{{$arrayBase[4]["full_name"]}}"></div>
                    <div class="form-group col-md-4"><label for="edad">Edad</label><input class="form-control" type="text" name="edad" value="{{$arrayBase[4]["years_old"]}}"></div>
                    <div class="form-group col-md-4"><label for="parentezco">Parentezco</label><input class="form-control" type="text"name="parentezco" value="{{$arrayBase[4]["kinship"]}}"></div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6"><label for="ocupation">Ocupación</label><input class="form-control" type="text" name="ocupation" value="{{$arrayBase[4]["occupation"]}}"></div>
                    <div class="form-group col-md-6"><label for="sameIns">¿Pertenece al colegio?</label><select class="form-control" name="sameIns" ><option value="SI">Si</option><option value="NO">No</option></select></div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-success btn-submit-ss" id="btn4" type="button">Guardar</button>
            </div>
        </div>
    </form>

    <form action="" id="form5">
        <div class="card">
            <div class="card-header">
                <h4 class="my-3">Persona 6</h4>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-4"><label for="inName">Nombre</label><input class="form-control" type="text"  name="inName" value="{{$arrayBase[5]["full_name"]}}"></div>
                    <div class="form-group col-md-4"><label for="edad">Edad</label><input class="form-control" type="text" name="edad" value="{{$arrayBase[5]["years_old"]}}"></div>
                    <div class="form-group col-md-4"><label for="parentezco">Parentezco</label><input class="form-control" type="text"name="parentezco" value="{{$arrayBase[5]["kinship"]}}"></div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6"><label for="ocupation">Ocupación</label><input class="form-control" type="text" name="ocupation" value="{{$arrayBase[5]["occupation"]}}"></div>
                    <div class="form-group col-md-6"><label for="sameIns">¿Pertenece al colegio?</label><select class="form-control" name="sameIns" ><option value="SI">Si</option><option value="NO">No</option></select></div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-success btn-submit-ss" id="btn5" type="button">Guardar</button>
            </div>
        </div>
    </form>

    <form action="" id="form6">
        <div class="card">
            <div class="card-header">
                <h4 class="my-3">Persona 7</h4>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-4"><label for="inName">Nombre</label><input class="form-control" type="text"  name="inName" value="{{$arrayBase[6]["full_name"]}}"></div>
                    <div class="form-group col-md-4"><label for="edad">Edad</label><input class="form-control" type="text" name="edad" value="{{$arrayBase[6]["years_old"]}}"></div>
                    <div class="form-group col-md-4"><label for="parentezco">Parentezco</label><input class="form-control" type="text"name="parentezco" value="{{$arrayBase[6]["kinship"]}}"></div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6"><label for="ocupation">Ocupación</label><input class="form-control" type="text" name="ocupation" value="{{$arrayBase[6]["occupation"]}}"></div>
                    <div class="form-group col-md-6"><label for="sameIns">¿Pertenece al colegio?</label><select class="form-control" name="sameIns" ><option value="SI">Si</option><option value="NO">No</option></select></div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-success btn-submit-ss" id="btn6" type="button">Guardar</button>
            </div>
        </div>
    </form>

    <form action="" id="form7">
        <div class="card">
            <div class="card-header">
                <h4 class="my-3">Persona 8</h4>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-4"><label for="inName">Nombre</label><input class="form-control" type="text"  name="inName" value="{{$arrayBase[7]["full_name"]}}"></div>
                    <div class="form-group col-md-4"><label for="edad">Edad</label><input class="form-control" type="text" name="edad" value="{{$arrayBase[7]["years_old"]}}"></div>
                    <div class="form-group col-md-4"><label for="parentezco">Parentezco</label><input class="form-control" type="text"name="parentezco" value="{{$arrayBase[7]["kinship"]}}"></div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6"><label for="ocupation">Ocupación</label><input class="form-control" type="text" name="ocupation" value="{{$arrayBase[7]["occupation"]}}"></div>
                    <div class="form-group col-md-6"><label for="sameIns">¿Pertenece al colegio?</label><select class="form-control" name="sameIns" ><option value="SI">Si</option><option value="NO">No</option></select></div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-success btn-submit-ss" id="btn7" type="button">Guardar</button>
            </div>
        </div>
    </form>

    <form action="" id="form8">
        <div class="card">
            <div class="card-header">
                <h4 class="my-3">Persona 9</h4>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-4"><label for="inName">Nombre</label><input class="form-control" type="text"  name="inName" value="{{$arrayBase[8]["full_name"]}}"></div>
                    <div class="form-group col-md-4"><label for="edad">Edad</label><input class="form-control" type="text" name="edad" value="{{$arrayBase[8]["years_old"]}}"></div>
                    <div class="form-group col-md-4"><label for="parentezco">Parentezco</label><input class="form-control" type="text"name="parentezco" value="{{$arrayBase[8]["kinship"]}}"></div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6"><label for="ocupation">Ocupación</label><input class="form-control" type="text" name="ocupation" value="{{$arrayBase[8]["occupation"]}}"></div>
                    <div class="form-group col-md-6"><label for="sameIns">¿Pertenece al colegio?</label><select class="form-control" name="sameIns" ><option value="SI">Si</option><option value="NO">No</option></select></div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-success btn-submit-ss" id="btn8" type="button">Guardar</button>
            </div>
        </div>
    </form>

    <form action="" id="form9">
        <div class="card">
            <div class="card-header">
                <h4 class="my-3">Persona 10</h4>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-4"><label for="inName">Nombre</label><input class="form-control" type="text"  name="inName" value="{{$arrayBase[9]["full_name"]}}"></div>
                    <div class="form-group col-md-4"><label for="edad">Edad</label><input class="form-control" type="text" name="edad" value="{{$arrayBase[9]["years_old"]}}"></div>
                    <div class="form-group col-md-4"><label for="parentezco">Parentezco</label><input class="form-control" type="text"name="parentezco" value="{{$arrayBase[9]["kinship"]}}"></div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6"><label for="ocupation">Ocupación</label><input class="form-control" type="text" name="ocupation" value="{{$arrayBase[9]["occupation"]}}"></div>
                    <div class="form-group col-md-6"><label for="sameIns">¿Pertenece al colegio?</label><select class="form-control" name="sameIns" ><option value="SI">Si</option><option value="NO">No</option></select></div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-success btn-submit-ss" id="btn9" type="button">Guardar</button>
            </div>
        </div>
    </form>
    
    <hr>
</div>
<section>
    <script>
        $(".btn-submit-ss").click(function() {
            var idbtn = $(this).attr('id'); //btnguardar4
            var idgroup = idbtn.substr(3);
            var newid = parseInt(idgroup)+1;
            var chardata = $('#form'+idgroup).serialize().concat("&").concat("idgrp").concat('=').concat(newid);
            alert(chardata)
            $.ajax({
                data:chardata,
                cache: false,
                processData: false,
                contentType: false,
                type: 'GET',
                url:"home_circle",
                success: function (dataofconfirm) {
                    $("#test").html(dataofconfirm);
                    Swal.fire({
                        icon: 'success',
                        title: 'Guardado',
                        text: 'Se ha guardado correctamente',
                        showConfirmButton:false,
                        timer: 1500
                    })
                }
            });
        });
    </script>
</section>
