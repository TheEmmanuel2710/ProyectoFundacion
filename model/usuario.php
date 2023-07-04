<?php

namespace Modelo;

use PDO;
use PDOException;

include_once "conexion.php";

class Usuario
{
    private $id;
    private $correo;
    private $password;
    public $con;

    public function __construct()
    {
        $this->con = new \Conexion;
    }
    public function login()
    {
        try {
            $sql = $this->con->getCon()->prepare("SELECT * FROM usuarios WHERE correo=? AND password=?");
            $sql->bindParam(1, $this->correo);
            $sql->bindParam(2, $this->password);
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            return "Error:" . $e->getMessage();
        }
    }
    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }


    /**
     * Get the value of correo
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set the value of correo
     */
    public function     setCorreo($correo): self
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     */
    public function setPassword($password): self
    {
        $this->password = $password;

        return $this;
    }
}
