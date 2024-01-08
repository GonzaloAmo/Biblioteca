<section class="login-container">
	<?php if (isset($errValidacion) && $errValidacion == true) { ?>
		<p style="color: red;">Usuario y/o contraseña incorrecta</p>
	<?php } ?>
	<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
		<?php if (isset($errUsuario) && $errUsuario == true) { 
			?>
				<p style="color: red;">Usuario no válido</p>
			<?php } ?>
		<label for="usuario">Escribe tu usuario </label>
		<input type="text" id="usuario" name="usuario" value="<?php if (isset($usuario))
			echo $usuario; ?>"><br>
		<?php if (isset($errPassword) && $errPassword == true) { ?>
			<p style="color: red;">Contraseña no válida</p>
		<?php } ?>
		<label for="password">Escribe tu contraseña </label>
		<input type="password" id="password" name="password"><br>
		<input type="submit" id="enviar" name="enviar" value="Entrar" class="btn-generico">
		<input type="submit" id="registro" name="registro" value="Registrar" class="btn-generico">
	</form>
</section>