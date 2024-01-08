<?php
function conectarse()
{
    $host = "localhost";
    $usuario = "HOST";
    $password = "HOST";
    $nombreBD = "proyecto";
    $mysqli = new mysqli($host, $usuario, $password, $nombreBD);
    if (mysqli_connect_errno()) {
        echo "Fallo al conectar a MySQL: " . mysqli_connect_error();
    } else {

    }
    return $mysqli;
}
function detectareserva($idlibro){
    $mysqli = conectarse();
    $consulta1 = $mysqli->query("SELECT COUNT(*) FROM prestamo WHERE ID_Libro='$idlibro'");
    if(mysqli_fetch_row($consulta1)[0] > 0){
        $consulta2 = $mysqli->query("SELECT COUNT(*) FROM prestamo WHERE ID_Libro='$idlibro' AND ReservaActiva = 1");
        if (mysqli_fetch_row($consulta2)[0] > 0) {
            return true;
        } else {
            return false;
        }
    }else{
        return false;
    }
}

function recogeidUsuario($Usuario)
{
    $mysqli = conectarse();

    $Usuario = mysqli_real_escape_string($mysqli, $Usuario);

    $consulta = $mysqli->query("SELECT ID FROM Usuarios WHERE Nombre_Usuario = '$Usuario'");

    if (mysqli_num_rows($consulta) == 1) {
        $fila = mysqli_fetch_assoc($consulta);
        return $fila['ID'];
    }
    return false;
}

function detectaemail($email)
{
    $mysqli = conectarse();
    $consulta = $mysqli->query("SELECT COUNT(*) FROM Usuarios WHERE Correo_Electronico='$email'");
    if (mysqli_fetch_row($consulta)[0] > 0) {
        return true;
    }
    ;
}

function detectausuarios($usuario)
{
    $mysqli = conectarse();
    $consulta = $mysqli->query("SELECT COUNT(*) FROM Usuarios WHERE Nombre_Usuario='$usuario'");
    if (mysqli_fetch_row($consulta)[0] > 0) {
        return true;
    }
    ;
}


