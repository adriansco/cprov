<?php
require_once 'model/importacion.php';
require_once 'model/proveedor.php';
require_once 'model/contenedor.php';
date_default_timezone_set("America/Mexico_City");
require_once 'model/auth.php';
require_once 'model/servicio.php';
class importacionController
{

    private $model;
    private $dateOne;
    private $session;
    private $servicio;

    public function __CONSTRUCT()
    {
        $this->model = new importacion();
        $this->proveedor = new proveedor();
        $this->contenedores = new contenedor();
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
        $proveedores = $this->proveedor->Listar();
        require_once 'view/header.php';
        require_once 'view/importacion/importacion.php';
        require_once 'view/footer.php';
    }
    /* Recibe el id que se envia por url con el botón */
    public function Crud()
    {
        /* $proveedor = new proveedor(); */

        if (isset($_REQUEST['id'])) {
            $proveedor = $this->proveedor->Obtener($_REQUEST['id']);
        } else {
            $proveedores = $this->proveedor->Listar();
            /* $containers = $this->contenedores->listar(); */
        }
        /* Arma Vista */
        require_once 'view/header.php';
        require_once 'view/importacion/importacion-editar.php';
        require_once 'view/footer.php';
    }

    /* Registrar Servicios por proveedor */
    /* public function AddService()
    {
        $proveedor = new proveedor();
        if (isset($_REQUEST['id'])) {
            $proveedor = $this->model->obtenerContenedores($_REQUEST['id']);
        }
        require_once 'view/header.php';
        require_once 'view/proveedor/proveedor-servicio.php';
        require_once 'view/footer.php';
    } */

    /* Muestra */
    public function fetchFiles()
    {
        $id = $_REQUEST['id'];

        if (isset($id)) {
            if ($id > 0) {
                $contenedor = $this->model->buscarContenedorId($id);
                /* Arma la vista */
                require_once 'view/header.php';
                require_once 'view/importacion/importacion-record-files.php';
                require_once 'view/footer.php';
            } else {
                $_SESSION['message'] = 'Ooopps!!' . $id;
                header('Location: ?c=importacion');
            }
        } else {
            $_SESSION['message'] = 'ERRORO FATAL!!';
            /* Arma Vista */
            require_once 'view/header.php';
            require_once 'view/importacion/importacion.php';
            require_once 'view/footer.php';
        }
    }

    public function fetchContenedores()
    {
        $id = $_REQUEST['id'];
        if (isset($id)) {
            if ($id > 0) {
                $proveedor = $this->proveedor->Obtener($id);
                /* Arma la vista */
                require_once 'view/header.php';
                require_once 'view/importacion/importacion-record.php';
                require_once 'view/footer.php';
            } else {
                header('Location: ?c=importacion');
            }
        } else {
            $_SESSION['message'] = 'ERRORO FATAL!!';
            /* Arma Vista */
            require_once 'view/header.php';
            require_once 'view/importacion/importacion.php';
            require_once 'view/footer.php';
        }
    }

