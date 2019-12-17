<?php 
  if (isset($_SESSION['user'])) {
    echo  "<div class='center'>
    <hr>
    <div class='bar black card'>
      <a href='profile' class='bar-item button'><img style='width: 50px; margin-right: 35px' src='img/profile/def4.jpg'></a>
      <a href='gallery' class='bar-item button'><img style='width: 50px; margin-right: 35px' src='img/icons/Files.png'></a>
      <a href='upload' class='bar-item button'><img style='width: 55px; margin-right: 35px' src='img/icons/Camera.png'></a>
      <a href='settings' class='bar-item button'><img style='width: 53px; margin-right: 35px' src='img/icons/settings.png'></a>
      <a href='logout' class='bar-item button'><img style='width: 53px' src='img/icons/Exit.png'></a>
    </div>
    <hr>
    </div>";
  } 
?>
