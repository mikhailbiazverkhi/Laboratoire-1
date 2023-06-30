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
   <!-- <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'> -->

   <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script> -->
</head>

<body>
   <!-- <header class="header headerBG"> -->
   <header class="header">
      <div class="logoDiv">
         <a href="#home"><img src="foody-logo.jpg" alt="Logo Image" class="logo"></a>
      </div>

      <div class="navBar" id="nav_bar">
         <ul class="navList">
            <li class="navItem"><a href="/index.php" class="navLink">Accueil</a></li>
            <!-- <li class="navItem"><a href="/ajoutRepas.php" class="navLink">Ajouter Repas</a></li> -->
            
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
            <!-- <li class="navItem"><a href="#" class="navLink">Blog</a></li>

            <li class="navItem"><a href="#contact" class="navLink">Contact</a></li> -->
         </ul>
         <!-- <div class="closeIconDiv" id="closeId">
            <i class='bx bxs-x-circle icon closeIcon'></i>
         </div> -->
      </div>

      <div class="accountBtn">
         <a href="/connexion.php" class="contactLink"><span>Se connecter</span></a>
         <!-- <a href="/inscrire.php" class="contactLink">S'inscrire</a> -->

      </div>

      <!-- <div class="toggleDiv" id="toggleId">
         <i class='bx bx-dialpad-alt icon toggleIcon'></i>
      </div> -->

   </header>

   <!-- <section class="productionSection" id="shop"> -->
   <section class="productionSection section" id="shop">
      <div class="sectionIntro">
         <div class="headerInfo container">
            <h2 class="title">Oeuvres des Cegeps<h2>
         </div>
      </div>
      <div class="boxesContainer container">
      <?php foreach ($tableauRepas as $repas) :
// foreach ($tableauxRepasParUser as $tableauxRepas) {
   //  foreach ($tableauxRepas as $repas) {
        ?>
         <div class="boxContent sHide">
            <div class="boxImgDiv">
               <img src="<?=$repas['cheminImage']?>" alt="Food Image" class="boxImg">
            </div>
            <div class="imgDesc">
               <span class="imageTitle"><?=$repas['nomRepas']?></span>
            </div>

            <!-- <span class="stars">
               <i class='bx bxs-star starIcon'></i>
               <i class='bx bxs-star starIcon'></i>
               <i class='bx bxs-star starIcon'></i>
               <i class='bx bxs-star starIcon'></i>
               <i class='bx bxs-star-half starIcon'></i>
            </span> -->
            <span class="boxImgPrice">
               $<?=$repas['prixRepas']?>
            </span>
            <span class="boxImgPrice">
               <?=$repas['localisation']?>
            </span>
            <!-- <div class="boxImgBtn"> -->
               <a href="seulRepas.php?id=<?=$repas['repasId']?>">
               <div class="boxImgBtn">
                  <button type="button">Voir plus</button>
                  </div>
               </a>
            <!-- </div> -->
         </div>
      <?php endforeach;
// }
// }
?>
      </div>
   </section>
</body>

</html>