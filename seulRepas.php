<?php

// if(!isset($_SESSION['user'])){
//   header('Location: /connexion.php');
// }

$filename = __DIR__ . '/public/data/users.json';
$repasId = $_GET['id'];
$repasChoisi = [];

// print_r($repasId);

if (file_exists($filename)) {
    $users = json_decode(file_get_contents($filename), true) ?? [];
}

foreach ($users as $user) {
    if (isset($user['repas'])) {
        foreach ($user['repas'] as $repas) {
            if ($repas['repasId'] == $repasId) {
                // echo '<pre>';
                $repasChoisi = $repas;
//                 print_r($repas);
//                 echo '</pre>';
//                 echo "UserId: ".$user['userId'];
// echo '<br>';    
//                 echo $repas['cheminImage'];
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
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
 <div class="container">
  <div class="boxesContainer">
   <div class="boxContent">
    <div class="boxImgDiv">
     <!-- <img src="<?=$repasChoisi['cheminImage']?>" alt="Food Image"> -->
     <img src="<?=$repasChoisi['cheminImage']?>" class="img-fluid" alt="Food Image">
    </div>

    <span class="imageTitle">
        <?=$repasChoisi['nomRepas']?>
    </span>
    <span class="boxPrice">
        <?=$repasChoisi['prixRepas']?>$
    </span>
    <span class="boxLocalisation">
        <?=$repasChoisi['localisation']?>
    </span>

    <!-- <div class="boxImgBtn">
     <div><button type="button" class="modifier btn-primary">Modifier</button></div>

     <div><button type="button" class="supprimer btn-secondary">Supprimer</button></div>
    </div> -->

    <div class="imgDesc"> 
    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laboriosam quos excepturi aperiam sed voluptatem. Quos animi ullam quo aliquam, qui, at, reprehenderit quam sint explicabo doloribus ipsa! Eius, veritatis aliquam?
    </div>
    </div>
    <!-- <div class="boxContent">

</div> -->

  </div>
  <div class="boxesContainer">
  <div class="boxContent">
    <?=$repasChoisi['cheminImage']?>
</div>
<textarea name="" id="" cols="30" rows="10"></textarea>

</div>

</div>
</body>

</html>
