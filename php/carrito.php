<?php
require_once("./config_BD.php");
session_start();

if (!isset($_SESSION['sesion_personal'])) {
    header("Location: ./sesion.php");
}

// Crear una conexión
$con = mysqli_connect($db_hostname, $db_username, $db_password, $db_name);
    
// verificar connection con la BD
if (mysqli_connect_errno()) :
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
else:
    $arreglo_de_productos=[];
    $result = mysqli_query($con, "SELECT p.ID_producto,p.Fotos,p.Nombre,p.Precio,p.Cantidad_almacen,c.Cantidad_producto,c.ID_carrito FROM carrito_compras as c INNER JOIN productos as p ON c.Producto = p.ID_producto WHERE c.Usuario=".$_SESSION['sesion_personal']['id'].";");
    $n_productos=mysqli_num_rows($result);
    while ($row = mysqli_fetch_array($result)):
        array_push($arreglo_de_productos, array(
            "id_carrito"=>$row['ID_carrito'],
            "id"=>$row['ID_producto'],
            "imagen"=>$row['Fotos'],
            "nombre"=>$row['Nombre'],
            "precio"=>$row['Precio'],
            "disponibles"=>$row['Cantidad_almacen'],
            "cantidad"=>$row['Cantidad_producto'],
        ));
    endwhile;

    // cerrar conexión
    mysqli_close($con);
endif;
$suma=0;
$arreglo_para_comprar=array();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include "./head_html.php" ?>
    <title>Carrito de compras</title>
    <!--icono pestaña-->
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico"/>
    <!-- CSS -->
    <link rel="preload" href="../css/carrito.css" as="style">
    <link rel="stylesheet" href="../css/carrito.css">
    <!-- JS -->
    <script type="text/javascript" src="../js/Agrega_carrito.js"></script>
</head>

<body class="container">
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
                        <li class="active">
                            <a href="./"><span class="glyphicon glyphicon-shopping-cart"></span> Carrito de compras</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- fin barra de navegación -->

    <?php if ($n_productos==0): ?>
    <h1 class="h1">Tu carrito esta vacío</h1>
    <?php else: ?>
    <h1 class="h1">Carrito de compras</h1>
    <div class="table-responsive">
        <table class="table table-hover">
            <tr>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Disponibles</th>
                <th>Cantidad seleccionada</th>
                <th>Precio</th>
                <th>Total</th>
            </tr>

            <?php foreach ($arreglo_de_productos as $producto): 
            // [0]=
            array_push($arreglo_para_comprar,($producto["cantidad"].",".$producto["id"].""));
            ?>
            <tr>
                <td>
                    <img src="../img/productos/<?= $producto["imagen"] ?>" alt="producto <?= $producto["nombre"] ?>"
                        class="imagen">
                </td>
                <td>
                    <span class="texto-informativo"><?= $producto["nombre"] ?></span>
                </td>
                <td>
                    <span class="texto-informativo"><?= $producto["disponibles"] ?></span>
                </td>
                <td>
                    <div class="btn-group">
                        <a href="modificar_producto_carrito.php?signo=0&id_carrito=
                            <?=$producto['id_carrito']?>&disp=<?=$producto["disponibles"]?>&cant=
                            <?=$producto["cantidad"]?>" class="btn btn-default">-
                        </a>

                        <button type="submit" class="btn btn-default disabled"><?= $producto["cantidad"] ?></button>

                        <a href="modificar_producto_carrito.php?signo=1&
                            id_carrito=<?=$producto['id_carrito']?>&disp=<?=$producto["disponibles"]?>
                            &cant=<?=$producto["cantidad"]?>" class="btn btn-default">
                            +
                        </a>
                    </div>
                </td>
                <td>
                    <span class="texto-informativo">$<?= number_format(floatval($producto["precio"]), 2, '.', ',') ?></span>
                </td>
                <td>
                    <span class="texto-informativo">
                        $<?= number_format(floatval(floatval($producto["precio"])*((int) $producto["cantidad"])), 2, '.', ',') ?>
                    </span>
                </td>
            </tr>
            <?php $suma+=floatval(floatval($producto["precio"])*((int) $producto["cantidad"])); ?>
            <?php endforeach; ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <th>Total</th>
                <td>$<?= number_format(floatval(floatval($suma)), 2, '.', ',') ?></td>
            </tr>
        </table>
    </div>
    <script>
    var arreglo_de_productos = JSON.parse('<?= json_encode($arreglo_para_comprar); ?>');
    </script>
    <div class="posiciona-botones">
        <a href="vaciar_carrito.php"><input type="submit" class="btn btn-default boton" value="Vaciar carrito"></a>
        <input type="submit" class="btn btn-default boton" value="Comprar todo"
            onclick="enviar_a_comprar_muchos(arreglo_de_productos)">
    </div>
    <?php endif ?>
</body>

</html>