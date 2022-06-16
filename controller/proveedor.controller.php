<?php
require_once 'model/proveedor.php';
date_default_timezone_set("America/Mexico_City");
require_once 'model/auth.php';
require_once 'model/servicio.php';
class proveedorController
{

    private $model;
    private $dateOne;
    private $session;
    private $servicio;

    public function __CONSTRUCT()
    {
        $this->model = new proveedor();
        $this->servicio = new servicio();
        $this->dateOne = new DateTime();
        $this->session = new auth();
        $this->session->init();
        if ($this->session->getStatus() === 1 || empty($this->session->get('data'))) {
            header('Location: view/error/accessdenied.php');
        }
    }

    public function Index()
    {
        require_once 'view/header.php';
        require_once 'view/proveedor/proveedor.php';
        require_once 'view/footer.php';
    }
    /* Recibe el id que se envia por url con el botón */
    public function Crud()
    {
        $proveedor = new proveedor();

        if (isset($_REQUEST['id'])) {
            $proveedor = $this->model->Obtener($_REQUEST['id']);
        }
        /* Arma Vista */
        require_once 'view/header.php';
        require_once 'view/proveedor/proveedor-editar.php';
        require_once 'view/footer.php';
    }

    /* Registrar Servicios por proveedor */
    public function AddService()
    {
        $proveedor = new proveedor();
        if (isset($_REQUEST['id'])) {
            $proveedor = $this->model->Obtener($_REQUEST['id']);
        }
        /* Arma Vista */
        require_once 'view/header.php';
        require_once 'view/proveedor/proveedor-servicio.php';
        require_once 'view/footer.php';
    }

    /* Muestra los servicios por proveedor */
    public function Record()
    {
        /* $proveedor = new proveedor(); */
        if (isset($_REQUEST['id'])) {
            /* Obtenemos los proveedores y los servicios */
            $proveedor = $this->model->Obtener($_REQUEST['id']);
            $documentos = $this->model->fetchDocuments($_REQUEST['id']);
        }
        /* Arma la vista */
        require_once 'view/header.php';
        require_once 'view/proveedor/proveedor-record.php';
        require_once 'view/footer.php';
    }

