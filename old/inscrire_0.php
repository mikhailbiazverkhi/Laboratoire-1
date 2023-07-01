<?php

require './helpers/functions.php';

$filename = __DIR__ . '/public/data/users.json';

$errors = [
    'pseudo' => '',
    'courriel' => '',
    'motDePasse' => '',
    'motDePasse_confirmation' => '',
    'message_motDePasse' => '',
];

if (isset($_POST["continuer"])) {

    $_POST = filter_input_array(INPUT_POST, [
        'pseudo' => FILTER_SANITIZE_SPECIAL_CHARS,
        'courriel' => FILTER_SANITIZE_EMAIL,
        'motDePasse' => FILTER_SANITIZE_SPECIAL_CHARS,
        'motDePasse_confirmation' => FILTER_SANITIZE_SPECIAL_CHARS,
    ]);

    $pseudo = $_POST['pseudo'] ?? '';
    $courriel = $_POST['courriel'] ?? '';
    $motDePasse = $_POST['motDePasse'] ?? '';
    $motDePasse_confirmation = $_POST['motDePasse_confirmation'] ?? '';

    if (!$pseudo) {
        $errors['pseudo'] = 'Entrez le pseudo svp !';
    } elseif (!estPseudoUnique($pseudo)) {
        $errors['pseudo'] = 'Pseudo n\'est pas unique';
    }

    if (!$courriel) {
        $errors['courriel'] = 'Entrez le courriel svp !';
    } elseif (!filter_var($courriel, FILTER_VALIDATE_EMAIL)) {
        $errors['courriel'] = "Entrez le courriel valide svp !";
    }

    if (!$motDePasse) {
        $errors['motDePasse'] = 'Entrez le mot de passe svp !';
    }

    if (!$motDePasse_confirmation) {
        $errors['motDePasse_confirmation'] = 'Répétez le mot de passe svp !';
    }

    if ($motDePasse != $motDePasse_confirmation && $motDePasse && $motDePasse_confirmation) {
        $errors['message_motDePasse'] = 'Les mots de passe ne sont pas identiques';
    }

    if (empty(array_filter($errors, fn($e) => $e !== ''))) {
        // if (file_exists($filename)) {
        //     $users = json_decode(file_get_contents($filename), true) ?? [];
        // }

        $users = getTableauUsers($filename);

        if (!empty($users)) {
            $userId = $users[count($users) - 1]['userId'];
        } else {
            $userId = 0;
        }

        $users = [...$users, [

            'pseudo' => trim($pseudo),
            'courriel' => trim($courriel),
            'motDePasse' => $motDePasse,
            'userId' => ++$userId,
        ],
        ];

        //file_put_contents($filename, json_encode($users));
        writeTableauUsersInFile($filename, $users);
        header('Location: /connexion.php');
    }
}

    if (isset($_POST["annuler"])) {
        header('Location: /');
    }

?>



<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Sign Up</title>
 <link rel="stylesheet" href="public/css/style.css">
</head>

<body>

 <main class="container">
  <h2>S'inscrire</h2>
  <form class="gap" action="" method="POST">

   <div class="input-field">
    <input type="text" name="pseudo" id="pseudo" value="<?=$pseudo ?? ''?>" placeholder="Entrer un pseudo"/>
    <div class="underline"></div>
    <?php if ($errors['pseudo']): ?>
        <p style="color:red;"><?=$errors['pseudo']?></p>
    <?php endif;?>
   </div>
   <div class="input-field">
    <input type="text" name="courriel" id="courriel" value="<?=$courriel ?? ''?>" placeholder="Entrer un courriel"/>
    <div class="underline"></div>
    <?php if ($errors['courriel']): ?>
        <p style="color:red;"><?=$errors['courriel']?></p>
    <?php endif;?>
   </div>

   <div class="input-field">
    <input type="password" name="motDePasse" id="motDePasse" value="<?=$motDePasse ?? ''?>" placeholder="Entrer le mot de passe"/>
    <div class="underline"></div>
    <?php if ($errors['motDePasse']): ?>
        <p style="color:red;"><?=$errors['motDePasse']?></p>
    <?php endif;?>
   </div>
   <div class="input-field">
    <input type="password" name="motDePasse_confirmation" id="motDePasse_confirmation" value="<?=$motDePasse_confirmation ?? ''?>" placeholder="Confirmer le mot de passe"/>
    <div class="underline"></div>
    <?php if ($errors['motDePasse_confirmation']): ?>
        <p style="color:red;"><?=$errors['motDePasse_confirmation']?></p>
    <?php endif;?>
   </div>
    <?php if ($errors['message_motDePasse']): ?>
        <p style="color:red;"><?=$errors['message_motDePasse']?></p>
    <?php endif;?>

   <input type="submit" name="continuer" value="Continuer"/>
   <input type="submit" name="annuler" value="Annuler"/>

  </form>

  <div class="footer">
    <span>Avez-vous déjà un compte? <a href="./connexion.php"><u>Identification ici</u></a></span>
  </div>

 </main>
</body>

</html>