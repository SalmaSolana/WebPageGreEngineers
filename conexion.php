<?php
    function OpenConnection(){
        $dbHost = "localhost";
        $dbUser = "root";
        $dbPass = "";
        $db = "PlantasDB";
        $conexion = new mysqli($dbHost, $dbUser, $dbPass, $db) or die("Connect failed %a\n" . $conexion -> $error);
        return $conexion;
    }
    function CloseConnection($conexion){
        $conexion->close();
    }
?>