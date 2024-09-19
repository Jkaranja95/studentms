<nav class="navbar sticky-top navbar-expand-lg navbar-light  top-nav">
  <?php
  $linksplit = explode('/',$_SERVER['PHP_SELF']);
  $page = end($linksplit);
  $page = $linksplit[(count($linksplit) - 1) - 1].'/'.$page;
  if (($page == 'products/view.php')) {
    ?>
    <div class="btn" id="menu-toggle" style="background-color: transparent;border-color: transparent;border: none;"><i class="fa fa-bars" style="color: #000;font-size: 22px;"></i></div>
    <?PHP } ?>
    <a class="navbar-brand" href="<?php echo URL::get();?>/index.php" ><img src="<?php echo URL::get();?>/resources/images/logo2.png" style="">StudentMS</a>
    <div class="navbar-toggler" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" style="border-color: transparent;">
      <i class="fa fa-ellipsis-v" style="color: #000;font-size: 22px;"></i>
    </div>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">

      </ul>
      <ul class="navbar-nav navbar-right">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URL::get();?>/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URL::get();?>/login.php">Login</a>
        </li>
      </ul>
    </div>
  </nav>