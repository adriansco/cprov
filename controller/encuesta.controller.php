<?php
require_once 'model/encuesta.php';
date_default_timezone_set("America/Mexico_City");
require_once 'model/auth.php';

class encuestaController{
    
    private $model;
    private $dateOne;
    private $session;
    
    public function __CONSTRUCT(){
        $this->model = new encuesta();
        $this->dateOne = new DateTime();
        $this->session = new auth();
        $this->session->init();
        if($this->session->getStatus() === 1 || empty($this->session->get('data')))
        header('Location: view/error/accessdenied.php');
        /* exit; */
    }
    
    public function Index(){
        require_once 'view/header.php';
        require_once 'view/encuesta/encuesta.php';
        require_once 'view/footer.php';
    }
    
    public function Crud(){
        $encuesta = new encuesta();
        
        if(isset($_REQUEST['id'])){
            $encuesta = $this->model->Obtener($_REQUEST['id']);
        }
        /* Arma la vista */
        require_once 'view/header.php';
        require_once 'view/encuesta/encuesta-editar.php';
        require_once 'view/footer.php';
    }
    
    public function Guardar(){
        /* Recuperación de field opciones */
        $field_values_array = $_REQUEST['field_name'];
        /* Campos de la encuesta */
        $encuesta = new encuesta();
        $encuesta->id = $_REQUEST['id'];
        $encuesta->subject = $_REQUEST['subject'];
        $encuesta->created = $this->dateOne->format('Y-m-d H:i:s');
        $encuesta->modified = $this->dateOne->format('Y-m-d H:i:s');
        $encuesta->status = 1;
        /* Si el id es mayor actualiza si no crea */
        $encuesta->id > 0 
            ? $this->model->Actualizar($encuesta, $field_values_array)
            : $this->model->Registrar($encuesta, $field_values_array);
        /* Redirección a home */
        header('Location: view_survey.php');
    }
    
    public function Eliminar(){
        $this->model->Eliminar($_REQUEST['id']);
        header('Location: view_survey.php');
    }
}