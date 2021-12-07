<?php
$connectSQL = array();
$connectSQL['host'] = "localhost";
$connectSQL['user'] = "root";
$connectSQL['password'] = "";
$connectSQL['db'] = "livreor";

session_start();
$addcommentaire = 0;
if (isset($_SESSION['login'])){

    $addcommentaire = 1;

}

$mysqli=mysqli_connect($connectSQL['host'],$connectSQL['user'],$connectSQL['password'],$connectSQL['db']);

if (!$mysqli){

    $erreur = "Connexion à la base de données non établie.";
    exit;

}

$sql = mysqli_query($mysqli, "SELECT commentaire, login, date FROM utilisateurs INNER JOIN commentaires ON utilisateurs.id = commentaires.id_utilisateur ORDER By date DESC");
$result = mysqli_fetch_all($sql);

?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livre d'or</title>
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
    <h1 id="titre_main"> Livre d'or </h1>

    <div class="erreurs">
        <?php if(isset($erreur)) {echo $erreur ;} ?>
    </div>

    <section>
    <table>
        
        <?php foreach($result as $value) {

            $date = $value[2];
            $login = $value[1];
            $commentaire = $value[0]; ?>
          
            <tr>
                <td class="commentaires"> Posté le <?php echo $date ?> <br> par <?php echo $login ?> </td>
                <td class="commentaires"> <?php echo $commentaire ?></td>
            </tr>
        <?php } ?> 

    </table>
    </section>

    <?php 
    if ($addcommentaire==1){ ?>

        <a href="commentaire.php"><button id="bouton_form">Ajouter un commentaire</button></a>
    
    <?php } ?>
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
        
