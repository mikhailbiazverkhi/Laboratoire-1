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


function noteMoyenneRepas($repas){
    $sum = 0;
    if(isset($repas['avis'])){
        foreach($repas['avis'] as $avis){
            $sum += $avis['note'];
        }
        return round($sum/count($repas['avis']),1);
    }
    return 0;
}

function nombreCommentairs($repas){
    $count = 0;
    if(isset($repas['avis'])){
        foreach($repas['avis'] as $avis){
            if(!empty($avis['commentaire'])){
                $count++;
            }
        }
    }
    return $count;
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


// fonction de filtrage des localisations

function filtreLocalisations($tableauRepas, $localisation){
    if(!empty($localisation)){
        $repasParLocalisation = [];
        foreach($tableauRepas as $repas){
           if($repas['localisation'] === $localisation){
              $repasParLocalisation = [...$repasParLocalisation, $repas];
           }
        } 
        return $repasParLocalisation;
    } 
    return $tableauRepas;
}



?>