function anadirusuario($nombre, $primerApellido, $segundoApellido, $usuario, $password, $email)
{
    $mysqli = conectarse();
    $contraseña_hash = password_hash($password, PASSWORD_BCRYPT);
    try {
        $query = "INSERT INTO Usuarios (Nombre, Apellido, Apellido2, Nombre_Usuario, Contrasenia, Correo_Electronico) VALUES ('$nombre', '$primerApellido', '$segundoApellido', '$usuario', '$contraseña_hash','$email' )";
        if ($mysqli->query($query)) {
            return true;
        } else {
            echo "Error: " . $mysqli->error;
            return false;
        }
    } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
        $mysqli->close();
        return false;
    }

}
function compruebalogin($usuario, $password){
    try {
        $mysqli = conectarse();
        if (detectausuarios($usuario)) {

            $consulta = $mysqli->query("SELECT Contrasenia FROM usuarios WHERE Nombre_Usuario = '$usuario'");
            $contra = mysqli_fetch_row($consulta)[0];

            if (password_verify($password, $contra)) {
                $mysqli->close();
                return true;
            } else {
                $mysqli->close();
                return false;
            }
        } else {
            return false;
        }
    } catch (e) {

    }
}
function compruebaAdmin($usuario, $password)
{
    $mysqli = conectarse();
    if (compruebalogin($usuario, $password)) {
        $consulta = $mysqli->query("SELECT Rol FROM usuarios WHERE Nombre_Usuario = '$usuario'");
        $rol = mysqli_fetch_row($consulta)[0];
        if ($rol === "LECTOR") {
            return false;
        } else if ($rol === "ADMIN") {
            return true;
        }
    }
}
function mostrarLibros($busqueda = null)
{
    $mysqli = conectarse();
    $sql = "SELECT ISBN, Titulo, Autor, Editorial, ID FROM libros WHERE Activo = 1";

    if ($busqueda) {
        $sql .= " AND Titulo LIKE '%$busqueda%'";
    }

    $result = mysqli_query($mysqli, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<table class='libros'>";
        echo "<tr><th>ISBN</th><th>Título</th><th>Autor</th><th>Editorial</th><th>Reservar</th></tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["ISBN"] . "</td>";
            echo "<td>" . $row["Titulo"] . "</td>";
            echo "<td>" . $row["Autor"] . "</td>";
            echo "<td>" . $row["Editorial"] . "</td>";
            if(!detectareserva($row["ID"])){
                echo "<td><button class='reservar-btn' onclick=\"location.href='?ruta=libro&id=" . $row["ID"] . "'\">Disponible</button></td>";
            } else {
                echo "<td><button class='reservado-btn' disabled>Reservado</button></td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron libros en la base de datos.";
    }
}
function muestraAllDatos($id)
{
    $mysqli = conectarse();
    $consulta = $mysqli->query("SELECT Titulo, Autor, Editorial, ISBN, URL FROM libros WHERE ID = '$id'");
        if ($fila = mysqli_fetch_assoc($consulta)) {
            return $fila;
        } else {
            return false;
        }
}
function muestraDatosReserva($id){
    $mysqli = conectarse();
    $consulta = $mysqli->query("SELECT Titulo, Autor, Editorial, ISBN, URL FROM libros WHERE ID = '$id'");
    if(detectareserva($id)){
        if ($fila = mysqli_fetch_assoc($consulta)) {
            return $fila;
        } else {
            return false;
        }
    }else{
        return false;
    }
}
function inserta_prestamo($id, $Usuario)
{
    $mysqli = conectarse();
    $id_Usu = recogeidUsuario($Usuario);

    try {
        $query = "INSERT INTO prestamo (ID_Usuario, ID_Libro, Inicio_Prestamo, Fin_Prestamo) VALUES ('$id_Usu', '$id', NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY))";
        $mysqli->query($query);
    } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
        $mysqli->close();
        return false;
    }
}
function LibrosPerfil($Usuario)
{
    $mysqli = conectarse();
    try {
        $idusu=recogeidUsuario($Usuario);
        $query = "SELECT ID_Libro FROM prestamo WHERE ID_Usuario='$idusu' AND ReservaActiva = 1";
        $result = $mysqli->query($query);
        return $result;  // Devuelve todos los libros reservados por el usuario
    } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
        $mysqli->close();
        return false;
    }
}
function mostrarLibrosReservados($Usuario) {
    $result = LibrosPerfil($Usuario);
    if($result-> num_rows <= 0) {
        echo "<h2>No hay libros reservados</h2>";
    } else {
        echo "<h2>Libros Reservados:</h2>";
    }
    while ($row = mysqli_fetch_assoc($result)) {
        $id_libro = $row['ID_Libro'];
        $datos = muestraDatosReserva($id_libro);
        echo "<div class='libro'>";
        echo "<p>Título: " . $datos["Titulo"] . "</p>";
        echo "<p>ISBN: " . $datos["ISBN"] . "</p>";
        echo "<p>Autor: " . $datos["Autor"] . "</p>";
        echo "<p>Editorial: " . $datos["Editorial"] . "</p>";
        echo "<button class='btn-verde' onclick=\"location.href='?ruta=devolucion&usuario=$Usuario&libro=$id_libro'\">Devolver</button>";
        echo "</div>";
    }
}
function devolverLibros($usuario,$idlibro){
    $mysqli = conectarse();
    $idusu=recogeidUsuario($usuario);
    $query = "UPDATE prestamo SET ReservaActiva = 0, Fin_Prestamo = NOW() WHERE ID_Usuario='$idusu' AND ID_Libro='$idlibro'";
    $mysqli->query($query);
}

