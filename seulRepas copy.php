<?php

// if(!isset($_SESSION['user'])){
//   header('Location: /connexion.php');
// }

$filename = __DIR__ . '/public/data/users.json';
$repasId = $_GET['id'];

// print_r($repasId);

if (file_exists($filename)) {
    $users = json_decode(file_get_contents($filename), true) ?? [];
}

foreach ($users as $user) {
    if (isset($user['repas'])) {
        foreach ($user['repas'] as $repas) {
            if ($repas['repasId'] == $repasId) {
                // echo '<pre>';
                // print_r($repas);
                // echo '</pre>';
                // echo "UserId: ".$user['userId'];
                break;
            }
        }
    }

}

?>


<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>User account</title>
 <link rel="stylesheet" href="public/css/account.css">
</head>

<body>
 <main class="container">
  <!-- <div class="profil">
   <img src="<?=$repas['cheminImage']?>" alt="profile">
   <h2> Hey <span>ANNA</span> Welcome back !</h2>
  </div> -->
  <div class="boxesContainer">
   <div class="boxContent">
    <div class="boxImgDiv">
     <img src="<?=$repas['cheminImage']?>" alt="Food Image" class="boxImg">
    </div>
    <div class="imgDesc">
     <span class="imageTitle">Repas 1</span>
    </div>
    <span class="boxImgPrice">
        <?=$repas['prixRepas']?>$
    </span>
    <span class="boxImgPrice">
        <?=$repas['localisation']?>
    </span>
    <div class="boxImgBtn">
     <div><button type="button" class="modifier btn-primary">Modifier</button></div>

     <div><button type="button" class="supprimer btn-secondary">Supprimer</button></div>
    </div>

   </div>


  </div>
 </main>
</body>

</html>
