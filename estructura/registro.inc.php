<?php
    if (isset($_SESSION["erroresRegistro"])) {
        $erroresRegistro = $_SESSION["erroresRegistro"];
        unset($_SESSION["erroresRegistro"]);
    } else {
        $erroresRegistro = array(
            "nombre" => false,
            "primerApellido" => false,
            "segundoApellido" => false,
            "usuario" => false,
            "email" => false,
            "password" => false,
        );
    }
?>

<section class="registro-container">
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
        <?php if (isset($erroresRegistro["nombre"]) && $erroresRegistro["nombre"] == true) { ?>
            <p style="color: red;">Nombre Incorrecto</p>
        <?php } ?>
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" value="<?php if (isset($nombre))
            echo $nombre; ?>"><br>
        <?php if (isset($erroresRegistro["primerApellido"]) && $erroresRegistro["primerApellido"] == true) { ?>
            <p style="color: red;">Primer Apellido Incorrecto</p>
        <?php } ?>
        <label for="primerApellido">Primer Apellido</label>
        <input type="text" id="primerApellido" name="primerApellido" value="<?php if (isset($primerApellido))
            echo $primerApellido; ?>"><br>
        <?php if (isset($erroresRegistro["segundoApellido"]) && $erroresRegistro["segundoApellido"] == true) { ?>
            <p style="color: red;">Segundo Apellido Incorrecto</p>
        <?php } ?>
        <label for="segundoApellido">Segundo Apellido</label>
        <input type="text" id="segundoApellido" name="segundoApellido" value="<?php if (isset($segundoApellido))
            echo $segundoApellido; ?>"><br>
        <?php if (isset($erroresRegistro["usuario"]) && $erroresRegistro["usuario"] == true) { ?>
            <p style="color: red;">Usuario ya existe</p>
        <?php } ?>
        <label for="usuario">Escribe tu usuario</label>
        <input type="text" id="usuario" name="usuario" value="<?php if (isset($usuario))
            echo $usuario; ?>"><br>
        <?php if (isset($erroresRegistro["email"]) && $erroresRegistro["email"] == true) { ?>
            <p style="color: red;">El Correo ya existe o es Incorrecto</p>
        <?php } ?>
        <label for="email">Escribe tu Correo electornico</label>
        <input type="email" id="email" name="email" value="<?php if (isset($email))
            echo $email; ?>"><br>

        <?php if (isset($erroresRegistro["password"]) && $erroresRegistro["password"] == true) { ?>
            <p style="color: red;">Contraseña no válida (min 8 Caracteres y una Mayúscula)</p>
        <?php } ?>
        <label for="password">Escribe tu contraseña</label>
        <input type="password" id="password" name="password"><br>
        <input type="submit" id="guardar" name="guardar" value="Guardar" class="btn-generico">
            <input type="submit" id="irlogin" name="irlogin" value="Volver"  onclick="window.location.href = '<?php echo $_SERVER["PHP_SELF"]; ?>';" class="btn-generico">
        </form>
</section>