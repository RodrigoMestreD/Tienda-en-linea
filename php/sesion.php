<?php
require_once("./config_BD.php");
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include "./head_html.php" ?>
    <title>Inicio de sesión</title>
    <!-- icono -->
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico"/>
    <!-- CSS -->
    <link rel="preload" href="./../css/sesion_y_registro.css" as="style">
    <link rel="stylesheet" href="./../css/sesion_y_registro.css">
    <link rel="preload" href="./css/estilo_generico.css" as="style">
    <link rel="stylesheet" href="./css/estilo_generico.css">
    
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
                    <a class="navbar-brand" href="./../index.php">E-Store</a>
                </div>

                <div class="collapse navbar-collapse" id="myNavbar">
                    <!-- menú derecho -->
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="./registro.php"><span class="glyphicon glyphicon-user"></span>Registrarse
                            </a>
                        </li>
                        <li class="active">
                            <a href="#"><span class="glyphicon glyphicon-log-in"></span>Ingresar</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- ingreso de datos -->

    <!-- validacion -->
    <?php
    include "./valida_usuario.php";
    ?>
    <!-- formulario -->
    <div class="centrar">
        <h1 style="text-align:center; margin:0">Inicio de sesión</h1>
        <form class="form form-horizontal" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="form-group">
                <label for="nombre" class="control-label">Nombre de usuario: <span class="error"><?php echo $nombreErr?></span></label>
                <div class="input-group">
                    <div class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                    </div>
                    <input type="text" name="nombre" class="form-control" autocomplete="username" value="<?= $nombre?>">
                </div>
            </div>
            <div class="form-group">
                <label for="contrasena" class="control-label">Contraseña <span class="error"><?php echo $contraseñaErr?></span></label>
                <div class="input-group">
                    <div class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></div>
                <input type="password" class="form-control" name="contrasena" placeholder="Password" autocomplete="password" value="<?php echo $contraseña?>">
                </div>
            </div>
            <p class="no-registrado">¿Aún no tienes cuenta? <a class="btn-link" href="./registro.php">Registrate</a></p>
            <div class="form-group boton">
                <input type="submit" class="btn btn-default comprar" value="Inicia sesión"></input>
            </div>
        </form>
    </div>
</body>

</html>