<?php
    
$connectSQL = array();
$connectSQL['host'] = "localhost";
$connectSQL['user'] = "root";
$connectSQL['password'] = "";
$connectSQL['db'] = "livreor";
$mysqli = mysqli_connect($connectSQL['host'], $connectSQL['user'], $connectSQL['password'], $connectSQL['db']);

$requetemaison = rand(0,3);

if(!$mysqli) {
    echo "Connexion SQL non établie.";
    exit;
}
   
//par défaut, on affiche le formulaire (quand il validera le formulaire sans erreur avec l'inscription validée, on l'affichera plus)
$AfficherFormulaire=1;

if(isset($_POST['login'],$_POST['password'],$_POST['password_confirm'])){//l'utilisateur à cliqué sur "S'inscrire", on demande donc si les champs sont défini avec "isset"
    
    if(empty($_POST['login'])){//le champ pseudo est vide, on arrête l'exécution du script et on affiche un message d'erreur
        $erreur = "Le champ Pseudo est vide.";
    } 
    
    elseif(strlen($_POST['login'])>255){//le pseudo est trop long, il dépasse 25 caractères
        $erreur = "Le pseudo est trop long, il dépasse 255 caractères.";
    } 
    
    elseif(empty($_POST['password'])){//le champ mot de passe est vide
        $erreur = "Le champ Mot de passe est vide.";
    } 
    
    elseif(empty($_POST['password_confirm'])){//le champ mot de passe est vide
        $erreur = "Le champ Confirmer le mot de passe est vide.";
    } 
    
    elseif($_POST['password']!==$_POST['password_confirm']){
      $erreur = "Les mots de passe saisis ne correspondent pas.";
    } 
    
    elseif(mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM utilisateurs WHERE login='".$_POST['login']."'"))==1){//on vérifie que ce pseudo n'est pas déjà utilisé par un autre membre
        $erreur = "Ce pseudo est déjà utilisé.";
    } 
    
    else {

        if ($requetemaison==0){

            $maison = "Gryffondor";

        }

        elseif ($requetemaison == 1){

            $maison = "Poufsouffle";

        }

        elseif ($requetemaison == 2){

            $maison = "Serpentard";

        }

        elseif ($requetemaison == 3){

            $maison = "Serdaigle";

        }
        //toutes les vérifications sont faites, on passe à l'enregistrement dans la base de données:
        //Bien évidement il s'agit là d'un script simplifié au maximum, libre à vous de rajouter des conditions avant l'enregistrement comme la longueur minimum du mot de passe par exemple
            mysqli_query($mysqli,"INSERT INTO utilisateurs SET login='".$_POST['login']."', password='".$_POST['password']."', maison='".$maison."'");
            $inscrit = "Vous êtes inscrit avec succès, ".$_POST['login']." ! Le Choixpeau magique a fait son choix... Vous êtes... ".$maison." !";
            //on affiche plus le formulaire
            $AfficherFormulaire=0;
            $BoutonConnexion= 1;
        
    }
} ?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Inscription</title>
  <link rel="stylesheet" href="style/inscription.css">
</head>
<body>
<header> 
    <img width="422px" height="310px" id="logo" src="style/Assets/logo.png" alt="logo">
    <div class="titre_header">
        <h1> Projet Livre d'Or </h1>
        <h4> Valentin MATHIEU </h4> 
    </div>
</header> 

<main>  

    <section id="section_inscription">
    <h1 id="titre_inscription"> Formulaire d'inscription </h1>

    <section class="messages">
        <?php if (isset($erreur)) {echo $erreur;} ?>
    </section>

    <section class="messages">
        <?php if (isset($inscrit)) {echo $inscrit;} ?>
    </section>

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
        <button id="bouton_inscription" type="submit">S'inscrire !</button>
        </div>
    </form>
</section>
<?php
}
?>

<footer>    
<img id="embleme_poudlard" src="style/Assets/embleme_poudlard.png" alt="poudlard" height="200px" width="242px">
    <div id="titre_footer"><h1> Voici mon lien GitHub et mon Linkedin ! </h1></div>
    <div id="logo_github"><a href="https://github.com/valentin-mathieu"><img src="style/Assets/logo-github.png" alt="github" height=120px width=120px></a></div>
    <div id="logo_linkedin"><a href="https://www.linkedin.com/in/valentin-mathieu-6857ab21b"><img src="style/Assets/logo-linkedin.png" alt="linkedin" height=140px width=140px></a></div>
</footer>
</body>
</html>