<?php
class contenedor
{
    private $pdo;

    public $idcontenedor;
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
    public function listar()
    {
        try {
            $result = array();
            $stm = $this->pdo->prepare("SELECT `idcontenedor`,`idagentis`,`nombre`,`correo`, `telefono` FROM `contenedor` WHERE `status` = '1'");
            $stm->execute(array());
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
