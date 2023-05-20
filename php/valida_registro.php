<!-- valicación de datos -->
<?php
require_once("./config_BD.php");
// Variables que contendrán un posible mensaje de error
$nombreErr = $contraseñaErr = $fecha_nacimientoErr = $correoErr = $num_tarjetaErr = $direccionErr = "";
// Variables que guardan el contenido de los campos del formulario
$nombre = $contraseña = $correo = $num_tarjeta = $direccion = "";
$fecha_nacimiento = "1966-01-03";
$hay_errores = false;
function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function checkemail($str){
    return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? false : true;
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
    date_default_timezone_set("America/Mexico_City");
    if (($_POST["fnac"]) == "1969-12-31") { // esta vacio ?
        $fecha_nacimientoErr = "* Fecha requerida";
        $hay_errores = true;
    } else {
        $fecha_nacimiento = date("Y-m-d", strtotime($_POST["fnac"]));
    }
    if (empty($_POST["correo"])) {
        $correoErr = "* Email requerido";
        if (!checkemail(test_input($_POST["correo"]))) {
            $correoErr = "* Email invalido";
            $hay_errores = true;
        }
    } else {
        $correo = test_input($_POST["correo"]);
    }
    if (empty($_POST["numero_tarjeta"])) {
        $num_tarjetaErr = "* Número de tarjeta requerido";
        $hay_errores = true;
    } else {
        $num_tarjeta = test_input($_POST["numero_tarjeta"]);
    }
    if (empty($_POST["direccion"])) {
        $direccionErr = "* Dirección requerida";
        $hay_errores = true;
    } else {
        $direccion = test_input($_POST["direccion"]);
    }
    if (!$hay_errores) { // si no hay errores
        $con = mysqli_connect($db_hostname, $db_username, $db_password, $db_name);
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        } else {
            // registrar usuario
            $query="insert into usuarios (Nombre, Correo, Contraseña, Fecha_nacimiento, Num_tarjeta_bancaria, Direccion_postal) 
                values ('$nombre','$correo','$contraseña','$fecha_nacimiento','$num_tarjeta','$direccion');";
            mysqli_query($con, $query);
            //obtener id
            $result = mysqli_query($con, "SELECT ID_usuario, Nombre FROM usuarios where Nombre='$nombre' and Contraseña='$contraseña' ;");
            while ($row = mysqli_fetch_array($result)) {
                $id=$row['ID_usuario'];
                $nombre=$row['Nombre'];
            }

            //cerrar conexión
            mysqli_close($con);
            //session
            session_start();
            $_SESSION['sesion_personal']=array();
            $_SESSION['sesion_personal']['id']=$id;
            $_SESSION['sesion_personal']['nombre']=$nombre;
            //enviar a index
            header("Location: ../index.php");
        }
    }
}
?>