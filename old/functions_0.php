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


//fonctions de filtrage, triage et recheche

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

// fonction de triage par prix
function sortParPrix($tableauRepas, $ordre){
    if(!empty($ordre)){
        $sortTableau = [];
        $tableauPrixRepas = array_column($tableauRepas, 'prixRepas');
        if($ordre === "croissant"){
           asort($tableauPrixRepas);
        } else if ($ordre === "decroissant"){
           arsort($tableauPrixRepas);
        }
        foreach($tableauPrixRepas as $key => $value){
            $sortTableau = [...$sortTableau, $tableauRepas[$key]];
        }        
       return $sortTableau;
    }
    return $tableauRepas;
 }


/* fonction de recherche par critères 
($critere = 'nomRepas' Nom de repas ou $critere = 'description' repas spécifiques*/ 

 function rechercheParCriteres($tableauRepas, $motcle, $critere){
    if(!empty($motcle)){
        $tableauRepasCherches = [];
        $tableauNomRepas = array_column($tableauRepas, $critere);

        $tableauNomsCherches = 
        array_filter($tableauNomRepas, fn($v) => strripos($v, $motcle) !== FALSE);

        foreach($tableauNomsCherches as $key => $value){
            $tableauRepasCherches = [...$tableauRepasCherches, $tableauRepas[$key]];
        }        
       return $tableauRepasCherches;
    }
    return $tableauRepas;
 }


//  function rechercheParNomRepas($tableauRepas, $motcle){
//     if(!empty($motcle)){
//         $tableauRepasCherches = [];
//         $tableauNomRepas = array_column($tableauRepas, 'nomRepas');

//         $tableauNomsCherches = 
//         array_filter($tableauNomRepas, fn($v) => strripos($v, $motcle) !== FALSE);

//         foreach($tableauNomsCherches as $key => $value){
//             $tableauRepasCherches = [...$tableauRepasCherches, $tableauRepas[$key]];
//         }        
//        return $tableauRepasCherches;
//     }
//     return $tableauRepas;
//  }



//  function rechercheParRepasSpecifiques($tableauRepas, $motcle){
//     if(!empty($motcle)){
//         $tableauRepasCherches = [];
//         $tableauNomRepas = array_column($tableauRepas, 'description');

//         $tableauNomsCherches = 
//         array_filter($tableauNomRepas, fn($v) => strripos($v, $motcle) !== FALSE);

//         foreach($tableauNomsCherches as $key => $value){
//             $tableauRepasCherches = [...$tableauRepasCherches, $tableauRepas[$key]];
//         }        
//        return $tableauRepasCherches;
//     }
//     return $tableauRepas;
//  }


?>