    public function Guardar()
    {
        if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Guardar') {
            $proveedor = new proveedor();
            $proveedor->id = $_REQUEST['id'];
            $proveedor->nombre = $_REQUEST['nombre'];
            $proveedor->idagentis = $_REQUEST['idagentis'];
            /* var_dump($_REQUEST['idagentis']); */
            $proveedor->correo = $_REQUEST['correo'];
            $proveedor->telefono = $_REQUEST['telefono'];
            /* Esto se puede optimizar, optiene fecha actual del sistema*/
            $create_at = $this->dateOne->format('Y-m-d H:i:s');
            /* Si el id es mayor actualiza si no crea ? cierto : falso*/
            $proveedor->id > 0
                ? $lastInsertId = $this->model->Actualizar($proveedor, $create_at)
                : $lastInsertId = $this->model->Registrar($proveedor, $create_at);

            for ($y = 0; $y < 11; $y++) {
                $file_arre = array();
                /* Recorrer cada input uploadedFile 1 ... n*/
                if ($y == 0) {
                    $inputId = 'uploadedFile';
                } elseif ($y == 1) {
                    /* No hacer nada :v */
                    $y++;
                    $inputId = 'uploadedFile' . $y;
                } else {
                    $inputId = 'uploadedFile' . $y;
                }
                $file_ary = $_FILES[$inputId];
                $file_count = count($_FILES[$inputId]['name']);
                $file_keys = array_keys($_FILES[$inputId]);

                for ($i = 0; $i < $file_count; $i++) {
                    foreach ($file_keys as $key) {
                        /* Generar arreglo comprensible para la función guardarDocumento()  */
                        $file_arre[$i][$key] = $file_ary[$key][$i];
                    }
                    /* if (!empty($file_arre[$i]["name"])) {
                print('NO SE HACE EL LLMADO :d<br>');
                } else {
                print('NO SE HACE EL LLMADO :d<br>');
                } */
                }
                $message = $this->validarInput($file_arre, $lastInsertId, $y, $create_at);
                /* var_dump(empty($message)); */
                if (!empty($message)) {
                    $_SESSION['message'] = $message;
                }
            }
            /* echo('<hr><br>'.$_SESSION['message']); */
            /* Redirección a home (capturar error) */
            header('Location: index.php');
        } else {
            echo ("Error");
            /* echo($_REQUEST['idagentis']); */
        }
    }

    public function validarInput($file_arre, $lastInsertId, $y, $create_at)
    {
        $nombreArchivo = '';
        $longitud = count($file_arre);
        /* Begin Method */
        if (!empty($file_arre)) {
            $message = '';
            for ($i = 0; $i < $longitud; $i++) {
                if ($file_arre[$i]['error'] === UPLOAD_ERR_OK) {
                    // obtener detalles del archivo cargado
                    $fileTmpPath = $file_arre[$i]['tmp_name'];
                    $fileName = $file_arre[$i]['name'];
                    $fileSize = $file_arre[$i]['size'];
                    $fileType = $file_arre[$i]['type'];
                    $fileNameCmps = explode(".", $fileName);
                    $fileExtension = strtolower(end($fileNameCmps));
                    // sanitize file-name
                    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                    // compruebe si el archivo tiene una de las siguientes extensiones
                    $allowedfileExtensions = array('pdf');
                    /* Inicio Cambiar Nombre */
                    if ($y == 0) {
                        $nombreArchivo = "RFC";
                    } elseif ($y == 2) {
                        $nombreArchivo = "CSF";
                    } elseif ($y == 3) {
                        $nombreArchivo = "Opinión de cumplimiento positiva SAT";
                    } elseif ($y == 4) {
                        $nombreArchivo = "Comprobante de domicilio";
                    } elseif ($y == 5) {
                        $nombreArchivo = "Estado de cuenta";
                    } elseif ($y == 6) {
                        $nombreArchivo = "Acta constitutiva";
                    } elseif ($y == 7) {
                        $nombreArchivo = "Poder RL";
                    } elseif ($y == 8) {
                        $nombreArchivo = "Identificación oficial RL";
                    } elseif ($y == 9) {
                        $nombreArchivo = "Contrato";
                    } elseif ($y == 10) {
                        $nombreArchivo = $fileName;
                    }
                    /* Fin Cambiar Nombre */
                    if (in_array($fileExtension, $allowedfileExtensions)) {
                        // Estructura de la carpeta deseada
                        $estructura = './proveedores/' . $lastInsertId . '/';
                        $path = $estructura . $newFileName;
                        if (!file_exists($estructura)) {
                            if (!mkdir($estructura, 0777, true)) {
                                die('Fallo al crear las carpetas...');
                            } else {
                                $id_doc = $this->model->guardarArchivo($nombreArchivo, $path, $create_at);
                                $this->model->guardarDocumentoProveedor($id_doc, $lastInsertId);
                                $dest_path = $estructura . $newFileName;
                            }
                        } else {
                            $id_doc = $this->model->guardarArchivo($nombreArchivo, $path, $create_at);
                            $this->model->guardarDocumentoProveedor($id_doc, $lastInsertId);
                            $dest_path = $estructura . $newFileName;
                        }
                        if (move_uploaded_file($fileTmpPath, $dest_path)) {
                            $message = 'El archivo se cargó correctamente.';
                        } else {
                            $message = 'Hubo algún error al mover el archivo al directorio de carga. <br>Asegúrese de que el servidor web pueda escribir en el directorio de carga.';
                        }
                    } else {
                        $message = 'Subida fallida. Tipos de archivo permitidos: ' . implode(',', $allowedfileExtensions);
                    }
                }
            }
        } else {
            $message = 'Debes seleccionar por lo menos un archivo.<br>';
        }
        /* End Method */
        return $message;
    }

    /* Eliminar proveedor */
    public function Eliminar()
    {
        $this->model->Eliminar($_REQUEST['id']);
        header('Location: index.php');
    }

    /* Eliminar Servicio del proveedor */
    public function EliminarRecord()
    {
        /* Obtiene el id del registro en BD */
        $servicio = $this->servicio->obtenerServicio($_REQUEST['id']);
        $borrar = $servicio->Ruta;
        /* Borrar el archivo del directrio */
        unlink($borrar);
        /* Borra registro de BD */
        $this->servicio->EliminarRecord($_REQUEST['id']);
        header('Location: index.php?c=proveedor&a=Record&id=' . $_REQUEST['idproveedor']);
    }
    /* Email de registro */
    public function enviarMail($proveedor)
    {
        $to = "easuarez@vizcarra.com, easuarez@vizcarra.com";
        $subject = "Nuevo proveedor en Sistema Registro Proveedores - SIVI 0.1";
        $message = "Nuevo usuario registrado:\n correo: " . $proveedor->correo . "\n Nombre: " . $proveedor->nombre . " " . $proveedor->apellidos . "\n Teléfono: " . '+52' . $proveedor->telefono . "\n Registrado por: " . $_SESSION['data']['Name'];
        mail($to, $subject, $message);
    }

    public function generarReporte()
    {
        foreach ($this->model->genReport() as $row) {
            $ctrl_data = array("ID Agentis" => $row->idagentis, "Nombre" => $row->nombre, "Correo" => $row->correo, "Telefono" => $row->telefono, "RFC" => $row->RFC, "CSF" => $row->CSF, "Opinion de Cumplimiento Positiva SAT" => $row->Opinion_SAT, "Comprobante de Domicilio" => $row->Comp_domicilio, "Estado de Cuenta" => $row->Estado_cuenta, "Acta Constitutiva" => $row->Acta_const, "Poder RL" => $row->Poder_RL, "Identificacion Oficial RL" => $row->Ident_RL, "Contrato" => $row->Contrato);
            $data[] = $ctrl_data;
        }
        // file name for download
        $filename = "reporte_proveedores_emv" . date('Ymd') . ".xls";
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel");
        $flag = false;
        foreach ($data as $row) {
            if (!$flag) {
                // display field/column names as first row
                echo implode("\t", array_keys($row)) . "\n";
                $flag = true;
            }
            /* array_walk($row, __NAMESPACE__ . '\cleanData'); */
            echo implode("\t", array_values($row)) . "\n";
        }
        exit;
    }

    /* public function generarReporte()
    {
    //VARIABLES
    $name = $_POST['users'];
    //Buscar por nombre el usuario seleccionado
    $temusr = $this->model->obtenerUserId($name);
    $user = $this->model->obtenerUser($temusr->iduser);
    $create_at = $this->dateOne->format('Y-m-d H:i:s');
    // NOMBRE DEL ARCHIVO Y CHARSET
    header('Content-Type:text/csv; charset="utf-8"');
    header('Content-Disposition: attachment; filename="Reporte_' . $user->name . '_' . $create_at . '.csv"');
    // SALIDA DEL ARCHIVO
    $salida = fopen('php://output', 'w');
    // ENCABEZADOS
    fputcsv($salida, array('Nombre', 'Apellidos', 'Fecha de Nacimiento', 'Correo', 'Telefono'));
    // QUERY PARA CREAR EL REPORTE
    foreach ($this->model->Listar($temusr->iduser) as $r) :
    $newDate = date("Y/m/d", strtotime($r->fnac));
    fputcsv($salida, array($r->nombre, $r->apellidos, $newDate, $r->correo, $r->telefono));
    endforeach;
    } */

    public function generarReportePremium()
    {
        /* Validación de la peticón */
        if (isset($_REQUEST['id'])) {
            $id = $_REQUEST['id'];
        }
        /* VARIABLES */
        $create_at = $this->dateOne->format('Y-m-d H:i:s');
        // NOMBRE DEL ARCHIVO Y CHARSET
        header('Content-Type:text/csv; charset="utf-8"');
        header('Content-Disposition: attachment; filename="Reporte_Clientes' . '_' . $create_at . '.csv"');
        // SALIDA DEL ARCHIVO
        $salida = fopen('php://output', 'w');
        // ENCABEZADOS
        fputcsv($salida, array('Nombre', 'Apellidos', 'Fecha de Nacimiento', 'Correo', 'Telefono'));
        // QUERY PARA CREAR EL REPORTE
        foreach ($this->model->Listar($id) as $r) :
            $newDate = date("Y/m/d", strtotime($r->fnac));
            fputcsv($salida, array($r->nombre, $r->apellidos, $newDate, $r->correo, $r->telefono));
        endforeach;
    }
    /* Guardar Archivos */
    public function guardarDocumento()
    {
        /*  */
        $message = '';
        $idproveedor = $_POST["id"];
        $nombre = $_POST["nombrearchivo"];
        $create_at = $this->dateOne->format('Y-m-d H:i:s');
        /* Validación de campos */
        $variable = array($_FILES['doc_path']);
        $cont = count($variable[0]["name"]);
        /* Begin Method */
        if (!empty($variable)) {
            for ($i = 0; $i < $cont; $i++) {
                if ($variable[0]['error'][$i] === UPLOAD_ERR_OK) {
                    // obtener detalles del archivo cargado
                    $fileTmpPath = $variable[0]['tmp_name'][$i];
                    $fileName = $variable[0]["name"][$i];
                    /* $fileSize = $variable[0]['size'][$i];
                    $fileType = $variable[0]['type'][$i]; */
                    $fileNameCmps = explode(".", $fileName);
                    $fileExtension = strtolower(end($fileNameCmps));
                    // sanitize file-name
                    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                    // compruebe si el archivo tiene una de las siguientes extensiones
                    $allowedfileExtensions = array('pdf');
                    /* Nombre del archivo */
                    $nombreArchivo = $_POST["doc_nombre"][$i];
                    if (in_array($fileExtension, $allowedfileExtensions)) {
                        // Estructura de la carpeta deseada
                        $estructura = './proveedores/' . $idproveedor . '/';
                        $path = $estructura . $newFileName;
                        if (!file_exists($estructura)) {
                            if (!mkdir($estructura, 0777, true)) {
                                die('Fallo al crear las carpetas...');
                            } else {
                                $this->model->guardarArchivo($idproveedor, $nombreArchivo, $path, $create_at);
                                $dest_path = $estructura . $newFileName;
                            }
                        } else {
                            $this->model->guardarArchivo($idproveedor, $nombreArchivo, $path, $create_at);
                            $dest_path = $estructura . $newFileName;
                        }

                        if (move_uploaded_file($fileTmpPath, $dest_path)) {
                            $message = 'El archivo se cargó correctamente.';
                        } else {
                            $message = 'Hubo algún error al mover el archivo al directorio de carga. <br>Asegúrese de que el servidor web pueda escribir en el directorio de carga.';
                        }
                    } else {
                        $message = 'Subida fallida. Tipos de archivo permitidos: ' . implode(',', $allowedfileExtensions);
                    }
                }
            }
        } else {
            $message = 'Debes seleccionar por lo menos un archivo.<br>';
        }
        /* End Method */
        $_SESSION['message'] = $message;
        header('Location: index.php');
    }
}
