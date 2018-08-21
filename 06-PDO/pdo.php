<?php

// -----------------------------
//              PDO
// -----------------------------
// PDO pour PHP Data Objects est une extension de PHP qui définit une interface pour accéder à une base de données depuis PHP (via du SQL).


function debug($param) {
    echo '<pre>';
        var_dump($param);
    echo '</pre>';
}


// --------------------------
// 01- Connexion à la BDD
// --------------------------
echo '<h3> 01- Connexion à la BDD </h3>';

$pdo = new PDO('mysql:host=localhost;dbname=entreprise',    // driver mysql : serveur ; nom de la BDD
                'root',     // pseudo de la BDD
                '', // mot de passe de la BDD 
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,    // option 1 : pour afficher les erreurs SQL
                      PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8') // option 2 : définit le jeu de caractères des échanges avec la BDD
                ); 

// $pdo est un objet issu de la classe prédéfinie PDO.  Il représente la connexion à la BDD. 



// -----------------------------------------
// 02- exec() avec INSERT, DELETE et UDPATE
// -----------------------------------------
echo '<h3> 02- exec() avec INSERT, DELETE et UDPATE </h3>';

// Notre première requête SQL : 
$resultat = $pdo->exec("INSERT INTO employes (prenom, nom, sexe, service, date_embauche, salaire) 
                        VALUES ('test', 'test', 'm', 'test', '2018-03-27', 500)");

// exec() est utilisé pour la formulation de requête ne retournant pas de jeu de résultats : INSERT, DELETE et UPDATE. 

/* Valeur de retour (dans $resultat) : 
                - en cas de succès : 1 ou plus, qui correspond au nombre de lignes affectées par la requête
                - en cas d'echec   : false
*/

echo "Nombre d'enregistrements affectés par l'INSERT : $resultat <br>";
echo 'Dernier id généré après la requête : ' . $pdo->lastInsertId();    // méthode qui permet de récupérer depuis la BDD le dernier id inséré par la requête précédente


// ---------
$resultat = $pdo->exec("DELETE FROM employes WHERE prenom = 'test'"); 
echo "<br> Nombre d'enregistrements affectés par DELETE : $resultat";



// -------------------------------------------------------
// 03- query() avec SELECT ET fetch() avec 1 seul résultat
// -------------------------------------------------------
echo '<h3> 03- query() avec SELECT ET fetch() avec 1 seul résultat </h3>';

$result = $pdo->query("SELECT * FROM employes WHERE prenom = 'daniel'");

// Au contraire de exec(), query() est utilisé pour les requêtes qui retournent un ou plusieurs résultats provenant de la BDD : SELECT. Notez que query() peut être aussi utilisé avec INSERT, UDPATE ou DELETE.

/* Valeur de retours : 
            - en cas de succès  : nouvel objet issu de la classe prédéfinie PDOStatement
            - en cas d'échec    : false
*/

debug($result);

// $result est le résultat de la requête sous une forme inexploitable directement : il faut donc le transformer avec la méthode fetch() :
$employe = $result->fetch(PDO::FETCH_ASSOC);    // la méthode fetch() avec son paramètre PDO::FETCH_ASSOC permet de transformer l'objet $result en un ARRAY ASSOCIATIF exploitable (ici $employe) indexé avec le nom des champs de la table.

debug($employe);    // Pour voir l'array associatif

echo 'Je suis ' . $employe['prenom'] . ' ' . $employe['nom'] . ' du service ' . $employe['service'] . '.<br>';


// -------
// Les trois autres méthodes de fetch() : 

$result = $pdo->query("SELECT * FROM employes WHERE prenom = 'daniel'");
$employe = $result->fetch(PDO::FETCH_NUM);  // transform $result en un array indexé numériquement
debug($employe); 
echo $employe[1] . '<br>';  /// affiche Daniel


$result = $pdo->query("SELECT * FROM employes WHERE prenom = 'daniel'");
$employe = $result->fetch();    // sans paramètre fetch() mélange array associatif et array numérique
debug($employe);  
echo $employe['prenom'] . '<br>';   // ou alors : 
echo $employe[1] . '<br>';


$result = $pdo->query("SELECT * FROM employes WHERE prenom = 'daniel'");
$employe = $result->fetch(PDO::FETCH_OBJ);  // transforme en un objet avec les noms des champs de la table comme propriétés de cet objet
debug($employe);
echo $employe->prenom . '<br>'; 

// Attention : après une requête, il faut choisir l'un des fetch(). Si l'on veut en refaire un, il faut refaire la requête : en effet, on ne peut pas effectuer plusieurs transformations successives sur le même objet $result.


// ------------------------
// Exercice : afficher le service de l'employé dont l'id_employe est 417 (production)

$result = $pdo->query("SELECT * FROM employes WHERE id_employes = 417");
$employe  = $result->fetch(PDO::FETCH_OBJ);  
debug($employe);
echo $employe->service . '<br>'; 

// ou

$result = $pdo->query("SELECT service FROM employes WHERE id_employes = 417");
$employe = $result->fetch(PDO::FETCH_ASSOC);    // on transforme l'objet $result (qui n'est pas exploitable directement) en un array associatif avec pour indice le nom du champ du SELECT(ici service)
debug($employe);    // on voit ici le contenu de l'array associatif

echo $employe['service'] . '<br>';

// Si la requête retourne qu'un seul résultat => pas de boucle. Si elle peut potentiellement en retourner plusieurs => boucle.


// -----------------------------------------------------
// 04- fetch() avec boucle while (plusieurs résultats)
// -----------------------------------------------------
echo '<h3>04- fetch() avec boucle while (plusieurs résultats) </h3> ';

$resultat = $pdo->query("SELECT * FROM employes"); /// cette requête retourne plusieurs résultats, on fait donc une boucle pour les parcourir.


echo 'Nombre d\'employés : ' . $resultat->rowCount() . '<br>';  // permet de compter le nombre de lignes retournées par le SELECT (exemples : nombre de produits séllectionnés dans une boutique)

// Comme nous avons plusieurs lignes de résultats, nous devons faire une boucle while : 
while ($employe = $resultat->fetch(PDO::FETCH_ASSOC)) { // fetch() retourne la ligne SUIVANTE du jeu de résultat en un array associatif. La boucle while permet de faire avancer le curseur dans le jeu de résultat et s'arrête quand le curseur est arrivé à la fin.
    // debug($employe); // $employe est un array associatif qui contient des données d'un seul employé à chaque tour de boucle

    echo '<div>';
        echo $employe['prenom'] . '<br>';
        echo $employe['nom'] . '<br>';
        echo $employe['service'] . '<br>'; 
    echo '------------</div>';  
}

// Attention : il n'y a pas UN array avec tous les enregistrements dedans, mais un array par enregistrement, un array par employé !


// -----------------------------------------------------
// 05- Exercice
// -----------------------------------------------------
echo '<h3>05- Exercice </h3> ';

// Afficher la liste des différents service dans une liste <ul><li>.


$resultat = $pdo->query("SELECT DISTINCT service FROM employes");       // fonctionne aussi ioci avec GROUP BY, mais ce dernier est plutôt utilisé avec les fonctions qui assemblent des éléments comme SUM(), COUNT(), MIN(), MAX() ET AVG()

echo '<ul>';
    while($employe = $resultat->fetch(PDO::FETCH_ASSOC)) {
        echo '<li>'. $employe['service'] . '</li>'; 
    }
echo '</ul>';


// -----------------------------------------------------
//  06- fetchAll()
// -----------------------------------------------------
echo '<h3> 06- fetchAll() </h3> ';

$resultat = $pdo->query("SELECT * FROM employes");
debug($resultat);   

$donnees = $resultat->fetchAll(PDO::FETCH_ASSOC);   // retourne TOUTES les lignes de résultats dans un tableau multidimensionnel (sans faire de boucle) : nous avons 1 array associatif par employé à chaque indice numérique.

debug($donnees);    // array mulitidemsionnel

echo '<hr>';

// Pour afficher son contenu, on fait une boucle foreach :
 foreach ($donnees as $employe) {
     //debug($employe);   // $employe correspond aux sous arrays qui représentent un employé à chaque tour de boucle

     echo "<div>
                <p>$employe[prenom]</p>
                <p>$employe[nom]</p>
                <p>$employe[salaire]</p>
        </div><hr>";

}

// Si nous avions voulu afficher TOUTES les infos de façon dynamique, nous aurions fait 2 foreach imbriquées l'une dans l'autre.


// -----------------------------------------------------
//  07- Table HTML
// -----------------------------------------------------
echo '<h3> 07- Table HTML </h3> ';

// On veut afficher dynamiquement les résultats de la requête sous forme de table HTML.

$resultat = $pdo->query("SELECT id_employes, prenom, nom, service, salaire FROM employes ORDER BY salaire DESC");

echo '<table border="1">';
    // La ligne d'entêtes : 
    echo '<tr>';
        echo '<th>id_employés</th>';
        echo '<th>prénom</th>';
        echo '<th>nom</th>';
        echo '<th>service</th>';
        echo '<th>salaire</th>';
    echo '</tr>';

    // Affichage des autres lignes :
    while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';
            // Affichage des infos de chaque ligne $ligne : 
            foreach ($ligne as $info) {
                echo '<td>' . $info . '</td>';
            } 
        echo '</tr>';
    }
echo '</table>';


// -----------------------------------------------------
//  08- Requête préparée et bindParam()
// -----------------------------------------------------
echo '<h3> 08- Requête préparée et bindParam() </h3> ';

$nom = 'sennard';

// 1- Préparer la requête : 
$resultat = $pdo->prepare("SELECT * FROM employes WHERE nom = :nom" );  // :nom est un marqueur nominatif qui attend qu'on lui donne une valeur

// 2- Lier les marqueurs aux valeurs :
$resultat->bindParam(':nom', $nom); // 

// 3- Exécuter la requête :
$resultat->execute();

// 4- Affichage
$donnees = $resultat->fetch(PDO::FETCH_ASSOC);
debug($donnees);
