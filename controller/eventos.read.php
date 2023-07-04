<?php
include_once "../model/evento.php";
$eventoM = new Modelo\Evento();
$result = $eventoM->read();

echo json_encode($result);
unset($eventoM);
unset($result);
?>
