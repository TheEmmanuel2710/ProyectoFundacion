<?php
include_once '../model/evento.php';
$id = $_POST["id"];
$eventoM = new Modelo\Evento();
$result = $eventoM->readOne($id);
echo json_encode($result);
unset($eventoM);
?>