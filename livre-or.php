<?php
$connectSQL = array();
$connectSQL['host'] = "localhost";
$connectSQL['user'] = "root";
$connectSQL['password'] = "";
$connectSQL['db'] = "livreor";

session_start();

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
    <link rel="stylesheet" href="css/autrespages.css">

</head>
<body>

<main>

    <h1 id="titre_profil"> Livre d'or </h1>
    <br><br>

    <div class="erreurs">
        <?php if(isset($erreur)) {echo $erreur ;} ?>
    </div>

    <section>
    <table>
        
        <?php foreach($result as $value) {

            $date = $value[2];
            $login = $value[1];
            $commentaire = $value[0];
            
            echo "<tr>
                    <td> Posté le '".$date."'<br> par '".$login."' </td>
                    <td> '".$commentaire."'</td>
                  </tr>" ; 
        } ?>

    </table>
    </section>

</main>

        <!-- AJOUTER LE FOOTER REQUIRE -->
        
            
</body>
</html>