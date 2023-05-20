
<!DOCTYPE html>
<html lang="es">
  <?php
    require_once("./config_BD.php");
    session_start();
  ?>
  <head>
    <?php include "./head_html.php" ?>
    <title>Registro</title>
    <!-- icono -->
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico"/>
    <!-- CSS -->
    <link rel="preload" href="../css/sesion_y_registro.css" as="style">
    <link rel="stylesheet" href="../css/sesion_y_registro.css">
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
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-tarPOST="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- marca -->
                    <a class="navbar-brand" href="./../index.php">E-Store</a>
                </div>
                <div class="collapse navbar-collapse" name="myNavbar">
                    <!-- menú derecho -->
                    <ul class="nav navbar-nav navbar-right">
                        <li class="active">
                            <a href="#"><span class="glyphicon glyphicon-user"></span>Registrarse</a>
                        </li>
                        <li>
                            <a href="./sesion.php"><span class="glyphicon glyphicon-log-in"></span>Ingresar</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- validación de datos -->
    <?php
    include "./valida_registro.php";
    ?>

    <!-- contenedor de formulario -->
    <div class="centrar">
        <h1 style="text-align:center; margin:0">Registra un nuevo usuario</h1>
        <!-- form -->
        <form class="form form-horizontal" method="POST" action="<?= htmlspecialchars($_SERVER["PHP_SELF"])?>">
            <!-- preguntas inicio -->
            <div class="form-group">
                <label for="nombre" class="control-label">Nombre de usuario: <span class="error"><?php echo $nombreErr?></span></label>
                <div class="input-group">
                    <div class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                    </div>
                    <input type="text" name="nombre" class="form-control" value="<?php echo $nombre?>">
                </div>
            </div>
            <div class="form-group">
                <label for="contrasena" class="control-label">Contraseña: <span class="error"><?php echo $contraseñaErr?></span></label>
                <div class="input-group">
                    <div class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
                    </div>
                    <input type="password" name="contrasena" class="form-control" value="<?php echo $contraseña?>">
                </div>
            </div>
            <div class="form-group">
                <label for="fnac" class="control-label">Fecha de nacimiento: <span class="error"><?php echo $fecha_nacimientoErr?></span></label>
                <div class="input-group">
                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></div>
                    <input type="date" name="fnac" class="form-control" value="<?php echo $fecha_nacimiento?>" max="2004-05-03">
                </div>
            </div>
            <div class="form-group">
                <label for="correo" class="control-label">Correo: <span class="error"><?php echo $correoErr?></span></label>
                <div class="input-group">
                    <div class="input-group-addon"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                    </div>
                    <input type="email" name="correo" class="form-control" autocomplete="email" value="<?php echo $correo?>">
                </div>
            </div>
            <div class="form-group">
                <label for="numero_tarjeta" class="control-label">Número de tarjeta: <span class="error"><?php echo $num_tarjetaErr?></span></label>
                <div class="input-group">
                    <div class="input-group-addon"><span class="glyphicon glyphicon-tags" aria-hidden="true"></div>
                    <input type="text" name="numero_tarjeta" class="form-control" value="<?php echo $num_tarjeta?>">
                </div>
            </div>
            <div class="form-group">
                <label for="direccion" class="control-label">Dirección: <span class="error"><?php echo $direccionErr?></span></label>
                <div class="input-group">
                    <div class="input-group-addon"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>
                    </div>
                    <input type="text" name="direccion" class="form-control" autocomplete="address-level1" value="<?php echo $direccion?>">
                </div>
            </div>
            
            <p class="no-registrado">¿Ya tienes cuenta? <a class="btn-link" href="./sesion.php">Inicia sesión</a></p>
            <div class="form-group boton">
                <input type="submit" class="btn btn-default comprar" value="Registrarse"></input>
            </div>
        </form>
    </div>
  </body>
</html>