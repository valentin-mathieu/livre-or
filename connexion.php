<?php
$connectSQL = array();
$connectSQL['host'] = "localhost";
$connectSQL['user'] = "root";
$connectSQL['password'] = "";
$connectSQL['db'] = "livreor";

session_start(); // à mettre tout en haut du fichier .php, cette fonction propre à PHP servira à maintenir la $_SESSION
$AfficherFormulaire=1;
if(isset($_POST['connexion'])) { // si le bouton "Connexion" est appuyé
    // on vérifie que le champ "Pseudo" n'est pas vide
    // empty vérifie à la fois si le champ est vide et si le champ existe belle et bien (is set)
    if(empty($_POST['login'])) {
        echo "Le champ Login est vide.";
    } else {
        // on vérifie maintenant si le champ "Mot de passe" n'est pas vide"
        if(empty($_POST['password'])) {
            echo "Le champ Mot de passe est vide.";
        } else {
            // les champs sont bien posté et pas vide, on sécurise les données entrées par le membre:
            $Login = $_POST['login']; // le htmlentities() passera les guillemets en entités HTML, ce qui empêchera les injections SQL
            $Password = $_POST['password'];
            //on se connecte à la base de données:
            $mysqli = mysqli_connect($connectSQL['host'], $connectSQL['user'], $connectSQL['password'], $connectSQL['db']);
            //on vérifie que la connexion s'effectue correctement:
            if(!$mysqli){
                echo "Erreur de connexion à la base de données.";
            } else {
                // on fait maintenant la requête dans la base de données pour rechercher si ces données existe et correspondent:
                $Requete = mysqli_query($mysqli,"SELECT * FROM utilisateurs WHERE login = '".$Login."' AND password = '".$Password."'");//si vous avez enregistré le mot de passe en md5() il vous suffira de faire la vérification en mettant mdp = '".md5($MotDePasse)."' au lieu de mdp = '".$MotDePasse."'
                // si il y a un résultat, mysqli_num_rows() nous donnera alors 1
                // si mysqli_num_rows() retourne 0 c'est qu'il a trouvé aucun résultat
                if(mysqli_num_rows($Requete) == 0) {
                    echo "Le pseudo ou le mot de passe est incorrect, le compte n'a pas été trouvé.";
                } else {
                    // on ouvre la session avec $_SESSION:
                    $_SESSION['login'] = $Login; // la session peut être appelée différemment et son contenu aussi peut être autre chose que le pseudo
                    echo "Vous êtes à présent connecté, $Login !";
                    $AfficherFormulaire=0;
                    ?> <a href="profil.php"><button id="bouton_modif">Modifier votre profil</button></a> <?php
                }
            }
        }
    }
}

if($AfficherFormulaire==1) {
?>

<form action="connexion.php" method="post">
    Login: <input type="text" name="login"/>
    <br/>
    Mot de passe: <input type="password" name="password"/>
    <br/>
    <input type="submit" name="connexion" value="Connexion"/>
</form>

<?php } ?>