<!DOCTYPE html> 
@extends("layouts.mcdn")
@section("title")
Saint Charles Formularios
@endsection

@section("headex")

@endsection

@section("context")
    <style>
        .abs-center {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        }
    
        .form {
        width: 450px;
        }
        .ingreso {
            font-family: "Consolas" !important;
            color: grey
        }
    </style>
    <div class="container">
        <!-- input contraseña -->
        <div class="abs-center">
            <form action="/auth_admin" method="GET" class="border p-3 was-validated">
                @csrf
                <img src="public/scc_logo.png" class="card-img-top rounded mx-auto d-block" alt="logo" style="width: 150px;">
                <div class="card-header">
                    <h4 style="text-align: center;">Panel de Administración</h4>
                </div>
                @if ( session('message') )
                    <div class="alert alert-danger">{{ session('message') }}</div>
                @endif
                <div class="form-group">
                    <label for="passAdmin">Contraseña</label>
                    <input type="password" class="form-control is-invalid" id="passAdmin" name="passAdmin" placeholder="ABCDE" required="" minlength="7" maxlength="7" autofocus="">
                    <!-- <input type="text" class="form-control is-invalid" id="passwd" name="passwd" minlength="6" maxlength="6" autofocus="" placeholder="ABCDEF" required=""> -->
                </div>
                <button type="submit" class="btn btn-primary">Ingresar</button>
                @if(isset($exc))
                    <hr>
                    <h6 class="text-danger" style="text-align: center">{{$exc}}</h6>
                @endif
            </form>
        </div>
    </div>
@endsection