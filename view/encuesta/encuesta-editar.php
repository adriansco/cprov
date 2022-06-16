<h1 class="page-header">
    <?php echo $encuesta->id != null ? $encuesta->subject : 'Nuevo Registro'; ?>
</h1>

<ol class="breadcrumb">
  <li><a href="?c=encuesta">Preguntas</a></li>
  <li class="active"><?php echo $encuesta->id != null ? $encuesta->subject : 'Nuevo Registro'; ?></li>
</ol>

<form id="frm-alumno" action="?c=encuesta&a=Guardar" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $encuesta->id; ?>" />
    
    <div class="form-group">
        <label>Nombre</label>
        <input type="text" name="subject" value="<?php echo $encuesta->subject; ?>" class="form-control" placeholder="Ingresa pregunta" required>
    </div>

    <div class="alert alert-warning" role="alert">
        Posibles Respuestas <span class="negritas">(Max. 5 Opciones)</span>:
    </div>
    <div class="field_wrapper">
        <div>
            <input type="text" name="field_name[]" value=""/>
            <a href="javascript:void(0);" class="add_button" title="Add field"><img src="assets/images/add-icon.png"/></a>
        </div>
    </div>
    <hr />
    <div class="text-right">
        <button class="btn btn-primary">Guardar</button>
    </div>
</form>