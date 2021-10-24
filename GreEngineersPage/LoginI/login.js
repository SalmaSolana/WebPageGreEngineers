type = ['', 'info', 'success', 'warning', 'danger'];

function mensaje(from, align, time, color, mensaje) {
    $.notify({
        message: mensaje
    }, {
        type: type[color],
        delay: time,
        z_index: 10000,
        placement: {
            from: from,
            align: align
        }
    });
}


function iniciarSesion(usuario, contrasena, ev) {
    if (usuario.trim() == "" || contrasena.trim() == "") {
        mensaje('top', 'center', 2000, 3, 'Complete los campos por favor');
        return;
    }
    contrasena = CryptoJS.SHA256(contrasena).toString();
    $.ajax({
        beforeSend: function() {
            $('#botonRegistra').prop("disabled", true);
            $('#botonRegistra').html('<i class="fa fa-refresh fa-spin"></i> Validando...');
        },
        url: 'main.php',
        type: 'POST',
        data: { usuario, contrasena, tipo: 'login' },
        success: function(respuesta) {
            console.log(respuesta);
            if (respuesta == "ok") {
                window.location = "index_dashboard.php";
            } else if (respuesta == "noExiste") {
                console.log("Error...", "El usuario ingresado no existe", "error");
            } else {
                console.log("Error...", "Los datos ingresados no son válidos", "error");
            }
            $('#botonRegistra').prop("disabled", false);
            $('#botonRegistra').html('Ingresar');
        },
    });
}
