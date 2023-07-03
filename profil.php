<?php

session_start();

require './helpers/functions.php';

if (!isset($_SESSION['user'])) {
    header('Location: /');
    die;
} else {
    $userId = $_SESSION['user']['userId'];
    $userPseudo = $_SESSION['user']['pseudo'];
}

$filename = __DIR__ . '/public/data/users.json';

$users = getTableauUsers($filename);

$tableauxRepasParUser = array_column($users, 'repas');

$tableauRepas = mergeTableauRepas($tableauxRepasParUser);

$localisations = array_unique(array_column($tableauRepas, 'localisation'));

$userRepas = getTableauUserRepas($userId, $users);

$tableauRepas = $userRepas;

$pageTitle = "Oeuvres des Cegeps de ".$userPseudo;

//bloc de la fonctionalité (filtre, triage, recherche)
require './includes/bloc_filtreEtRecherche.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <?php require './includes/head.php'?>
   
   <title>Foodie_Share</title>
   <link rel="stylesheet" href="public/css/index.css">
</head>

<body>
   <header class="header">
      <div class="logoDiv">
         <a href="#home"><img src="logo/foody-logo.jpg" alt="Logo Image" class="logo"></a>
      </div>

      <div class="navBar">
         <ul class="navList">
            <li class="navItem"><a href="/profil.php" class="navLink">Hi, <?=$userPseudo?> !!!</a></li>
            <li class="navItem"><a href="/index.php" class="navLink">Accueil</a></li>
            <li class="navItem"><a href="/ajoutRepas.php" class="navLink">Ajouter Repas</a></li>

            <?php require './includes/triageEtRecherche.php'?>

         </ul>
      </div>

      <div class="accountBtn">
         <a href="/sortir.php" class="contactLink">Sortir</a>
      </div>

   </header>

   <?php require "./includes/listeRepas.php"?>

   <!-- <section class="productionSection section">
      ($tableauRepas as $repas) -->
   
</body>

</html>