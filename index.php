<?php
$filename = __DIR__ . '/public/data/users.json';

if (file_exists($filename)) {
    $users = json_decode(file_get_contents($filename), true) ?? [];
    $tableuxRepasParUser = array_column($users, 'repas');
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Foodie_Share</title>
   <link rel="stylesheet" href="public/css/index.css">
   <!-- <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'> -->
</head>

<body>
   <header class="header headerBG">
      <div class="logoDiv">
         <a href="#home"><img src="foody-logo.jpg" alt="Logo Image" class="logo"></a>
      </div>
      <div class="navBar" id="nav_bar">
         <ul class="navList">
            <li class="navItem"><a href="/index.php" class="navLink">Accueil</a></li>
            <li class="navItem"><a href="/ajoutRepas.php" class="navLink">Ajouter Repas</a></li>
            <li class="navItem"><a href="#" class="navLink">Blog</a></li>

            <li class="navItem"><a href="#contact" class="navLink">Contact</a></li>
         </ul>
         <div class="closeIconDiv" id="closeId">
            <i class='bx bxs-x-circle icon closeIcon'></i>
         </div>
      </div>

      <div class="accountBtn">
         <a href="/connexion.php" class="contactLink">Se connecter</a>
         <a href="/inscrire.php" class="contactLink">S'inscrire</a>

      </div>

      <div class="toggleDiv" id="toggleId">
         <i class='bx bx-dialpad-alt icon toggleIcon'></i>
      </div>

   </header>

   <section class="productionSection section" id="shop">
      <div class="sectionIntro">
         <div class="headerInfo container">
            <h2 class="title">Oeuvres des Cegeps<h2>

         </div>
      </div>
      <div class="boxesContainer container">
      <?php
         foreach ($tableuxRepasParUser as $tableuxRepas) {
            foreach ($tableuxRepas as $repas) {
      ?>
         <div class="boxContent sHide">
            <div class="boxImgDiv">
               <img src="<?=$repas['cheminImage']?>" alt="Food Image" class="boxImg">
            </div>
            <div class="imgDesc">
               <span class="imageTitle"><?=$repas['nomRepas']?></span>
            </div>

            <span class="stars">
               <i class='bx bxs-star starIcon'></i>
               <i class='bx bxs-star starIcon'></i>
               <i class='bx bxs-star starIcon'></i>
               <i class='bx bxs-star starIcon'></i>
               <i class='bx bxs-star-half starIcon'></i>
            </span>
            <span class="boxImgPrice">
               $<?=$repas['prixRepas']?>
            </span>
            <span class="boxImgPrice">
               <?=$repas['localisation']?>
            </span>
            <div class="boxImgBtn">
               <button type="button">Ajouter un avis</button>
            </div>
         </div>
      <?php
            }
         }
      ?>
      </div>
   </section>
</body>

</html>