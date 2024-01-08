<?php
session_start();
require_once("./funcionesbdd/establecerconexion.php");
//SI LE DAMOS A ENVIAR
if (isset($_POST["enviar"])) {
	//SI EL USUARIO EXSISTE Y NO ES VACÍO
	if (isset($_POST["usuario"]) && !empty($_POST["usuario"]) && compruebaUsuarioActivo($_POST["usuario"])) {
		$usuario = $_POST["usuario"];
		//ASIGNAMOS EL VALOR DE USUARIO A LA VARIABLE $USUARIO
	}
	//SINO LA VARIABLE ERROR USUARIO ES TRUE
	else {
		$errUsuario = true;
	}
	//SI LA CONTRASEÑA EXSISTE Y NO ESTÁ VACÍA
	if (isset($_POST["password"]) && !empty($_POST["password"])) {
		//ASIGNAMOS EL VALOR DE LA CONTRASÑA EN LA VARIABLE $PASSWORD
		$password = $_POST["password"];
	} else {
		//SINO EXSISTE LA CONTRASEÑA O ESTÁ VACÍA CREAMOS LA VARIABLE ERRPASSWORD Y LA ASIGNAMOS A TRUE
		$errPassword = true;
	}
	//CREAMOS VARIABLES PARA SIMULAR QUE ES LA BASE DE DATOS Y SON USUARIOS VÁLIDOS
	// SI EL USUARIO Y CONTRASEÑAS SON VALIDOS
	if (!isset($errUsuario) && !isset($errPassword) && compruebalogin($usuario, $password) 
			&& !compruebaAdmin($usuario, $password)) {
		// Asignamos la sesión del usuario al usuario logueado con rol estandar y enviamos a perfil
		$_SESSION["usuario"] = $usuario;
		$_SESSION["rol"] = "LECTOR";
		header("Location: " . $_SERVER["PHP_SELF"] . "?ruta=perfil");
		exit;
	} else if (!isset($errUsuario) && !isset($errPassword)&&compruebalogin($usuario, $password) 
			&& compruebaAdmin($usuario, $password)) {
		$_SESSION["usuario"] = $usuario;
		$_SESSION["rol"] = "ADMIN";
		header("Location: " . $_SERVER["PHP_SELF"] . "?ruta=perfil");
		exit;
	} else {
		$errValidacion = true;
	}
} else if (isset($_POST["registro"])) {
	header("Location: " . $_SERVER["PHP_SELF"] . "?ruta=registro");
}
// SI LE DAMOS A Guardar
if (isset($_POST["guardar"])) {
    if (isset($_POST["nombre"]) && !empty($_POST["nombre"]) && preg_match('/^[a-zA-Z\s]+$/', $_POST["nombre"])) {
        $nombre = $_POST["nombre"];
    } else {
        $errNombre = true;
    }

    if (isset($_POST["primerApellido"]) && !empty($_POST["primerApellido"]) && preg_match('/^[a-zA-Z\s]+$/', $_POST["primerApellido"])) {
        $primerApellido = $_POST["primerApellido"];
    } else {
        $errPrimerApe = true;
    }

    if (isset($_POST["segundoApellido"]) && !empty($_POST["segundoApellido"]) && preg_match('/^[a-zA-Z\s]+$/', $_POST["segundoApellido"])) {
        $segundoApellido = $_POST["segundoApellido"];
    } else {
        $errSegundoApe = true;
    }

    if (isset($_POST["usuario"]) && !empty($_POST["usuario"]) && !detectausuarios($_POST["usuario"]) && preg_match('/^[a-zA-Z0-9]+$/', $_POST["usuario"])) {
        $usuario = $_POST["usuario"];
    } else {
        $errUsuario = true;
    }

    if (isset($_POST["email"]) && !empty($_POST["email"]) && !detectaemail($_POST["email"])) {
        $email = $_POST["email"];
    } else {
        $errEmail = true;
    }

    if (isset($_POST["password"]) && !empty($_POST["password"]) && preg_match('/^(?=.*[A-Z]).{8,}$/', $_POST["password"])) {
        $password = $_POST["password"];
    } else {
        $errPassw = true;
    }
	$_SESSION["erroresRegistro"] = array(
		"nombre" => $errNombre,
		"primerApellido" => $errPrimerApe,
		"segundoApellido" => $errSegundoApe,
		"usuario" => $errUsuario,
		"email" => $errEmail,
		"password" => $errPassw,
	);
	if ($errNombre || $errPrimerApe || $errSegundoApe || $errUsuario || $errEmail || $errPassw) {
        header("Location: " . $_SERVER["PHP_SELF"] . "?ruta=registro");
    } else {
		if(anadirusuario($nombre, $primerApellido, $segundoApellido, $usuario, $password, $email)){
			$_SESSION["usuario"] = $usuario;
			$_SESSION["rol"] = "LECTOR";
			header("Location: " . $_SERVER["PHP_SELF"] . "?ruta=libros");
		}else{
			echo "ERROR";
		}
		
	}
}
if(isset($_POST["confirmar"])) {
	inserta_prestamo($_SESSION["id_libro"],$_SESSION["usuario"]);
	header("Location: " . $_SERVER["PHP_SELF"] . "?ruta=libros");
}
if(isset($_POST["modificar"])){
	$antiguoUsuario = $_POST["antiguoUsuario"];
	if(detectausuarios($antiguoUsuario)){
		$_SESSION["errorUsuario"] = false;
		$nuevoUsuario = isset($_POST["nuevoUsuario"]) ? $_POST["nuevoUsuario"] : null;
		$nuevoEmail = isset($_POST["nuevoEmail"]) ? $_POST["nuevoEmail"] : null;
		$rol = isset($_POST["rol"]) ? $_POST["rol"] : null;
		modificaUsuario($antiguoUsuario, $nuevoUsuario, $nuevoEmail, $rol);
		header("Location: " . $_SERVER["PHP_SELF"] . "?ruta=perfil");
		$_SESSION["errorUsuario"] = false;
	}else{
		$_SESSION["errorUsuario"] = true;
		header("Location: " . $_SERVER["PHP_SELF"] . "?ruta=perfil");
	}
}
if(isset($_POST["eliminar"])){
	$antiguoUsuario = $_POST["antiguoUsuario"];
	if(detectausuarios($antiguoUsuario)){
		eliminaUsuario($antiguoUsuario);
		devolverLibrosUsuariosInactivos();
		$_SESSION["errorUsuario"] = false;
		header("Location: " . $_SERVER["PHP_SELF"] . "?ruta=perfil");
	}else{
		$_SESSION["errorUsuario"] = true;
		header("Location: " . $_SERVER["PHP_SELF"] . "?ruta=perfil");
	}
}
if(isset($_POST["activar"])){
	$antiguoUsuario = $_POST["antiguoUsuario"];
	if(detectausuarios($antiguoUsuario)){
		activaUsuario($antiguoUsuario);
		header("Location: " . $_SERVER["PHP_SELF"] . "?ruta=perfil");
		$_SESSION["errorUsuario"] = false;
	}else{
		$_SESSION["errorUsuario"] = true;
		header("Location: " . $_SERVER["PHP_SELF"] . "?ruta=perfil");
	}
}
if(isset($_POST["aniadir"])){
	if (isset($_POST["isbn"]) && preg_match('/^9780\d{9}$/', trim($_POST["isbn"]))) {
		$isbn = $_POST["isbn"];
	} else {
		$errIsbn = true;
	}
	if (isset($_POST["titulo"]) && !empty($_POST["titulo"])&& preg_match('/^[a-zA-Z\s]+$/', $_POST["autor"])) {
		$titulo = $_POST["titulo"];
	}else{
		$errTitulo = true;
	}
	if (isset($_POST["autor"]) && !empty($_POST["autor"])) {
		$autor = $_POST["autor"];
	}else{
		$errAutor = true;
	}
	if (isset($_POST["editorial"]) && !empty($_POST["editorial"])) {
		$editorial = $_POST["editorial"];
	}else{
		$errEditorial = true;
	}
	if (isset($_FILES["imagen"]["name"]) && !empty($_FILES["imagen"]["name"])) {
		$url = $_FILES["imagen"]["name"];
	}else{
		$errUrl = true;
	}
	$_SESSION["erroresLibro"] = array(
        "errIsbn" => $errIsbn,
        "errTitulo" => $errTitulo,
        "errAutor" => $errAutor,
        "errEditorial" => $errEditorial,
        "errUrl" => $errUrl,
    );

	if(isset($isbn,$titulo,$autor,$editorial,$url)){
	 	if(!compruebaLibrosDuplicados($isbn) && aniadirLibro($isbn, $titulo, $autor, $editorial, $url)){
			if(isset($_SESSION["errorLibro"])){
				$_SESSION["errorLibro"] = false;
			}
			header("Location: " . $_SERVER["PHP_SELF"] . "?ruta=perfil");
		}else{
			$_SESSION["errorLibro"] = true;
			header("Location: " . $_SERVER["PHP_SELF"] . "?ruta=perfil");
		}
	}else{
		header("Location: " . $_SERVER["PHP_SELF"] . "?ruta=perfil");
		$_SESSION["errorLibro"] = true;	
	}
}
if(isset($_POST["eliminar_libro"])){
	$isbn = $_POST["isbn"];
	if(eliminarLibro($isbn)&&compruebaLibrosDuplicados($isbn)){
		if(isset($_SESSION["errorLibro"])){
			$_SESSION["errorLibro"] = false;
		}
		header("Location: " . $_SERVER["PHP_SELF"] . "?ruta=perfil");
	}else{
		$_SESSION["errorLibro"] = true;
		header("Location: " . $_SERVER["PHP_SELF"] . "?ruta=perfil");
	}
}
if(isset($_POST["activar_libro"])){
	$isbn=$_POST["isbn"];
	if(activarLibro($isbn)&&compruebaLibrosDuplicados($isbn)){
		if(isset($_SESSION["errorLibro"])){
			$_SESSION["errorLibro"] = false;
		}
		header("Location: " . $_SERVER["PHP_SELF"] . "?ruta=perfil");

	}else{
		$_SESSION["errorLibro"] = true;
		header("Location: " . $_SERVER["PHP_SELF"] . "?ruta=perfil");
	}
}
if(isset($_POST["btn_buscar_Prof"])){
	if(isset($_POST["busqueda_isbn"])&&!empty($_POST["busqueda_isbn"])){
		$isbn=$_POST["busqueda_isbn"];
	}else
		$isbn=null;
	if(isset($_POST["busqueda_titulo"])&&!empty($_POST["busqueda_titulo"])){
		$titulo=$_POST["busqueda_titulo"];
	}else
		$titulo=null;
	if(isset($_POST["busqueda_autor"])&&!empty($_POST["busqueda_autor"])){
		$autor=$_POST["busqueda_autor"];
	}else 
		$autor=null;
	if(isset($_POST["busqueda_editorial"])&&!empty($_POST["busqueda_editorial"])){
		$editorial=$_POST["busqueda_editorial"];
	}else
		$editorial=null;

	$abc=busquedaAvanzada($isbn,$titulo,$autor,$editorial);
	echo var_dump($abc);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<title>Biblioteca</title>
</head>

<body>
	<?php include_once "estructura/cabecera.inc.php"; ?>
	<?php include_once "estructura/menu.inc.php"; ?>
	<?php
	if ((empty($_GET)) && (!isset($_SESSION["usuario"]))) {
		include_once "estructura/login.inc.php";
	} else if (isset($_GET["ruta"]) && ($_GET["ruta"] == "registro")) {
		include_once "estructura/registro.inc.php";
	} else if (isset($_SESSION["usuario"])) {
	 	if (isset($_GET["ruta"]) && ($_GET["ruta"] == "perfil")) {
			include_once "estructura/perfil.inc.php";
		} else if (isset($_GET["ruta"]) && ($_GET["ruta"] == "logout")) {
			include_once "estructura/logout.inc.php";
		}else if (isset($_GET["ruta"]) && ($_GET["ruta"] == "libros")) {
			include_once "estructura/libros.inc.php";
		}else if (isset($_GET["ruta"]) && ($_GET["ruta"] == "libro") && isset($_GET["id"])) {
			include_once "estructura/libro.inc.php";
		}else if(isset($_GET["ruta"]) && ($_GET["ruta"] == "devolucion")){
			include_once "estructura/devolucion.inc.php";
		}else if(isset($_GET["ruta"]) && ($_GET["ruta"] == "buscadorProfesional")){
			include_once "estructura/buscadorProfesional.inc.php";
		}
	}
	?>
	<?php include_once "estructura/pie.inc.php"; ?>
</body>

</html>