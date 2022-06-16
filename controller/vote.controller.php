<?php
require_once 'model/vote.php';
date_default_timezone_set("America/Mexico_City");
require_once 'model/auth.php';

class voteController{
    
    private $model;
    private $dateOne;
    private $session;
    
    public function __CONSTRUCT(){
        $this->model = new vote();
        $this->dateOne = new DateTime();
        $this->session = new auth();
        $this->session->init();
        if($this->session->getStatus() === 1 || empty($this->session->get('data')))
        header('Location: view/error/accessdenied.php');
        /* exit; */
    }
    
    public function Index(){
        require_once 'view/header.php';
        require_once 'view/encuesta/vote.php';
        require_once 'view/footer.php';
    }
    
    public function Crud(){
        $vote = new vote();
        
        if(isset($_REQUEST['id'])){
            $vote = $this->model->Obtener($_REQUEST['id']);
        }
        /* Arma la vista */
        require_once 'view/header.php';
        require_once 'view/encuesta/vote-editar.php';
        require_once 'view/footer.php';
    }
    
    public function Guardar(){
        /* Recuperación de field opciones */
        $field_values_array = $_REQUEST['field_name'];
        /* Campos de la vote */
        $vote = new vote();
        $vote->id = $_REQUEST['id'];
        $vote->subject = $_REQUEST['subject'];
        $vote->created = $this->dateOne->format('Y-m-d H:i:s');
        $vote->modified = $this->dateOne->format('Y-m-d H:i:s');
        $vote->status = 1;
        /* Si el id es mayor actualiza si no crea */
        $vote->id > 0 
            ? $this->model->Actualizar($vote, $field_values_array)
            : $this->model->Registrar($vote, $field_values_array);
        /* Redirección a home */
        header('Location: view_survey.php');
    }
    
    public function Eliminar(){
        $this->model->Eliminar($_REQUEST['id']);
        header('Location: view_survey.php');
    }
}