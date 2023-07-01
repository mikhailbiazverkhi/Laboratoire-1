<?php
session_start();

require './helpers/functions.php';

$filename = __DIR__ . '/public/data/users.json';

$errors = [
    'pseudo' => '',
    'motDePasse' => '',
    'messageDeConnexion' => '',
];

if (isset($_POST["continuer"])) {

    $_POST = filter_input_array(INPUT_POST, [
        'pseudo' => FILTER_SANITIZE_SPECIAL_CHARS,
        'motDePasse' => FILTER_SANITIZE_SPECIAL_CHARS,
    ]);

    $pseudo = $_POST['pseudo'] ?? '';
    $motDePasse = $_POST['motDePasse'] ?? '';

    if (!$pseudo) {
        $errors['pseudo'] = 'Entrez le pseudo svp !';
    }

    if (!$motDePasse) {
        $errors['motDePasse'] = 'Entrez le mot de passe svp !';
    }

    if (empty(array_filter($errors, fn($e) => $e !== ''))) {
        // if (file_exists($filename)) {
        //     $users = json_decode(file_get_contents($filename), true) ?? [];
        // }

        $users = getTableauUsers($filename);

        if (!empty($users)) {
            foreach ($users as $user) {
                if ($user['pseudo'] === $pseudo && $user['motDePasse'] === $motDePasse) {

                    $_SESSION['user'] = [
                        "userId" => $user["userId"],
                        "pseudo" => $user["pseudo"],
                        "courriel" => $user["courriel"],
                    ];

                    header('Location: /profil.php');

                } else {
                    $errors['messageDeConnexion'] = 'Entrez le pseudo ou le mot de passe valide !';
                }
            }
        } else {
            $errors['messageDeConnexion'] = 'Créez votre compte !';
        }
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
 <title>Log In</title>
 <link rel="stylesheet" href="public/css/style.css">
</head>

<body>

 <main class="container">
  <h2>Login</h2>
  <form class="gap" action="" method="POST">
    
   <div class="input-field">
    <input type="text" name="pseudo" id="pseudo" value="<?=$pseudo ?? ''?>" placeholder="Enter votre pseudo"/>
    <div class="underline"></div>
    <?php if ($errors['pseudo']): ?>
        <p style="color:red;"><?=$errors['pseudo']?></p>
    <?php endif;?>
   </div>
   <div class="input-field">
    <input type="password" name="motDePasse" id="motDePasse" value="<?=$motDePasse ?? ''?>" placeholder="Enter votre mot de passe"/>
    <div class="underline"></div>
    <?php if ($errors['motDePasse']): ?>
        <p style="color:red;"><?=$errors['motDePasse']?></p>
    <?php endif;?>
   </div>
   <?php if ($errors['messageDeConnexion']): ?>
        <p style="color:red;"><?=$errors['messageDeConnexion']?></p>
    <?php endif;?>

   <input type="submit" name="continuer" value="Continuer"/>
   <input type="submit" name="annuler" value="Annuler"/>

  </form>

  <div class="footer">
    <span>N'avez-vous pas de compte? <a href="./inscrire.php"><u>Enregistrer ici</u></a></span>
  </div>
 </main>
</body>

</html>