<?php
session_start();
if (isset($_SESSION["correo"]) and !empty($_SESSION["correo"])){
    $response=true;
}else {
    $response=false;
}

echo json_encode($response);