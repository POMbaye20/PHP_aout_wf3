<?php

// ----------------------------------------
// La superglobale $_POST
// ----------------------------------------
// $_POST est une superglobale qui permet de récupérer des données saisies dans un formulaire.

// $_POST étant une superglobale, il s'agit d'un ARRAY, et il est disponible dans tous les contextes du script, y compris au sein des fonctions (sans faire global $_POST).

// L'array $_POST se rempit de la manière suivante : les names du formulaire constituent les indices de $_POST, et les données saisies dans le formulaire constituent les valeurs de $_POST.
$message = '';
var_dump($_POST);

if (!empty($_POST)) {   // si $_POST n'est pas vide, c'est qu'il est rempli par des données reçues de l'internaute.
    
    // dans un futur proche on vérifiera les données reçues avant de les traiter


    $message = '<p>Prénom : ' . $_POST['prenom'] . '</p>';
    $message .= '<p>Description : ' . $_POST['description'] . '</p>';

}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulaire</title>
</head>
<body>
    <h1>Formulaire</h1>

    <?php echo $message; ?>

    <form method="post" action=""><!-- un formulaire est toujours dans des <form> pour fonctionner. method= comment vont circuler les données du navigateur au serveur (ici en post). action = url de destination des données -->
        <div>
            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" id="prenom" value=""><!-- ne pas oublier les names : ils constituent les indices de l'array $_POST qui réceptionne les données -->
        </div>
        
        <div>
            <label for="description">Description</label>
            <textarea name="description" id="description"></textarea>
        </div>
        
        <div>
            <input type="submit" name="validation" value="envoyer">
        </div>

    </form>
    <!-- les id des labels ne sont pas indispensables : ils permettent de relier un label à son input grâce au for de même nom. Ainsi si nous cliquons sur un label, le curseur se postionne dans son input. -->
</body>
</html>
