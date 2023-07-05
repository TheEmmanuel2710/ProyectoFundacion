<?php

namespace Modelo;

use PDO;
use PDOException;

include_once "conexion.php";

class Evento
{
    private $id;
    private $titulo;
    private $descripcion;
    private $anexo;
    public $con;

    public function __construct()
    {
        $this->con = new \Conexion();
    }

    public function create()
    {
        try {
            $request = $this->con->getCon()->prepare("INSERT INTO eventos(notiTitulo,notiDescripcion,notiAnexo) VALUES(:titulo,:descripcion,:anexo)");
            $request->bindParam(':titulo', $this->titulo);
            $request->bindParam(':descripcion', $this->descripcion);
            $request->bindParam(':anexo', $this->anexo);
            // Subir el archivo al servidor
            $uploadPath = "../media/";
            $uploadedFile = $_FILES['fileAnexo']['name'];
            $tempName = $_FILES['fileAnexo']['tmp_name'];

            if (!empty($uploadedFile)) {
                $anexoPath = $uploadPath . $uploadedFile;
                move_uploaded_file($tempName, $anexoPath);
                $this->setAnexo($uploadedFile); // Asignar el nombre del archivo a la propiedad 'anexo'
            }
            $request->execute();
            return "Evento creado de manera exitosa";
        } catch (PDOException $e) {
            return "Error: al crear el evento" . $e->getMessage();
        }
    }


    public function read()
    {
        try {
            $request = $this->con->getCon()->prepare("SELECT * FROM  eventos");
            $request->execute();
            $result = $request->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            return "Error: al consultar evento" . $e->getMessage();
        }
    }


    public function readOne($id)
    {
        try {
            $request = $this->con->getCon()->prepare("SELECT * FROM eventos WHERE id = :id");
            $request->bindParam(":id", $id);
            $request->execute();
            $result = $request->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            return "Error al consultar evento " . $e->getMessage();
        }
    }
    
    public function update()
    {
        try {
            $request = $this->con->getCon()->prepare("UPDATE eventos SET notiTitulo=?, notiDescripcion=?, notiAnexo=? WHERE id=?");
            $request->bindParam(1, $this->titulo);
            $request->bindParam(2, $this->descripcion);
            $request->bindParam(3, $this->anexo);
            $request->bindParam(4, $this->id);
            $request->execute();
            return "Evento modificado";
        } catch (PDOException $e) {
            return "Error al actualizar el evento" . $e->getMessage();
        }
    }

    public function delete()
    {
        try {
            $request = $this->con->getCon()->prepare("SELECT notiAnexo FROM eventos WHERE id = ?");
            $request->bindParam(1, $this->id);
            $request->execute();
            $result = $request->fetch(PDO::FETCH_ASSOC);
            $anexoPath = $result['notiAnexo'];

            // Ruta completa de la carpeta "media"
            $mediaPath = "../media/";

            // Eliminar el archivo de la carpeta "media"
            if (file_exists($mediaPath . $anexoPath)) {
                unlink($mediaPath . $anexoPath);
            }

            $request = $this->con->getCon()->prepare("DELETE FROM eventos WHERE id = ?");
            $request->bindParam(1, $this->id);
            $request->execute();
            return "Evento eliminado de manera exitosa";
        } catch (PDOException $e) {
            return "Error al eliminar el evento: " . $e->getMessage();
        }
    }


    /**
     * Get the value of titulo
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set the value of titulo
     */
    public function setTitulo($titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get the value of descripcion
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     */
    public function setDescripcion($descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get the value of anexo
     */
    public function getAnexo()
    {
        return $this->anexo;
    }

    /**
     * Set the value of anexo
     */
    public function setAnexo($anexo): self
    {
        $this->anexo = $anexo;

        return $this;
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
}
