<!DOCTYPE html> 
@extends("layouts.mcdn")
@section("title")
Saint Charles Portal Apoderados
@endsection

@section("headex")

@endsection

@section("context")
    <div class="container mx-auto" style="display: flex;min-height: 100vh;align-items: center;justify-content: center;">
        <div class="card">
            <img src="public/scc_logo.png" class="card-img-top rounded mx-auto d-block my-3" alt="logo" style="width: 150px;">
            <div class="card-header">
                <h4 style="text-align: center;">Portal de Apoderados</h4>
            </div>
            <div class="card-body">
                <form class="was-validated" action="auth_proxy" method="GET">
                    @csrf
                    <div class="form-row">
                        @if ( session('message') )
                            <div class="alert alert-danger">{{ session('message') }}</div>
                        @endif
                        <div class="form-group col-md-12">
                            <label for="dni">Ingrese su rut</label>
                        <input type="text" class="form-control is-invalid" id="dni" name="dni" autofocus="" placeholder="12345678-9" required="">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="passwd">Contraseña<br></label>
                            <input type="password" class="form-control is-invalid" id="passwd" name="passwd" minlength="6" maxlength="20" placeholder="ABCDEF" required="">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Continuar</button>
                </form>
                <hr>
                <a href="">Olvidé mi contraseña</a>
                <hr>
                <h6 class="text-primary">Cualquier duda, problema o consulta envíar un correo a: servicio@saintcharlescollege.cl</h6>
                @if(isset($exc))
                <hr>
                <h6 class="text-danger" style="text-align: center">{{$exc}}</h6>
                @endif
            </div>
        </div>
    <div>
@endsection