<?php

// ----------- fonction de debug ---------------

function  debug($param) {
    echo '<pre>';
        print_r($param);
    echo '</pre>';
}


// -------------- fonctions membres -------------- 

// Fonction qui indique si l'internaute est connecté :
function internauteEstConnecte() {
    if(isset($_SESSION['membre'])) {    // si la session "membre"" existe, c'est que l'internaute est passé par la page de connexion et que nous avons créé cet indice dans $_SESSION.
        return true;
    } else {
        return false;
    }
    // OU :
    return (isset($_SESSION['membre']));
}


// Fonction qui indique si le membre est admin connecté : 
function internauteEstConnecteEtAdmin() {
    if (internauteEstConnecte() && $_SESSION['membre']['statut'] == 1) { // si membre connecté ET que son statut dans la session vaut 1, il est admin connecté
        return true;
    } else {
        return false;
    }

    // OU : 
    return (internauteEstConnecte() && $_SESSION['membre']['statut'] == 1);
} 


// *----------------------------- fonction de requête -----------------------------------
function executeRequete($req, $param = array()) {   /// cette fonction attend 2 valeurs : une requête SQL (obligatoire) et un array qui associe les marqueurs aux valeurs (non obligatoire car on a affecté au paramètre un array() vide par défaut)

    // Échappement des données reçues avec htmlspecialchars :
    if (!empty($param)) {   /// si l'array $param ,n'est pas vide, je peux faire la boucle
    foreach ($param as $indice => $valeur ) {
        $param[$indice] = htmlspecialchars($valeur, ENT_QUOTES);    /// on échappe les valeurs de $param que l'on remet à leur place dans $param[$indice]
        }
    }

    global $pdo;    // permet d'avoir accès à la variable $pdo définie dans l'espace global (c'est-à-dire hors de cette fonction) au sein de cette fonction

    $result = $pdo->prepare($req);  // on prépare la requête envoyée à notre fonction
    $result->execute($param);   // on exécute la requête en lui donnant l'array présent dans $param qui associe tous les marqueurs à leur valeur
    return $result; // on retourne le résultat de la requête de SELECT

}
