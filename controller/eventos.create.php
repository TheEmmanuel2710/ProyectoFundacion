<?php

include_once "../model/evento.php";

$eventosM = new Modelo\Evento();
$eventosM->setTitulo($_POST["txtTitulo"]);
$eventosM->setDescripcion($_POST["txtDescripcion"]);

// Obtener la información del archivo
$anexoNombre = $_FILES["fileAnexo"]["name"];
$anexoTmpName = $_FILES["fileAnexo"]["tmp_name"];
$anexoDestino = "../media/" . $anexoNombre;

// Mover el archivo a la ubicación deseada
move_uploaded_file($anexoTmpName, $anexoDestino);

$eventosM->setAnexo($anexoDestino);
$result = $eventosM->create();

echo json_encode($result);

unset($eventosM);



?>
