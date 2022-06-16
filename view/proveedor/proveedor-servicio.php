<img src="assets/images/logo.png" alt="logo" class="logocentro">
<h1 class="page-header">
    <?php echo $proveedor->idproveedor != null ? 'Agregar Documento: ' . $proveedor->nombre : 'Nuevo Registro'; ?>
</h1>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="?c=proveedor">Proveedor</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo $proveedor->idproveedor != null ? $proveedor->nombre : 'Nuevo Registro'; ?></li>
    </ol>
</nav>

<form id="frm-alumno" action="?c=proveedor&a=guardarDocumento" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $proveedor->idproveedor; ?>" />
    <input type="hidden" id = "nombrearchivo" name="nombrearchivo" value="<?php echo $proveedor->nombre; ?>" />

    <div class="form-group">
        <label>Nombre</label>
        <input type="text" name="Nombre" value="<?php echo $proveedor->nombre; ?>" class="form-control" placeholder="Ingrese su nombre" disabled>
    </div>

    <div class="form-group">
        <label>Correo</label>
        <input type="email" name="Correo" value="<?php echo $proveedor->correo; ?>" class="form-control" placeholder="Ingrese su correo electrónico" disabled>
    </div>
    <div class="form-group">
        <label>Telefono</label>
        <input type="text" name="telefono" value="<?php echo $proveedor->telefono; ?>" class="form-control" placeholder="Ingrese su telefono" disabled>
    </div>

    <!-- Begin Container-->
    <div class="container">
        <h3 class="mt-5">Documentos</h3>
        <hr>
        <!-- Begin Row -->
        <div class="row">
            <div class="col-12 col-md-12">
                <!-- Begin Form -->
                <form name="frmProduct" method="post" action="">
                    <div id="outer">
                        <div id="header">
                            <div class="float-left">&nbsp; Nro.</div>
                            <div class="float-left col-heading"> Nombre</div>
                            <div class="float-left col-heading2"> Documento</div>
                        </div>
                        <div id="productos">
                            <?php require_once('view/proveedor/InputDinamico.php'); ?>
                        </div>
                        <div class="btn-action float-clear">
                            <input class="btn btn-success" type="button" name="agregar_registros" value="Agregar Campo" onClick="AgregarMas();" />
                            <input class="btn btn-danger" type="button" name="borrar_registros" value="Borrar Campos" onClick="BorrarRegistro();" />
                            <span class="success"><?php if (isset($resultado)) {
                                                        echo $resultado;
                                                    } ?></span>
                        </div>
                        <hr />
                        <div class="text-right">
                            <input class="btn btn-primary" type="submit" name="guardar" value="Guardar" />
                        </div>
                    </div>
                </form>
                <!-- End Form -->
            </div>
        </div>
        <!-- End Row -->
    </div>
    <!-- End Container -->
    <!-- <div class="text-right">
        <button class="btn btn-primary">Agregar</button>
    </div> -->

</form>