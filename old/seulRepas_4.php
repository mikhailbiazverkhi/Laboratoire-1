<?php

session_start();

require './helpers/functions.php';

if(!isset($_SESSION['user'])){
  header('Location: /connexion.php');
}

$filename = __DIR__ . '/public/data/users.json';

$errors = [
    'commentaire' => '',
    'note' => '',
];

$repasId = $_GET['id'];

$users = getTableauUsers($filename);

    foreach ($users as $user) {
        if (isset($user['repas'])) {
            foreach ($user['repas'] as $repas) {
                if ($repas['repasId'] == $repasId) {
                    $repasChoisi = $repas ?? [];
                    $userId = $user['userId'] ?? '';
                    $userPseudo = $user['pseudo'];
                    break;
                }
            }
        }
    }

    $indexUser = array_search($userId, array_column($users, 'userId'));
    $indexRepas = array_search($repasId, array_column($users[$indexUser]['repas'], 'repasId'));
    $repasAvis = $users[$indexUser]['repas'][$indexRepas]['avis'] ?? [];


if (isset($_POST["envoyer"])) {
    $_POST = filter_input_array(INPUT_POST, [
        'note' => FILTER_SANITIZE_SPECIAL_CHARS,
        'commentaire' => FILTER_SANITIZE_SPECIAL_CHARS,
    ]);

    $note = $_POST['note'] ?? '';
    $commentaire = $_POST['commentaire'] ?? '';

    if (!$note) {
        $errors['note'] = 'Entrez la note svp !';
    } elseif (!filter_var($note, FILTER_VALIDATE_INT)) {
        $errors['note'] = "Entrez l'entier svp !";
    } elseif ($note < 0 || $note > 10) {
        $errors['note'] = "Entrez la note entre 0 et 10 svp !";
    }

    if (!$commentaire) {
        $errors['commentaire'] = 'Entrez le commentaire svp !';
    }

    if (empty(array_filter($errors, fn($e) => $e !== ''))) {
        $users[$indexUser]['repas'][$indexRepas]['avis'] =
            [...$users[$indexUser]['repas'][$indexRepas]['avis'] ?? [], [
            'note' => $note,
            'commentaire' => $commentaire,
            'userPseudo' => $_SESSION['user']['pseudo']
        ],
        ];


        writeTableauUsersInFile($filename, $users);
        header('Location: /seulRepas.php?id='.$repasId);
    }

}

if (isset($_POST["annuler"])) {
    if ($_SESSION['user']) {
        header('Location: /');
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

  </div>
  <div class="boxesContainer">
  <!-- <div class="boxContent"> -->

  <?php if($_SESSION['user']['userId'] !== $userId) : ?>
    <!-- </div> -->
    <h3>Le repas d'utilisateur: <span><?=$userPseudo?></span></h3>
<br><br>
    <h3>Entrez votre commentaire et votre note: </h3>
    <form action="seulRepas.php?id=<?=$repasId?>" method="POST">
        <!-- <input type="number" name="note" min=0 max=10/> -->
        <label for="note">Votre note: </label>
        <input type="text" name="note" id="note" value="<?=$note ?? ''?>">
        <?php if ($errors['note']): ?>
          <p style="color:red;"><?=$errors['note']?></p>
        <?php endif;?>

<br><br>

        <label for="commentaire">Votre commentaire: </label>
        <input name="commentaire" id="commentaire" value="<?=$commentaire ?? ''?>">
        <!-- <textarea name="commentaire" id="commentaire" cols="50" rows="3">
        </textarea> -->
        <?php if ($errors['commentaire']): ?>
          <p style="color:red;"><?=$errors['commentaire']?></p>
        <?php endif;?>

        <input type="submit" name="envoyer" value="Envoyer">
        <input type="submit" name="annuler" value="Annuler">
    </form>
    <?php else :?>
        <h3>Le repas d'utilisateur: <span><?=$_SESSION['user']['pseudo']?></span></h3>
    <?php endif;?>
<br><br>

    <h3>Tous les commentaires: </h3>
    <table>
  <tr>
    <th>Utilisateur</th>
    <th>Commentaire</th>
    <th>Note</th>
  </tr>
  <?php foreach ($repasAvis as $avis): ?>
  <tr>
    <td><?=$avis['userPseudo']?></td>
    <td><?=$avis['commentaire']?></td>
    <td><?=$avis['note']?></td>
  </tr>
  <?php endforeach;?>
    </table>

<br><br>
    <?php if($_SESSION['user']['userId'] == $userId) : ?>

        <button>Modifier</button>

<br><br>
        <button>Supprimer</button>
    <?php endif;?>
</div>

</div>
</body>

</html>