function modificaUsuario($antiguoUsuario, $nuevoUsuario = null, $nuevoEmail = null, $rol = null){
    $mysqli = conectarse();
    if(detectausuarios($antiguoUsuario)){
        $idusu=recogeidUsuario($antiguoUsuario);
        $query = "UPDATE usuarios SET ";
        if($nuevoUsuario != null){
            $query .= "Nombre_Usuario = '$nuevoUsuario', ";
        }
        if($nuevoEmail != null){
            $query .= "Correo_Electronico = '$nuevoEmail', ";
        }
        if($rol != null){
            $query .= "Rol = '$rol', ";
        }
        $query = rtrim($query, ", ");
        $query .= " WHERE ID='$idusu'";
        $mysqli->query($query);
    }else{
        echo "No se ha encontrado el usuario";
    }
}
function eliminaUsuario($antiguoUsuario){
    $mysqli = conectarse();
    if($idusu=recogeidUsuario($antiguoUsuario)){
        $query = "UPDATE usuarios SET Activo = 0 WHERE ID='$idusu'";
        $mysqli->query($query);
        return true;
    }else{
        echo "No se ha encontrado el usuario";
        return false;
    }
}
function compruebaUsuarioActivo($Usuario){
    $mysqli = conectarse();
    if(detectausuarios($Usuario)){
        $idusu=recogeidUsuario($Usuario);
        $consulta = $mysqli->query("SELECT Activo FROM usuarios WHERE ID = '$idusu'");
        if(mysqli_fetch_row($consulta)[0] == 1){
            return true;
        }else{
            return false;
        }
    } 
}
function activaUsuario($Usuario){
    $mysqli = conectarse();
    if(!compruebaUsuarioActivo($Usuario)){
        $idusu=recogeidUsuario($Usuario);
        $query = "UPDATE usuarios SET Activo = 1 WHERE ID='$idusu'";
        $mysqli->query($query);
    }
}
function detectaUsuariosInactivos(){
    $mysqli=conectarse();
    $usuariosInactivos = $mysqli->query("SELECT ID FROM usuarios WHERE Activo = 0");
    if($usuariosInactivos->num_rows > 0){
        $consulta=$mysqli->query("SELECT ID_Libro FROM prestamo WHERE ReservaActiva = 1 AND WHERE ID_USUARIO=");
    }
}
function obtenerNombreUsuario($id_usuario){
    $mysqli = conectarse();
    $consulta = $mysqli->query("SELECT Nombre_Usuario FROM usuarios WHERE ID = '$id_usuario'");
    if ($fila = mysqli_fetch_assoc($consulta)) {
        return $fila['Nombre_Usuario'];
    } else {
        return false;
    }
}
function devolverLibrosUsuariosInactivos(){
    $mysqli = conectarse(); 
    $usuariosInactivos = $mysqli->query("SELECT ID FROM usuarios WHERE Activo = 0");
    if ($usuariosInactivos->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($usuariosInactivos)) {
            $id_usuario = $row['ID'];
            $libros_reservados = $mysqli->query("SELECT ID_Libro FROM prestamo WHERE ID_Usuario='$id_usuario' AND ReservaActiva = 1");
            while ($libro = mysqli_fetch_assoc($libros_reservados)) {
                $id_libro = $libro['ID_Libro'];
                $nombre_usuario = obtenerNombreUsuario($id_usuario);
                devolverLibros($nombre_usuario, $id_libro);
            }
        }
    }
}
function aniadirLibro($isbn, $titulo, $autor, $editorial, $imagen){
    $mysqli = conectarse();
    try {
        $query = "INSERT INTO libros (ISBN, Titulo, Autor, Editorial, URL) VALUES ('$isbn', '$titulo', '$autor', '$editorial', '$imagen')";
        $mysqli->query($query);
        return true;
    } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
        $mysqli->close();
        return false;
    }
}
function eliminarLibro($isbn){
    $mysqli = conectarse();
    try {
        $query = "UPDATE libros SET Activo = 0 WHERE ISBN='$isbn'";
        $mysqli->query($query);
        return true;
    } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
        $mysqli->close();
        return false;
    }
}
function compruebaLibrosDuplicados($isbn){
    $mysqli = conectarse();
    $consulta = $mysqli->query("SELECT COUNT(*) FROM libros WHERE ISBN='$isbn'");
    if(mysqli_fetch_row($consulta)[0] > 0){
        return true;
    }else{
        return false;
    }
}
function activarLibro($isbn){
    $mysqli = conectarse();
    try {
        $query = "UPDATE libros SET Activo = 1 WHERE ISBN='$isbn'";
        $mysqli->query($query);
        return true;
    } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
        $mysqli->close();
        return false;
    }
}
function muestraLibrosIsbn($isbn){
    $mysqli = conectarse();
    $consulta = $mysqli->query("SELECT Titulo, Autor, Editorial, ISBN, URL FROM libros WHERE ISBN = '$isbn'");
    if ($fila = mysqli_fetch_assoc($consulta)) {
        return $fila;
    } else {
        return false;
    }
}
function busquedaAvanzada($busqueda_isbn=null, $busqueda_titulo=null, $busqueda_autor=null, $busqueda_editorial=null){
    $mysqli = conectarse();
    if ($busqueda_isbn === null && $busqueda_titulo === null && $busqueda_autor === null && $busqueda_editorial === null) {
        return false;
    }
    $query = "SELECT * FROM libros WHERE 1=1";
    
    if ($busqueda_isbn !== null) {
        $query .= " AND ISBN = LIKE '%$busqueda_isbn%'";
    }
    if ($busqueda_titulo !== null) {
        $query .= " AND Titulo LIKE '%$busqueda_titulo%'";
    }
    
    if ($busqueda_autor !== null) {
        $query .= " AND Autor LIKE '%$busqueda_autor%'";
    }
    
    if ($busqueda_editorial !== null) {
        $query .= " AND Editorial LIKE '%$busqueda_editorial%'";
    }
    $result = $mysqli->query($query);
    
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $libro=muestraLibrosIsbn($row['ISBN']);
        }
    } else {
        echo "No se encontraron libros.";
    }
}
?>