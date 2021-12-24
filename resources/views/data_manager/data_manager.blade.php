@extends("layouts.mcdn")
@section("title")
Saint Charles Formularios
@endsection

@section("headex")

@endsection
@section("context")

<div class="container">
    <!-- NAV -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="categorias-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Categorías</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="archivos-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Archivos</a>
        </li>

    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="categorias-tab">@include('data_manager.categorias_table')</div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="archivos-tab">@include('data_manager.archivos_table')</div>
    </div>   
</div>


@endsection