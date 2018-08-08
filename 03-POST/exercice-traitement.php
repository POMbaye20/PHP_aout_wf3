<?php

$champ = '';

// var_dump($_POST);
if (!empty($_POST)) {   // est équivalent à if($_POST) : signifie que $_POST n'est pas vide, donc que le formulaire a été soumis
   


$champ = '<p>Ville : ' . $_POST['ville'] . '</p>';
$champ .= '<p>Code Postal : ' . $_POST['code_postal'] . '</p>';
$champ .= '<p>Adresse : ' . $_POST['adresse'] . '</p>';


}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Votre formulaire</title>
</head>
<body>
    <h1>Vous avez indiqué :</h1>
    <?php echo $champ; ?>
    
</body>
</html>