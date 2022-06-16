<?php

class auth
{
	private $pdo;
    
    public $iduser;
	public $name;
	public $alias;
	public $password;
    public $email;
	public $corp;

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
	/* Valida que el usuario exista a nivel BD */
	public function Auth($email, $password)
	{
		try 
		{
			$result = array();
			$stm = $this->pdo
			            ->prepare("SELECT * FROM `user` WHERE `email` = ? AND `password` = ? LIMIT 1");
			$stm->execute(array($email,$password));
			return $stm->fetch(PDO::FETCH_OBJ);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function SearchUser($email)
	{
		try 
		{
			/* $result = array(); */
			$stm = $this->pdo
						->prepare("SELECT * FROM user WHERE alias = '$email' LIMIT 1");
						$stm->bindParam(':alias', $email, PDO::PARAM_STR);
						$stm->execute();
						return $stm->rowCount();
			/* return $stm->fetch(PDO::FETCH_OBJ); */
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	/* Obtiene el registro */
	public function Obtener($email)
	{
		try
		{
			$stm = $this->pdo->prepare("SELECT * FROM user WHERE alias = ?");
			$stm->execute(array($email));
			return $stm->fetch(PDO::FETCH_ASSOC);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	/**
   	* Inicializa la sesión
   	*/
  	public function init()
  	{
    	session_start();
  	}

  	/**
   	* Agrega un elemento a la sesión
   	* @param string $key la llave del array de sesión
   	* @param string $value el valor para el elemento de la sesión
   	*/
  	public function add($key, $value)
  	{
    	$_SESSION[$key] = $value;
  	}

	/**
	 * Retorna un elemento a la sesión
	 * @param string $key la llave del array de sesión
	 * @return string el valor del array de sesión si tiene valor
	 */
	public function get($key)
	{
		return !empty($_SESSION[$key]) ? $_SESSION[$key] : null;
	}

	/**
	 * Retorna todos los valores del array de sesión
	 * @return el array de sesión completo
	 */
	public function getAll()
	{
		return $_SESSION;
	}

	/**
	 * Remueve un elemento de la sesión
	 * @param string $key la llave del array de sesión
	 */
	public function remove($key)
	{
		if(!empty($_SESSION[$key]))
		unset($_SESSION[$key]);
	}

	/**
	 * Cierra la sesión eliminando los valores
	 */
	public function close()
	{
		$this->init();
		session_unset();
		session_destroy();
	}

	/**
	 * Retorna el estatus de la sesión
	 * @return string el estatus de la sesión
	 */
	public function getStatus()
	{
		return session_status();
	}

}