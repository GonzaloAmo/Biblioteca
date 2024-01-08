<?php
    if (isset($_SESSION["erroresLibro"])) {
        $erroresLibro = $_SESSION["erroresLibro"];
        unset($_SESSION["erroresLibro"]);
    } else {
        $erroresLibro = array(
            "errIsbn" => false,
            "errTitulo" => false,
            "errAutor" => false,
            "errEditorial" => false,
            "errUrl" => false,
        );
    }
?>

<section class="section_generico">
    <p>Bienvenid@:
        <?php echo $_SESSION["usuario"]; ?>
    </p>
    <p>Tu rol es:
        <?php echo $_SESSION["rol"] ?>
    </p>
    <?php
        $Usuario = $_SESSION["usuario"];
        if($_SESSION["rol"] === "LECTOR"){
            mostrarLibrosReservados($Usuario);
        }else{
            ?>
                <h2>Modificar Usuarios</h2>
                <?php
                    if(isset($_SESSION["errorUsuario"])){
                        if($_SESSION["errorUsuario"]){
                            ?>
                            <p style="color: red; font-weight: bold;">No se ha encontrado el usuario</p>
                            <?php
                        }else{
                            ?>
                            <p style="color: green; font-weight: bold;">Usuario modificado correctamente</p>
                            <?php
                        }
                    }
                ?>
                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                    <label for="antiguoUsuario">Escribe el usuario que quieres modificar</label>
                    <input type="text" id="antiguoUsuario" name="antiguoUsuario" required>
                    <br>
                    <label for="nuevoUsuario">Escribe el nuevo nombre de usuario</label>
                    <input type="text" id="nuevoUsuario" name="nuevoUsuario">

                    <label for="nuevoEmail">Escribe el nuevo email</label>
                    <input type="email" id="nuevoEmail" name="nuevoEmail">

                    <label for="rol">Escribe el rol</label>
                    <select id="rol" name="rol" required>
                        <option value="LECTOR">Lector</option>
                        <option value="ADMIN">Admin</option>
                    </select>
                    <br><br>
                    <input type="submit" id="modificar" name="modificar" value="Modificar" class="btn-generico">
                    <input type="submit" id="eliminar" name="eliminar" value="Eliminar" class="btn-eliminar">
                    <input type="submit" id="activar" name="activar" value="Activar" class="btn-generico">
                </form>
                
                <h2>Añadir Libros</h2>
                <?php
                    if(isset($_SESSION["errorLibro"])){
                        if($_SESSION["errorLibro"]){
                            ?>
                            <p style="color: red; font-weight: bold;">Error al Modificar el libro</p>
                            <?php
                        }else{
                            ?>
                            <p style="color: green; font-weight: bold;">Libro Modificado correctamente</p>
                            <?php
                        }
                    }
                ?>
                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
                    <?php if(isset($erroresLibro["errIsbn"]) && $erroresLibro["errIsbn"]){ ?>
                        <p style="color: red;">ISBN Incorrecto</p>
                    <?php } ?>
                    <label for="isbn">ISBN</label>
                    <input type="text" id="isbn" name="isbn" required>
                    <?php if (isset($erroresLibro["errTitulo"]) && $erroresLibro["errTitulo"]) { ?>
		                <p style="color: red;">Titulo Incorrecto</p>
	                <?php } ?>
                    <label for="titulo">Título</label>
                    <input type="text" id="titulo" name="titulo">
                    <?php if (isset($erroresLibro["errAutor"]) && $erroresLibro["errAutor"]) { ?>
		                <p style="color: red;">Autor Incorrecto</p>
	                <?php } ?>
                    <label for="autor">Autor</label>
                    <input type="text" id="autor" name="autor">
                    <?php if (isset($erroresLibro["errEditorial"]) && $erroresLibro["errEditorial"]) { ?>
		                <p style="color: red;">Editorial Incorrecto</p>
	                <?php } ?>
                    <label for="editorial">Editorial</label>
                    <input type="text" id="editorial" name="editorial">
                    <?php if (isset($erroresLibro["errUrl"]) && $erroresLibro["errUrl"]) { ?>
		                <p style="color: red;">Imagen Incorrecto</p>
	                <?php }  ?>
                    <label for="imagen">Imagen</label>
                    <input type="file" id="imagen" name="imagen" accept="image/*">
                    <br><br>
                    <input type="submit" id="aniadir" name="aniadir" value="Añadir" class="btn-generico">
                    <input type="submit" id="eliminar_libro" name="eliminar_libro" value="Eliminar Libro" class="btn-eliminar">
                    <input type="submit" id="activar_libro" name="activar_libro" value="Activar" class="btn-generico">
                </form>
                
            <?php
        }
    ?>
    

    <a href="<?php echo $_SERVER["PHP_SELF"] . "?ruta=logout"; ?>">Cerrar sesión</a>
</section>