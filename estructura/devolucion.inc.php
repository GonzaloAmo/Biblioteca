<?php
require_once("./funcionesbdd/establecerconexion.php");
$usuario=$_GET["usuario"];
$libro=$_GET["libro"];
echo $usuario.$libro;
devolverLibros($usuario,$libro);
header("Location: ?ruta=perfil");
?>