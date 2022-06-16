$(document).ready(function () {
  $(".datepicker").datepicker({
    dateFormat: "yy-mm-dd",
  });

  // Masked inputs initialization
  $('[data-toggle="masked"]').inputmask();
});
