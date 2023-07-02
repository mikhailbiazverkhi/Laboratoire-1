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

//recherche par nom de plat
// if(isset($_GET['recherche'])){
//    $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
//    $motcle = $_GET['recherche'] ?? '';
//    $tableauRepas = rechercheParNomRepas($tableauRepas, $motcle);
// }


//recherche par repas spécifiques
// if(isset($_GET['recherche'])){
//    $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
//    $motcle = $_GET['recherche'] ?? '';
//    $tableauRepas = rechercheParRepasSpecifiques($tableauRepas, $motcle);
// }

if(isset($_GET['recherche'])){
   $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
   $motcle = $_GET['recherche'] ?? '';

   $critere = 'nomRepas';          // Nom de repas
   // $critere = 'description';     // Repas spécifiques

   $tableauRepas = rechercheParCriteres($tableauRepas, $motcle, $critere);
}

// var_dump(!empty($_GET['recherche']));

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