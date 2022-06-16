<?php
require_once 'model/servicio.php';
require_once 'model/auth.php';

class servicioController{
    
    private $model;
    private $session;
    
    public function __CONSTRUCT(){
        $this->model = new servicio();
        $this->session = new auth();
        $this->session->init();
        if($this->session->getStatus() === 1 || empty($this->session->get('data')))
        header('Location: view/error/accessdenied.php');
    }
    
    public function Index(){
        require_once 'view/header.php';
        require_once 'view/servicio/servicio.php';
        require_once 'view/footer.php';
    }
    /* Recibe el id que se envia por url con el botón */
    public function Crud(){
        $servicio = new servicio();
        
        if(isset($_REQUEST['id'])){
            $servicio = $this->model->Obtener($_REQUEST['id']);
        }
        /* Arma Vista */
        require_once 'view/header.php';
        require_once 'view/servicio/servicio-editar.php';
        require_once 'view/footer.php';
    }
    
    public function Guardar(){
        $servicio = new servicio();
        $servicio->id = $_REQUEST['id'];
        $servicio->nombre = $_REQUEST['Nombre'];
        $servicio->status = $_REQUEST['status'];
        /* datos del usuario que ingreso al sistema */
        $fk_user = $_SESSION['data']['ID'];
        /* Si el id es mayor actualiza si no crea */
        $servicio->id > 0 
            ? $this->model->Actualizar($servicio)
            : $this->model->Registrar($servicio, $fk_user);
        /* Redirección a home */
        header('Location: ?c=servicio');
    }
    
    public function Eliminar(){
        $this->model->Eliminar($_REQUEST['idservicio'], $_REQUEST['idunion']);
        header('Location: ?c=servicio');
    }
}