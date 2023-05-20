<?php
require_once("./config_BD.php");
session_start();

if(!isset($_SESSION['sesion_personal'])){
    header("Location: ./sesion.php");
}
$id_usuario=$_SESSION['sesion_personal']['id'];
$nombre_usuario=$_SESSION['sesion_personal']['nombre'];

// Creación de la lista del información del usuario
$con = mysqli_connect($db_hostname, $db_username, $db_password, $db_name);
// verificar connection con la BD
if (mysqli_connect_errno()) :
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
else:
    $usuario=[];
    $result = mysqli_query($con, "SELECT * FROM usuarios WHERE ID_usuario=".$id_usuario.";");
    while ($row = mysqli_fetch_array($result)):
        array_push($usuario, array(
            "correo"=>$row['Correo'],
            "contraseña"=>$row['Contraseña'],
            "fecha_nac"=>$row['Fecha_nacimiento'],
            "num_tarjeta"=>$row['Num_tarjeta_bancaria'],
            "direccion"=>$row['Direccion_postal'],
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
    <!--CSS-->
    <link rel="preload" href="../css/perfil.css" as="style">
    <link rel="stylesheet" href="../css/perfil.css">
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
                        <li class="navbar-text quita_margen">
                            <a href="./perfil.php" class="navbar-link">
                                Usuario:  
                                <u><?=$_SESSION['sesion_personal']['nombre']?></u>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="./cerrar_sesion.php"><span class="glyphicon glyphicon-log-out"></span> Cerrar sesión</a>
                        </li>
                        <li>
                            <a href="./carrito.php"><span class="glyphicon glyphicon-shopping-cart"></span> Carrito de compras</a>
                        </li>
                    </ul>
                    
                </div>
            </div>
        </nav>
    </header>

<body class="container">
    <h1>Perfil del usuario</h1>
    <div class="padre">
        <section>
            <p><b>Nombre:</b> <?= $nombre_usuario;?></p>
            <p><b>Correo:</b> <?= $usuario[0]['correo'];?></p>
            <p><b>Contraseña:</b> <?= $usuario[0]['contraseña'];?></p>
            <p><b>Fecha de nacimiento:</b> <?= $usuario[0]['fecha_nac'];?></p>
            <p><b>Dirección:</b> <?= $usuario[0]['direccion'];?></p>
            <p><b>Número de tarjeta bancaria:</b> <?= $usuario[0]['num_tarjeta'];?></p>
        </section>
        
    </div>
    <a href="historial_compras.php"><input type="submit" class="btn btn-default boton"
            value="Historial de compras "></a>
</body>

</html>