<?php
require_once("./funcionesbdd/establecerconexion.php");
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $_SESSION["id_libro"] = $id;
    $datos = muestraAllDatos($id);
    if ($datos) {
        $ruta = $datos['URL'];
        ?>
        <div class="libro-container">
            <h1>
                <?php echo $datos['Titulo'] ?>
            </h1>
            <div class="libro-details">
                <div class="libro-image">
                    <img src="<?php echo "./img/" . $ruta ?>" alt="Portada" width="350" height="500">
                </div>
                <div class="libro-info">
                    <p><strong>ISBN:</strong>
                        <?php echo $datos['ISBN'] ?>
                    </p>
                    <p><strong>Autor:</strong>
                        <?php echo $datos['Autor'] ?>
                    </p>
                    <p><strong>Editorial:</strong>
                        <?php echo $datos['Editorial'] ?>
                    </p>
                </div>
            </div>
            <div class="libro-sinopsis">
                <h2>Sinopsis</h2>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam eget efficitur purus,
                    sed eleifend justo. Aenean vitae vestibulum est. Sed eget facilisis quam.
                </p>
            </div>
        </div>

        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" style="text-align: center;">
            <input type="submit" class="reservar-btn" id="confirmar" name="confirmar" value="Confirmar Reserva" style="margin: auto;">
        </form><br>
        <input type="button" class="btn-generico" id="volver" name="volver" value="Volver" onclick="window.location.href = '?ruta=libros';">
        <?php
    }
}
?>