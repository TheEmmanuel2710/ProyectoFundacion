<?php
include_once "../model/usuario.php";

$correo = $_GET["txtCorreo"];
$password = $_GET["txtPassword"];
$usuarioM = new Modelo\Usuario();
$usuarioM->setCorreo($correo);
$usuarioM->setPassword($password);

$response = $usuarioM->login();

if (isset($response[0]["correo"]) && !empty($response[0]["correo"])) {
    session_start();    
    $_SESSION["correo"] = $response[0]["correo"];
    $_SESSION["password"] = $response[0]["password"];
}

echo json_encode($response);
unset($usuarioM);
unset($response);
