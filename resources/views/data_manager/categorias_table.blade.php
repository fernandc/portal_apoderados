<div>
    <h3>Gestor de Categorías</h3>
</div>
<div class="row">
    <div class="class col-md-6">
        <button class="btn btn-md bg-info text-white"  data-toggle="modal" data-target="#modalAddCategoria">
            <i class="fas fa-plus-circle"></i> Agregar Nueva Categoría
        </button> 
    </div>
</div>
<hr>
<div class="row">
    <div class="class col-md-12"  >
        <div class="table-responsive">
            <table class="table table-hover" id="gestorCategoriasTable">
                <thead class="thead-dark">
                    <tr style="text-align:center;">
                    <th scope="col">#</th>
                    <th scope="col">Categorias</th>
                    <th scope="col">Cantidad de Archivos</th>
                    <th scope="col">Editar</th>
                    <th scope="col">Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="text-align:center;">
                        <th scope="row">
                            1
                        </th>
                        <td>
                            Matemáticas
                        </td>
                        <td>
                            15
                        </td>
                        <td>
                            <span class="btn btn-md bg-warning text-white"> <span class="far fa-edit"></span> </span> 
                        </td>
                        <td>
                            <span class="btn btn-md bg-danger text-white"> <span class="fas fa-trash"></span> </span>                    
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>     
</div>

<!-- Modal -->
<div class="modal fade" id="modalAddCategoria" tabindex="-1" role="dialog" aria-labelledby="modalAddCategoriaCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddCategoriaCenterTitle">Agregar Nueva Categoría</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputNombreCategoria">Nombre</span>
                    </div>
                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputNombreCategoria">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready( function () {
        $('#gestorCategoriasTable').DataTable({
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Filas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Filas",
                "infoFiltered": "(Filtrado de _MAX_ total Filas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Filas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                    }
            },
        });
    } );
</script>