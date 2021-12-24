<div>
    <h3>Gestor de Archivos</h3>
</div>
<div class="row">
    <div class="class col-md-6">
    <button class="btn btn-md bg-success text-white" data-toggle="modal" data-target="#modalAddArchivo">
            <i class="fas fa-plus-circle"></i> Agregar Nuevo Archivo
        </button> 
    </div>
</div>
<hr>
<div class="row">
    <div class="class col-md-12"  >
        <div class="table-responsive">                   
            <table class="table table-hover" id="gestorArchivosTable">
                <thead class="thead-dark">
                    <tr style="text-align:center;">
                    <th scope="col">#</th>
                    <th scope="col">Archivo</th>
                    <th scope="col">Visualizar</th>
                    <th scope="col">Fecha de creación</th>
                    <th scope="col">Descargar</th>
                    <th scope="col">Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="text-align:center;">
                        <th scope="row">
                            1
                        </th>
                        <td>
                            Logaritmos.pdf
                        </td>
                        <td>
                            <button class="btn btn-md bg-info text-white">
                                <i class="fas fa-eye"></i>
                            </button>  
                        </td>
                        <td>
                            23/01/2021
                        </td>
                        <td>
                            <button class="btn btn-md bg-primary text-white">  
                                <i class="fas fa-cloud-download-alt"></i>
                            </button>  
                        </td>
                        <td>
                            <button class="btn btn-md bg-danger text-white"> <i class="fas fa-trash"></i> </button>                    
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAddArchivo"  tabindex="-1" role="dialog" aria-labelledby="modalAddArchivoCenterTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddArchivoCenterTitle">Agregar Nuevo Archivo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="newFile" class="was-validated" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="custom-file" style="width:100%" >
                            <input type="file" class="custom-file-input" accept=".pdf,image/*" autocomplete="off" id="fileAdded" name="fileAdded"  onchange="loadFile(event)" required="" lang="es">
                            <label id="label_vac_file" for="fileAdded" class="custom-file-label"  >
                                <i class="fa fa-cloud-upload"></i>Subir archivo...
                            </label>
                            <hr>
                            <div class="text-center">
                                <img id="output" style="height: 200px"/>
                            </div>
                            <br>
                        </div>                                
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" id="saveNewFile" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>




<script>
    $(document).ready( function () {
        $('#gestorArchivosTable').DataTable({
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
<script>
    var loadFile = function(event) {
        var output = document.getElementById('output');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
        }
    };
    // Send vaccine file
    function file_extension(filename){
        return (/[.]/.exec(filename)) ? /[^.]+$/.exec(filename)[0] : undefined;
    }
    $('#fileAdded').change(function() {
        var i = $(this).prev('label').clone();
        var file = $('#fileAdded')[0].files[0].name;
        var extension = file_extension(file);
        if(extension == "pdf" || extension == "jpg" || extension == "png" || extension == "jpeg"){
            if(extension == "pdf"){
                $("#output").hide();
            }else{
                $("#output").show();
            }
            $("#saveNewFile").attr("disabled",false);
        }else{
            Swal.fire('Error!', 'el archivo no es válido.', 'error');
            $("#saveNewFile").attr("disabled",true);
            file = null;
        }
        $(this).prev('label').text(file);
        console.log(extension);
        
    });
</script>