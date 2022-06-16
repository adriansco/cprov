$(document).ready(function () {
  console.log("Designed by EASuárez!");
  /* VALIDA CAMPOS */
  $("#frm-alumno").submit(function () {
    return $(this).validate();
  });

  /* No me acuerdo para que era, pero no borrar ¬¬ */
  $("#preguntas").on("click", function () {
    var x = $("#preguntas").val();
    /* console.log(x); */
  });

  /* Agregar opciones a pregunta */
  var maxField = 5; //Input fields increment limitation
  var addButton = $(".add_button"); //Add button selector
  var wrapper = $(".field_wrapper"); //Input field wrapper
  var fieldHTML =
    '<div><br><input type="text" name="field_name[]" value=""/><a href="javascript:void(0);" class="remove_button" title="Remove field"> <img src="assets/images/remove-icon.png"/></a></div>'; //New input field html
  var x = 1; //Initial field counter is 1
  $(addButton).click(function () {
    //Once add button is clicked
    if (x < maxField) {
      //Check maximum number of input fields
      x++; //Increment field counter
      $(wrapper).append(fieldHTML); // Add field html
    }
  });
  $(wrapper).on("click", ".remove_button", function (e) {
    //Once remove button is clicked
    e.preventDefault();
    $(this).parent("div").remove(); //Remove field html
    x--; //Decrement field counter
  });

  $("#fecha").datepicker({
    defaultDate: "+1w",
    numberOfMonths: 1,
    dateFormat: "dd-mm-yy",
  });

  /* Deshabilitar botón de envío */
  $("#btn").click(function () {
    //Once remove button is clicked
    document.forms["frm-alumno"].addEventListener("submit", avisarUsuario);
  });

  function avisarUsuario(evObject) {
    evObject.preventDefault();
    var botones = document.querySelectorAll(".btn-primary");
    for (var i = 0; i < botones.length; i++) {
      botones[i].disabled = true;
      Notiflix.Loading.Init({});
      Notiflix.Loading.Standard("Cargando...");
    }
    /* Retrasa y envía el formulario */
    var retrasar = setTimeout(procesoRetrasar, 500);
  }

  function procesoRetrasar() {
    document.forms["frm-alumno"].submit();
    /* Notiflix.Notify.Success('Agregado correctamente'); */
  }

  /* console.log( "ready-2!" ); */
  /* FILTRO DEL SELECT */
  /* var table = $('#tabla').DataTable({
        destroy: true,
        dom: 'lrtip'
     }); */
  /* var table = $('#example').DataTable();
    table.ajax.reload();

    $('#table-filter').on('change', function(){
       table.search(this.value).draw();
    }); */
});

function cambiar(val) {
  /* console.log(val); */
  var pdrs = document.getElementById(val).files[0].name;
  /* console.log(pdrs); */
  var test = "test" + val;
  /* console.log(test); */
  document.getElementById(test).innerHTML = pdrs;
}
/* Campo dinámico */
function AgregarMas() {
  $("<div>").load("view/proveedor/InputDinamico.php", function () {
    $("#productos").append($(this).html());
  });
}

function BorrarRegistro() {
  $("div.lista-producto").each(function (index, item) {
    jQuery(":checkbox", this).each(function () {
      if ($(this).is(":checked")) {
        $(item).remove();
      }
    });
  });
}

/* jQuery("input[type=file]").change(function () {
  var filename = jQuery(this).val().split("\\").pop();
  var idname = jQuery(this).attr("id");
  console.log(jQuery(this));
  console.log(filename);
  console.log(idname);
  jQuery("span." + idname)
    .next()
    .find("span")
    .html(filename);
});
 */
/* Solo números */
function validaNumericos(event) {
  if (event.charCode >= 48 && event.charCode <= 57) {
    return true;
  }
  return false;
}
