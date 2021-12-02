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

$AfficherFormulaire = 1;
$FormulaireMDP = 0;
$req = mysqli_query($mysqli,"SELECT * FROM utilisateurs WHERE login='".$_SESSION['login']."'");
$info = mysqli_fetch_array($req);

if (isset($_POST['deconnexion'])) {

    session_destroy();

    header('Refresh: 0; url=index.php');

}

if(isset($_POST['goformmdp'])) {

    $FormulaireMDP = 1 ; 
    $AfficherFormulaire = 0; 

}

if (isset($_POST['modifmdp'])){

    $password = $_POST['password'] ;
    $newpass = $_POST['newpass'];
    $confirmpass = $_POST['confirmpass'];
    $testmdp = mysqli_query($mysqli, "SELECT * FROM utilisateurs WHERE password = '".$password."'");

    if (empty($password)){

        $erreur = "Le champ mot de passe actuel est vide.";

    }

    elseif (mysqli_num_rows($testmdp)==0){

        $erreur = "Le mot de passe actuel est incorrect.";

    }

    elseif (empty($newpass)){

        $erreur = "Le champ nouveau mot de passe est vide.";

    }

    elseif (empty($confirmpass)){

        $erreur = "Le champ de confirmation du mot de passe est vide.";

    }

    elseif ($newpass != $confirmpass){

        $erreur = "Le nouveau mot de passe et sa confirmation ne correspondent pas.";
    
    }

    else {

        if (mysqli_query($mysqli, "UPDATE utilisateurs SET password = '".$newpass."' WHERE login='".$_SESSION['login']."'")){

            $confirmpass = "Votre mot de passe a été changé avec succès.";
            $FormulaireMDP = 0;
            $AfficherFormulaire = 1;

        }
    }
}

if(isset($_POST['modifier'])) {

    $login = $_POST['login'];
    $testlogin = mysqli_query($mysqli, "SELECT * FROM utilisateurs WHERE login='".$login."'");
    $mysqli_resultlogin = mysqli_num_rows($testlogin) ;
    $requetemdp = mysqli_query($mysqli, "SELECT * FROM utilisateurs WHERE password= '".$_POST['password']."'");

    if (empty($login)){

        $erreur = "Le champ Login est vide.";

    }

    elseif ($login != ($_SESSION['login'])){

        if (($mysqli_resultlogin)==1){

            $erreur = "Ce login est déjà utilisé.";

        }
    }

    if (empty($_POST['password'])){

        $erreur = "Le mot de passe doit être renseigné.";

    }

    elseif (mysqli_num_rows($requetemdp)==0){

        $erreur = "Le mot de passe est incorrect.";
      
    }
    
    else {

    $updateinfos = "UPDATE utilisateurs SET login ='".$login."' WHERE login = '".$_SESSION['login']."'";
        
        if (mysqli_query($mysqli, $updateinfos)){
            
            $_SESSION['login'] = $login;
            $req = mysqli_query($mysqli,"SELECT * FROM utilisateurs WHERE login='".$_SESSION['login']."'");
            $info = mysqli_fetch_array($req); 
            $AfficherFormulaire = 0;
            $confirmmodifs = "Modifications effectuées avec succès !";

        }

    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil membre</title>
    <link rel="stylesheet" href="css/autrespages.css">

</head>
<body>

<main>

    <h1 id="titre_profil"><u> Modifier votre profil </u></h1>
    <br><br>

    <section class="messages">
        <?php if (isset($confirmmodifs)) {echo $confirmmodifs;} ?>
        <?php if (isset($confirmpass)) {echo $confirmpass;} ?>
    </section>

    <div class="erreurs">
        <?php if(isset($erreur)) {echo $erreur ;}
        ?>
    </div>

    <?php if ($AfficherFormulaire==1){ ?>

        <form class="form" action="profil.php" method="post">
            <br>
            <label for="login"> Nouveau login : </label>
            <input type="text" name="login" value="<?php echo $info['login']; ?>">
            <br>
            <label for="password"> Mot de passe : </label>
            <input type="password" name="password" placeholder="Entrez votre mot de passe">
            <br><br>
            <div class="bouton_profil_form">
            <button class="bouton_form" type="submit" name="modifier"> Confirmer les informations </button>
            </div>
        </form>

    <?php } 

    if ($FormulaireMDP==1){ ?>
        <form class="form" action="profil.php" method="post">
            <br>
            <label for="password"> Mot de passe actuel : </label>
            <input type="password" name="password" placeholder="Entrez votre mot de passe actuel">
            <br>
            <label for="newpass"> Nouveau mot de passe : </label>
            <input type="password" name="newpass" placeholder="Entrez votre nouveau mot de passe">
            <br>
            <label for="confirmpass"> Confirmation du mot de passe : </label>
            <input type="password" name="confirmpass" placeholder="Confirmez votre nouveau mot de passe">
            <br><br>
            <div class="bouton_mdp_form">
            <button class="bouton_form" type="submit" name="modifmdp"> Confirmer votre nouveau mot de passe </button>
            </div>
        </form>
    <?php } ?>

    <?php if ($FormulaireMDP == 0){ ?>
        <form action="profil.php" method="post">
            <input class="bouton_profil" type="submit" name="goformmdp" value="Changer votre mot de passe">
        </form>
    <?php } ?>

    <form action="profil.php" method='post'>
        <input class="bouton_profil" type="submit" name="deconnexion" value="Se déconnecter"> 
    </form>

</main>
