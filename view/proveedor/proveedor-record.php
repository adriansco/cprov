<img src="assets/images/logo.png" alt="logo" class="logocentro">
<h1 class="page-header">
    <?php echo $proveedor->idproveedor != null ? 'Historial ' . $proveedor->nombre : 'Nuevo Registro'; ?>
    <!-- <a class="btn btn-primary pull-right" href="?c=proveedor&a=AddService&id=<?php echo $proveedor->idproveedor; ?>">Agregar Documento</a> -->
</h1>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="?c=proveedor">Proveedor</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo $proveedor->idproveedor != null ? $proveedor->nombre : 'Nuevo Registro'; ?></li>
    </ol>
</nav>

<form id="frm-alumno" action="?c=proveedor&a=Guardar" method="post" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?php echo $proveedor->idproveedor; ?>" />

    <table class="table  table-striped  table-hover" id="tabla-2">
        <thead>
            <tr>
                <th style="width:250px; background-color: #3f6ebc; color:#fff">Documento</th>
                <th style="width:50px; background-color: #3f6ebc; color:#fff; text-align: center;">Ver</th>
                <th style="width:50px; background-color: #3f6ebc; color:#fff; text-align: center;">Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($this->model->fetchDocuments($proveedor->idproveedor) as $r) : ?>
                <tr>
                    <td><?php echo $r->nombre; ?></td>
                    <td class="text-center">
                        <!-- <-?php echo $r->Ruta; ?> -->
                        <a class="btn btn-success" href="<?php echo $r->path; ?>" target="_blank" rel="noopener noreferrer">VER</a>
                    </td>
                    <!-- BOTÓN ELIMINAR -->
                    <td class="text-center">
                        <a class="btn btn-danger" onclick="return confirm('¿Seguro de eliminar este registro?');" href="?c=proveedor&a=EliminarRecord&id=<?php echo $r->iddocumento; ?>&idproveedor=<?php echo $proveedor->id_proveedor; ?>">Eliminar</a>
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