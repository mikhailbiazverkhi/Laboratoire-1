<?php

// fonctions pour les pages index.php et profil.php

function mergeTableauRepas($tableauxRepasParUser){
    foreach ($tableauxRepasParUser as $tableauxRepas) {
        $tableauRepas = array_merge($tableauRepas ?? [], $tableauxRepas);
     }
     return $tableauRepas;
}

function getTableauUserRepas($userId, $users){
    $userIndex = array_search($userId, array_column($users, 'userId'));

    return isset($users[$userIndex]['repas']) ? $users[$userIndex]['repas'] : [];
}


// les fonctions totales 

function getTableauUsers($filename){
    if (file_exists($filename)) {
        $users = json_decode(file_get_contents($filename), true) ?? [];
    }
    return $users;
}


function writeTableauUsersInFile($filename, $users){
    file_put_contents($filename, json_encode($users));
}





// fonction pour la page inscrire.php

function estPseudoUnique($pseudo)
{
    global $filename;
    if (file_exists($filename)) {
        $users = json_decode(file_get_contents($filename), true) ?? [];
    }
    if (!empty($users)) {
        foreach ($users as $user) {
            if ($user['pseudo'] == $pseudo) {
                return false;
            }
        }
    }
    return true;
}

?>