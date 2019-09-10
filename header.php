<header>
  <div class="site-width">
    <h1><a href="index.php">ÉPICE DE HOMME</a></h1>
    <nav id="top-nav">
      <ul>
        <?php
          if(empty($_SESSION['user_id'])){
        ?>
            <li><a href="login.php" class="far fa-user-circle fa-2x"></a></li>
            <li><a href="mycart.php" class="fas fa-shopping-cart fa-2x"></a></i>
        <?php
          }else{
        ?>
            <li><a href="signup.php" class="far fa-user-circle fa-2x"></a></li>
            <li><a href="mycart.php" class="fas fa-shopping-cart fa-2x"></a></i>
        <?php
          }
        ?>
      </ul>
    </nav>
  </div>
</header>