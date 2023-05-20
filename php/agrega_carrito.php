<?php
require_once("./config_BD.php");
session_start();
if (!isset($_SESSION['sesion_personal'])) {
    header("Location: ./sesion.php");
}
print_r($_GET);
$id_producto=$_GET["Producto"];
$cantidad_seleccionada=$_GET["cantidad"];
$id_usuario=$_SESSION['sesion_personal']['id'];

// hacer insersión
$con = mysqli_connect($db_hostname, $db_username, $db_password, $db_name);
    
// verificar connection con la BD
if (mysqli_connect_errno()) :
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
else:
    $result = mysqli_query($con, "INSERT INTO carrito_compras (Usuario,Producto,Cantidad_producto) 
        VALUES ($id_usuario,$id_producto,$cantidad_seleccionada);");
    mysqli_close($con);
    header('Location: ./carrito.php');
endif;

?>
