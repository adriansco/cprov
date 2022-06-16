<img src="assets/images/logo.png" alt="logo" class="logocentro">
<h1 class="page-header">Servicios</h1>

<a class="btn btn-primary pull-right" href="?c=servicio&a=Crud">Agregar</a>
<br><br><br>
<div class="table-responsive">
    <table class="table table-striped zero-configuration  table-hover" id="tabla">
        <thead>
            <tr>
                <th style="width:150px; background-color: #cd6155; color:#fff">Nombre</th>
                <th style="width:170px; background-color: #cd6155; color:#fff">Estado</th>
                <th style="width:50px; background-color: #cd6155; color:#fff"></th>
                <th style="width:50px; background-color: #cd6155; color:#fff"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($this->model->Listar($_SESSION['data']['ID']) as $r) : ?>
                <tr>
                    <td><?php echo $r->Servicio; ?></td>
                    <td><?php echo $r->Estado; ?></td>
                    <!-- BOTÓN EDITAR -->
                    <td>
                        <a class="btn btn-warning" href="?c=servicio&a=Crud&id=<?php echo $r->Edit; ?>">Editar</a>
                    </td>
                    <!-- BOTÓN ELIMINAR -->
                    <td>
                        <a class="btn btn-danger" onclick="return confirm('¿Seguro de eliminar este registro?');" href="?c=servicio&a=Eliminar&idservicio=<?php echo $r->ID; ?>&idunion=<?php echo $r->delunion; ?>">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>