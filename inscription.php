<?php
session_start();
include("header.php");
require_once("Connect.php"); // définir la connect pour réservation de salles

if (isset($_POST["submit"])){                
    // parcour uniquement le $_post de submit ou tous ? et retourne un bolléen true ou false ? 
    if (isset($_POST['login']) && isset($_POST['password'])){

        $login=$_POST["login"];
        $pass=$_POST["password"];
        $repass=$_POST["repass"];
        // variable qui définie les erreurs a afficher
        $erreur = '';
        //variable initié à 0
        $user = 0;
        // si $pass vaut $repass alors
        if ($pass == $repass){
            // Variable qui défini la requête SQL
            $req_check_user = "SELECT `login` FROM utilisateurs";
            // Variable qui prépare et éxecute la requête défini plus haut vers la base de donnée 
            $req = $conn->query($req_check_user);

            // retourne tous les résultats de la reqûete $req dans un tableau 
            $result_user = $req->fetch_all();
            // pour $x = 0 si le tableau retourne un résultat alors incrémenter $x de 1 pour chaque résultat correspondant
            for($x = 0; isset($result_user[$x][0]); $x++){
                // si le résultat retourné par le tableau correspond à $_POST login
                if($result_user[$x][0] == $_POST['login']){
                    $erreur = "<h1 class= 'erreur'>Login déja existant</h1>";
                    // permet d'incrémenter $user si une correspondance est trouvé .
                    $user ++;
                }
            }
            // Si user vaut zéro alors créer compte
            if($user == 0){
            // créer la requête pour insérer dans utilisateurs, les valeurs login , prénom , nom et password)
            $req = "INSERT INTO `utilisateurs`(`login`, `password`) VALUES ('$login', '$pass')";
            // éxécution de la requête.
            $create = $conn->query($req);
            // Redirection vers la page connexion.php
            header ('Location: connexion.php');
            }
    
            }else{
                $erreur = "<h1>password non similaire</h1>";
            }
    }
}


?>

<html>
    <head>
        <html lang="fr">
        <meta charset="utf-8">
        <!-- importer le fichier de style -->
        <link rel="stylesheet" href="style.css" media="screen" type="text/css"/>
        <title>Inscription</title>
    </head>

    <body>
        <div>
        <hr>
            <h1 class="box-title">Inscription en date du <?php echo date('d/m/Y') ?></h1>
            
            <h1>Veuillez renseigner les informations suivantes pour accéder à nos Salles</h1>

        </div>

        <div id="Formulaire">
            <!-- interet du champ Label ??????????? -->
            <form id="Form" action="" method="post">  <!-- required vérifie que le champs n'est pas vide ? -->
                <strong><label>Entrez votre Login</label></strong><br>
                <input type="text" class="box-input" name="login" placeholder="Login" required /><br>
                <strong><label>Entrez votre Mots de passe</label></strong><br>
                <input type="password" class="box-input" name="password" placeholder="Password" required /><br>
                <strong><label>Confirmez votre Mots de passe</label></strong>
                <input type="password" name="repass" placeholder="Confirm password" required /><br>
                <input type="submit" name="submit" value="S'inscrire" class="box-button"/>
            </form>

        <?php
            // si la variable $erreur existe alors echo
            if(isset($erreur)){
                echo "$erreur";
            }
        ?>
            <br><hr>


            <!--  Si connecté , masquer l'onglet inscription  -->
            <p><strong>Déjà inscrit? <a id="locate" href="connexion.php">Connectez-vous ici</a></strong></p>
            <hr class="hr1">
        </div>
    </body>
</html>

<!-- Include Footer.php -->
<?php
include("footer.php");
mysqli_close($conn);
?>