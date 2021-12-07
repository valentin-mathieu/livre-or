<?php
    
$connectSQL = array();
$connectSQL['host'] = "localhost";
$connectSQL['user'] = "root";
$connectSQL['password'] = "";
$connectSQL['db'] = "livreor";
$mysqli = mysqli_connect($connectSQL['host'], $connectSQL['user'], $connectSQL['password'], $connectSQL['db']);

if(!$mysqli) {
    echo "Connexion SQL non établie.";
    exit;
}
   
$boutons_user = 0;
$AfficherFormulaire = 1;

if(isset($_POST['login'],$_POST['password'],$_POST['password_confirm'])){
    
    if(empty($_POST['login'])){
        $erreur = "Le champ Pseudo est vide.";
    } 
    
    elseif(strlen($_POST['login'])>255){
        $erreur = "Le pseudo est trop long, il dépasse 255 caractères.";
    } 
    
    elseif(empty($_POST['password'])){
        $erreur = "Le champ Mot de passe est vide.";
    } 
    
    elseif(empty($_POST['password_confirm'])){
        $erreur = "Le champ Confirmer le mot de passe est vide.";
    } 
    
    elseif($_POST['password']!==$_POST['password_confirm']){
      $erreur = "Les mots de passe saisis ne correspondent pas.";
    } 
    
    elseif(mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM utilisateurs WHERE login='".$_POST['login']."'"))==1){//on vérifie que ce pseudo n'est pas déjà utilisé par un autre membre
        $erreur = "Ce pseudo est déjà utilisé.";
    } 
    
    else {
    
        mysqli_query($mysqli,"INSERT INTO utilisateurs SET login='".$_POST['login']."', password='".$_POST['password']."'");
        $inscrit = "Vous êtes inscrit avec succès, ".$_POST['login']." !";
        $_SESSION['login'] = $_POST['login'];
        $AfficherFormulaire=0;
        $boutons_user = 1;
        
    }
} ?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Inscription</title>
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
    <h1 id="titre_main"> Formulaire d'inscription </h1>

    <section class="messages">
        <?php if (isset($erreur)) {echo $erreur;} ?>
    </section>

    <section class="messages">
        <?php if (isset($inscrit)) {echo $inscrit;} ?>
    </section>

<?php 
if($boutons_user==1){ ?>
    <a href="profil.php"><button id="bouton_form">Modifier votre profil</button></a>
    <a href="livre-or.php"><button id="bouton_form">Voir le livre d'or</button></a>
    <a href="commentaire.php"><button id="bouton_form">Ajouter un commentaire</button></a>
<?php } ?>

<?php if($AfficherFormulaire==1){
    ?>

    <br/>
    <form method="post" action="inscription.php">
        <label for="login"> Nom d'utilisateur : </label>
        <input type="text" name="login">
        <br/>
        <label for="password"> Mot de passe : </label>
        <input type="password" name="password">
        <br/>
        <label for="pass_confirm"> Confirmer le mot de passe : </label>
        <input type="password" name="password_confirm">
        <br>
        <div id="bouton">
        <button id="bouton_form" type="submit">S'inscrire !</button>
        </div>
    </form>
</section>
<?php
}
?>

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