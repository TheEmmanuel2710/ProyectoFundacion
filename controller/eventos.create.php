<?php

include_once "../model/evento.php";

$eventosM = new Modelo\Evento();

// Leer los datos del evento desde $_POST
$eventosM->setTitulo($_POST["txtTitulo"]);
$eventosM->setDescripcion($_POST["txtDescripcion"]);

$filenames = []; // Matriz para almacenar los nombres de los archivos

foreach ($_FILES["fileAnexo"]["tmp_name"] as $key => $tmp_name) {
    if ($_FILES["fileAnexo"]["name"][$key]) {
        $filename = $_FILES["fileAnexo"]["name"][$key];
        $source = $_FILES["fileAnexo"]["tmp_name"][$key];

        $directorio = '../media/';

        if (!file_exists($directorio)) {
            mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");
        }

        $dir = opendir($directorio);
        $target_path = $directorio . '/' . $filename;

        if (move_uploaded_file($source, $target_path)) {
            echo "El archivo $filename se ha almacenado en forma exitosa.<br>";
            $filenames[] = $filename; // Agregar el nombre del archivo a la matriz
        } else {
            echo "Ha ocurrido un error, por favor inténtelo de nuevo.<br>";
        }
        closedir($dir);
    }
}

$eventosM->setAnexo($filenames); // Asignar la matriz de nombres de archivos al atributo "Anexo"
$result = $eventosM->create();

// Obtener los eventos después de crearlos
$eventos = $eventosM->read();

// Devolver los eventos como respuesta en formato JSON
echo json_encode($eventos);

unset($eventosM);


?>