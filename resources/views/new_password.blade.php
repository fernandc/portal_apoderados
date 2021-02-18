<!DOCTYPE HTML> 
@extends("layouts.mcdn")
@section("title")
Cambio de contraseña
@endsection

@section("headex")

@endsection

@section("context")

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Saint Charles</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
  </div>
</nav>

    <div class=" card container my-5">

      <div class="container my-3">
          <form action="/change_password" method="GET">
              @csrf
              <h1 class="text-center">Actualizar datos personales</h1>
              
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label for="names">Nombres</label>
                  <input type="text" maxlength="40" class="form-control" name="names" id="names" placeholder="Ingrese nombre completo" required>
                </div>
                <div class="form-group col-md-4">
                  <label for="last_p">Apellido Paterno</label>
                  <input type="text" maxlength="20" class="form-control" name="last_p" id="names" placeholder="Apellido Paterno..." required>
                </div>
                <div class="form-group col-md-4">
                  <label for="">Apellido Materno</label>
                  <input type="text" maxlength="20" class="form-control" name="last_m" id="last_m" placeholder="Apellido Materno..." required>
                </div>
              </div>
              
              <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="email">Correo electrónico</label>
                    <input type="email" name="email" class="form-control" placeholder="Ingrese Correo..." id="email">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="cell_phone">Teléfono celular</label>
                    <input type="text" name="cell_phone" id="cell_phone" class="form-control" placeholder="Teléfono celular">
                  </div>
              </div>
              <h1 class="text-center my-2">Crear Contraseña</h1>
              @if ( session('message') )
                  <div class="alert alert-danger">{{ session('message')}}</div>
              @endif
              <div class="form-group">
                <label for="passwd">Nueva Contraseña</label>
                <input type="password" min="6" maxlength="20" class="form-control" id="passwd" placeholder="Ingrese contraseña..." name="passwd">
                <small id="emailHelp" class="form-text text-muted">Ingrese mínimo 6 caracteres y como máximo 20 caracteres</small>
              </div>
              <div class="form-group">
                <label for="passwdconf">Reingrese Contraseña</label>
                <input type="password" min="6" maxlength="20" class="form-control" id="passwd" placeholder="reingrese contraseña..." name="passwdconf">
              </div>   
              <div class="text-center">
                  <button type="submit" class="btn btn-success">Enviar</button>
              </div>
          </form>
      </div>
  </div>
@endsection