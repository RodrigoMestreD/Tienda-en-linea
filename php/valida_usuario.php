<?php
require_once("./config_BD.php");
// Variables que contendrán un posible mensaje de error
$nombreErr = $contraseñaErr = "";
// Variables que guardan el contenido de los campos del formulario
$nombre = $contraseña = "";
$hay_errores=false;

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["nombre"])) {
        $nombreErr = "* Nombre requerido";
        $hay_errores = true;
    } else {
        $nombre = test_input($_POST["nombre"]);
    }
    if (empty($_POST["contrasena"])) {
        $contraseñaErr = "* Contraseña requerida";
        $hay_errores = true;
    } else {
        $contraseña = test_input($_POST["contrasena"]);
    }

    // verificacion de errores y creacion de sesion
    if (!$hay_errores) { // si no hay errores
        $con = mysqli_connect($db_hostname, $db_username, $db_password, $db_name);
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        } else {
            //obtener id
            $result = mysqli_query($con, "SELECT ID_usuario, Nombre FROM usuarios where Nombre='$nombre' and Contraseña='$contraseña' ;");
            $id=$nombre="";
            while ($row = mysqli_fetch_array($result)) {
                $id=$row['ID_usuario'];
                $nombre=$row['Nombre'];
            }

            //cerrar conexión
            mysqli_close($con);
            if ($id!=="") {
                //session
                session_start();
                $_SESSION['sesion_personal']=array();
                $_SESSION['sesion_personal']['id']=$id;
                $_SESSION['sesion_personal']['nombre']=$nombre;
                //enviar a index
                header("Location: ../index.php");
            }else{
                $nombreErr="ALGUN ERROR";
            }
        }
    }
}