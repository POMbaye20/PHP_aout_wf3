<?php

// Exercice : 
/*  Vous allez créer la page de gestion des membres dans le back-office : 
    1- Seul les admin ont accès à cette page. Les autres sont redirigés vers connexion.php. 
    2- Afficher dans cette page tous les membres inscrits sous forme de table HMTL, avec toutes les infos SAUF le mot de passe.
    3- Afficher le nombre de membres.
*/


require_once '../inc/init.inc.php'; 


if (!internauteEstConnecteEtAdmin()) {
    header('location:../connexion.php');    // si pas admin, on le redirige vers la page de connexion
    exit();
}

// 2- Table HTML
$resultat = $pdo->query("SELECT id_membre, pseudo, nom, prenom, email, civilite, ville, code_postal, adresse, statut FROM membre"); 

   $contenu .= '<p><i>Le nombre de membres est de    '. $resultat->rowCount() .'.</i></p>';   // pour afficher le nombre de membres

$contenu .= '<table border="1">';
    // La ligne d'entêtes : 
    $contenu .= '<tr>';
        $contenu .= '<th>id_membre</th>';
        $contenu .= '<th>Pseudo</th>';
        $contenu .= '<th>Nom</th>';
        $contenu .= '<th>Prénom</th>';
        $contenu .= '<th>Email</th>';
        $contenu .= '<th>Civilité</th>';
        $contenu .= '<th>Ville</th>';
        $contenu .= '<th>Code</th>';
        $contenu .= '<th>Adresse</th>';
        $contenu .= '<th>Statut</th>';
    $contenu .= '</tr>';

    while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
        $contenu .='<tr>';
            // Affichage des infos de chaque ligne $ligne : 
        foreach ($ligne as $indice => $value) {            
            $contenu .= '<td>' . $value . '</td>';
        }// fin foreach

        $contenu .= '</tr>';
    }
$contenu .= '</table>';




// --------------------------- AFFICHAGE ---------------------------
require_once '../inc/haut.inc.php'; 
?>

    <h1 class="mt-4">Gestion membres</h1>
<?php
echo $contenu;
require_once '../inc/bas.inc.php'; 