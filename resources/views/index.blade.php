<!DOCTYPE html> 
@extends("layouts.mcdn")
@section("title")
Saint Charles Formularios
@endsection

@section("headex")

@endsection

@section("context")
    <div class="container mx-auto" style="display: flex;min-height: 100vh;align-items: center;justify-content: center;">
        <div class="card">
            <img src="scc_logo.png" class="card-img-top rounded mx-auto d-block" alt="logo" style="width: 150px;">
            <div class="card-header">
                <h4 style="text-align: center;">Portal de Apoderados</h4>
                
            </div>
            <div class="card-body">
                <form class="was-validated" action="/auth_proxy" @method('POST')>
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="dni">Ingrese su rut<br><span class="text-secondary"></span></label>
                            <input type="text" class="form-control is-invalid" id="dni" name="dni" autofocus="" placeholder="12345678" required="">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="passwd">Contraseña<br></label>
                            <input type="text" class="form-control is-invalid" id="passwd" name="passwd" minlength="6" maxlength="20" placeholder="ABCDEF" required="" style="text-transform: uppercase">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Continuar</button>
                </form>
                @if(isset($exc))
                <hr>
                <h6 class="text-danger" style="text-align: center">{{$exc}}</h6>
                @endif
            </div>
        </div>
    <div>
@endsection