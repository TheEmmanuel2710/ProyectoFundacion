<?php
include_once '../model/evento.php';

$id = $_POST["id"];
$titulo = $_POST["txtTituloEdit"];
$descripcion = $_POST["txtDescripcionEdit"];
$anexo = $_FILES["fileAnexo"];

$eventoM = new Modelo\Evento();

$eventoM->setId($id);
$eventoM->setTitulo($titulo);
$eventoM->setDescripcion($descripcion);

// Obtener el valor actual de notiAnexo
$oldAnexo = $eventoM->getAnexo();

// Obtener los nombres de los archivos nuevos enviados en la solicitud
$newAnexo = array_filter($anexo["name"]);

// Eliminar los archivos antiguos que no están en los nuevos
$oldFiles = explode(',', $oldAnexo);
$newFiles = array_filter($anexo["name"]);
$deletedFiles = array_diff($oldFiles, $newFiles);

$uploadPath = "../media/";

// Eliminar los archivos antiguos que no están en los nuevos
foreach ($deletedFiles as $file) {
    if (!in_array($file, $newFiles)) {
        $filePath = $uploadPath . $file;
        if (is_file($filePath)) {
            unlink($filePath);
        }
    }
}

// Guardar los archivos adjuntos en el servidor si tienen nombres diferentes
$uploadedFiles = array();
foreach ($anexo["tmp_name"] as $index => $tmpName) {
    if ($anexo["error"][$index] === UPLOAD_ERR_OK && isset($tmpName) && $tmpName !== '') {
        $filename = basename($anexo["name"][$index]);
        $targetPath = $uploadPath . $filename;

        // Verificar si el archivo tiene un nombre diferente a los antiguos
        if (!in_array($filename, $oldFiles) && !in_array($filename, $uploadedFiles)) {
            move_uploaded_file($tmpName, $targetPath);
            $uploadedFiles[] = $filename;
        }
    }
}

$newAnexo = implode(',', $uploadedFiles);
$eventoM->setAnexo($newAnexo);

$response = $eventoM->update();

unset($eventoM);

echo json_encode($response);
?>
