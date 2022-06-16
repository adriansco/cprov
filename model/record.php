<?php
class record
{
	private $pdo;
    
    public $idrecord;
	public $fk_cliente;
	public $fk_service;

	public $Cliente;
	public $Servicio;

	public function __CONSTRUCT()
	{
		try
		{
			$this->pdo = Database::StartUp();     
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Listar()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM record");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}
	/* Obtiene el registro */
	public function Obtener($idrecord)
	{
		try 
		{
			$stm = $this->pdo->prepare("SELECT * FROM record WHERE idrecord = ?");
			$stm->execute(array($idrecord));
			return $stm->fetch(PDO::FETCH_OBJ);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Eliminar($idrecord)
	{
		try 
		{
			$stm = $this->pdo
			            ->prepare("DELETE FROM record WHERE idrecord = ?");			          

			$stm->execute(array($idrecord));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Actualizar($data)
	{
		try 
		{
			$sql = "UPDATE record SET
						fk_cliente          = ?,
						fk_service          = ?,						
				    WHERE idrecord = ?";

			$this->pdo->prepare($sql)
			     ->execute(
				    array(
						$data->fk_cliente,
						$data->fk_service,
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Registrar(record $data)
	{
		try 
		{
		$sql = "INSERT INTO record (fk_cliente,fk_service) 
		        VALUES (?, ?)";

		$this->pdo->prepare($sql)
		     ->execute(
				array(
					$data->fk_cliente,
					$data->fk_service,
                )
			);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
}