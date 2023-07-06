function Create() {
    // Obtener los valores de los campos
    var txtTitulo = document.getElementById("txtTitulo").value;
    var txtDescripcion = document.getElementById("txtDescripcion").value;
    var fileInput = document.getElementById("fileAnexo");
    var file = fileInput.files[0];

    // Validar que los campos no estén vacíos
    if (txtTitulo.trim() === "" || txtDescripcion.trim() === "") {
        alert("Por favor, completa todos los campos.");
        return;
    }

    // Validar que se haya seleccionado un archivo
    if (!file) {
        alert("Por favor, selecciona un archivo.");
        return;
    }

    // Crear objeto FormData para enviar el formulario y los archivos
    var formData = new FormData();
    formData.append('txtTitulo', txtTitulo);
    formData.append('txtDescripcion', txtDescripcion);
    formData.append('fileAnexo', file);

    // Configurar la petición fetch
    var options = {
        method: "POST",
        body: formData,
    };

    fetch("./controller/eventos.create.php", options)
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
            Read();
            location.reload();
        })
        .catch((error) => {
            console.log("-----Error al crear evento-----");
        });
}


function Read() {
    fetch("./controller/eventos.read.php")
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
            let filas = "";
            data.forEach((element, index) => {
                filas += `<tr>`;
                filas += `<td>${element.notiTitulo}</td>`;
                filas += `<td>${element.notiDescripcion}</td>`;

                filas += `<td>`;
                if (typeof element.notiAnexo === 'string' && element.notiAnexo !== '') {
                    const filenames = element.notiAnexo.split(',');
                    filas += `
                        <div id="carousel-${index}" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">`;
                    filenames.forEach((filename, i) => {
                        const activeClass = i === 0 ? 'active' : '';
                        filas += `
                                <div class="carousel-item ${activeClass}">
                                    <img src="./media/${filename.trim()}" style="width:100%; height:130px;" class="d-block" alt="Imagen">
                                </div>`;
                    });
                    filas += `
                            </div>
                            <a class="carousel-control-prev" href="#carousel-${index}" role="button" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carousel-${index}" role="button" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </a>
                        </div>`;
                } else {
                    filas += `${element.notiAnexo}`;
                }

                filas += `</td>`;
                filas += `<td><a onclick="readId(${element.id})" class='btn btn-info' data-bs-toggle='modal' data-bs-target='#updateModal'><i class="fa fa-edit text-white" title="ver/editar" style="font-size: 1rem;"></i></a> <a onclick="deleteID(${element.id},'${element.notiTitulo}')" class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#deleteModal'><i class="fa fa-trash" title="Eliminar" style="font-size: 1rem;"></i></a></td>`;
                filas += `</tr>`;
            });
            document.getElementById("tbl-Evento").innerHTML = filas;
        })
        .catch((error) => {
            console.log("-----Error al consultar Evento-----");
        });
}

Read();

function update() {
    let id = localStorage.id;
    let titulo = document.getElementById("txtTituloEdit").value;
    let descripcion = document.getElementById("txtDescripcionEdit").value;
    let fileAnexo = document.getElementById("fileAnexo").files;

    let formData = new FormData();
    formData.append("id", id);
    formData.append("txtTituloEdit", titulo);
    formData.append("txtDescripcionEdit", descripcion);

    for (let i = 0; i < fileAnexo.length; i++) {
        formData.append("fileAnexo[]", fileAnexo[i]);
    }

    var options = {
        method: "POST",
        body: formData
    };

    fetch("./controller/eventos.update.php", options)
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
            Read();
            location.reload();
        });
}




function Delete() {
    let id = localStorage.id;
    let data = `id=${id}`;
    var options = {
        method: "POST",
        body: data,
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
    };
    fetch("./controller/eventos.delete.php", options)
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
            Read();
            location.reload();
        });
}


function readId(id) {
    console.log(id);

    var data = `id=${id}`;

    // Configuración de la petición
    var options = {
        method: "POST",
        body: data,
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
    };

    fetch("./controller/eventos.readOne.php", options)
        .then((response) => response.json())
        .then((data) => {
            console.log(data)
            document.getElementById("txtTituloEdit").value = data[0].notiTitulo;
            document.getElementById("txtDescripcionEdit").value = data[0].notiDescripcion;

            // Mostrar el nombre del archivo en lugar del campo de archivo
            var fileAnexoInput = document.getElementById("fileAnexo");
            fileAnexoInput.nextElementSibling.textContent = data[0].notiAnexo;

            localStorage.id = data[0].id;
        })
        .catch((error) => {
            console.log("-----Error al obtener los eventos, por favor revisar-----" + error)
        });
}


function deleteID(id, notiTitulo) {
    document.getElementById("mensajeEliminar").innerHTML = `¿Seguro de eliminar el evento? ${notiTitulo}`;
    localStorage.id = id
}



window.onload = (event) => {
    Read();
};
