<?php
if (isset($title))
{
?>




<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
  <div class="container">
    <a class="navbar-brand" href="#">DIGISCAPE</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">

        <img src="imagenes/<?php echo $_SESSION['foto']; ?>" alt="" class="rounded-circle float-right" style="height: 30px; width: 30px;" >

        <li class="nav-item dropdown">

          <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"  >
            <?php
            if (isset($_SESSION['user_id'])) {
            echo $_SESSION['user_name']; }
            ?>
          </a>

          <div class="dropdown-menu">

            <a class="dropdown-item" data-toggle="modal" data-target="#modalSong" href="#">Upload Song</a>

            <div class="dropdown-divider"></div>

            <a class="dropdown-item" data-toggle="modal" data-target="#modalPerfil" href="#">Mi Perfil</a>
            
            <a class="dropdown-item" data-toggle="modal" data-target="#modalPassword" href="#">Cambiar Password</a>
            
            <div class="dropdown-divider"></div>

            <a class="dropdown-item" href="login.php?logout">Cerrar Sesión</a>

          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>
<?php
}
?>