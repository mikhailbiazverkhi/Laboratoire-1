<?php

session_start();

require './helpers/functions.php';

if (!isset($_SESSION['user'])) {
    header('Location: /connexion.php');
}

$filename = __DIR__ . '/public/data/users.json';

$errors = [
    'commentaire' => '',
    'note' => '',
];

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
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
            'userPseudo' => $_SESSION['user']['pseudo'],
        ],
        ];

        writeTableauUsersInFile($filename, $users);
        header('Location: /seulRepas.php?id=' . $repasId);
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
    <?php require './includes/head.php'?>

    <title>User account</title>
    <link rel="stylesheet" href="public/css/seulRepas.css">
</head>

<body>

<div class="container d-grid gap-1 px-4">
    <div class="row">
        <div class="col mt-4 mb-4">
            <div class="text-center">
                <?php if ($_SESSION['user']['userId'] !== $userId): ?>
                    <h4>Le repas d'utilisateur: <span><?=$userPseudo?></span></h4>
                <?php else: ?>
                    <h4>Le repas d'utilisateur: <span><?=$_SESSION['user']['pseudo']?></span></h4>
                <?php endif;?>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col d-flex align-content-center justify-content-center">
            <img src="<?=$repasChoisi['cheminImage']?>" class="img-fluid" alt="Food Image">
        </div>

        <div class="col d-grid gap-1">
                <h5>Nom du repas: <?=$repasChoisi['nomRepas']?></h5>
                <h5>Nom du repas: <?=$repasChoisi['prixRepas']?>$</h5>
                <h5>Localisation: <?=$repasChoisi['localisation']?></h5>
                <h5>Description: </h5>
                <p><?=$repasChoisi['description']?></p>
        </div>
  </div>

  <div class="row">

    <div class="col my-4">
        <h4 class="text-center">Tous les commentaires: </h4>
        <div style="overflow-y:scroll; height:250px;">
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
        </div>
    </div>

    <div class="col mt-4 mb-5">

        <?php if ($_SESSION['user']['userId'] !== $userId): ?>
            <h4 class="text-center">Entrez votre commentaire et votre note: </h4>
            <form action="seulRepas.php?id=<?=$repasId?>" method="POST">

                <div class="mb-3">
                    <label for="note" class="form-label">Votre note: </label>
                    <input type="text" class="form-control" name="note" id="note" value="<?=$note ?? ''?>"/>
                    <?php if ($errors['note']): ?>
                        <p style="color:red;"><?=$errors['note']?></p>
                    <?php endif;?>
                </div>

                <div class="mb-3">
                    <label for="commentaire" class="form-label">Votre commentaire: </label>
                    <textarea class="form-control" name="commentaire" id="commentaire" rows="3"></textarea>
                    <?php if ($errors['commentaire']): ?>
                        <p style="color:red;"><?=$errors['commentaire']?></p>
                    <?php endif;?>
                </div>
                <div class="d-flex justify-content-end gap-5 mt-4" >
                    <input class="btn btn-primary" type="submit" name="envoyer" value="Envoyer">
                    <input class="btn btn-secondary" type="submit" name="annuler" value="Annuler">
                </div>
            </form>

        <?php else :?>
            <div class="d-flex justify-content-around" >
                <a class="btn btn-primary" role="button" href="/modifierRepas.php?id=<?=$repasId?>">Modifier</a>
                <a class="btn btn-secondary" role="button" href="/index.php">Annuler</a>
                <a class="btn btn-danger" role="button" href="/supprimerRepas.php?id=<?=$repasId?>">Supprimer</a>
            </div>
        <?php endif;?>
    </div>
  </div>
</div>

</body>

</html>
