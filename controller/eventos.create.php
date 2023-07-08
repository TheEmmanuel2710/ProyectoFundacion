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
            mkdir($directorio, 0777) or die("No se puede crear el directorio de extracción");
        }

        $dir = opendir($directorio);
        $target_path = $directorio . '/' . $filename;

        if (move_uploaded_file($source, $target_path)) {
            echo "El archivo $filename se ha almacenado en forma exitosa.<br>";
            $filenames[] = $filename; // Agregar el nombre del archivo a la matriz
        } else {
            echo "Ha ocurrido un error al almacenar el archivo $filename. Por favor, inténtelo de nuevo.<br>";
            // Crear el script para mostrar el Sweet Alert de error
            echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';
            echo '<script>';
            echo 'swal("¡Error!", "Ha ocurrido un error al almacenar el archivo ' . $filename . '", "error");';
            echo '</script>';
        }
        closedir($dir);
    }
}

$eventosM->setAnexo($filenames); // Asignar la matriz de nombres de archivos al atributo "Anexo"
$result = $eventosM->create();

// Obtener los eventos después de crearlos
$eventos = $eventosM->read();

// Comprobar si se crearon eventos
if (!empty($eventos)) {
    // Crear el script para mostrar el Sweet Alert de éxito y redireccionar al archivo HTML
    echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';
    echo '<script>';
    echo 'swal("Sistema Fundacion Divino Niño Dice:", "Evento creado de manera correcta.", "success").then(function() { window.location.href = "../vistaGestionarEventos.html"; });';
    echo '</script>';
} else {
    // En caso de que no se hayan creado eventos
    echo "Ha ocurrido un error al crear los eventos. Por favor, inténtelo de nuevo.";
}

// Devolver los eventos como respuesta en formato JSON
echo json_encode($eventos);

unset($eventosM);
?>
