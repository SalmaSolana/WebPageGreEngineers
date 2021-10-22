<?php
    session_start();
    error_reporting(0);
    include 'conexion.php';

    $bd = new MYSQLIFunctions();
    $user = $_SESSION['user'];
    date_default_timezone_set('America/Mexico_City');
    $hoy=date('Y-m-d');
    $hora=date('H:i:s');
    $fechaHora=date('Y-m-d H:i:s', time());
    $meses = array("01"=>"Enero", "02"=>"Febrero", "03"=>"Marzo" , "04"=>"Abril" , "05"=>"Mayo" , "06"=>"Junio" , "07"=>"Julio" , "08"=>"Agosto" , "09"=>"Septiembre" , "10"=>"Octubre" , "11"=>"Noviembre", "12"=>"Diciembre");
    $diasSemana = array("Domingo", "Lunes", "Martes", "Miércoles" , "Jueves" , "Viernes" , "Sábado");

    if($tipo == 'login'){
        $usuario = utf8_decode($_POST['usuario']);
        $contrasena = utf8_decode($_POST['contrasena']);
        // Cambiar a prepare
        // $saltBD = $bd->select("SELECT Salt as variable FROM usuarios WHERE Usuario = '".$usuario."' and Estatus>0 ")['variable'];
        $datosUser = $bd->select("SELECT Id, Salt, Estatus FROM usuarios WHERE Usuario = '".$usuario."' ");

        if($datosUser['Id'] == ''){
            echo  "noExiste";
            exit;
        }else if($datosUser['Estatus'] == 0){
            echo  "noActivo";
            exit;
        }

        $contrasenaFinal = hash("sha256", $datosUser['Salt'].$contrasena);
        $login = $bd->query("SELECT Id FROM usuarios where Usuario = '".$usuario."' and Contrasena = '".$contrasenaFinal."' and Estatus>0");
        if($bd->rows($login) > 0){
            session_start();
            while($l = $bd->fassoc($login)){
                $_SESSION['user'] = $l['Id'];
                $_SESSION['sesion'] = hash("sha256", "sesvalida");
            }
            echo "ok";
        }else {
            "error";
        }
    }


    else if($tipo == 'registraUsuario'){
        $name=utf8_decode($_POST['nombre']);
        $pate=utf8_decode($_POST['paterno']);
        $mate=utf8_decode($_POST['materno']);
        $correo=utf8_decode($_POST['usuario']);
        $tipoU=$_POST['tipoU'];
        $emp=$_POST['emp'];
        $pass=utf8_decode($bd->escapestr($_POST['contrasenaSHA']));
        $home=$_POST['home'];

        $exist=$bd->select("SELECT Id as variable FROM `usuarios` WHERE Usuario='".$correo."'")['variable'];
        if($exist>0){
            echo "exist";
            return;
        }

        $salt = hash("sha256", openssl_random_pseudo_bytes(64));
        $contrasenaFinal = hash("sha256", $salt.$pass);

        $insert="INSERT INTO `usuarios` (`Tipo`, `Rol`, `Usuario`, `Nombre`, `ApellidoP`, `ApellidoM`, `Contrasena`, `Salt`, `Inicio`,  `Empresa`, `Sucursal`, `Estatus`) VALUES ('".$tipoU."', 99, '".$correo."', '".$name."', '".$pate."', '".$mate."', '".$contrasenaFinal."', '".$salt."', '".$home."', '".$emp."', 0, 1)";
        if($bd->query($insert)){
            $id = $bd->select("SELECT MAX(Id) as max FROM `usuarios` WHERE Usuario='".$correo."' AND Estatus>0 ")['max'];
            $plan = $bd->select("SELECT Plan as variable FROM `empresas` WHERE Id ='".$emp."' AND Estatus>0 ")['variable'];

            $consulta1 = $bd->query("SELECT Modulo, Escritura, Edicion, Eliminar FROM roles WHERE Plan = '".$plan."' AND Rol = 99 AND Estatus > 0");
            while($res1=$bd->fassoc($consulta1)){
                $insertModulo=$bd->query("INSERT INTO `permisos` (`Usuario`, `Modulo`, `Escritura`, `Edicion`, `Eliminar`) VALUES ('".$id."', '".$res1['Modulo']."', '".$res1['Escritura']."', '".$res1['Edicion']."', '".$res1['Eliminar']."') ");
            }
            //permiso a cuenta principal
            $consulta=$bd->query("SELECT Id, Usuarios FROM cuentas WHERE Empresa='".$empresa."'  and Sucursal='".$sucursal."' ORDER BY Id ASC LIMIT 1");
            while($res=$bd->fassoc($consulta)){
                $usuarios=json_decode($res['Usuarios'], true);
                $idCuenta=$res['Id'];
            }
            if($usuarios==""){
              $users['Usuario0']=$id;
            }else{
              foreach($usuarios as $index => $val){
                  $users[$index]=$val;
              }
              $index++;
              $users[$index]=$id;
            }
            $query=$bd->query("UPDATE `cuentas` SET `Usuarios`='".json_encode($users)."' WHERE Id='".$idCuenta."' and Empresa='".$empresa."' and Sucursal='".$sucursal."' ");
            echo "ok";
        }
        // Nota: si se modifica algo de estas lineas, verificar si es necesario cambiar la función "nuevoRegistro"
    }

    else if($tipo == 'cargaModulos'){
        $empresaF = $_POST['empresa'];
        $rol = $_POST['rol'];
        if($empresaF==0) $empresaF = $empresa;

        $x=0;
        $array = array();
        $planEmpresa = $bd->select("SELECT Plan as variable FROM `empresas` WHERE Id ='".$empresaF."' AND Estatus>0 ")['variable'];
        $consulta = $bd->query("SELECT DISTINCT r.Modulo, m.Nombre, m.Categoria FROM `modulos` as m INNER JOIN roles as r ON r.`Plan`='".$planEmpresa."' and r.`Rol`='".$rol."' and r.Estatus>0 and r.Modulo=m.Id and m.Estatus>0 ORDER BY m.Orden ASC");
        while($res=$bd->fassoc($consulta)){
            if ($res['Categoria'] > 0){
                $descCategoria = $bd->select("SELECT Descripcion as variable FROM `catalogos` WHERE Tipo = 'CategoriaModulo' AND Valor = '".$res['Categoria']."' AND Estatus > 0 ")['variable'];
                $nombre = $descCategoria.'->'.$res['Nombre'];
            } else {
                $nombre = $res['Nombre'];
            }

            $array[$x]['Id'] = $res['Modulo'];
            $array[$x]['Nombre'] = utf8_encode($nombre);
            $x++;
        }
        echo json_encode($array);
    }

    else if($tipo == 'cargaModulosEditar'){
        $id = $_POST['idUsuario'];
        $x=0;
        $array = array();

        $consulta = $bd->query("SELECT m.Id, m.Nombre FROM permisos AS p INNER JOIN modulos AS m ON p.Usuario = '".$id."' AND p.Modulo = m.Id AND m.Estatus > 0 ORDER BY m.Nombre");
        while($res=$bd->fassoc($consulta)){
            $array[$x]['Id'] = $res['Id'];
            $array[$x]['Nombre'] = utf8_encode($res['Nombre']);
            $x++;
        }
        echo json_encode($array);
    }

    else if($tipo == 'tablaUsuarios'){
        $estatus = $_POST['estatus'];
        $x=0;
        $array = array();

        $permiso = $funciones->validaPermiso(2);
        $consulta=$bd->query("SELECT * FROM usuarios WHERE Estatus='".$estatus."' AND Tipo = 1 OR (Tipo = 2 AND Rol = 99) ORDER BY Nombre ASC");
        while($res=$bd->fassoc($consulta)){
            if($permiso==1){
                $edit='<a onclick="infoEditaUsuario('.$res['Id'].')" data-toggle="modal" data-target="#editUser" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pen" style="padding-top:3px"></i></a>';
                $modulos='<a onclick="modulosUser('.$res['Id'].'), modulosUserInicio('.$res['Id'].')" data-toggle="modal" data-target="#modules" class="btn btn-info shadow btn-xs sharp mr-1"><i class="fas fa-user-check" style="padding-top:3px"></i></a>';
            }else{
                $edit='';
                $modulos='';
            }
            $empresa = $bd->select("SELECT Nombre as variable FROM `empresas` WHERE Id='".$res['Empresa']."'")['variable'];
            $array[$x]['usuario'] = utf8_encode($res['Usuario']);
            $array[$x]['nombre'] = utf8_encode($res['Nombre']);
            $array[$x]['apellido'] = utf8_encode($res['ApellidoP'].' '.$res['ApellidoM']);
            $array[$x]['empresa'] = utf8_encode($empresa);
            $array[$x]['id'] = $res['Id'];
            $array[$x]['edit'] = $edit;
            $array[$x]['modulos'] = $modulos;
            $x++;
        }
        echo json_encode($array);
    }

    else if($tipo == 'infoEditaUsuario'){
        $id=$_POST['id'];
        $dire=0;
        $array = array();
        $consulta=$bd->query("SELECT * FROM usuarios WHERE Id='".$id."' ");
        while($res=$bd->fassoc($consulta)){
            $array[1]['nombre'] = utf8_encode($res['Nombre']);
            $array[1]['paterno'] = utf8_encode($res['ApellidoP']);
            $array[1]['materno'] = utf8_encode($res['ApellidoM']);
            $array[1]['correo'] = utf8_encode($res['Usuario']);
            $array[1]['id'] = $res['Id'];
            $array[1]['empresa'] = $res['Empresa'];
            $array[1]['tipo'] = $res['Tipo'];
            $array[1]['estatus'] = $res['Estatus'];
            $array[1]['inicio'] = $res['Inicio'];

        }
        echo json_encode($array);
    }

    else if($tipo == 'editaUsuario'){
        $nombre=utf8_decode($_POST['nombre']);
        $pate=utf8_decode($_POST['pate']);
        $mate=utf8_decode($_POST['mate']);
        $mail=utf8_decode($_POST['usuario']);
        $id=$_POST['id'];
        $pass=$bd->escapestr($_POST['pass']);
        $actPass=$_POST['act'];
        $estatus=$_POST['estatus'];
        $empresaUser=$_POST['empresa'];
        $tipoUE=$_POST['tipoUE'];

        $exist=$bd->select("SELECT Id as variable FROM `usuarios` WHERE Usuario='".$mail."' and Id!='".$id."' ")['variable'];
        if($exist>0){
            echo "exist";
            return;
        }

        if($actPass==1){
            $salt = hash("sha256", openssl_random_pseudo_bytes(64));
            $contrasenaFinal = hash("sha256", $salt.$pass);
            $query="UPDATE `usuarios` SET `Tipo`='".$tipoUE."', `Usuario`='".$mail."', `Nombre`='".$nombre."', `ApellidoP`='".$pate."', `ApellidoM`='".$mate."', `Contrasena`='".$contrasenaFinal."', `Salt`='".$salt."', `Empresa`='".$empresaUser."', `Estatus`='".$estatus."' WHERE Id='".$id."' ";
        }else{
            $query="UPDATE `usuarios` SET `Tipo`='".$tipoUE."', `Usuario`='".$mail."', `Nombre`='".$nombre."', `ApellidoP`='".$pate."', `ApellidoM`='".$mate."', `Empresa`='".$empresaUser."', `Estatus`='".$estatus."' WHERE Id='".$id."' ";
        }

        if($bd->query($query)){
            echo "ok";
            /*$cons = $bd->select("SELECT Id as variable FROM `permisos` WHERE IdUser='".$id."' and IdModulo='".$home."'")['variable'];
            if($cons=="" and $home>0){
                $query=$bd->query("INSERT INTO `permisos` (`IdUser`, `IdModulo`, `Escritura`, `Edicion`, `Eliminar`) VALUES ('".$id."', '".$home."', 0, 0, 0)");
            }*/
        }
    }


?>
