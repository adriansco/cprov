<?php
require_once 'model/clientecdmx.php';
date_default_timezone_set("America/Mexico_City");
require_once 'model/auth.php';
class clientecdmxController{
    
    private $model;
    private $dateOne;
    private $session;
    
    public function __CONSTRUCT(){
        $this->model = new clientecdmx();
        $this->dateOne = new DateTime();
        $this->session = new auth();
        $this->session->init();
        if($this->session->getStatus() === 1 || empty($this->session->get('data')))
        header('Location: view/error/accessdenied.php');
        /* exit(); */
        /* exit('¡¡Acceso denegado!!'); */
    }
    
    public function Index(){
        require_once 'view/header.php';
        require_once 'view/cliente/cliente.php';
        require_once 'view/footer.php';
    }
    /* Recibe el id que se envia por url con el botón */
    public function Crud(){
        $cliente = new clientecdmx();
        
        if(isset($_REQUEST['id'])){
            $cliente = $this->model->Obtener($_REQUEST['id']);
        }
        /* Arma Vista */
        require_once 'view/header.php';
        require_once 'view/cliente/clientecdmx-editar.php';
        require_once 'view/footer.php';
    }

    /* Registrar Servicios por cliente */
    public function AddService(){
        $cliente = new cliente();
        
        if(isset($_REQUEST['id'])){
            $cliente = $this->model->Obtener($_REQUEST['id']);
        }
        /* Arma Vista */
        require_once 'view/header.php';
        require_once 'view/cliente/cliente-servicio.php';
        require_once 'view/footer.php';
    }

    /* Muestra los servicios por cliente */
    public function Record(){
       $cliente = new cliente();
        if(isset($_REQUEST['id'])){
            /* Obtenemos los clientes y los servicios */
            $cliente = $this->model->Obtener($_REQUEST['id']);
            $cosa = $this->model->Servicios($_REQUEST['id']);
        }
        /* Arma la vista */
        require_once 'view/header.php';
        require_once 'view/cliente/cliente-record.php';
        require_once 'view/footer.php';
    }
    
    public function Guardar(){
        $cliente = new cliente();
        $cliente->id = $_REQUEST['id'];
        $cliente->nombre = $_REQUEST['Nombre'];
        $cliente->apellidos = $_REQUEST['apellidos'];
        $cliente->correo = $_REQUEST['Correo'];  
        $cliente->telefono = $_REQUEST['telefono'];
        $cliente->servicio = $_REQUEST['service'];
        /* Datepicker */
        $cliente->fnac = date('Y-m-d', strtotime($_POST['datepicker']));
        /* Formato para MailChimp */
        $cliente->birthday = date("m/d", strtotime($_POST['datepicker']));
        /* Esto se puede optimizar, optiene fecha actual del sistema */
        $create_at = $this->dateOne->format('Y-m-d H:i:s');
        /* Obtenemos el usuario logueado para que se guarde en el MailChimp correspondiente*/
        $api = $_SESSION['data']['API'];
        $list = $_SESSION['data']['LIST'];
        $id = $_SESSION['data']['ID'];
        /* Si el id es mayor actualiza si no crea */
        $cliente->id > 0
            ? $this->model->Actualizar($cliente)
            : $this->model->Registrar($cliente,$api,$list, $id, $create_at);
        /*Email de aviso al admin*/
        $this->enviarMail($cliente);
        /* Redirección a home */
        header('Location: index.php');
    }
    
    /* Agregar Servicio */
    public function GuardarServicio(){
        $id = $_REQUEST['id'];
        $idservice = $_POST['service'];
        $create_at = $this->dateOne->format('Y-m-d H:i:s');
        /* Si el id es mayor actualiza si no crea */
        $id > 0 
            ? $this->model->RegistrarServicio($id, $idservice, $create_at)/* $this->model->Actualizar($cliente) */
            : $this->model->Actualizar($cliente);
        /* Redirección a home */
        header('Location: ?c=cliente&a=Record&id='.$id);
    }

    /* Eliminar Cliente */
    public function Eliminar(){
        $this->model->Eliminar($_REQUEST['id']);
        header('Location: index.php');
    }

    /* Eliminar Servicio del cliente */
    public function EliminarRecord(){
        $this->model->EliminarRecord($_REQUEST['id']);
        header('Location: index.php');
    }
    /* Email de registro */
    public function enviarMail($cliente)
    {
        $to = "paranda@arsenweb.com.mx, desarrolloarsen@gmail.com";
        $subject = "Nuevo cliente en Sistema Registro ARSEN - SIRA 0.1";
        $message = "Nuevo usuario registrado:\n correo: ".$cliente->correo."\n Nombre: ".$cliente->nombre." ".$cliente->apellidos."\n Teléfono: ".'+52'.$cliente->telefono."\n Registrado por: ".$_SESSION['data']['Name'];
        mail($to, $subject, $message);
    }

    public function generarReporte()
    {
        /* VARIABLES */
        $name = $_POST['users'];
        //Buscar por nombre el usuario seleccionado
        $temusr = $this->model->obtenerUserId($name);
        $user = $this->model->obtenerUser($temusr->iduser);
        $create_at = $this->dateOne->format('Y-m-d H:i:s');
        // NOMBRE DEL ARCHIVO Y CHARSET
        header('Content-Type:text/csv; charset="utf-8"');
        header('Content-Disposition: attachment; filename="Reporte_'.$user->name.'_'.$create_at.'.csv"');
        // SALIDA DEL ARCHIVO
        $salida=fopen('php://output', 'w');
        // ENCABEZADOS
        fputcsv($salida, array('Nombre', 'Apellidos', 'Fecha de Nacimiento', 'Correo', 'Telefono'));
        // QUERY PARA CREAR EL REPORTE
        foreach($this->model->Listar($temusr->iduser) as $r):
            $newDate = date("Y/m/d", strtotime($r->fnac));
            fputcsv($salida, array($r->nombre, $r->apellidos,$newDate, $r->correo, $r->telefono));
        endforeach;
    }

    public function generarReportePremium()
    {
        /* Validación de la peticón */
        if(isset($_REQUEST['id'])){
            $id = $_REQUEST['id'];
        }
        /* VARIABLES */
        $create_at = $this->dateOne->format('Y-m-d H:i:s');
        // NOMBRE DEL ARCHIVO Y CHARSET
        header('Content-Type:text/csv; charset="utf-8"');
        header('Content-Disposition: attachment; filename="Reporte_Clientes'.'_'.$create_at.'.csv"');
        // SALIDA DEL ARCHIVO
        $salida=fopen('php://output', 'w');
        // ENCABEZADOS
        fputcsv($salida, array('Nombre', 'Apellidos', 'Fecha de Nacimiento', 'Correo', 'Telefono'));
        // QUERY PARA CREAR EL REPORTE
        foreach($this->model->Listar($id) as $r):
            $newDate = date("Y/m/d", strtotime($r->fnac));
            fputcsv($salida, array($r->nombre, $r->apellidos,$newDate, $r->correo, $r->telefono));
        endforeach;
    }
}