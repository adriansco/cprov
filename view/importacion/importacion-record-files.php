<?php
if (isset($_SESSION['message']) && $_SESSION['message']) {
    /* printf('<div id="msg_error" class="alert alert-danger" role="alert" style="display: none"></div>'); */
    print('<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>' . $_SESSION['message'] . '</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    </button></div>');
    /* printf('<b>%s</b>', $_SESSION['message']); */
    unset($_SESSION['message']);
}
?>
<img src="assets/images/logo.png" alt="logo" class="logocentro">
<h2 class="page-header">Documentos de la carpeta <?php echo $contenedor->nombre ?></h2>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="?c=importacion">Importaciones</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo $contenedor->idcontenedor != null ? $contenedor->nombre : 'Nuevo Registro'; ?></li>
    </ol>
</nav>

<!-- <form id="frm-alumno" action="?c=proveedor&a=Guardar" method="post" enctype="multipart/form-data"> -->
<div class="align-self-end ml-auto text-right">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="las la-plus icon align-middle"></i>Agregar</button>
</div>
<br>
<!-- Modal -->
<form enctype="multipart/form-data" class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Documento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul id="errorList"></ul>
                <input type="text" class="form-control" id="idcontenedor" name="idcontenedor" value="<?php echo $contenedor->idcontenedor ?>" hidden>
                <input type="text" class="form-control" id="idproveedor" name="idproveedor" value="<?php echo $contenedor->id_proveedor ?>" hidden>

                <div class="mb-3">
                    <label for="title" class="form-label">Nombre del archivo</label>
                    <select class="form-control" id="title" name="title">
                        <option value="" selected>Clic aquí...</option>

                        <option value="Orden de compra">Orden de compra</option>
                        <option value="Pedimento">Pedimento</option>
                        <option value="Factura">Factura</option>
                        <option value="Cuenta de gastos">Cuenta de gastos</option>

                        <option value="Entrada MP">Entrada MP</option>
                        <option value="Cartas">Cartas</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlFile1" class="form-label">Archivo</label>
                    <input type="file" class="form-control" id="exampleFormControlFile1" id="inputfile" name="file[]" accept="application/pdf">
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" name="btn-register-file" id="btn-register-file">Guardar</button>
            </div>
        </div>
    </div>
</form>

<input type="hidden" name="id" value="<?php echo $contenedor->idcontenedor; ?>" />

<table class="table table-striped zero-configuration table-hover" id="tabla-2" style="width: 100%;">
    <thead style="background-color: #3f6ebc;">
        <tr>
            <th style="display: none;">ID</th>
            <th style="color:#fff">Nombre archivo</th>
            <th style="color:#fff">Fecha de registro</th>
            <th style="color:#fff; text-align: center;">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($this->model->fetchFiles($contenedor->idcontenedor) as $r) : ?>
            <tr>
                <td style="display: none;" id="idcontenedor"><?php echo $r->idcontenedor; ?></td>
                <td><?php echo $r->nombre; ?></td>
                <td><?php echo $r->creado; ?></td>
                <td class="text-center">
                    <a class="btn btn-success" href="<?php echo $r->path ?>" target="_blank" rel="noopener noreferrer"><i class="icon align-middle las la-eye"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- <script>
    $(document).ready(function(){
        $("#frm-alumno").submit(function(){
            return $(this).validate();
        });
    })
</script> -->