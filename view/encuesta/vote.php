<h1 class="page-header">Responder</h1>


    <a class="btn btn-primary pull-right" href="?c=encuesta&a=Crud">Agregar</a>
<br><br><br>


<div class="lista">
    <?php $cosa = $this->model->ListarPreguntas(5)?>
        <?php foreach($this->model->ListarPreguntas(5) as $cosa){ ?>
        <?php echo '<h3>'.$cosa->subject.'</h3>'?>
                <?php foreach($this->model->Listar($cosa->id) as $opt){
                    /* echo '<br>'.$opt->name.'<br>';
                    echo '<input type="radio" name="'.$cosa->id.'voteOpt" value="'.$opt->id.'">'; */
                    echo '<span class="fa-stack">
                      <input type="radio" name="option" id="check'.$opt->id.'" />
                      <label for="check'.$opt->id.'" class="opciones">'.$opt->name.'
                      <br/><i class="caja fa fa-square-o fa-stack-1x"></i>
                          <i class="fa fa-check fa-stack-1x"></i>
                      </label>
                    </span>';
                }?>
    <?php } ?>
</div>

<br><br><br>