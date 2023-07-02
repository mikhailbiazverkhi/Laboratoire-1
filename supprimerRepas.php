<?php
session_start();

require './helpers/functions.php';

if (!isset($_SESSION['user'])) {
    header('Location: /');
}

$filename = __DIR__ . '/public/data/users.json';

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
$repasId = $_GET['id'];

$userId = $_SESSION['user']['userId'];

$users = getTableauUsers($filename);

$userIndex = array_search($userId, array_column($users, 'userId'));
$user = $users[$userIndex]['repas'];

$repasIndex = array_search($repasId, array_column($user, 'repasId'));

unset($users[$userIndex]['repas'][$repasIndex]);

writeTableauUsersInFile($filename, $users);

header('Location: /profil.php');

?>