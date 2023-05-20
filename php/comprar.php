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
    $usuario=[];
    $result = mysqli_query($con, "SELECT * FROM usuarios WHERE ID_usuario=".$id_usuario.";");
    while ($row = mysqli_fetch_array($result)):
        array_push($usuario, array(
            "correo"=>$row['Correo'],
            "num_tarjeta"=>$row['Num_tarjeta_bancaria'],
            "direccion"=>$row['Direccion_postal'],
        ));
    endwhile;

    // recorrer el arreglo de productos para hacer un arreglo de productos mas detallado
    $producto=[];
    foreach ($arreglo as $indice => $valor) {
        $cantidad=$valor[0];  //  el primer [0] es el primero producto
        $id_producto=$valor[1];
        /// AQUI
        $result = mysqli_query($con, "SELECT * FROM productos WHERE ID_producto=".$id_producto.";");
        while ($row = mysqli_fetch_array($result)) {
            array_push($producto, array(
                "nombre"=>$row['Nombre'],
                "imagen"=>$row['Fotos'],
                "precio"=>$row['Precio'],
                "cantidad"=>$cantidad,
            ));
        }
    }
    
    mysqli_close($con);
endif;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include "./head_html.php" ?>
    <title>Hora de comprar!!</title>
    <!--icono pestaña-->
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico"/>
    <!-- estilos -->
    <link rel="preload" href="../css/comprar.css" as="style">
    <link rel="stylesheet" href="../css/comprar.css">
    <!-- JavaScript -->
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
                <!-- menú -->
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
    <h1>Orden de compra</h1>
    <h3>Información de la factura</h3>
    <!-- dirección, numero de tarjeta, correo -->
    <div class="info-producto"><br>
        <div class="centrar-texto">
            <p><b>Correo:</b> <?= $usuario[0]['correo'];?></p>
            <p><b>Número de tarjeta:</b> <?= $usuario[0]['num_tarjeta'];?></p>
            <p><b>Dirección:</b> <?= $usuario[0]['direccion'];?></p>
        </div>
    </div>
    <hr>
    <h3>Confirmación de orden de compra</h3> <!-- datos de los productos  NUEVO-->
    <?php foreach ($producto as $value) :?>
    <div class="info-producto">
        <div class="ancho-minimo">
            <p><b>Nombre:</b> <?= $value['nombre'];?></p>
            <p><b>Precio:</b> $<?= number_format(floatval($value['precio']), 2, '.', ',')?></p>
            <p><b>Cantidad:</b> <?= $value['cantidad'];?></p>
            <p><b>Total:</b>
                $<?= number_format(floatval($value['cantidad']*floatval($value['precio'])), 2, '.', ',');?>
            </p>
        </div>
        <div>
            <img src="../img/productos/<?= $value['imagen']?>" alt="<?= $value['nombre']?>">
        </div>
    </div>
    <br><br>
    <?php endforeach; ?>

    <script>
        var arreglo_de_productos = JSON.parse('<?= json_encode($arreglo); ?>');
    </script>
    <div class="centrar-botones">
        <input type="submit" value="Confirmar compra" class="btn btn-default boton"
            onclick="comprar(arreglo_de_productos,<?=(int) $vaciar_carrito?>)">
        <input type="submit" value="Cancelar compra" class="btn btn-default boton"
            onclick="window.location.replace('../index.php')">
    </div>
</body>

</html>