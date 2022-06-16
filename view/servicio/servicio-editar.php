<img src="assets/images/logo.png" alt="logo" class="logocentro">
<h1 class="page-header">
    <?php echo $servicio->idservicio != null ? $servicio->nombre : 'Nuevo Registro'; ?>
</h1>

<ol class="breadcrumb">
  <li><a href="?c=servicio">Servicio</a></li>
  <li class="active"><?php echo $servicio->idservicio != null ? $servicio->nombre : 'Nuevo Registro'; ?></li>
</ol>

<form id="frm-alumno" action="?c=servicio&a=Guardar" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $servicio->idservicio; ?>" />
    
    <div class="form-group">
        <label>Nombre</label>
        <input type="text" name="Nombre" value="<?php echo $servicio->nombre; ?>" class="form-control" placeholder="Ingrese su nombre" required>
    </div>

    <div class="form-group">
        <label>Estado</label>
        <!-- <input type="text" name="apellidos" value="<?php echo $servicio->status; ?>" class="form-control" placeholder="Ingrese sus apellidos" required> -->
        <select name="status" id="status" class="mdb-select md-form select-css" searchable="Busca aquí..">
            <option value="1">1</option>
            <option value="0">0</option>
        </select>
    </div>

    <hr />
    <div class="text-right">
        <button class="btn btn-primary">Guardar</button>
    </div>
    
</form>