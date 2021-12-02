<?php
$connectSQL = array();
$connectSQL['host'] = "localhost";
$connectSQL['user'] = "root";
$connectSQL['password'] = "";
$connectSQL['db'] = "livreor";

session_start();

if (!isset($_SESSION['login'])){

    header("Refresh: 3; url=connexion.php");
    echo "Vous devez être connecté pour accéder à cette page. <br> Redirection vers la page de connexion en cours...";

}

$mysqli=mysqli_connect($connectSQL['host'],$connectSQL['user'],$connectSQL['password'],$connectSQL['db']);

if (!$mysqli){

    echo "Connexion à la base de données non établie.";
    exit;

}

if (isset($_POST['valider'])){

    $commentaire = $_POST['commentaire'];
    
    $sqlid = mysqli_query($mysqli, "SELECT id FROM utilisateurs WHERE login = '".$_SESSION['login']."'");
    $resultid = mysqli_fetch_assoc($sqlid);
    $id_utilisateur = $resultid['id'] ;

    $resultat = mysqli_query($mysqli, "INSERT INTO commentaires (commentaire, id_utilisateur, date) VALUES ('".$commentaire."','".$id_utilisateur."',now())");

    if (empty($commentaire)){

        $erreur = "Le champ Commentaires est vide.";

    }

    else {
        
        if ($resultat){

            $confirm = "Commentaire ajouté avec succès !";

        }
    }
} ?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout de commentaire</title>
    <link rel="stylesheet" href="css/autrespages.css">

</head>
<body>

<main>

    <h1 id="titre_profil"><u> Modifier votre profil </u></h1>
    <br><br>

    
    <section class="messages">
        <?php if (isset($confirm)) {echo $confirm;} ?>
    </section>

    <div class="erreurs">
        <?php if(isset($erreur)) {echo $erreur ;} ?>
    </div>

    <form action="commentaire.php" method="post">

    <label for="commentaire"> Commentaire à ajouter : </label>
    <input type="text-area" name="commentaire">
    <br>
    <div class="bouton_profil_form">
        <button class="bouton_form" type="submit" name="valider"> Ajouter votre commentaire </button>
    </div>
    </form>