<?php
// if(!isset($_POST["user_password_repeat3"]) || !isset($_POST["user_password_new3"])) exit();

session_start();

require_once("libraries/password_compatibility_library.php");

if ($_POST['user_password_new3'] === $_POST['user_password_repeat3'])
	{
		require_once ("config/db.php");
		require_once ("config/conexion.php");

		$user_id = $_SESSION['user_id'];
		$user_password = $_POST['user_password_new3'];

		$user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);

		$sql = "UPDATE users SET user_password_hash='".$user_password_hash."' WHERE user_id='".$user_id."'";
		$query = mysqli_query($con,$sql);

		if ($query) 
		{
			echo 'ok';
		} 
		else "Lo sentimos , el registro falló. Por favor, regrese y vuelva a intentarlo.";
	}

else "Un error desconocido ocurrió.";

?>