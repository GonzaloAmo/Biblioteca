<?php
//eliminamos las variables de sesión
session_unset();
//eliminamos la sesión
session_destroy();
//redireccionamos a index
header("Location: index.php");
exit;
?>