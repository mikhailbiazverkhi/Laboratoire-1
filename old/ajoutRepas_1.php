<?php
session_start();

if(!isset($_SESSION['user'])){
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

$userId = $_SESSION['user']['userId'];

if (file_exists($filename)) {
    $users = json_decode(file_get_contents($filename), true) ?? [];
    $userIndex = array_search($userId, array_column($users, 'userId'));
    //$user = $users[$userIndex];
}

if (isset($_POST["ajouter"])) {
    $_POST = filter_input_array(INPUT_POST, [
        'nomRepas' => FILTER_SANITIZE_SPECIAL_CHARS,
        'prixRepas' => FILTER_SANITIZE_SPECIAL_CHARS,
        'localisation' => FILTER_SANITIZE_SPECIAL_CHARS,
        'description' => FILTER_SANITIZE_FULL_SPECIAL_CHARS
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

    $chemin_image = 'uploads/' . time() . '_' . $_FILES['image']['name'];

    if (!move_uploaded_file($_FILES['image']['tmp_name'], './' . $chemin_image)) {
        $errors['image'] = 'Téléversez l\'image svp !';
    }

    if (empty(array_filter($errors, fn($e) => $e !== ''))) {

        $users[$userIndex]['repas'] = [...$users[$userIndex]['repas'] ?? [], [

            'nomRepas' => $nomRepas,
            'cheminImage' => $chemin_image,
            'prixRepas' => $prixRepas,
            'localisation' => $localisation,
            'description' => $description,
            'repasId' => time()
        ]
        ];

        file_put_contents($filename, json_encode($users));

          header('Location: /indexUser.php');

    }
}

if (isset($_POST["annuler"])) { 
  header('Location: /indexUser.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ajouter un repas</title>
  <link rel="stylesheet" href="public/css/ajoutRepas.css">
</head>

<body>
  <main class="container">
    <h2>Ajouter un nouveau repas</h2>
    <form action="" method="POST" enctype="multipart/form-data">
      <div class="input-field">
        <label for="nomRepas">Nom du Repas</label>
        <!-- <input type="text" name="nomRepas" id="nomRepas" placeholder="Veuillez entrer un Nom" value="<?=$nomRepas ?? ''?>"> -->
        <input type="text" name="nomRepas" id="nomRepas" value="<?=$nomRepas ?? ''?>">
        <?php if ($errors['nomRepas']): ?>
          <p style="color:red;"><?=$errors['nomRepas']?></p>
          <!-- <p class="text-danger""><?=$errors['nomRepas']?></p> -->
        <?php endif;?>
        <div class="underline"></div>
      </div>

      <div class="input-field">
        <label for="image">Image</label>
        <input type="file" id="image" name="image" accept="image/*">
        <?php if ($errors['image']): ?>
          <p style="color:red;"><?=$errors['image']?></p>
        <?php endif;?>
        <div class="underline"></div>
      </div>

      <div class="input-field">
        <label for="prixRepas">Prix du repas</label>
        <!-- <input type="number" name="prixRepas" id="prixRepas" placeholder="Entrer le prix du repas" value="<?=$prixRepas ?? ''?>"> -->
        <!-- <input type="number" name="prixRepas" id="prixRepas" value="<?=$prixRepas ?? ''?>"> -->
        <input type="text" name="prixRepas" id="prixRepas" value="<?=$prixRepas ?? ''?>">
        <?php if ($errors['prixRepas']): ?>
          <p style="color:red;"><?=$errors['prixRepas']?></p>
        <?php endif;?>
        <div class="underline"></div>
      </div>
      <div class="input-field">
        <label for="localisation">Localisation</label>
        <!-- <input type="text" name="localisation" id="localisation" placeholder="Entrer la Localisation" value="<?=$prixRepas ?? ''?>"> -->
        <input type="text" name="localisation" id="localisation" value="<?=$localisation ?? ''?>">
        <?php if ($errors['localisation']): ?>
          <p style="color:red;"><?=$errors['localisation']?></p>
        <?php endif;?>
        <div class="underline"></div>
      </div>

      <div class="description">
        <label for="description">Description</label>
        <!-- <textarea name="description" id="description" placeholder="Description"><?=$description ?? ''?></textarea> -->
        <textarea name="description" id="description"><?=$description ?? ''?></textarea>
        <?php if ($errors['description']): ?>
          <p style="color:red;"><?=$errors['description']?></p>
        <?php endif;?>
        <div class="underline"></div>
      </div>


      <input type="submit" name="ajouter" value="Ajouter">
      <input type="submit" name="annuler" value="Annuler"/>
    </form>
  </main>
</body>

</html>