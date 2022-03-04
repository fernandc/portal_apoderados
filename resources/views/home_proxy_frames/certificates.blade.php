
<form action="get_certificado_al_reg" method="get">
  <div class="row">
    <div class="col-2"></div>
    <div class="col-8">
      <div class="form-group">
        <label for="" style="font-weight: bold">Alumnos Matriculados</label>
        <select class="custom-select" name="alumnosCert" id="alumnosCert">
          <option selected>Seleccionar</option>
          @foreach ($matriculas as $item)
            @if ($item['antecedentes'] == 1 && $item['a_madre'] == 1 && $item['a_padre'] == 1 && $item['misc'] == 1)                            
              <option value="{{$item["crypt"]}}">{{$item["nombre_stu"]}}</option>                
            @endif
          @endforeach
        </select>
        <label for="" style="font-weight: bold">Certificados</label>
        <select class="custom-select" name="certSel" id="certSel" disabled="true">
          <option selected>Seleccionar</option>
          <option value="certAlumnoRegular">Certificado de alumno regular</option>
        </select>
        <div class="text-center my-3" >
          <a class="btn btn-primary disabled" target="_blank" href="" id="btn-cert" disabled type="button">Descargar</a>
        </div>
      </div>
    </div>
    <div class="col-2"></div>
  </div>
</form>
<script>
  $("#alumnosCert").change(function(){
    id_alumno = $("#alumnosCert").val();
    if (id_alumno != "Seleccionar") {
      $("#certSel").prop("disabled",false);      
      $("#btn-cert").attr("href","https://saintcharlescollege.cl/ins/generatePDF?data="+$("#alumnosCert").val());
    } else {
      $("#certSel").prop("disabled",true);
    }
  });
  $("#certSel").change(function(){
    if($("#certSel").val() == "certAlumnoRegular"){
      $("#btn-cert").removeClass("disabled");
    }else{
      $("#btn-cert").addClass("disabled");
    }
  });

</script>