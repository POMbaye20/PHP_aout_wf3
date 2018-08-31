<?php

/* Sujet : 
    - Créer une fonction qui permet de convertir une date FR en date US, ou inversement.
    Cette fonction prend 2 paramètres : une date et le, format de conversion "US" ou "FR".

    - Vous validez que le paramètre format de sortie est bien "US" ou "FR". La fonction retourne un message si ce n'est pas le cas. 
*/

// Préambule à l'exercice : 

$aujourdhui = date('d-m-Y');    // donne la date du jour au format indiqué 
echo $aujourdhui . '<br>';

// ----
// Convertir une date d'un format vers un autre : 
$date = '2018-08-24';
echo 'La date au format US : ' . $date . '<br>'; 

$objetDate = new DateTime($date);
echo 'La date au format FR : ' . $objetDate->format('d-m-Y');   // la méthode format() permet de convertir un objet date selon le format indiqué

echo '<hr>';

// Votre exercice : 

function afficherDate($date, $format) {
   
        // Vérifier la valeur du paramètre $format  :
        if ($format != 'US' && $format != 'FR') {
           return 'Erreur sur le format !';
        }


        // une fois le(s) paramètre(s) validé(s), on fait le traitement :
    if ($format == 'US') {
        $objetDate = new DateTime($date);
        return 'La date au format US : ' . $objetDate->format('Y-m-d');
    } else {
        $objetDate = new DateTime($date);
        return 'La date au format FR : ' . $objetDate->format('d-m-Y');
    }

}


echo afficherDate ('19-02-2018', 'US'); // converti le format "FR" en "US"
echo '<br>';
echo afficherDate ('2018-02-19', 'FR'); // converti le format "US" en "FR"
echo '<br>';    
echo afficherDate ('2018-02-19', 'xx'); // affiche une erreur sur le format vu que ce n'est ni "US" ni "FR".
