<?php


session_start();

require_once ("config/db.php");
require_once ("config/conexion.php");


$song_name = $_POST["song_name"];
$artist_name = $_POST["artist_name"];
$song_year = $_POST["song_year"];
$song_genre = $_POST["song_genre"];

// $_FILES["song_file"]


$songname_file = $_FILES['song_file']['name'];

$target_dir = "mp3/";
$target_file = $target_dir . basename($_FILES["song_file"]["name"]);
$uploadOk = 1;
$FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if($FileType != "mp3" && $FileType != "png" && $FileType != "jpeg"
&& $FileType != "gif" ) 
	{
	    echo "Sorry, only JPG, JPEG,MP3, PNG & GIF files are allowed.";
	    $uploadOk = 0;
	}


if ($uploadOk == 0) 
	{
	    echo "Sorry, your file was not uploaded.";
	} 


if (move_uploaded_file($_FILES["song_file"]["tmp_name"], $target_file)) 
	{
	   	$sql = "INSERT INTO songs (name_song, artist, year, genre, filename_song)
		VALUES('".$song_name."','".$artist_name."', '" . $song_year . "', '" . $song_genre . "','".$songname_file."');";

		$query_newsong = mysqli_query($con,$sql);

		if($query_newsong) echo "ok";
	    // echo "The file ". basename( $_FILES["song_file"]["name"]). " has been uploaded.";
	} 
else 
    {
        echo "Sorry, there was an error uploading your file.";
    }
?>