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
            <li class="navItem">Hi, <?=$userPseudo?></li>
            <li class="navItem"><a href="/index.php" class="navLink">Accueil</a></li>
            <li class="navItem"><a href="/ajoutRepas.php" class="navLink">Ajouter Repas</a></li>

            <?php require './includes/triageEtRecherche.php'?>

            <!-- <li class="navItem">
               <label for="localisation">Localisation:</label>
               <select name="localisation" id="localisation">
               <option value="">toutes</option>
               <?php foreach ($localisations as $localisation): ?>
                  <option value="<?=$localisation?>"><?=$localisation?></option>
               <?php endforeach;?>
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
         <a href="/sortir.php" class="contactLink">Sortir</a>
      </div>

   </header>

   <?php require "./includes/listeRepas.php"?>

   
</body>

</html>