<?php
class Database
{
    public static function StartUp()
    {
        $pdo = new PDO('mysql:host=localhost;dbname=vanaheim_mod;charset=utf8mb4','root','');
        /* $pdo = new PDO('mysql:host=impulsadoradigitaldenegocios.org;dbname=arsenweb_registro;charset=utf8mb4', 'arsenweb_admin', 'ssxezT4O]vhK'); */
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
}