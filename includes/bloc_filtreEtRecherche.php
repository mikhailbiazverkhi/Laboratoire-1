<?php

//nom du fichier pour former lien de la GET requête (voir le fichier "triageEtRecherche.php")
$nomFichier = $_SERVER['SCRIPT_NAME'];

//filtrer par localisation
if(isset($_GET['localisation'])){
   $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
   $localisation = $_GET['localisation'] ?? '';
   $tableauRepas = filtreLocalisations($tableauRepas, $localisation);
}

//trier par prix
if(isset($_GET['prix'])){
   $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
   $ordrePrix = $_GET['prix'] ?? '';
   $tableauRepas = sortParPrix($tableauRepas, $ordrePrix);
}

/* recherche par deux critères: nom de plat ($critere = 'nomRepas') 
et repas spécifiques ($critere = 'description')*/
if(isset($_GET['recherche'])){
   $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
   $motcle = $_GET['recherche'] ?? '';

   $critere = 'nomRepas';          // Nom de repas
   //$critere = 'description';     // Repas spécifiques

   $tableauRepas = rechercheParCriteres($tableauRepas, $motcle, $critere);
}

?>