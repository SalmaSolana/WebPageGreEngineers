function cerrarSesion(){
    $.ajax({
        url: 'main.php',
        type: 'POST',
        data: { tipo: 'cerrarSesion' },
        success: function(respuesta) {
            console.log(respuesta);
            if (respuesta == "ok") {
                window.location = "../../login.php";
            }
        },
    });
}