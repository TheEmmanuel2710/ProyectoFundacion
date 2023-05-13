const fs = require('fs');
const path = require('path');

const rutaFotos = '../media/fotos'; // Ruta de la carpeta fotos 
var contenedorImagenes = document.getElementById('contenedor-fotos');
fs.readdir(rutaFotos, (err, files) => {
  if (err) {
    console.error('Error al leer los archivos:', err);
    return;
  }
  
  // Filtrar solo los archivos con la extensión .png
  const imagenesPNG = files.filter(file => path.extname(file).toLowerCase() === '.png');
  
  // Recorrer los nombres de las imágenes
  imagenesPNG.forEach(nombreImagen => {
    // Crear la etiqueta <img> para cada imagen
    var imagen = document.createElement('img');
    
    // Establecer el atributo "src" con la ruta completa de la imagen
    imagen.src = rutaFotos + '/' + nombreImagen;
    
    // Agregar la etiqueta <img> al contenedor de imágenes
    contenedorImagenes.appendChild(imagen);
  });
});
