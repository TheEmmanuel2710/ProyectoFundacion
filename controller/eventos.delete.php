<?php
include_once '../model/evento.php';

$id = $_POST["id"];
$eventoM = new Modelo\Evento();
$eventoM->setId($id);
$response = $eventoM->delete();

// Obtener la ruta del archivo anexo desde la respuesta del servidor
$anexoPath = "../media/" . $response[""]; // Reemplaza "rutaArchivo" con el nombre correcto del campo en la respuesta

// Eliminar el archivo de la carpeta "media"
if (file_exists($anexoPath)) {
    unlink($anexoPath);
}

echo json_encode($response);
unset($eventoM);
unset($response);
?>
