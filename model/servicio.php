<?php
class servicio
{
	private $pdo;

	public $iddocumento;
	public $nombre;
	public $path;

	public function __CONSTRUCT()
	{
		try {
			$this->pdo = Database::StartUp();
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

	public function Listar($id)
	{
		try {
			$result = array();
			/* $stm = $this->pdo->prepare("SELECT * FROM services"); */
			$stm = $this->pdo->prepare("SELECT
			r.idservicio AS ID,
			r.nombre AS Servicio,
			r.`status` AS Estado,
			r.idservicio As Edit,
			c.idunion AS delunion
			FROM
				`union` c
			INNER JOIN `user` p ON c.fk_user = p.iduser
			INNER JOIN services r ON r.idservicio = c.fk_service
			WHERE
			p.iduser = ? AND r.`status` = '1'");
			$stm->execute(array($id));
			return $stm->fetchAll(PDO::FETCH_OBJ);
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}
	/* Obtiene el registro */
	public function Obtener($id)
	{
		try {
			$stm = $this->pdo->prepare("SELECT * FROM services WHERE idservicio = ?");
			$stm->execute(array($id));
			return $stm->fetch(PDO::FETCH_OBJ);
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}
	/* Servicios */
	public function obtenerServicio($id)
	{
		try {
			$stm = $this->pdo->prepare("SELECT
			`nombre` AS Nombre,
			`path` AS Ruta,
			`iddocumento` AS ID 
			FROM
				documento
			WHERE
				iddocumento = ?");
			$stm->execute(array($id));
			/* un VALOR no TODOS fetch*/
			return $stm->fetch(PDO::FETCH_OBJ);
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

	/* Borara Documento */
	public function EliminarRecord($id)
	{
		try {
			$stm = $this->pdo
				->prepare("DELETE FROM documento WHERE iddocumento = ?");
			$stm->execute(array($id));
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

	/* Borrado lógico */
	public function Eliminar($idservicio, $idunion)
	{
		try {
			$stm = $this->pdo
				->prepare("UPDATE services
						SET `status` = '0'
						WHERE
							idservicio = ?");
			$stm->execute(array($idservicio));
			/* Eliminamos union */
			$this->EliminarUnion($idunion);
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}
	/* Borrado fisico de la union*/
	public function EliminarUnion($id)
	{
		try {
			$stm = $this->pdo
				->prepare("DELETE FROM `union` WHERE idunion = ?");

			$stm->execute(array($id));
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

	public function Actualizar($data)
	{
		try {
			$sql = "UPDATE services
			SET nombre = ?, `status` = ?
			WHERE
				idservicio = ?";

			$this->pdo->prepare($sql)
				->execute(
					array(
						$data->nombre,
						$data->status,
						$data->id
					)
				);
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

	public function Registrar(servicio $data, $fk_user)
	{
		try {
			$sql = "INSERT INTO services (nombre,status) 
		        VALUES (?, ?)";

			$this->pdo->prepare($sql)
				->execute(
					array(
						$data->nombre,
						$data->status
					)
				);
			/* Último id que se inserto en tabla cliente */
			$lastInsertId = $this->pdo->lastInsertId();
			/* Validar servició, por quello de los servicios nulos :B */
			if (isset($fk_user)) {
				/* Si se eligio servicio se agrega */
				$this->RegistrarUnion($fk_user, $lastInsertId);
			}
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

	public function RegistrarUnion($fk_user, $lastInsertId)
	{
		try {
			$sql = "INSERT INTO `union` (fk_user, fk_service) 
		        VALUES (?, ?)";

			$this->pdo->prepare($sql)
				->execute(
					array(
						$fk_user,
						$lastInsertId
					)
				);
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}
}
