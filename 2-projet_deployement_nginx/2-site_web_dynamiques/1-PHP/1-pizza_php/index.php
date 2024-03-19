<?php use Library as Lib; ?>
<?php require_once("templates/header.php") ?>
<?php require_once("templates/navbar.php") ?>
<?php require_once("templates/slider.php") ?>
<?php require_once("data/pizzas.php") ?>
<?php require_once("lib/pizzas.php") ?>



  <!-- PRODUCT ITEMS  -->
  <h1 class="tc">Nos Offres Les Plus Populaires</h1>
  
  <div id="app">
    <!-- <img src="/assets/images/icons/espin.gif" alt="">
    <h3>Merci de patienter, page en cours de chargement ...</h3>
    <img src="/assets/images/icons/espin.gif" alt=""> -->
    <?php 

    foreach ($pizzas as  $pizza) {
      echo Lib\dispay_pizza($pizza);
    }


    ?>
  </div>

  <?php require_once("templates/footer.php") ?>



  
 