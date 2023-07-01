<?php
session_start();

require './helpers/functions.php';

$filename = __DIR__ . '/public/data/users.json';

$users = getTableauUsers($filename);

$tableauxRepasParUser = array_column($users, 'repas');

$tableauRepas = mergeTableauRepas($tableauxRepasParUser);

$localisations = array_unique(array_column($tableauRepas, 'localisation'));

$pageTitle = "Oeuvres des Cegeps";
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Foodie_Share</title>
   <link rel="stylesheet" href="public/css/index.css">
</head>

<body>
   <header class="header">
      <div class="logoDiv">
         <a href="#home"><img src="/logo/foody-logo.jpg" alt="Logo Image" class="logo"></a>
      </div>

      <div>
         <ul class="navList">
            <li class="navItem"><a href="/index.php" class="navLink">Accueil</a></li>

            <?php if(isset($_SESSION['user'])) :?>
            <li class="navItem"><a href="/indexUser.php" class="navLink">Profil</a></li>
            <?php endif?>

            <?php require './includes/triageEtRecherche.php'?>
            <!-- <li class="navItem">
               <label for="localisation">Localisation:</label>
               <select name="localisation" id="localisation">
               <option value="toutes">toutes</option>
               <?php foreach ($localisations as $localisation) : ?>
                  <option value="<?=$localisation?>"><?=$localisation?></option>
               <?php endforeach; ?>
               </select>
            </li>

            <li class="navItem">
               <label for="prix">Prix:</label>
               <select name="prix" id="prix">
                  <option value="croissant">Croissant</option>
                  <option value="decroissant">Décroissant</option>
               </select>
            </li>

            <li class="navItem">
               <form action="">
                  <input type="text"/>
                  <button type="button">Recherche</button>
               </form>

            </li> -->
         </ul>
      </div>

      <div class="accountBtn">
      <?php if(isset($_SESSION['user'])) :?>
         <a href="/sortir.php" class="contactLink">Sortir</a>
      <?php else :?>
         <a href="/connexion.php" class="contactLink"><span>Se connecter</span></a>
         <!-- <a href="/inscrire.php" class="contactLink">S'inscrire</a> -->
      <?php endif;?>
      </div>
   </header>

   <?php require "./includes/listeRepas.php"?>
   
   <!-- <section class="productionSection section">
      ($tableauRepas as $repas) -->
      
</body>
</html>