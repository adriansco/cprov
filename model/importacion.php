<?php
class importacion
{
    private $pdo;

    public $idproveedor;
    public $idagentis;
    public $nombre;
    public $correo;
    public $telefono;

    /* public $servicio; */

    public function __CONSTRUCT()
    {
        try {
            $this->pdo = Database::StartUp();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function fetchDocumentos()
    {
        try {
            $result = array();
            $stm = $this->pdo->prepare("SELECT
            proveedor.idproveedor,
            proveedor.nombre AS name,
            proveedor.`status` ,
            proveedor.created_at AS date
        FROM
            proveedor
            JOIN contenedor ON proveedor.idproveedor = contenedor.id_proveedor 
        WHERE
            proveedor.`status` = '1' 
        GROUP BY
            proveedor.nombre 
        ORDER BY
            proveedor.nombre ASC");
            $stm->execute(array());
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function genReport()
    {
        try {
            $stm = $this->pdo->prepare("SELECT
            contenedor.creado_en AS 'date',
            contenedor.nombre AS 'name_cont',
            proveedor.idproveedor,
            proveedor.nombre AS 'name'
        FROM
            contenedor
            JOIN proveedor ON proveedor.idproveedor = contenedor.id_proveedor
            WHERE proveedor.`status` = '1'");
            $stm->execute(array());
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /* IMPORTANTE Obtiene el registro */
    /* public function obtenerContenedores($id)
    {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM contenedor WHERE id_proveedor = ?");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    } */

    /* Servicios */
    public function fetchContainers($id)
    {
        try {
            $stm = $this->pdo->prepare("SELECT idcontenedor, nombre, creado_en, id_proveedor FROM contenedor WHERE contenedor.id_proveedor = ?");
            $stm->execute(array($id));
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function fetchFiles($id)
    {
        try {
            $stm = $this->pdo->prepare("SELECT
                documento_importacion.id_contenedor,
                documento.iddocumento,
                documento.nombre,
                documento.path,
                documento.creado 
            FROM
                `documento_importacion`
                JOIN documento ON documento_importacion.id_documento = documento.iddocumento 
            WHERE
                id_contenedor = ?");
            $stm->execute(array($id));
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Eliminar($id)
    {
        try {
            $stm = $this->pdo
                ->prepare("UPDATE proveedor
						SET `status` = '0'
						WHERE
						idproveedor = ?");
            $stm->execute(array($id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Actualizar($data, $updated_at)
    {
        try {
            $sql = "UPDATE proveedor SET
						nombre = ?,
                        correo = ?,
                        telefono = ?,
						updated_at = ?,
						idagentis = ?
				    WHERE idproveedor = ?";
            $this->pdo->prepare($sql)
                ->execute(
                    array(
                        $data->nombre,
                        $data->correo,
                        $data->telefono,
                        $updated_at,
                        $data->idagentis,
                        $data->id,
                    )
                );
            return $data->id;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function guardarContenedor($id_proveedor, $nombre, $creado_en)
    {
        try {
            $sql = "INSERT INTO contenedor (nombre,creado_en,id_proveedor)
		        VALUES (?, ?, ?)";
            $this->pdo->prepare($sql)
                ->execute(
                    array(
                        $nombre,
                        $creado_en,
                        $id_proveedor,
                    )
                );
            /* Último id que se inserto en tabla proveedor */
            $lastInsertId = $this->pdo->lastInsertId();
            return $lastInsertId;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    /* guardarArchivo */
    public function guardarArchivo($fileName, $path, $create_at)
    {
        try {
            $sql = "INSERT INTO documento(nombre,path,creado)
		        VALUES (?, ?, ?)";

            $this->pdo->prepare($sql)
                ->execute(
                    array(
                        $fileName,
                        $path,
                        $create_at,
                    )
                );
            /* Último id que se inserto en tabla documento */
            $lastInsertId = $this->pdo->lastInsertId();
            return $lastInsertId;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function guardarImportacion($id_documento, $id_contenedor)
    {
        try {
            $sql = "INSERT INTO documento_importacion(id_documento,id_contenedor)
		        VALUES (?, ?)";

            $this->pdo->prepare($sql)
                ->execute(
                    array(
                        $id_documento,
                        $id_contenedor,
                    )
                );
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function buscarContenedor($name)
    {
        /* SELECT COUNT(1) FROM contenedor WHERE id_proveedor = */
        try {
            $stm = $this->pdo->prepare("SELECT COUNT(1) AS flag FROM contenedor WHERE nombre = ?");
            $stm->execute(array($name));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function buscarContenedorId($id)
    {
        try {
            $stm = $this->pdo->prepare("SELECT idcontenedor,nombre,creado_en,id_proveedor FROM `contenedor` WHERE idcontenedor = ?");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
