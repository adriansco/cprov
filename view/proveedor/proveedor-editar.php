<img src="assets/images/logo.png" alt="logo" class="logocentro">
<h1 class="page-header">
    <?php echo $proveedor->idproveedor != null ? $proveedor->nombre : 'Nuevo Registro'; ?>
</h1>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="?c=proveedor">Proveedor</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo $proveedor->idproveedor != null ? $proveedor->nombre : 'Nuevo Registro'; ?></li>
    </ol>
</nav>

<form id="frm-alumno" name="frm-alumno" action="?c=proveedor&a=Guardar" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $proveedor->idproveedor; ?>" />

    <div class="form-group">
        <label>ID Agentis</label>
        <!-- onkeypress='return validaNumericos(event)' -->
        <input type="text" name="idagentis" id="idagentis" value="<?php echo $proveedor->idagentis; ?>" class="form-control" placeholder="Ingrese ID Agentis" required>
    </div>

    <div class="form-group">
        <label>Nombre</label>
        <input type="text" name="nombre" value="<?php echo $proveedor->nombre; ?>" class="form-control" placeholder="Ingrese su nombre" required>
    </div>

    <!-- idagentis -->

    <div class="form-group">
        <label>Correo</label>
        <input type="email" name="correo" value="<?php echo $proveedor->correo; ?>" class="form-control" placeholder="Ingrese su correo electrónico" required>
    </div>

    <div class="form-group">
        <label>Telefono</label>
        <input type="text" onkeypress='return validaNumericos(event)' name="telefono" value="<?php echo $proveedor->telefono; ?>" class="form-control" placeholder="Ingrese su telefono" required>
    </div>
    <!-- Trabajando -->
    <!-- Grid Init -->
    <div class="grid-container pt-3">

        <div class="grid-item">
            <div class="custom-file">
                <input type="file" name="uploadedFile[]" class="custom-file-input" id="1" onchange="cambiar(this.id)" multiple>
                <!-- <div id="info"></div> -->
                <label class="custom-file-label" for="customFile" id="test1">RFC</label>
            </div>
        </div>

        <div class="grid-item">
            <div class="custom-file">
                <input type="file" name="uploadedFile2[]" class="custom-file-input" id="2" onchange="cambiar(this.id)" multiple>
                <!-- <div id="info"></div> -->
                <label class="custom-file-label" for="customFile" id="test2">CSF</label>
            </div>
        </div>

        <div class="grid-item">
            <div class="custom-file">
                <input type="file" name="uploadedFile3[]" class="custom-file-input" id="3" onchange="cambiar(this.id)" multiple>
                <!-- <div id="info"></div> -->
                <label class="custom-file-label" for="customFile" id="test3">Opinión de Cumplimiento positiva SAT</label>
            </div>
        </div>

        <div class="grid-item">
            <div class="custom-file">
                <input type="file" name="uploadedFile4[]" class="custom-file-input" id="4" onchange="cambiar(this.id)" multiple>
                <!-- <div id="info"></div> -->
                <label class="custom-file-label" for="customFile" id="test4">Comprobante de Domicilio</label>
            </div>
        </div>

        <div class="grid-item">
            <div class="custom-file">
                <input type="file" name="uploadedFile5[]" class="custom-file-input" id="5" onchange="cambiar(this.id)" multiple>
                <!-- <div id="info"></div> -->
                <label class="custom-file-label" for="customFile" id="test5">Estado de cuenta</label>
            </div>
        </div>

        <div class="grid-item">
            <div class="custom-file">
                <input type="file" name="uploadedFile6[]" class="custom-file-input" id="6" onchange="cambiar(this.id)" multiple>
                <!-- <div id="info"></div> -->
                <label class="custom-file-label" for="customFile" id="test6">Acta Constitutiva</label>
            </div>
        </div>

        <div class="grid-item">
            <div class="custom-file">
                <input type="file" name="uploadedFile7[]" class="custom-file-input" id="7" onchange="cambiar(this.id)" multiple>
                <!-- <div id="info"></div> -->
                <label class="custom-file-label" for="customFile" id="test7">Poder RL</label>
            </div>
        </div>

        <div class="grid-item">
            <div class="custom-file">
                <input type="file" name="uploadedFile8[]" class="custom-file-input" id="8" onchange="cambiar(this.id)" multiple>
                <!-- <div id="info"></div> -->
                <label class="custom-file-label" for="customFile" id="test8">Identificación Oficial RL</label>
            </div>
        </div>

        <div class="grid-item">
            <div class="custom-file">
                <input type="file" name="uploadedFile9[]" class="custom-file-input" id="9" onchange="cambiar(this.id)" multiple>
                <!-- <div id="info"></div> -->
                <label class="custom-file-label" for="customFile" id="test9">Contrato</label>
            </div>
        </div>

        <div class="grid-item">
            <div class="custom-file">
                <input type="file" name="uploadedFile10[]" class="custom-file-input" id="10" onchange="cambiar(this.id)" multiple>
                <!-- <div id="info"></div> -->
                <label class="custom-file-label" for="customFile" id="test10">Otro</label>
            </div>
        </div>
    </div>
    <!-- Grid End -->
    <hr />
    <div class="text-right">
        <!-- <button class="btn btn-primary" type="submit" name="uploadBtn" value="Upload">Guardar</button> -->
        <input type="submit" id="uploadBtn" name="uploadBtn" value="Guardar" class="test" />
    </div>

</form>