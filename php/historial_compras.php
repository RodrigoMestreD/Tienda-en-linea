<?php
require_once("./config_BD.php");
session_start();
if(!isset($_SESSION['sesion_personal'])){
    header("Location: ./sesion.php");
}
$id_usuario=$_SESSION['sesion_personal']['id'];
include "head_html.php";

// Crear una conexión
$con = mysqli_connect($db_hostname, $db_username, $db_password, $db_name);
    
// verificar connection con la BD
if (mysqli_connect_errno()) :
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
else:
    $historial=[];
    $result = mysqli_query($con, "SELECT p.ID_producto,p.Nombre,p.Fotos,p.Precio,h.Cantidad_producto FROM productos as p INNER JOIN historial_compras as h ON p.ID_producto=h.Producto WHERE h.Usuario=".$id_usuario.";");
    $num_productos=mysqli_num_rows($result);
    while ($row = mysqli_fetch_array($result)):
        $precio=$row['Precio'];
        $cantidad=$row['Cantidad_producto'];
        $total=$precio*$cantidad;
        array_push($historial, array(
            "nombre_producto"=>$row['Nombre'],
            "imagen"=>$row['Fotos'],
            "precio_producto"=>$precio,
            "cantidad_comprada"=>$cantidad,
            "total"=>$total,
        ));
    endwhile;
    // cerrar conexión
    mysqli_close($con);
endif;

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include "./head_html.php" ?>
    <title>Historial de compras</title>
    <!--icono pestaña-->
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico"/>
    <!-- CSS -->
    <link rel="preload" href="../css/historial_compras.css" as="style">
    <link rel="stylesheet" href="../css/historial_compras.css">
</head>
<!-- barra de navegación -->
<header>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <!-- responsividad del header, marca -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- marca -->
                <a class="navbar-brand" href="../index.php">E-Store</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <!-- menú -->
                <ul class="nav navbar-nav">
                    <li class="navbar-text">
                        <a href="../php/perfil.php" class="navbar-link">
                            usuario:
                            <u><?=$_SESSION['sesion_personal']['nombre']?></u>
                        </a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="../php/cerrar_sesion.php"><span class="glyphicon glyphicon-log-out"></span> Cerrar sesión</a>
                    </li>
                    <li>
                        <a href="../php/carrito.php"><span class="glyphicon glyphicon-shopping-cart"></span> Carrito de compras</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<body class="container">
    <?php if ($num_productos==0) :?>
        <h1 class="h1">No has realizado ninguna compra aún</h1>
    <?php else: ?>
        <h1>Historial de compras</h1>
        <div class="table-responsive">
            <table class="table table-hover">
                <tr>
                    <th>Producto</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Cantidad comprada</th>
                    <th>Total pagado</th>
                </tr>
                <?php foreach ($historial as $producto): ?>
                <tr>
                    <td><img src="../img/productos/<?= $producto["imagen"]; ?>" alt="producto <?= $producto["nombre_producto"]; ?>" class="imagen"></td>
                    <td><?= $producto['nombre_producto']; ?></td>
                    <td>$<?= number_format(floatval($producto['precio_producto'])); ?></td>
                    <td><?= $producto['cantidad_comprada']?></td>
                    <td>$<?= number_format(floatval($producto['total'])); ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    <?php endif; ?><br>
</body>

</html>