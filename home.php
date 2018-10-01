<?php
session_start();
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1)
	{
		header("location: login.php");
		exit;
	}
require_once ("config/db.php");
require_once ("config/conexion.php");
$active_usuarios="active";
$title="Home | Digiscape";
?>
<!DOCTYPE html>
<html lang="en">
	<?php include("head.php"); ?>
	
	<body>
		<?php include("navbar.php"); ?>
		<?php include("header.php"); ?>

		<section>
			<div>

				<div class="row align-items-center">
					<table class="table">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">First</th>
								<th scope="col">Last</th>
								<th scope="col">Handle</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th scope="row">1</th>
								<td>Mark</td>
								<td>Otto</td>
								<td>@mdo</td>
							</tr>
							<tr>
								<th scope="row">2</th>
								<td>Jacob</td>
								<td>Thornton</td>
								<td>@fat</td>
							</tr>
							<tr>
								<th scope="row">3</th>
								<td>Larry</td>
								<td>the Bird</td>
								<td>@twitter</td>
							</tr>
						</tbody>
					</table>
				</div>

			</div>
		</section>

		<hr>

		<?php include("footer.php"); ?>

		<!-- MODAL EDITAR PERFIL -->
		<div class="modal fade" id="modalPerfil" tabindex="-1" role="dialog" aria-labelledby="MiPerfil" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Mi Perfil</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form method="post" action="recibeEditarPerfil.php" enctype="multipart/form-data" id="formEditarPerfil" >
						<div class="modal-body">
							<p class="statusMsg"></p>
							
							<div class="form-group">
								<label for="user_email">Email</label>
								<input type="email" class="form-control" id="user_email" name="user_email" aria-describedby="emailHelp" placeholder="Ingrese su Email" value="<?php echo $_SESSION['user_email']; ?>">
								
							</div>
							<div class="form-group">
								<label for="nombre">Username</label>
								<input type="text" class="form-control" id="nombre" name="user_name" placeholder="Ingrese su nombre" value="<?php echo $_SESSION['user_name']; ?>">
								<small id="usernameHelp" class="form-text text-muted">Recuerde que su username lo utilizará para iniciar sesión</small>
							</div>
							<div class="form-group">
								<label for="nombre">Foto de Perfil</label>
								<input type="file" class="form-control" id="foto" name="foto" placeholder="Seleccione su foto" >
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
							<button type="submit" class="btn btn-primary" id="btnEditarUser">Guardar Cambios</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		
		<!-- Modal -->
		<div class="modal fade" id="modalPassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Cambiar contraseña</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
						
					</div>
					
					<div class="modal-body">
						<form class="form-horizontal" method="post" id="formEditarPassword">
							<p class="statusMsgg"></p>
							
							<div class="form-group">
								<label for="user_password_new3" class="col-sm-4 control-label">Nueva contraseña</label>
								<div class="col-sm-8">
									<input type="password" class="form-control" id="user_password_new3" name="user_password_new3" placeholder="Nueva contraseña" pattern=".{6,}" title="Contraseña ( min . 6 caracteres)" required>
									<input type="hidden" id="user_id_mod" name="user_id_mod">
								</div>
							</div>
							<div class="form-group">
								<label for="user_password_repeat3" class="col-sm-4 control-label">Repite contraseña</label>
								<div class="col-sm-8">
									<input type="password" class="form-control" id="user_password_repeat3" name="user_password_repeat3" placeholder="Repite contraseña" pattern=".{6,}" required>
								</div>
							</div>
							
							
							
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
								<button type="submit" class="btn btn-primary" id="btnEditarPass">Cambiar contraseña</button>
							</div>
						</form>
					</div>
				</div>
				
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="modalSong" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Subir Canción</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
						
					</div>
					
					<div class="modal-body">
						<form class="form-horizontal" method="post" id="formUploadSong" enctype="multipart/form-data">
							<p class="statusMsggg"></p>
							
							<div class="form-group">
								<label for="nombresong">Name Song</label>
								<input type="text" class="form-control" id="nombresong" name="song_name" placeholder="Ingrese su nombre de la Canción" required>
							</div>

							<div class="form-group">
								<label for="nameartist">Artist</label>
								<input type="text" class="form-control" id="nameartist" name="artist_name" placeholder="Ingrese Artist" required>
							</div>

							<div class="form-group">
								<label for="yearsong">Year</label>
								<input type="text" class="form-control" id="yearsong" name="song_year" placeholder="Ingrese Año de la Canción" required>
							</div>

							<!-- <div class="form-group">
								<label for="genre">Genre</label>
								<input type="text" class="form-control" id="genre" name="song_genre" placeholder="Ingrese genero de la Canción" required>
							</div> -->


							<div class="form-group">
								<!-- <label for="mod_categoria" class="col-sm-3 control-label">Categoría</label> -->
								<label for="genre">Genre</label>
								<!-- <div class="col-sm-8"> -->
									<select class='form-control' name='song_genre' id='genre' required>
										<option value="">Selecciona una categoría</option>
											<?php 
											$query_categoria=mysqli_query($con,"select * from generos order by name_genre");
											while($rw=mysqli_fetch_array($query_categoria))	{
												?>
											<option value="<?php echo $rw['id_genre'];?>"><?php echo $rw['name_genre'];?></option>			
												<?php
											}
											?>
									</select>			  
								<!-- </div> -->
							</div>



							<div class="form-group">
								<label for="songfile">Song File</label>
								<input type="file" class="form-control" id="songfile" name="song_file" placeholder="Seleccione su foto" required>
							</div>

														
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
								<button type="submit" class="btn btn-primary" id="btnSubirSong">Subir Canción</button>
							</div>
						</form>
					</div>
				</div>
				
			</div>
		</div>



		<?php include("script.php"); ?>

		<script src="player/howler.core.js"></script>
		<script src="player/siriwave.js"></script>
  		<script src="player/player.js"></script>


		<script type="text/javascript">
			$(document).ready(function() {
			$("#formEditarPerfil").on('submit', function(e)
			{
				$('.statusMsg').html('');
				e.preventDefault();
				$.ajax({
						type: 'POST',
						url: 'recibeEditarPerfil.php',
						data: new FormData(this),
						contentType: false,
						cache: false,
						processData:false,
						beforeSend: function()
						{
							$('#btnEditarUser').attr("disabled","disabled");
						},
						success: function(msg){
								$('.statusMsg').html('');
								if(msg == 'ok')
								{
									$('.statusMsg').html('<span style="font-size:18px;color:#34A853">Perfil Editado Correctamente</span>');
								}
								else
								{
									$('.statusMsg').html('<span style="font-size:18px;color:#EA4335">Algo Pasó</span>');
								}
								$('#formEditarPerfil').css("opacity","");
								$("#btnEditarUser").removeAttr("disabled");
								// $('#modalPerfil').modal('hide');
								setTimeout(function()
							{
						location.reload();
					}, 2000);
								
						}
				});
			});
			});
		</script>
		<script type="text/javascript">
			$(document).ready(function() {
				$("#formEditarPassword").on('submit', function(e){
					$('.statusMsgg').html('');
					e.preventDefault();
					$.ajax({
							type: 'POST',
							url: 'recibeEditarPassword.php',
							data: new FormData(this),
							contentType: false,
							cache: false,
												processData:false,
							beforeSend: function()
							{
								$('#btnEditarPass').attr("disabled","disabled");
							},
							success: function(msg){
									$('.statusMsgg').html('');
									if(msg == 'ok')
									{
										$('.statusMsgg').html('<span style="font-size:18px;color:#34A853">Password Editada Correctamente</span>');
									}
									else
									{
										$('.statusMsgg').html('<span style="font-size:18px;color:#34A853">ERROR :C</span>');
									}
									$('#formEditarPassword').css("opacity","");
									$("#btnEditarPass").removeAttr("disabled");
									// $('#modalPerfil').modal('hide');
									setTimeout(function()
								{
							location.reload();
						}, 1000);
									
							}
					});
				});
			});
		</script>
		<script type="text/javascript">
			$(document).ready(function() {
				$("#formUploadSong").on('submit', function(e){
					$('.statusMsggg').html('');
					e.preventDefault();
					$.ajax({
							type: 'POST',
							url: 'recibeNuevaSong.php',
							data: new FormData(this),
							contentType: false,
							cache: false,
							processData:false,
							beforeSend: function()
							{
								$('#btnSubirSong').attr("disabled","disabled");
							},
							success: function(msg){
									$('.statusMsggg').html('');
									if(msg == 'ok')
									{
										$('.statusMsggg').html('<span style="font-size:18px;color:#34A853">Song Uploaded Correctamente</span>');
									}
									else
									{
										$('.statusMsggg').html('<span style="font-size:18px;color:#34A853">ERROR :C</span>');
									}
									$('#formEditarPassword').css("opacity","");
									$("#btnSubirSong").removeAttr("disabled");
									// $('#modalPerfil').modal('hide');
									setTimeout(function()
								{
							location.reload();
						}, 3000);
									
							}
					});
				});
			});
		</script>

	</body>
</html>