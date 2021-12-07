<?php
$connectSQL = array();
$connectSQL['host'] = "localhost";
$connectSQL['user'] = "root";
$connectSQL['password'] = "";
$connectSQL['db'] = "livreor";

session_start(); 
$AfficherFormulaire=1;
$boutons_user = 0;
if(isset($_POST['connexion'])) { 
   
    if(empty($_POST['login'])) {
        $erreur = "Le champ Login est vide.";
    } 
    else {
        
        if(empty($_POST['password'])) {
            $erreur = "Le champ Mot de passe est vide.";
        } 
        
        else {
            
            $login = $_POST['login']; 
            $password = $_POST['password'];
            $mysqli = mysqli_connect($connectSQL['host'], $connectSQL['user'], $connectSQL['password'], $connectSQL['db']);
           
            if(!$mysqli){
                echo "Erreur de connexion à la base de données.";
            } 
            
            else {
                
                $requete = mysqli_query($mysqli,"SELECT * FROM utilisateurs WHERE login = '".$login."' AND password = '".$password."'");//si vous avez enregistré le mot de passe en md5() il vous suffira de faire la vérification en mettant mdp = '".md5($MotDePasse)."' au lieu de mdp = '".$MotDePasse."'
                
                if(mysqli_num_rows($requete) == 0) {
                    $erreur = "Le pseudo ou le mot de passe est incorrect, le compte n'a pas été trouvé.";
                } 
                
                else {
                    $_SESSION['login'] = $_POST['login'];
                    $boutons_user = 1;
                    $connected = "Vous êtes à présent connecté, ".$_SESSION['login']." !";
                    $AfficherFormulaire=0;
                }
            }
        }
    }
} ?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Connexion</title>
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
    <h1 id="titre_main"> Formulaire de connexion </h1>

    <section class="messages">
        <?php if (isset($erreur)) {echo $erreur;} ?>
    </section>

    <section class="messages">
        <?php if (isset($connected)) {echo $connected;} ?>
    </section>

<?php 
if($boutons_user==1) { ?>
    <a href="profil.php">    <button id="bouton_form">Modifier votre profil</button></a>
    <a href="livre-or.php">    <button id="bouton_form">Voir le livre d'or</button></a>
    <a href="commentaire.php">    <button id="bouton_form">Ajouter un commentaire</button></a>
<?php } ?>
<?php
if($AfficherFormulaire==1) {
?>

<form action="connexion.php" method="post">
    <label for="login"> Login : </label>
    <input type="text" name="login"/>
    <br/>
    <label for="password"> Mot de passe : </label>
    <input type="password" name="password"/>
    <br/>
    <div id="bouton">
    <button id="bouton_form" type="submit" name="connexion"> Se connecter </button>
    </div>
</form>

<?php } ?>

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