<h1 class="page-header">Preguntas</h1>
    <a class="btn btn-primary pull-right" href="?c=encuesta&a=Crud">Agregar</a>
<br><br><br>

<table class="table  table-striped  table-hover" id="tabla">
    <thead>
        <tr>
            <th style="width:180px; background-color: #5DACCD; color:#fff">Subject</th>
            <th style="width:180px; background-color: #5DACCD; color:#fff">Creado</th>
            <th style="width:120px; background-color: #5DACCD; color:#fff">Modificado</th>
            <th style="width:120px; background-color: #5DACCD; color:#fff">Estado</th>
            <!-- <th style="width:120px; background-color: #5DACCD; color:#fff">Propietario</th>  -->          
            <th style="width:60px; background-color: #5DACCD; color:#fff"></th>
            <th style="width:60px; background-color: #5DACCD; color:#fff"></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($this->model->Listar() as $r): ?>
        <tr>
            <td><?php echo $r->subject; ?></td>
            <td><?php echo $r->created; ?></td>
            <td><?php echo $r->modified; ?></td>
            <td><?php echo $r->status; ?></td>
            <td>
                <a  class="btn btn-warning" href="?c=encuesta&a=Crud&id=<?php echo $r->id; ?>">Editar</a>
            </td>
            <td>
                <a  class="btn btn-danger" onclick="return confirm('¿Seguro de eliminar este registro?');" href="?c=encuesta&a=Eliminar&id=<?php echo $r->id; ?>">Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table> 
