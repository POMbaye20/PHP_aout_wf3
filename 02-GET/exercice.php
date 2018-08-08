<?php 

// Exercice : 
/* 
    1- Vous créez une page profil qui affiche un nom et un prénom.
    2- Vous y ajoutez un lien en GET "modifier mon profil" et un second "Supprimer mon profil". 
    Ces liens passent dans l'url à la page exercice.php elle-même que l'on a cliqué sur le lien "modifier mon profil" ou sur le lien "supprimer mon profil". Pensez qu'il faut un indice et une valeur pour  chaque action.

    3- Si on a cliqué sur le lien  "modifier mon profil", c'est à dire que vous avez reçu cette info en GET, vous affichez le message "Vous avez demandé la modification de votre profil", et si c'est la suppression qui est demandé, vous affichez "Vous avez demandé la suppresion de votre profil". 
*/ 
$message = '';  // variable pour contenir les messages pour l'internaute

// var_dump($_GET);

if (isset($_GET['action']) && $_GET['action'] == 'modifier' ) { // il faut vérifier d'abord l'existence de l'indice "action" dans $_GET AVANT d'en vérifier la valeur
    $message =  '<p> Vous avez demandé la modification de votre profil';
}


if (isset($_GET['action']) && $_GET['action'] == 'supprimer' ) { 
    $message =  '<p> Vous avez demandé la suppression de votre profil';
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profil</title>
</head>
<body>
    <h1>Profil</h1>

    <?php echo $message;?>

    <p>Nom : DOE</p>
    <p>Prénom : John</p>

    <p><a href="?action=modifier">Modifier mon profil</a><br></p>
    <p><a href="?action=supprimer">Supprimer mon profil</a><br></p>

    
</body>
</html>

<?php
