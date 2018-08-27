<?php
require_once '../inc/init.inc.php';

// 1- On vérifie membre est admin : 
if (!internauteEstConnecteEtAdmin()) {
    header('location:../connexion.php');    // si pas admin, on le redirige vers la page de connexion
    exit();
}

// 2- Affichage des produits dans le back-office : 
// Exercice : afficher tous les produits sous forme de table HTML que vous stockez dans la variable $contenu. Tous les champs doivent être affichés. Pour la photo, afficher une image (de 90px de coté).

$resultat = $pdo->query("SELECT * FROM produit");

$contenu .= '<table border="1">';
    // La ligne d'entêtes : 
    $contenu .= '<tr>';
    $contenu .= '<th>id_produit</th>';
        $contenu .= '<th>Référence</th>';
        $contenu .= '<th>Catégorie</th>';
        $contenu .= '<th>Titre</th>';
        $contenu .= '<th>Description</th>';
        $contenu .= '<th>Couleur</th>';
        $contenu .= '<th>Taille</th>';
        $contenu .= '<th>Public</th>';
        $contenu .= '<th>Photo</th>';
        $contenu .= '<th>Prix</th>';
        $contenu .= '<th>Stock</th>';
    $contenu .= '</tr>';

    // Affichage des autres lignes :
    while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
        $contenu .='<tr>';
            // Affichage des infos de chaque ligne $ligne : 
        foreach ($ligne as $indice => $value) {
            
            if ($indice == 'photo') {
                $contenu .= '<td><img src="../'. $value .'" width=90" alt=""></td>';
            } else {
                $contenu .= '<td>' . $value . '</td>';
            }
        }// fin foreach
        $contenu .= '</tr>';
    }
$contenu .= '</table>';





// ---------------------------- AFFICHAGE ---------------------------
require_once '../inc/haut.inc.php';
?>
    <h1 class="mt-4">Gestion boutique</h1>

    <ul class="nav nav-tabs">
        <li><a class="nav-link active" href="gestion_boutique.php">Affichage des produits</a></li>
        <li><a class="nav-link" href="ajout_produit.php">Ajout d'un produit</a></li>
    </ul>

<?php
echo $contenu;
require_once '../inc/bas.inc.php';