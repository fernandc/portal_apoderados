<!DOCTYPE html> 
@extends("layouts.mcdn")
@section("title")
Restablecer Contraseña
@endsection

@section("headex")

@endsection

@section("context")
@if(isset($id))
    <div class="row my-3">
        <div class="col-md-4"></div>
        <div class="col-md-4 col-xs-12">
            <form method="get">
                <div class="card">
                    <h3 class="text-center my-3">Reestablecer contraseña</h3>
                    <div class="form-row mx-3 my-3">
                        <div class="form-group col-12">
                            <label for="">Contraseña</label>
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
        <div class="col-md-4"></div>
    </div>

    <script>
        $("#btnrecov").click(function(){
            var pass = $("#pass").val();
            pass = pass.trim();
            var passConf = $("#passConfirm").val();
            passConf = passConf.trim();
            if(pass.length == 0 || passConf.length == 0){
                Swal.fire({
                    icon: 'error',
                    title: 'Debe rellenar todos los campos.',
                    showConfirmButton: false,
                    timer: 1500
                })
            }
            else if(pass == passConf){
                $.ajax({
                    type: "GET",
                    url: "updPass",
                    data: {pass:pass,id:"{{$id}}"},
                    success: function(data)
                    {
                        //$("#test").html(data);
                        if(data == "DONE"){
                            Swal.fire({
                                icon: 'success',
                                title: 'Su contraseña ha sido modificada',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            window.location.href = "https://saintcharlescollege.cl/apoderados";  
                        }else{
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
@else
<script>
    $( document ).ready(function() {
        window.location.href = "https://saintcharlescollege.cl/apoderados";
    });
</script>
@endif


@endsection