<?php
$filename = __DIR__ . '/public/data/users.json';

if (file_exists($filename)) {
    $users = json_decode(file_get_contents($filename), true) ?? [];
    $tableauxRepasParUser = array_column($users, 'repas');
}

// $tableauRepas = [];

foreach ($tableauxRepasParUser as $tableauxRepas) {
   $tableauRepas = array_merge($tableauRepas ?? [], $tableauxRepas);
}

// echo "<pre>";
// print_r($tableauRepas);
// echo "</pre>";

$localisations = array_unique(array_column($tableauRepas, 'localisation'));

// echo "<pre>";
// print_r($localisations);
// echo "</pre>";

// die;
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

      <div class="navBar" id="nav_bar">
         <ul class="navList">
            <li class="navItem"><a href="/index.php" class="navLink">Accueil</a></li>
      
            <li class="navItem">
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
               <!-- <label for="recherche">Prix:</label> -->
               <form action="">
                  <input type="text"/>
                  <button type="button">Recherche</button>
               </form>

            </li>
         </ul>
      </div>

      <div class="accountBtn">
         <a href="/connexion.php" class="contactLink"><span>Se connecter</span></a>
         <!-- <a href="/inscrire.php" class="contactLink">S'inscrire</a> -->
      </div>
   </header>

   <section class="productionSection section">
      <div class="sectionIntro">
         <div class="headerInfo container">
            <h2 class="title">Oeuvres des Cegeps<h2>
         </div>
      </div>
      <div class="boxesContainer container">

      <?php foreach ($tableauRepas as $repas) :?>

         <div class="boxContent">
            <div class="boxImgDiv">
               <img src="<?=$repas['cheminImage']?>" alt="Food Image" class="boxImg">
            </div>
            <div class="imgDesc">
               <span class="imageTitle"><?=$repas['nomRepas']?></span>
            </div>

            <span class="boxImgPrice">
               $<?=$repas['prixRepas']?>
            </span>
            <span class="boxImgPrice">
               <?=$repas['localisation']?>
            </span>

            <a href="seulRepas.php?id=<?=$repas['repasId']?>">
               <div class="boxImgBtn">
                  <button type="button">Voir plus</button>
               </div>
            </a>
         </div>
      <?php endforeach;?>

      </div>
   </section>
</body>

</html>