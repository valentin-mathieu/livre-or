<?php
$connectSQL = array();
$connectSQL['host'] = "localhost";
$connectSQL['user'] = "root";
$connectSQL['password'] = "";
$connectSQL['db'] = "livreor";

session_start();

if (!isset($_SESSION['login'])){

    header("Refresh: 3; url=connexion.php");
    $erreur = "Vous devez être connecté pour accéder à cette page. <br> Redirection vers la page de connexion en cours...";

}

$mysqli=mysqli_connect($connectSQL['host'],$connectSQL['user'],$connectSQL['password'],$connectSQL['db']);

if (!$mysqli){

    $erreur = "Connexion à la base de données non établie.";
    exit;

}

if (isset($_POST['valider'])){

    $commentaire = $_POST['commentaire'];
    $sqlid = mysqli_query($mysqli, "SELECT id FROM utilisateurs WHERE login = '".$_SESSION['login']."'");
    $resultid = mysqli_fetch_assoc($sqlid);
    $id_utilisateur = $resultid['id'] ;

    $resultat = mysqli_query($mysqli, "INSERT INTO commentaires (commentaire, id_utilisateur, date) VALUES ('".$commentaire."','".$id_utilisateur."',now())");

    if (empty($commentaire)){

        $erreur = "Le champ Commentaire est vide.";

    }

    else {
        
        if ($resultat){

            $confirm = "Commentaire ajouté avec succès !";

        }
    }
} 

if (isset($_POST['deconnexion'])){
    
    session_destroy();
    header("Refresh: 0; url=connexion.php");
    
} ?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout de commentaire</title>
    <link rel="stylesheet" href="style/pages.css">

</head>
<body>

<header> 
    <img width="422px" height="310px" id="logo" src="style/Assets/logo.png" alt="logo">
    <div class="titre_header">
        <h1> Projet Livre d'Or </h1>
        <h4> Valentin MATHIEU </h4> 
    </div>
    <a href="index.php"><img id="logo_accueil" width="100px" height="100px" src="style/Assets/logo_accueil.png" alt="accueil"></a>
</header>

<main>

    <section id="section_main">
    <h1 id="titre_main">Ajouter un commentaire</h1>
 
    <section class="messages">
        <?php if (isset($confirm)) {echo $confirm;} ?>
    </section>

    <section class="messages">
        <?php if(isset($erreur)) {echo $erreur ;} ?>
    </section>

    <form action="commentaire.php" method="post">

    <label for="commentaire"> Commentaire à ajouter : </label>
    <input type="text-area" name="commentaire">
    <br>
    <button id="bouton_form" type="submit" name="valider"> Ajouter votre commentaire </button>
    <button id="bouton_form" type="submit" name="deconnexion"> Se déconnecter </button>
    </form> 
    <a href="livre-or.php"><button id="bouton_form">Voir le livre d'or</button></a>    

</main>

<footer>
    <div id="embleme_poudlard">
    <img src="style/Assets/embleme_poudlard.png" alt="poudlard" height="200px" width="242px">
    </div>
    <div id="titre_footer"> Voici mon lien GitHub et mon Linkedin ! </div>
    <section class="logos_footer">
    <div id="logo_github"><a href="https://github.com/valentin-mathieu"><img src="style/Assets/logo-github.png" alt="github" height=120px width=120px></a></div>
    <div id="logo_linkedin"><a href="https://www.linkedin.com/in/valentin-mathieu-6857ab21b"><img src="style/Assets/logo-linkedin.png" alt="linkedin" height=140px width=140px></a></div>
    </section>
</footer>
</body>
</html>