<?php
include_once '../model/evento.php';

$id = $_POST["id"];
$eventoM = new Modelo\Evento();
$eventoM->setId($id);

// Obtener la información de las imágenes asociadas al evento
$evento = $eventoM->readOne($id);
if ($evento && isset($evento[0]['notiAnexo'])) {
    $anexos = explode(',', $evento[0]['notiAnexo']);

    // Ruta completa de la carpeta "media"
    $mediaPath = "../media/";

    // Eliminar cada archivo de la carpeta "media"
    foreach ($anexos as $anexo) {
        $anexoPath = $mediaPath . $anexo;
        if (file_exists($anexoPath)) {
            unlink($anexoPath);
        }
    }
}

// Eliminar el evento de la base de datos
$response = $eventoM->delete();

echo json_encode($response);
unset($eventoM);
unset($response);
?>
