<?php
require_once("./config_BD.php");
session_start();
if (!isset($_SESSION['sesion_personal'])) {
    header("Location: ./sesion.php");
}
$id_usuario=$_SESSION['sesion_personal']['id'];
$vaciar_carrito=$_GET['v'];

$arreglo=array(); // arreglo de productos con sus cantidad y id pe [0]=1, 2
foreach ($_GET['datos'] as $value) {
    $subarreglo=explode(",",$value);
    array_push($arreglo,$subarreglo);
}

$con = mysqli_connect($db_hostname, $db_username, $db_password, $db_name);
if (mysqli_connect_errno()) :
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
else:
    foreach ($arreglo as $indice => $valor) {
        $cantidad_seleccionada=$valor[0];  //  el primer [0] es el primero producto
        $id_producto=$valor[1];
        
        // disminuir el numero de elementos
        $result=mysqli_query($con, "SELECT Cantidad_almacen FROM productos WHERE ID_producto=$id_producto;");
        while ($row = mysqli_fetch_array($result)){
            $nueva_cantidad=((int)$row['Cantidad_almacen']) - $cantidad_seleccionada;
        }
        $actualizacion_de_cantidad=mysqli_query($con,"UPDATE productos	SET Cantidad_almacen=$nueva_cantidad WHERE ID_producto=$id_producto;");
        
        // registrar la compra en el historial de compras
        $query="INSERT INTO historial_compras (Usuario,Producto,Cantidad_producto) 
            VALUES ($id_usuario,$id_producto,$cantidad_seleccionada);";
        $otro=mysqli_query($con, $query);
    }

    if((int)$vaciar_carrito){
        mysqli_query($con, "DELETE FROM carrito_compras;");
    }

    mysqli_close($con);
    header('Location: ./historial_compras.php');
endif;