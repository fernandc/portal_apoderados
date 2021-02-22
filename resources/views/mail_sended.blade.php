<!DOCTYPE html> 
@extends("layouts.mcdn")
@section("title")
Test Section
@endsection

@section("headex")

@endsection

@section("context")
<div class="container text-center">
    <div class="card">
        <div class="card-header">
            Activación de Cuenta
        </div>
        <div class="card-body">
            Hemos enviado un correo con un enlace de activación a su e-mail. Verifique su bandeja de entrada.
            <strong><span class="text-danger">En caso de no encontrarlo, revise su bandeja de spam (correo no deseado).</span></strong>
        </div>
    </div>
</div>
@endsection