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
            <button class="btn btn-success text-white"> <a href="confirmation_account"> Enviar código de activacion a Correo</a></button>
            <button class="btn btn-success" disabled>Enviar código de activacion por SMS</button>
        </div>
    </div>
</div>
@endsection