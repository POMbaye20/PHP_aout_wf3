<?php

/* Sujet :  
    Vous créez un tableau PHP contenant les pays suivants : 
    - France
    - Italie
    - Espagne
    - Inconnu
    - Allemagne

    Vous leur associer les valeurs suivantes : 
    - Paris
    - Rome
    - Madrid
    - '?'
    - Berlin

    Vous parcourez ce tableau pour afficher la phrase "La capitale X se situe en "Y" dans un <p>, où X remplace la capitale et Y le pays.
    Pour le pays "inconnu", vous afficherez "La capitale de inconnu n'existe pas !" à la place de la phrase précédente.


*/ 

// $pays = array('France', 'Italie', 'Espagne', 'Inconnu', 'Allemagne');


$pays = array(
    'France' => 'Paris',
    'Italie' => 'Rome',
    'Espagne' => 'Madrid',
    'Inconnu' => '?',
    'Allemagne' => 'Berlin'
);

echo '<pre>';
print_r($pays);
echo '</pre>';

foreach ($pays as $indice => $detail) {
    if ($indice == 'Inconnu') {
        echo "<p>La capitale de Inconnu n'existe pas</p>";
    } else {
        echo "<p>La capitale $detail se situe en $indice  </p>";      
    }
}   // fin foreach


