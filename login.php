<?php

require_once("libraries/password_compatibility_library.php");
require_once("config/db.php");
require_once("classes/Login.php");

$login = new Login();

if ($login->isUserLoggedIn() == true) 
	{
		header("location: home.php");
	} 
else 
{

?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>DigiScape | Login</title>
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
		<link href="css/login.css" type="text/css" rel="stylesheet" media="screen,projection"/>
	</head>
	<body>
		<div class="container">
			<div class="card card-container">
				<img id="profile-img" class="profile-img-card" src="img/avatar_2x.png" />
				<p id="profile-name" class="profile-name-card"></p>
				<form method="post" accept-charset="utf-8" action="login.php" name="loginform" autocomplete="off" role="form" class="form-signin">
					<?php
						// show potential errors / feedback (from login object)
						if (isset($login)) {
							if ($login->errors) {
					?>
					<div class="alert alert-danger alert-dismissible" role="alert">
						<strong>Error!</strong>
						
						<?php
						foreach ($login->errors as $error) {
							echo $error;
						}
						?>
					</div>
					<?php
					}
					if ($login->messages) {
					?>
					<div class="alert alert-success alert-dismissible" role="alert">
						<strong>Aviso!</strong>
						<?php
						foreach ($login->messages as $message) {
							echo $message;
						}
						?>
					</div>
					<?php
					}
					}
					?>
					<span id="reauth-email" class="reauth-email"></span>
					<input class="form-control" placeholder="Usuario o Email" name="user_name" type="text" value="" autofocus="" required>
					<input class="form-control" placeholder="Contraseña" name="user_password" type="password" value="" autocomplete="off" required>
					<button type="submit" class="btn btn-lg btn-success btn-block btn-signin" name="login" id="submit">Iniciar Sesión</button>
					
					<button type="button" class="btn btn-lg btn-dark btn-block btn-signin" data-toggle="modal" data-target="#modalRegistro" href="#">Registrarse</button>


					<p class="statusMsg"></p>


				</form>
			</div>
		</div>
		

		<!-- MODAL REGISTRO -->
		<div class="modal fade" id="modalRegistro" tabindex="-1" role="dialog" aria-labelledby="NuevoRegistro" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabeel">Registro</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form method="post" action="recibeNuevoRegistro.php" enctype="multipart/form-data" id="formNuevoRegistro">
						<div class="modal-body">
							
							<!-- <p class="statusMsg"></p> -->
							<div class="form-group">
								<label for="firstname">Nombres</label>
								<input type="text" class="form-control" id="firstname" name="firstname" placeholder="Nombres" required>
							</div>
							<div class="form-group">
								<label for="lastname">Apellidos</label>
								<input type="text" class="form-control" id="lastname" name="lastname" placeholder="Apellidos" required>
							</div>
							<div class="form-group">
								<label for="user_name">Usuario</label>
								<input type="text" class="form-control" id="user_name" name="user_name" placeholder="Usuario" required>
								<small id="userHelp" class="form-text text-muted">Recuerde que su username lo utilizará para iniciar sesión</small>
							</div>
							
							<div class="form-group">
								<label for="user_email">Email</label>
								<input type="email" class="form-control" id="user_email" name="user_email" aria-describedby="emailHelp" placeholder="Ingrese su Email" required>
								
							</div>
							<div class="form-group">
								<label for="user_password_new">Password</label>
								<input type="password" class="form-control" id="user_password_new" name="user_password_new" placeholder="Password" pattern=".{6,}" required>
							</div>
							<div class="form-group">
								<label for="user_password_repeat">Repite Password</label>
								<input type="password" class="form-control" id="user_password_repeat" name="user_password_repeat" placeholder="Repite Password" pattern=".{6,}" required>
							</div>
							
							
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
							<button type="submit" class="btn btn-primary" id="btnNewUser">Guardar Cambios</button>
						</div>
					</form>
				</div>
			</div>
		</div>


		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

		<!-- AJAX REGISTRO -->
		<script type="text/javascript">
			$(document).ready(function() {
			$("#formNuevoRegistro").on('submit', function(e){
				$('.statusMsg').html('');
				e.preventDefault();
				$.ajax({
						type: 'POST',
						url: 'recibeNuevoRegistro.php',
						data: new FormData(this),
						contentType: false,
						cache: false,
						processData:false,
						beforeSend: function(){
								$('#btnNewUser').attr("disabled","disabled");
						},
						success: function(msg){
								$('.statusMsg').html('');
								if(msg == 'ok'){
										$('#formNuevoRegistro')[0].reset();
										$('.statusMsg').html('<span style="font-size:18px;color:#34A853">Editados Correctamente</span>');

										
								}else{
										$('.statusMsg').html('<span style="font-size:18px;color:#EA4335">'+ msg +'</span>');
								}
								$('#formNuevoRegistro').css("opacity","");
								$("#btnNewUser").removeAttr("disabled");
								$('#modalRegistro').modal('hide');
								setTimeout(function()
								{
          							location.reload();
          						}, 1000); 
								
						}
				});
			});
			});
		</script>
	</body>
	</html>
			
		<?php
}