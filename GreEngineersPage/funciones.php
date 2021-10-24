<?php
    function cerrarSesion(){
        session_destroy();
        header('Location:login.php');
    }
?>