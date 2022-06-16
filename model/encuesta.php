<?php
class encuesta
{
	private $pdo;
    
    public $id;
	public $subject;
	public $created;
    public $modified;
	public $status;
	public $id_final;

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

			$stm = $this->pdo->prepare("SELECT * FROM polls");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function ListarPropietarios()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM cliente");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Obtener($id)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("SELECT * FROM polls WHERE id = ?");
			          

			$stm->execute(array($id));
			return $stm->fetch(PDO::FETCH_OBJ);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Eliminar($id)
	{
		try 
		{
			$stm = $this->pdo
			            ->prepare("DELETE FROM polls WHERE id = ?");			          

			$stm->execute(array($id));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Actualizar(encuesta $data, array $field_values_array)
	{
		/* print '<pre>';
		foreach($field_values_array as $value){
            //your database query goes here
            print '<pre>';
            print_r('valor desde modelo actualizar => '.$value);
            print '<pre>';
		} */
		try 
		{
			$sql = "UPDATE polls SET
						subject = ?,
						modified = ?,
                        status = ?,
				    WHERE id = ?";

			$this->pdo->prepare($sql)
			     ->execute(
				    array(
						$data->subject,
						$data->modified,
                        $data->status, 
                        $data->id
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Registrar(encuesta $data, array $field_values_array)
	{
		//$lastid = $this->pdo->lastInsertId('polls');
		//print_r('VALOR OPTENIDO'.' = '.$lastid);
		$id_final = 0;
		foreach ($this->Listar() as $key) {
			# code...
			$key->id > $id_final
				? $id_final = $key->id
				: $id_final = $id_final;
			
			/* print '<pre>';
			print_r('LOS ID SON ==> '.$key->id);
			print '<pre>'; */
		}
		$id_final+= 1;
		/* print_r('EL FINAL ES ==> '.$id_final); */
		$max = sizeof($field_values_array);
		# code...
		try 
		{
			$sql = "INSERT INTO polls (id,subject,created,modified,status) 
		        VALUES (?, ?, ?, ?, ?)";
			$this->pdo->prepare($sql)
		     ->execute(
				array(
					$id_final,
					$data->subject,
					$data->created,
                    $data->modified, 
					$data->status,
                )
			);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
		
		try {
			$stmt = $this->pdo->prepare("INSERT INTO poll_options ( poll_id, name, created, modified, status) VALUES (?,?,?,?,?)");
			
			$this->pdo->beginTransaction();
			for ($i=0; $i < $max; $i++)
			{
				$stmt->execute(
					array(
						$id_final,
						$field_values_array[$i],
						$data->created, 
						$data->modified,
						1
					)
				);
			}
			$this->pdo->commit();
		}catch (Exception $e){
			$this->pdo->rollback();
			throw $e;
		}
	} 
}