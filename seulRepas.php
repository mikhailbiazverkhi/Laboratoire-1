<?php

// if(!isset($_SESSION['user'])){
//   header('Location: /connexion.php');
// }

$filename = __DIR__ . '/public/data/users.json';
$repasId = $_GET['id'];
print_r($repasId);

if (file_exists($filename)) {
    $users = json_decode(file_get_contents($filename), true) ?? [];
}

foreach ($users as $user) {
    if (isset($user['repas'])) {
        foreach ($user['repas'] as $repas) {
            if ($repas['repasId'] == $repasId) {
                echo '<pre>';
                print_r($repas);
                echo '</pre>';
                echo "UserId: ".$user['userId'];
            }
        }
    }

}
