const fs = require('fs');
const path = require('path');

const rutaFotos = '../media/fotos';
var contenedorImagenes = document.getElementById('contenedor-fotos');
fs.readdir(rutaFotos, (err, files) => {
  if (err) {
    console.error('Error al leer los archivos:', err);
    return;
  }
  const imagenesPNG = files.filter(file => path.extname(file).toLowerCase() === '.JPG');
  imagenesPNG.forEach(nombreImagen => {
    var imagen = document.createElement('img');
    imagen.src = rutaFotos + '/' + nombreImagen;
    contenedorImagenes.appendChild(imagen);
  });
});
