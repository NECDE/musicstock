<?php

if(!isset($_POST["user_email"]) || !isset($_POST["user_name"])) exit();

session_start();

require_once ("config/db.php");
require_once ("config/conexion.php");



$id = $_SESSION['user_id'];
$email = $_POST["user_email"];
$nombre = $_POST["user_name"];



	if(!empty($_FILES["foto"]["type"])){
		$fileName = time().'_'.$_FILES['foto']['name'];
		$valid_extensions = array("jpeg", "jpg", "png", "gif");
		$temporary = explode(".", $_FILES["foto"]["name"]);
		$file_extension = end($temporary);
		if((($_FILES["foto"]["type"] == "image/png") || ($_FILES["foto"]["type"] == "image/jpg") || ($_FILES["foto"]["type"] == "image/jpeg") || ($_FILES["foto"]["type"] == "image/gif")) && in_array($file_extension, $valid_extensions)){
			$sourcePath = $_FILES['foto']['tmp_name'];
			$targetPath = "imagenes/".$fileName;
			if(move_uploaded_file($sourcePath,$targetPath)){
				$uploadedFile = $fileName;

				$sql = "UPDATE users SET filename_avatar='".$fileName."', user_name='".$nombre."', user_email='".$email."' WHERE user_id='".$id."';";
				$query_update = mysqli_query($con,$sql);

				if($query_update) 
				{
					require_once("classes/Login.php");

					session_destroy();

					$login = new Login();
					$_POST['user_name'] = $nombre;
					// buscar la pass de db
					$_POST['user_password'] = "lala";
					$login->dologinWithPostData();

					echo "ok";

				}
			}
			else "Algo salió mal. Por favor verifica que la tabla exista";
		}
	}

	else
	{
		$sql = "UPDATE users SET user_name='".$nombre."', user_email='".$email."' WHERE user_id='".$id."';";
		$query_update = mysqli_query($con,$sql);

		if($query_update) {
			
		
			require_once("classes/Login.php");
			session_destroy();
			$login = new Login();
			$_POST['user_name'] = $nombre;
			$_POST['user_password'] = "lala";
			$login->dologinWithPostData();
			echo "ok";

		}
		
		else "Algo salió mal. Por favor verifica que la tabla exista";
	}

?>