    public function Guardar()
    {
        if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Guardar') {
            $id_proveedor = $_REQUEST['proveedor'];
            $container = $_REQUEST['container'];
            $create_at = $this->dateOne->format('Y-m-d H:i:s');
            $flag = $this->model->buscarContenedor($container);
            if ($flag->flag > 0) {
                /* existe */
                $message = 'Ya existe una carpeta con el nombre: ' . $container . ' verifique la inofrmación e intentelo nuevamente';
            } else {
                $id_contenedor = $this->model->guardarContenedor($id_proveedor, $container, $create_at);
                for ($y = 0; $y < 8; $y++) {
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
                    }
                    $message = $this->validarInput($file_arre, $id_proveedor, $y, $create_at, $id_contenedor);
                    if (!empty($message)) {
                        $_SESSION['message'] = $message;
                    }
                }
            }
        } else {
            echo ("Error");
            /* echo($_REQUEST['idagentis']); */
        }
        /* header('Location: index.php?c=proveedor&a=Record&id=' . $_REQUEST['idproveedor']); */
        /* header('Location: ?c=importacion&a=Record&id=' . $id_proveedor); */
        header('Location: ?c=importacion');
    }

    public function validarInput($file_arre, $id_proveedor, $y, $create_at, $id_contenedor)
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
                        $nombreArchivo = "Orden de compra";
                    } elseif ($y == 2) {
                        $nombreArchivo = "Pedimento";
                    } elseif ($y == 3) {
                        $nombreArchivo = "Factura";
                    } elseif ($y == 4) {
                        $nombreArchivo = "Cuenta de gastos";
                    } elseif ($y == 5) {
                        $nombreArchivo = "Entrada MP";
                    } elseif ($y == 6) {
                        $nombreArchivo = "Cartas";
                    } elseif ($y == 7) {
                        $nombreArchivo = $fileName;
                    }
                    /* Fin Cambiar Nombre */
                    if (in_array($fileExtension, $allowedfileExtensions)) {
                        // Estructura de la carpeta deseada
                        $estructura = './importaciones/' . $id_proveedor . '/';
                        $path = $estructura . $newFileName;
                        if (!file_exists($estructura)) {
                            if (!mkdir($estructura, 0777, true)) {
                                die('Fallo al crear las carpetas...');
                            } else {
                                $id_doc = $this->model->guardarArchivo($nombreArchivo, $path, $create_at);
                                $this->model->guardarImportacion($id_doc, $id_contenedor);
                                $dest_path = $estructura . $newFileName;
                            }
                        } else {
                            $id_doc = $this->model->guardarArchivo($nombreArchivo, $path, $create_at);
                            $this->model->guardarImportacion($id_doc, $id_contenedor);
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
            $ctrl_data = array("#" => $row->idproveedor, "Proveedor" => $row->name, "Carpeta" => $row->name_cont, "Creado en" => $row->date);
            $data[] = $ctrl_data;
        }
        // file name for download
        $filename = "reporte_importaciones_emv" . date('Ymd') . ".xls";
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

    public function guardarContenedor()
    {
        $name_container = $_POST['name-container'];
        $container   = trim($name_container, " \t\n\r\0\x0B"); //<--------OKAY
        $id_proveedor = $_POST['idproveedor'];
        $create_at = $this->dateOne->format('Y-m-d H:i:s');
        $flag = $this->model->buscarContenedor($container);

        if ($flag->flag > 0) {
            /* existe */
            $message = 'Ya existe una carpeta con el nombre: ' . $container . ' verifique la inofrmación e intentelo nuevamente';
            $data['status'] = '400';
            $data['msg'] = $message;
        } else {
            $id_contenedor = $this->model->guardarContenedor($id_proveedor, $container, $create_at);
            $message = 'Se crea carpeta: ' . $container . ' de manera exitosa';
            $data['status'] = '200';
            $data['msg'] = $message;
        }
        header('Content-type: application/json');
        echo json_encode($data);
    }

    public function upFile()
    {
        $files_post = $_FILES['file'];
        $nombreArchivo = $_POST['title'];
        $idproveedor = $_POST['idproveedor'];
        $id_contenedor = $_POST['idcontenedor'];
        $files = array();
        $file_count = count($files_post['name']);
        $file_keys = array_keys($files_post);
        /* Esto se puede optimizar, optiene fecha actual del sistema*/
        $create_at = $this->dateOne->format('Y-m-d H:i:s');

        for ($i = 0; $i < $file_count; $i++) {
            foreach ($file_keys as $key) {
                $files[$i][$key] = $files_post[$key][$i];
            }
        }

        foreach ($files as $fileID => $file) {
            $fileTmpPath = $file['tmp_name'];
            $ogName = $file['name'];
            $fileNameCmps = explode(".", $ogName);
            $fileExtension = strtolower(end($fileNameCmps));
            // sanitize file-name
            $newFileName = md5(time() . $nombreArchivo) . '.' . $fileExtension;
            // compruebe si el archivo tiene una de las siguientes extensiones
            $allowedfileExtensions = array('pdf');

            if (in_array($fileExtension, $allowedfileExtensions)) {
                // Estructura de la carpeta deseada
                $estructura = './importaciones/' . $idproveedor . '/';
                $path = $estructura . $newFileName;
                if (!file_exists($estructura)) {
                    if (!mkdir($estructura, 0777, true)) {
                        die('Fallo al crear las carpetas...');
                    } else {
                        $id_doc = $this->model->guardarArchivo($nombreArchivo, $path, $create_at);
                        $this->model->guardarImportacion($id_doc, $id_contenedor);
                        $dest_path = $estructura . $newFileName;
                    }
                } else {
                    $id_doc = $this->model->guardarArchivo($nombreArchivo, $path, $create_at);
                    $this->model->guardarImportacion($id_doc, $id_contenedor);
                    $dest_path = $estructura . $newFileName;
                }
                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $message = 'El archivo se agrego correctamente.';
                    $data['status'] = '200';
                    $data['msg'] = $message;
                } else {
                    $message = 'Hubo un error al mover el archivo al directorio de carga. <br>Asegúrese de que el servidor web pueda escribir en el directorio de carga.';
                    $data['status'] = '400';
                    $data['msg'] = $message;
                }
            } else {
                $message = 'Subida fallida. Tipos de archivo permitidos: ' . implode(',', $allowedfileExtensions);
                $data['status'] = '400';
                $data['msg'] = $message;
            }
        }
        header('Content-type: application/json');
        echo json_encode($data);
    }

    public function desFile()
    {
        $id = $_REQUEST['id'];
        /* Obtiene el id del registro en BD */
        $servicio = $this->servicio->obtenerServicio($id);
        $borrar = $servicio->Ruta;
        /*  */
        if (file_exists($borrar)) {
            /* Borrar el archivo del directrio */
            unlink($borrar);
            /* Borra registro de BD */
            if ($this->servicio->EliminarRecord($id)) {
                $message = 'Su archivo ha sido borrado.';
                $data['status'] = '200';
                $data['msg'] = $message;
            } else {
                $message = '¡Error fatal!, contacta ah EASuárez easuarez@vizcarra.com';
                $data['status'] = '400';
                $data['msg'] = $message;
            }
        } else {
            $message = '¡Error fatal!, contacta ah EASuárez easuarez@vizcarra.com';
            $data['status'] = '400';
            $data['msg'] = $message;
        }
        header('Content-type: application/json');
        echo json_encode($data);
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
                                $id_doc = $this->model->guardarArchivo($nombreArchivo, $path, $create_at);
                                /* $this->model->guardarImportacion($id_doc, $id_contenedor); */
                                $dest_path = $estructura . $newFileName;
                            }
                        } else {
                            $id_doc = $this->model->guardarArchivo($nombreArchivo, $path, $create_at);
                            /* $this->model->guardarImportacion($id_doc, $id_contenedor); */
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

    /* Ajax */
    public function fetchDocumentos()
    {
        /* $productos = obtenerProductos(); */
        $documentos = $this->model->fetchDocumentos();
        echo json_encode($documentos);
    }
}
