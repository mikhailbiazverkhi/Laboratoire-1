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

//triage localisation
// $userRepasLocalisation = [];
// foreach($userRepas as $repas) {

// if($repas['localisation'] == )
// $userRepasLocalisation = [...$userRepasLocalisation ?? [], $repas];
// }
// echo '<pre>';
// // print_r($userRepasLocalisation);
// echo '</pre>';

?>

<!DOCTYPE html>
<html lang="en">

<head>

   <?php require './includes/head.php'?>
   <!-- <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
   <title>Foodie_Share</title>

   <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
   <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/all.css"/> -->
   <link rel="stylesheet" href="public/css/index.css">
</head>

<body>
   <header class="header">
      <div class="logoDiv">
         <a href="#home"><img src="/logo/foody-logo.jpg" alt="Logo Image" class="logo"></a>
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