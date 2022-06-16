<?php
class proveedor
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
    /* Listar Por Usuario $id*/
    public function Listar()
    {
        try {
            $stm = $this->pdo->prepare("SELECT `idproveedor`,`idagentis`,`nombre`,`correo`, `telefono` FROM `proveedor` WHERE `status` = '1'");
            $stm->execute(array());
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function genReport()
    {
        try {
            $result = array();
                $stm = $this->pdo->prepare("SELECT
                    proveedor.idagentis,
                    proveedor.nombre,
                    proveedor.correo,
                    proveedor.telefono,
                    SUM( CASE WHEN ( documento.nombre ) = 'RFC' AND ( proveedor.idproveedor ) = ( documento_proveedor.id_proveedor ) THEN 1 ELSE 0 END ) AS RFC,
                    SUM( CASE WHEN ( documento.nombre ) = 'CSF' AND ( proveedor.idproveedor ) = ( documento_proveedor.id_proveedor ) THEN 1 ELSE 0 END ) AS CSF,
                    SUM( CASE WHEN ( documento.nombre ) = 'Opinión de cumplimiento positiva SAT' AND ( proveedor.idproveedor ) = ( documento_proveedor.id_proveedor ) THEN 1 ELSE 0 END ) AS Opinion_SAT,
                    SUM( CASE WHEN ( documento.nombre ) = 'Comprobante de domicilio' AND ( proveedor.idproveedor ) = ( documento_proveedor.id_proveedor ) THEN 1 ELSE 0 END ) AS Comp_domicilio,
                    SUM( CASE WHEN ( documento.nombre ) = 'Estado de cuenta' AND ( proveedor.idproveedor ) = ( documento_proveedor.id_proveedor ) THEN 1 ELSE 0 END ) AS Estado_cuenta,
                    SUM( CASE WHEN ( documento.nombre ) = 'Acta constitutiva' AND ( proveedor.idproveedor ) = ( documento_proveedor.id_proveedor ) THEN 1 ELSE 0 END ) AS Acta_const,
                    SUM( CASE WHEN ( documento.nombre ) = 'Poder RL' AND ( proveedor.idproveedor ) = ( documento_proveedor.id_proveedor ) THEN 1 ELSE 0 END ) AS Poder_RL,
                    SUM( CASE WHEN ( documento.nombre ) = 'Identificación oficial RL' AND ( proveedor.idproveedor ) = ( documento_proveedor.id_proveedor ) THEN 1 ELSE 0 END ) AS Ident_RL,
                    SUM( CASE WHEN ( documento.nombre ) = 'Contrato' AND ( proveedor.idproveedor ) = ( documento_proveedor.id_proveedor ) THEN 1 ELSE 0 END ) AS Contrato 
                FROM
                    documento_proveedor
                    JOIN proveedor
                    JOIN documento ON documento.iddocumento = documento_proveedor.id_documento 
                WHERE
                    proveedor.`status` = '1' 
                GROUP BY
                    proveedor.nombre");
            $stm->execute(array());
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /* Listar Admin */
    public function ListarAdmin()
    {
        try {
            $result = array();
            $stm = $this->pdo->prepare("SELECT *
			FROM
			proveedor;");
            $stm->execute(array());
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    /* Servicios */
    public function ListarServicios($id)
    {
        try {
            $result = array();
            $stm = $this->pdo->prepare("SELECT
			d.`nombre` AS Nombre,
			d.`path` AS Ruta
		FROM
			documento d
			INNER JOIN `proveedor` p ON d.fk_proveedor = p.idproveedor
		WHERE
			p.idproveedor = ?");
            $stm->execute(array($id));
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    /* Listar usuarios/empresas */
    public function ListarUsers()
    {
        try {
            $result = array();
            $stm = $this->pdo->prepare("SELECT
				`iduser`, `name`
			FROM
				`user`");
            $stm->execute(array());
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    /* Listar usuarios/empresas por id */
    public function ListarUsersId($id)
    {
        try {
            $result = array();
            $stm = $this->pdo->prepare("SELECT
				`iduser`, `name`
			FROM
				`user` WHERE `iduser` = ?");
            $stm->execute(array($id));
            /* return $stm->fetchAll(PDO::FETCH_OBJ); */
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    /* IMPORTANTE Obtiene el registro */
    public function Obtener($id)
    {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM proveedor WHERE idproveedor = ?");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /* Servicios */
    public function fetchDocuments($id)
    {
        try {
            $stm = $this->pdo->prepare("SELECT
                documento.iddocumento,
                documento_proveedor.id_proveedor,
                documento.nombre,
                documento.path,
                documento.creado 
            FROM
                `documento_proveedor`
                JOIN documento ON documento.iddocumento = documento_proveedor.id_documento 
            WHERE
                id_proveedor = ?");
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

    public function Registrar(proveedor $data, $create_at)
    {
        try {
            $sql = "INSERT INTO proveedor (nombre,correo,telefono,created_at, updated_at, idagentis)
		        VALUES (?, ?, ?, ?, ?, ?)";
            $this->pdo->prepare($sql)
                ->execute(
                    array(
                        $data->nombre,
                        $data->correo,
                        $data->telefono,
                        $create_at,
                        '1000-01-01 00:00:00',
                        $data->idagentis,
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

    public function guardarDocumentoProveedor($id_documento, $id_proveedor)
    {
        try {
            $sql = "INSERT INTO documento_proveedor(id_documento,id_proveedor)
		        VALUES (?, ?)";

            $this->pdo->prepare($sql)
                ->execute(
                    array(
                        $id_documento,
                        $id_proveedor,
                    )
                );
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function obtenerUser($id)
    {
        try {
            $stm = $this->pdo->prepare("SELECT `name` FROM `user` WHERE `iduser` = ?");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function obtenerUserId($name)
    {
        try {
            $stm = $this->pdo->prepare("SELECT `iduser`,`name` FROM `user` WHERE `name` = ?");
            $stm->execute(array($name));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
