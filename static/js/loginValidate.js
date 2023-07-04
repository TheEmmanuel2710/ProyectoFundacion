function read() {
    fetch("../controller/login.validate.php")
        .then(response => response.json())
        .then((data) =>{
            console.log(data);
            if (data==false) {
                window.location.href="login.html";
            }
        });
}

read();