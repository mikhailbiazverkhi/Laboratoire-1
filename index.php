<?php
session_start();

require './helpers/functions.php';

$filename = __DIR__ . '/public/data/users.json';

$users = getTableauUsers($filename);

$tableauxRepasParUser = array_column($users, 'repas');

$tableauRepas = mergeTableauRepas($tableauxRepasParUser);

$localisations = array_unique(array_column($tableauRepas, 'localisation'));

$pageTitle = "Oeuvres des Cegeps";

//nom du fichier pour former lien de la GET requête (voir le fichier "triageEtRecherche.php")
$nomFichier = $_SERVER['SCRIPT_NAME'];

//filtrer par localisation
if(isset($_GET['localisation'])){
   $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
   $localisation = $_GET['localisation'] ?? '';
   $tableauRepas = filtreLocalisations($tableauRepas, $localisation);
}

//trier par prix
if(isset($_GET['prix'])){
   $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
   $ordrePrix = $_GET['prix'] ?? '';
   $tableauRepas = sortParPrix($tableauRepas, $ordrePrix);
}

// echo "<pre>";
// print_r($tableauRepas);
// echo "<pre>";

// $newTab = array_column($tableauRepas, 'prixRepas');

// echo "<pre>";
// print_r($newTab);
// echo "<pre>";

// asort($newTab);

// echo "<pre>";
// print_r($newTab);
// echo "<pre>";

// foreach($newTab as $key => $value){
//    echo "<br>";
//    print_r($tableauRepas[$key]);
// }

// // echo "<pre>";
// // print_r(arry);
// // echo "<pre>";

// function sortParPrix($tableauRepas, $ordre){
//    if(!empty($ordre)){
//       $tableauPrixRepas = array_column($tableauRepas, 'prixRepas');
//       if($ordre === "croissant"){
//          asort($tableauPrixRepas);
//       } else if ($ordre === "decroissant"){
//          arsort($tableauPrixRepas);
//       }
//       return $tableauPrixRepas;
//    }
//    return $tableauRepas;
// }




// die;
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
         <a href="#home"><img src="/logo/foody-logo.jpg" alt="Logo Image" class="logo"></a>
      </div>

      <div class="navBar">
         <ul class="navList">
            <li class="navItem"><a href="/index.php" class="navLink">Accueil</a></li>

            <?php if(isset($_SESSION['user'])) :?>
            <li class="navItem"><a href="/profil.php" class="navLink">Profil</a></li>
            <?php endif?>

            <?php require './includes/triageEtRecherche.php'?>
            
         </ul>
      </div>

      <div class="accountBtn">
      <?php if(isset($_SESSION['user'])) :?>
         <a href="/sortir.php" class="contactLink">Sortir</a>
      <?php else :?>
         <a href="/connexion.php" class="contactLink"><span>Se connecter</span></a>
      <?php endif;?>
      </div>
   </header>

   <?php require "./includes/listeRepas.php"?>
   
   <!-- <section class="productionSection section">
      ($tableauRepas as $repas) -->
      
</body>
</html>