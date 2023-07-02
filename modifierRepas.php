<?php
session_start();

require './helpers/functions.php';

if (!isset($_SESSION['user'])) {
    header('Location: /');
}

$filename = __DIR__ . '/public/data/users.json';

$errors = [
    'nomRepas' => '',
    'prixRepas' => '',
    'localisation' => '',
    'description' => '',
    'image' => '',
];

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
$repasId = $_GET['id'];

$userId = $_SESSION['user']['userId'];

$users = getTableauUsers($filename);

$userIndex = array_search($userId, array_column($users, 'userId'));
$user = $users[$userIndex]['repas'];

$repasIndex = array_search($repasId, array_column($user, 'repasId'));
$repas = $user[$repasIndex];

if (isset($_POST["modifier"])) {
    $_POST = filter_input_array(INPUT_POST, [
        'nomRepas' => FILTER_SANITIZE_SPECIAL_CHARS,
        'prixRepas' => FILTER_SANITIZE_SPECIAL_CHARS,
        'localisation' => FILTER_SANITIZE_SPECIAL_CHARS,
        'description' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    ]);

    $nomRepas = $_POST['nomRepas'] ?? '';
    $prixRepas = $_POST['prixRepas'] ?? '';
    $localisation = $_POST['localisation'] ?? '';
    $description = $_POST['description'] ?? '';

    if (!$nomRepas) {
        $errors['nomRepas'] = 'Entrez le titre svp !';
    }

    if (!$prixRepas) {
        $errors['prixRepas'] = 'Entrez un prix svp !';
    } elseif (!filter_var($prixRepas, FILTER_VALIDATE_FLOAT)) {
        $errors['prixRepas'] = 'Entrez le prix valide svp !';
    }

    if (!$localisation) {
        $errors['localisation'] = 'Entrez une localisation svp !';
    }

    if (!$description) {
        $errors['description'] = 'Entrez la description svp !';
    }

    if (empty(array_filter($errors, fn($e) => $e !== ''))) {

        $users[$userIndex]['repas'][$repasIndex]['nomRepas'] = $nomRepas;
        $users[$userIndex]['repas'][$repasIndex]['prixRepas'] = $prixRepas;
        $users[$userIndex]['repas'][$repasIndex]['localisation'] = $localisation;
        $users[$userIndex]['repas'][$repasIndex]['description'] = $description;

        writeTableauUsersInFile($filename, $users);
        header('Location: /profil.php');
    }
}

if (isset($_POST["annuler"])) {
    header('Location: /profil.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ajouter un repas</title>
  <link rel="stylesheet" href="public/css/style.css">
</head>

<body>
  <main class="container">
    <h2>Modifier un repas</h2>
    <form action="" method="POST" enctype="multipart/form-data">
      <div class="input-field">
        <label for="nomRepas">Nom du Repas</label>
        <input type="text" name="nomRepas" id="nomRepas" value="<?=$repas['nomRepas'] ?? ''?>">
        <?php if ($errors['nomRepas']): ?>
          <p style="color:red;"><?=$errors['nomRepas']?></p>
        <?php endif;?>
        <div class="underline"></div>
      </div>

      <div class="input-field">
        <label for="prixRepas">Prix du repas</label>
        <input type="text" name="prixRepas" id="prixRepas" value="<?=$repas['prixRepas'] ?? ''?>">
        <?php if ($errors['prixRepas']): ?>
          <p style="color:red;"><?=$errors['prixRepas']?></p>
        <?php endif;?>
        <div class="underline"></div>
      </div>

      <div class="input-field">
        <label for="localisation">Localisation</label>
        <input type="text" name="localisation" id="localisation" value="<?=$repas['localisation'] ?? ''?>">
        <?php if ($errors['localisation']): ?>
          <p style="color:red;"><?=$errors['localisation']?></p>
        <?php endif;?>
        <div class="underline"></div>
      </div>

      <div class="description">
        <label for="description">Description</label>
        <textarea name="description" id="description"><?=$repas['description'] ?? ''?></textarea>
        <?php if ($errors['description']): ?>
          <p style="color:red;"><?=$errors['description']?></p>
        <?php endif;?>
        <div class="underline"></div>
      </div>

      <input type="submit" name="modifier" value="Modifier">
      <input type="submit" name="annuler" value="Annuler"/>
    </form>
  </main>
</body>

</html>