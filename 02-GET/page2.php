<h1>Détail du produit</h1>

<?php
// ---------------------------------
// La superglobale $_GET
// ---------------------------------
// $_GET représente les informations  qui transitent dans l'url. Il  s'agit d'une superglobale, et comme toutes les superglobales, il s'agit d'un ARRAY. Superglobale signifie que cet array est disponible dans tous les contextes du script, y compris dans l'espace local des fonctions.


// Les informations transitent dans l'url  sous la forme suivante : page.php?cle1=valeur1&cleN=valeurN

// $_GET transforme les informations passées dans l'url en un array : $_GET = array('cle1' => 'valeur1', 'cleN' => 'valeurN').

var_dump($_GET);

if (isset($_GET['article']) && isset($_GET['couleur']) && isset($_GET['prix'])) {
   
    echo '<p> Article : ' . $_GET['article'] . '</p>';
    echo '<p> Couleur : ' . $_GET['couleur'] . '</p>';
    echo '<p> Prix : ' . $_GET['prix'] . ' €</p>';
} else {
    echo '<p>Aucun produit sélectionné....</p>';
}