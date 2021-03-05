<!DOCTYPE html> 
@extends("layouts.mcdn")
@section("title")
Saint charles 
@endsection

@section("headex")

@endsection

@section("context")
<div class="container my-3" style="text-align: center">
    <form action="" method="get">
        <h3 id="test">Recuperar contraseña</h3>
        <hr>
        <p>Se enviará un correo de recuperación de contraseña, al email asociado a su cuenta.</p>
        <label for="">Ingrese su rut (sin puntos ni guión)</label>
        <input type="text" name="rutpass" id="rutpass">
        <button class="btn btn-success" type="button" id="btnpass">Enviar</button>
    </form>
    <script>
        $("#btnpass").click(function(){
            var dni = $("#rutpass").val();
            if(dni.length == 0 ){
                Swal.fire({
                    icon: 'error',
                    title: 'Debe rellenar el campo.',
                    showConfirmButton: false,
                    timer: 1500
                })
            }else{
                $.ajax({
                    type: "GET",
                    url: "forget_pass",
                    data: {dni:dni},
                    success: function(data)
                    {
                        if(data == "DONE" ){
                            Swal.fire({
                                icon: 'success',
                                title: 'Se ha enviado el correo',
                                timer: 6000
                            })
                        }else if(data == "FAILED" || data == "NOT FOUND"){
                            Swal.fire({
                                icon: 'error',
                                title: 'No se ha encontrado un usuario.',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                        else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Debe esperar ' + (300-data) + ' segundos para enviar otra solicitud.',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    }
                });
            }
        });
    </script>
</div>
@endsection