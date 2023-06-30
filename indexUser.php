<?php

session_start();

if (!isset($_SESSION['user'])) {
    header('Location: /');
    die;
} else {
    $userId = $_SESSION['user']['userId'];
    $userPseudo = $_SESSION['user']['pseudo'];
}

$filename = __DIR__ . '/public/data/users.json';

if (file_exists($filename)) {
    $users = json_decode(file_get_contents($filename), true) ?? [];

    $userIndex = array_search($userId, array_column($users, 'userId'));

    if(isset($users[$userIndex]['repas'])){
      $userRepas = $users[$userIndex]['repas'];
    }
    else {
      $userRepas = [];
    }

    $tableauxRepasParUser = array_column($users, 'repas');
}

foreach ($tableauxRepasParUser as $tableauxRepas) {
    $tableauRepas = array_merge($tableauRepas ?? [], $tableauxRepas);
}

$localisations = array_unique(array_column($tableauRepas, 'localisation'));


//triage localisation
// $userRepasLocalisation = [];
foreach($userRepas as $repas) {

// if($repas['localisation'] == )
$userRepasLocalisation = [...$userRepasLocalisation ?? [], $repas];
}
echo '<pre>';
// print_r($userRepasLocalisation);
echo '</pre>';


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
   <header class="header headerBG">
      <div class="logoDiv">
         <a href="#home"><img src="foody-logo.jpg" alt="Logo Image" class="logo"></a>
      </div>

      <div class="navBar" id="nav_bar">
         <ul class="navList">
            <li class="navItem">Hi, <?=$userPseudo?></li>
            <li class="navItem"><a href="/index.php" class="navLink">Accueil</a></li>
            <li class="navItem"><a href="/ajoutRepas.php" class="navLink">Ajouter Repas</a></li>

            <li class="navItem">
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

            </li>
         </ul>
      </div>

      <div class="accountBtn">
         <a href="/sortir.php" class="contactLink">Sortir</a>
      </div>

   </header>

   <section class="productionSection section" id="shop">
      <div class="sectionIntro">
         <div class="headerInfo container">
            <h2 class="title">Oeuvres des Cegeps de <?=$userPseudo?><h2>

         </div>
      </div>
      <div class="boxesContainer container">
      <?php foreach ($userRepas as $repas) : ?>
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
	      <?php endforeach; ?>
      </div>
   </section>
</body>

</html>