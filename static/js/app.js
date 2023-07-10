document.addEventListener('DOMContentLoaded', function() {
  let datos = "";
  for (let index = 1; index < 115; index++) {
    datos += "<div class='carousel-item'>";
    datos += "<img src='media/fotos/" + index +".JPG' class='d-block'></img>";
    datos += "</div>";
  }
  document.querySelector('.carousel-inner').innerHTML = datos;
  document.querySelector('.carousel-item').classList.add('active');
});
