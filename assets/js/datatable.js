$(document).ready(function () {
  var table = $("#tabla").DataTable({
    language: {
      lengthMenu: "Mostrar _MENU_ registros por página.",
      search: "Buscar",
      zeroRecords: "Lo sentimos. No se encontraron registros.",
      info: "Mostrando página _PAGE_ de _PAGES_",
      infoEmpty: "No hay registros aún.",
      infoFiltered: "(filtrados de un total de _MAX_ registros)",
      LoadingRecords: "Cargando ...",
      Processing: "Procesando...",
      SearchPlaceholder: "Comience a teclear...",
      paginate: {
        previous: "Anterior",
        next: "Siguiente",
      },
    },
  });
  $("#table-filter").on("change", function () {
    table.search(this.value).draw();
  });
});

$(document).ready(function () {
  var table = $("#tabla-2").DataTable({
    lengthMenu: [
      [6, 10, 25, 50, -1],
      [6, 10, 25, 50, "Todo"],
    ],
    language: {
      lengthMenu: "Mostrar _MENU_ registros por página.",
      search: "Buscar",
      zeroRecords: "Lo sentimos. No se encontraron registros.",
      info: "Mostrando página _PAGE_ de _PAGES_",
      infoEmpty: "No hay registros aún.",
      infoFiltered: "(filtrados de un total de _MAX_ registros)",
      LoadingRecords: "Cargando ...",
      Processing: "Procesando...",
      SearchPlaceholder: "Comience a teclear...",
      paginate: {
        previous: "Anterior",
        next: "Siguiente",
      },
    },
    //para usar los botones
    /* responsive: "true",
    dom: "Bfrtilp",
    buttons: [
      {
        extend: "colvis",
        titleAttr: "Ver/Ocultar Columnas",
        text: "Columnas",
        postfixButtons: ["colvisRestore"],
      },
    ], */
    columnDefs: [
      {
        targets: -1,
        visible: true,
      },
    ],
  });

  $("#table-filter").on("change", function () {
    table.search(this.value).draw();
  });

  // Every time a modal is shown, if it has an autofocus element, focus on it.
  $(".modal").on("shown.bs.modal", function () {
    $(this).find("[autofocus]").focus();
  });

  $("#btn-register").click(function () {
    $(this).text("Enviando...");
    var formData = new FormData(document.getElementById("exampleModal"));
    if ($("#name-container").val().length == 0) {
      /* Campos vacios */
      $("#errorList").html("");
      $("#errorList").addClass("alert alert-danger text-center");
      $("#errorList").append(
        "<span> *El campo nombre de la carpeta no puede estar vacío</span>"
      );
      $("#btn-register").text("Guardar");
      return false;
    } else {
      /* URL para controlador y su método */
      var url_php = "?c=importacion&a=guardarContenedor";
      $.ajax({
        url: url_php,
        type: "post",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
      })
        .done(function (res) {
          /* console.log(res); */
          let obj = JSON.parse(res);
          /* console.log(obj); */
          if (obj.status == 400) {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: obj.msg,
              timer: 3000,
              timerProgressBar: true,
              showConfirmButton: false,
            });
            $("#btn-register").text("Guardar");
          } else {
            Swal.fire({
              icon: "success",
              title: "¡Guardado!",
              text: obj.msg,
              timer: 2000,
              timerProgressBar: true,
              showConfirmButton: false,
            });
            $("#exampleModal").find("select").val("");
            $("#btn-register").text("Guardar");
            $("#exampleModal").modal("hide");
            /* location.reload(); */
            window.setTimeout(function () {
              location.reload();
            }, 2000);
          }
        })
        .fail(function (res) {
          console.log(res);
        });
    }
  });

  $("#btn-register-file").click(function () {
    $(this).text("Enviando...");
    var formData = new FormData(document.getElementById("exampleModal"));
    if ($("#title").val().length == 0) {
      /* Campos vacios */
      $("#errorList").html("");
      $("#errorList").addClass("alert alert-danger text-center");
      $("#errorList").append(
        "<span> *El campo nombre del archivo no puede estar vacío</span>"
      );
      $("#btn-register-file").text("Guardar");
      return false;
    } else {
      /* URL para controlador y su método */
      var url_php = "?c=importacion&a=upFile";
      $.ajax({
        url: url_php,
        type: "post",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
      })
        .done(function (res) {
          /* console.log(res); */
          let obj = JSON.parse(res);
          /* console.log(obj); */
          if (obj.status == 400) {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: obj.msg,
              timer: 2000,
              timerProgressBar: true,
              showConfirmButton: false,
            });
            $("#btn-register-file").text("Guardar");
          } else {
            Swal.fire({
              icon: "success",
              title: "¡Guardado!",
              text: obj.msg,
              timer: 2000,
              timerProgressBar: true,
              showConfirmButton: false,
            });
            $("#exampleModal").find("select").val("");
            $("#btn-register-file").text("Guardar");
            $("#exampleModal").modal("hide");
            /* location.reload(); */
            window.setTimeout(function () {
              location.reload();
            }, 2000);
          }
        })
        .fail(function (res) {
          console.log(res);
        });
    }
  });
});

$(document).on("click", ".des-doc", function (e) {
  e.preventDefault();
  /* $(this).text("Sending.."); */
  var id = $(this).data("id");
  var data = {
    id: id,
  };
  Swal.fire({
    title: "¿Está seguro?",
    text: "¡No podrás revertir esto!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "¡Sí, bórralo!",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      /* URL para controlador y su método */
      var url_php = "?c=importacion&a=desFile&id=" + id;
      $.ajax({
        url: url_php,
        type: "post",
        dataType: "html",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
      })
        .done(function (res) {
          console.log(res);
          let obj = JSON.parse(res);
          if (obj.status == 400) {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: obj.msg,
              showConfirmButton: false,
            });
          } else {
            Swal.fire("¡Borrado!", obj.mesg, "success");
            window.setTimeout(function () {
              location.reload();
            }, 2000);
          }
        })
        .fail(function (res) {
          Swal.fire("Error!", res, "error");
        });
    }
  });
});
