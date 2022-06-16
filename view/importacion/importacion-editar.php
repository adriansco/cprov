<img src="assets/images/logo.png" alt="logo" class="logocentro">
<h1 class="page-header">
    <!-- <-?php echo $proveedor->idproveedor != null ? $proveedor->nombre : 'Nuevo Registro'; ?> -->
    Nuevo Registro
</h1>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="?c=importacion">Importaciones</a></li>
        <!-- <-?php echo $proveedor->idproveedor != null ? $proveedor->nombre : 'Nuevo Registro'; ?> -->
        <li class="breadcrumb-item active" aria-current="page">Nuevo Registro</li>
    </ol>
</nav>

<form id="frm-alumno" name="frm-alumno" action="?c=importacion&a=Guardar" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="proveedor" class="form-label">Proveedor:</label>
        <select class="form-control" id="proveedor" name="proveedor" required>
            <option value="" selected>Selecciona un proveedor</option>
            <?php foreach ($proveedores as $key => $value) : ?>
                <option value="<?php echo $value->idproveedor; ?>"><?php echo $value->nombre; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="container" class="col-form-label">Nombre de la carpeta:</label>
        <input type="text" name="container" data-toggle="masked" data-inputmask="'mask': '9999/99/99'" placeholder="..." class="form-control">
        <span class="help-block">"Formato: AA/MM/DD"</span>
    </div>

    <!-- Documentos -->
    <!-- Grid Init -->
    <div class="grid-container">

        <div class="grid-item">
            <div class="custom-file">
                <input type="file" name="uploadedFile[]" class="custom-file-input" id="1" onchange="cambiar(this.id)" multiple>
                <label class="custom-file-label" for="customFile" id="test1">Orden de compra</label>
            </div>
        </div>

        <div class="grid-item">
            <div class="custom-file">
                <input type="file" name="uploadedFile2[]" class="custom-file-input" id="2" onchange="cambiar(this.id)" multiple>
                <!-- <div id="info"></div> -->
                <label class="custom-file-label" for="customFile" id="test2">Pedimento</label>
            </div>
        </div>

        <div class="grid-item">
            <div class="custom-file">
                <input type="file" name="uploadedFile3[]" class="custom-file-input" id="3" onchange="cambiar(this.id)" multiple>
                <!-- <div id="info"></div> -->
                <label class="custom-file-label" for="customFile" id="test3">Factura</label>
            </div>
        </div>

        <div class="grid-item">
            <div class="custom-file">
                <input type="file" name="uploadedFile4[]" class="custom-file-input" id="4" onchange="cambiar(this.id)" multiple>
                <!-- <div id="info"></div> -->
                <label class="custom-file-label" for="customFile" id="test4">Cuenta de gastos</label>
            </div>
        </div>

        <div class="grid-item">
            <div class="custom-file">
                <input type="file" name="uploadedFile5[]" class="custom-file-input" id="5" onchange="cambiar(this.id)" multiple>
                <!-- <div id="info"></div> -->
                <label class="custom-file-label" for="customFile" id="test5">Entrada MP</label>
            </div>
        </div>

        <div class="grid-item">
            <div class="custom-file">
                <input type="file" name="uploadedFile6[]" class="custom-file-input" id="6" onchange="cambiar(this.id)" multiple>
                <!-- <div id="info"></div> -->
                <label class="custom-file-label" for="customFile" id="test6">Cartas</label>
            </div>
        </div>

        <div class="grid-item">
            <div class="custom-file">
                <input type="file" name="uploadedFile7[]" class="custom-file-input" id="7" onchange="cambiar(this.id)" multiple>
                <!-- <div id="info"></div> -->
                <label class="custom-file-label" for="customFile" id="test7">Otro</label>
            </div>
        </div>
    </div>
    <!-- Grid End -->
    <hr />
    <div class="text-right">
        <input type="submit" id="uploadBtn" name="uploadBtn" value="Guardar" class="test" />
    </div>
</form>