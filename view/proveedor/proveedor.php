<img src="assets/images/logo.png" alt="logo" class="logocentro">
<h1 class="page-header">Proveedores EMV</h1>
<?php $data = $this->model->Listar(); ?>

<?php
if (isset($_SESSION['message']) && $_SESSION['message']) {
    print('<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>' . $_SESSION['message'] . '</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    </button></div>');
    unset($_SESSION['message']);
}
?>

<span class="btn-group">
    <a class="btn btn-success pull-right" href="?c=proveedor&a=generarReporte">Excel</a>
    <a class="btn btn-primary pull-right" href="?c=proveedor&a=Crud">Agregar</a>
    <!-- <button class="btn btn-success">Edit</button>
    <button class="btn btn-success dropdown-toggle" data-toggle="dropdown">
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li><a href="#">...my menus...</a></li>
    </ul> -->
</span>
<br><br>
<div class="table-responsive">
    <table class="table align-middle table-striped table-hover zero-configuration" id="tabla" style="width: 100%;">
        <thead style="background-color: #3f6ebc;">
            <tr>
                <th style="color:#fff">ID Agentis</th>
                <th style="color:#fff">Nombre</th>
                <th style="color:#fff">Correo</th>
                <th style="color:#fff">Teléfono</th>
                <th style="color:#fff">Acciones</th>
                <th style="color:#fff">Documentos</th>
                <!--  #cd6155  -->
            </tr>
        </thead>
        <tbody>
            <!-- Listado de proveedoress por usuarios -->
            <?php foreach ($this->model->Listar() as $r) : ?>
                <tr>
                    <td><?php echo $r->idagentis; ?></td>
                    <td><?php echo $r->nombre; ?></td>
                    <td><?php echo $r->correo; ?></td>
                    <td><?php echo $r->telefono; ?></td>
                    <!-- ACCIONES -->
                    <td class="text-center">
                        <span class="btn-group">
                            <a class="btn btn-warning" href="?c=proveedor&a=Crud&id=<?php echo $r->idproveedor; ?>">Editar</a>
                            <a class="btn btn-danger" onclick="return confirm('¿Seguro de eliminar este registro?');" href="?c=proveedor&a=Eliminar&id=<?php echo $r->idproveedor; ?>">Eliminar</a>
                        </span>
                    </td>
                    <!-- BOTÓN HISTORIAL -->
                    <td class="text-center">
                        <!-- Llamado a la función del controlador => href="?c=proveedor&a=Crud&id=<-?php echo $r->id; ?>" -->
                        <a class="btn btn-success" href="?c=proveedor&a=Record&id=<?php echo $r->idproveedor; ?>">Documentos</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>