<?php
include_once '../model/evento.php';

$id = $_POST["id"];
$titulo = $_POST["txtTituloEdit"];
$descripcion = $_POST["txtDescripcionEdit"];
$foto = $_FILES["fileAnexo"];

$eventoM = new Modelo\Evento();
$eventoM->setId($id);
$eventoM->setTitulo($titulo);
$eventoM->setDescripcion($descripcion);

// Obtener la información del archivo
$anexoNombre = $foto["name"];
$anexoTmpName = $foto["tmp_name"];
$anexoDestino = "../media/" . $anexoNombre;

// Obtener la imagen anterior
$eventoAnterior = $eventoM->readOne($id);
if ($eventoAnterior && isset($eventoAnterior[0]['notiAnexo'])) {
    $anexoAnterior = "../media/" . $eventoAnterior[0]['notiAnexo']; // Ajusta esto según cómo se almacene el nombre de archivo en la base de datos

    // Eliminar la imagen anterior solo si el nombre de archivo es diferente al nuevo archivo
    if ($anexoNombre !== $eventoAnterior[0]['notiAnexo']) {
        if (file_exists($anexoAnterior)) {
            unlink($anexoAnterior);
        }
    }
}

// Mover el archivo a la ubicación deseada
move_uploaded_file($anexoTmpName, $anexoDestino);

$eventoM->setAnexo($anexoNombre); // Ajusta esto según cómo se almacene el nombre de archivo en la base de datos
$result = $eventoM->update();
echo json_encode($result);
unset($eventoM);
unset($result);
?>
