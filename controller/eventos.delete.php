<?php
include_once '../model/evento.php';
$id = $_POST["id"];
$eventoM = new Modelo\Evento();
$eventoM ->setId($id);
$reponse=$eventoM->delete();
echo json_encode($reponse);
unset($eventoM);
unset($reponse);
?>