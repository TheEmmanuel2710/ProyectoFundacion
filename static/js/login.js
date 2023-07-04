function login() {
    fetch(`./controller/login.php?txtCorreo=${txtCorreo.value}&txtPassword=${txtPassword.value}`)
    .then((response)=>response.json())
    .then((data)=>{
        try {
            console.log(data);
            if (data[0]["correo"]) {
                window.location.href="vistaAgregarEventos.html"
            }
        } catch (error) {
            alert("Correo o Contraseña incorrecto");
        }
    });
}