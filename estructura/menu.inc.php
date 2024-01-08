<nav>
    <?php
    if (isset($_SESSION["usuario"])) {
        ?>
        <a <?php if ($_SESSION["rol"] == "ADMIN") {echo 'class="admin"';} ?> href="?ruta=perfil">
            <?php echo $_SESSION["usuario"] ?>
        </a>
        <a href="?ruta=libros">Libros</a>
        <a class="cerrarSesion" href="?ruta=logout">Cerrar Sesion</a>
        <a class="buscadorProfesional" href="?ruta=buscadorProfesional">Búsqueda Avanzada</a>
        <form action="?ruta=libros" method="post">
            <input type="text" name="busqueda" class="buscador" placeholder="Buscar por título">
            <input type="submit" name="btn_buscar" value="Buscar" class="btn-generico">
        </form>
        <?php
    }
    ?>
</nav>