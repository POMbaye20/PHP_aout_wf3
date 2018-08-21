<?php

echo '<h1>Les commerciaux et leur salaire </h1>';

/* Exercice : 
        - afficher dans une liste <ul><li> le prénom, le nom et le salaire des employés appartenant au service commercial (un <li> par commercial), en utilisant une requête préparée. 
        - afficher le nombre de commerciaux.
*/

function debug($param) {
    echo '<pre>';
        var_dump($param);
    echo '</pre>';
}

$pdo = new PDO('mysql:host=localhost;dbname=entreprise', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')); 




// 2- on fait la requête :
$service = 'commercial';

$employe = $pdo->prepare("SELECT nom, prenom, salaire FROM employes WHERE service = :service" );
$employe->bindParam(':service', $service);
$employe->execute();

echo 'Nombre de commerciaux : ' . $employe->rowCount() . '<br>';
echo '<ul>';
    while($donnees = $employe->fetch(PDO::FETCH_ASSOC)) {
        echo '<li>'. $donnees['prenom'] .' ' . $donnees['nom'] .' ' . $donnees['salaire'] . ' €' .'</li>'; 
        
    }
echo '</ul>';


// -----------------------------
// version en HTML : 
$employe->execute();


echo '<table border="1">';
    // les entêtes : 
    echo '<tr>';
        echo '<th>Prénom</th>';
        echo '<th>Nom</th>';
        echo '<th>Salaire</th>';
    echo '</tr>';
    
    while ($donnees = $employe->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';
            echo '<td>' . $donnees['prenom'] . '</td>';
            echo '<td>' . $donnees['nom'] . '</td>';
            echo '<td>' . $donnees['salaire'] . ' € </td>';
        echo '</tr>';
    }
echo '</table>';


echo '</table>';
