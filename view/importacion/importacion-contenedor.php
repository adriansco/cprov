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
<h1 class="page-header">Importaciones EMV</h1>

<span class="btn-group">
    <a class="btn btn-success" href="?c=importacion&a=generarReporte"><i class="las la-file-excel icon align-middle"></i>Excel</a>
    <a class="btn btn-primary" href="?c=importacion&a=Crud"><i class="las la-plus icon align-middle"></i>Agregar</a>
</span>
<br><br><br>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Crear directorio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul id="errorList"></ul>
                <input type="text" class="form-control" id="idproveedor" name="idproveedor" value="<?php echo $proveedor->idproveedor ?>" hidden>

                <div class="mb-3">
                    <label for="title" class="form-label">Proveedor</label>
                    <select class="form-control" id="title" name="title">
                        <option value="" selected>Selecciona un proveedor</option>
                        <?php foreach ($proveedores as $key => $value) : ?>
                            <option value="<?php echo $value->idproveedor; ?>"><?php echo $value->nombre; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlFile1" class="form-label">Archivo</label>
                    <input type="file" class="form-control" id="exampleFormControlFile1" id="inputfile" name="file[]" accept="application/pdf">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_SESSION['message']) && $_SESSION['message']) {
    /* printf('<div id="msg_error" class="alert alert-danger" role="alert" style="display: none"></div>'); */
    print('<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>' . $_SESSION['message'] . '</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    </button></div>');
    /* printf('<b>%s</b>', $_SESSION['message']); */
    unset($_SESSION['message']);
}
?>

<div class="table-responsive">
    <table class="table table-striped zero-configuration table-hover" id="tabla" style="width: 100%;"">
        <thead style=" background-color: #3f6ebc;">
        <tr>
            <th style="color: #ffff;">Nombre</th>
            <th style="color: #ffff;">Fecha</th>
            <th style="color: #ffff;" class="text-center">Carpetas</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($contenedores as $r) : ?>
                <tr>
                    <td><?php echo $r->nombre; ?></td>
                    <td><?php echo $r->creado_en; ?></td>
                    <td class="text-center">
                        <a class="btn btn-success" href="?c=importacion&a=documentosContenedor" rel="noopener noreferrer"><i class="lar la-folder"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
</div>