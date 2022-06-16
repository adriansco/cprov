<?php

require_once 'model/auth.php';
/* require_once 'model/auth.php'; */

class authController
{
    private $model;
    private $session;
    public function __CONSTRUCT()
    {
        $this->model = new auth();
        $this->session = new auth();
    }

    public function Index()
    {
        /* require_once 'view/header.php'; */
        /* $this->session->init(); */
        if ($this->session->getStatus() === 1 || empty($this->session->get('data'))) {
            require_once 'view/auth/auth.php';
            require_once 'view/footer.php';
        } else {
            header('Location:?c=proveedor');
        }
    }
    /* Recibe el id que se envia por url con el botón */
    public function Validation()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            header("Content-Type: application/json");
            $array_devolver = [];
            $email = strtolower($_POST['email']);
            $password = $_POST['password'];

            // comprobar si el user existe 
            $count = $this->model->SearchUser($email);
            if ($count == 1) {
                // Existe
                $user = $this->model->Obtener($email);
                $user_id = (int) $user['iduser'];
                $hash = (string) $user['password'];
                /* Verificar contraseña */
                if (password_verify($password, $hash)) {
                    /* Guardamos los datos del usuario */
                    $aut_huser = array(
                        'ID' => $user['iduser'],
                        'Name' => $user['name'],
                        'Email' => $user['email'],
                        'privilege' => $user['privilege'],
                        'message' => ''
                    );
                    /* Iniciamos Sesión */
                    $this->model->init();
                    /* Agregamos el usuario a la sesión */
                    $this->model->add('data', $aut_huser);
                    /* Redireccionamos si todo esta bien */
                    if ($_SESSION['data']['privilege'] == 'ENCARGADO') {
                        $array_devolver['redirect'] = '?c=proveedor';/* '?c=proveedor&a=Crud'; *//* '?c=proveedor&a='; */
                    } else {
                        $array_devolver['redirect'] = '?c=proveedor';/* '?c=proveedor&a=Crud'; *//* '?c=proveedor&a='; */
                    }
                } else {
                    $array_devolver['error'] = "Los datos no son validos.";
                }
            } else {
                $array_devolver['error'] = "No tienes cuenta."; /* <a href='registro.php'>Nuevo cuenta</a> */
            }

            echo json_encode($array_devolver);
        } else {
            exit("Fuera de aquí");
        }
    }

    public function Kill()
    {
        $this->model->close();
        header('Location: index.php');
    }
}
