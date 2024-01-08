<?php
require_once("./funcionesbdd/establecerconexion.php");
?>

<link rel="stylesheet" href="css/styles.css">
<h1>TODOS LOS LIBROS</h1>

<?php
if (isset($_POST["btn_buscar"])) {
    $busqueda = $_POST["busqueda"];
    mostrarLibros($busqueda);
} else {
    mostrarLibros();
}