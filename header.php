<?php
    session_start();
    require_once("db/db_func.php");
    $conn = db_conn();
    if ($css_file == "login" || $css_file == "success") {
        if (isset($_SESSION['user'])) {
            header("Location: index.php");
            exit;
        }
    }
    if ($css_file == "login") {
        $reg = db_submit($conn);
    }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">

    <title><?php echo $page_title; ?></title>

    <link rel="stylesheet" type="text/css" href="style/style.css">
    <link rel="stylesheet" type="text/css" href="style/<?php echo $css_file;?>.css">
    <script type='text/javascript' src='scripts/gen_validatorv4.js'></script>

    <?php 
    if ($css_file != "login") {
      ?>
      <script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
      <link rel="stylesheet" type="text/css" href="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
      <link rel="stylesheet" type="text/css" href="https://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
      <?php
    }
    ?>

  </head>

  <body>
    <div id="head">
      <div class="logoImage"><img src="style/img/von1.png"></div>
      <!--<div class="logo"><a href="index.php"><img src="style/img/b1.png"></a></div>-->

      <?php   
        if (!isset($_SESSION['user'])) {
        ?>   
            <div class="buttons" id="last"><a href="login.php"><img src="style/img/b2.png"></a></div>
        <?php
        }
        else {
        ?>
            <div class="buttons" id="last"><a href="logout.php"><img src="style/img/logout.png"></a></div>
        <?php
        }
      ?>
      <div class="buttons"><a href="maps.php"><img src="style/img/b3.png"></a></div>
      <div class="buttons"><a href="about.php"><img src="style/img/b4.png"></a></div>
      <div class="buttons"><a href="index.php"><img src="style/img/b1.png"></a></div>
      <br>
      <?php
        if ($css_file != "login") {
          ?>
          <div id="search">
            <form method = "GET" action = "index.php">
              <input type="text" name="search" placeholder="Search smth...">
            </form>
          </div>
          <?php
        }
      ?>
    </div>   

