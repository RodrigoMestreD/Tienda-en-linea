<?php
require_once("./config_BD.php");
session_start();
$id_producto=$_GET["id"];

/*Mandar php inicial siempre despues del head*/

if (!isset($_SESSION['sesion_personal'])) {
    header("Location: ./sesion.php");
}

// Crear una conexión
$con = mysqli_connect($db_hostname, $db_username, $db_password, $db_name);
    
// verificar connection con la BD
if (mysqli_connect_errno()) :
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
else:
    $info_del_producto=[];
    $result = mysqli_query($con, "SELECT * FROM productos WHERE ID_producto=".$id_producto.";");
    $num_productos=mysqli_num_rows($result);
    while ($row = mysqli_fetch_array($result)):
        array_push($info_del_producto, array(
            "nombre"=>$row['Nombre'],
            "descripcion"=>$row['Descripcion'],
            "imagen"=>$row['Fotos'],
            "disponibles"=>$row['Cantidad_almacen'],
            "precio"=>$row['Precio'],
            "fabricante"=>$row['Fabricante'],
            "origen"=>$row['Origen'],
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
    <title>Info del producto</title>
    <!--icono pestaña-->
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico"/>
    <!--CSS-->
    <link rel="preload" href="../css/info_producto.css" as="style">
    <link rel="stylesheet" href="../css/info_producto.css">
    <!--JS-->
    <script type="text/javascript" src="../js/Agrega_carrito.js"></script>
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
                <ul class="nav navbar-nav">
                    <li><span class="navbar-text"><a href="../php/perfil.php"
                        class="navbar-link"> Usuario:
                        <u><?=$_SESSION['sesion_personal']['nombre']?></u></a></span>
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
    <script>
    let id_del_producto = <?=$id_producto?>;
    </script>
    <div class="grande">
        <div class="imagen">
            <span><img src="../img/productos/<?= $info_del_producto[0]["imagen"] ?>" alt=""></span>
        </div>
        <div class="info-importante">
            <span><b>Nombre: </b><br><?= $info_del_producto[0]["nombre"]?></span>
            <span><b>Precio: </b><br>$ <?= number_format(floatval($info_del_producto[0]["precio"])) ?></span>
            <span><b>Disponibles: </b><br><?php $info_del_producto[0]["disponibles"] ?></span>
            <span><b>Cantidad: </b>
                <select class="form-control" id="cantidad_seleccionada">
                    <?php for ($i=1; $i <= $info_del_producto[0]["disponibles"]; $i++): ?>
                    <option value="<?=$i?>"><?=$i?></option>
                    <?php endfor ?>
                </select>
            </span>
            <span>
                <input type="button" onclick="enviar_a_comprar_uno(id_del_producto)"
                    class="btn btn-default comprar" value="Comprar">
                <input type="button" onclick="agregar_al_carrito(id_del_producto)" class="btn btn-default comprar" value="Agregar al carrito">
            </span>
        </div>
    </div>
    <h2>Acerca de este articulo</h2>
    <div class="info-secundaria">
        <span><b>Descripción: </b><?= $info_del_producto[0]["descripcion"] ?></span>
        <span><b>Fabricante: </b><?= $info_del_producto[0]["fabricante"] ?></span>
        <span><b>Origen: </b><?= $info_del_producto[0]["origen"] ?></span>
    </div>
</body>
</html>