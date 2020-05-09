<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Base de donnée - groupe 12</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <link rel="stylesheet" href="css/main.css">
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,500' rel='stylesheet' type='text/css'>
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
        <script src="js/jquery-1.8.2.min.js"></script>
        <script src="js/jquery.validate.min.js"></script>
        <script src="js/main.js"></script>
    </head>
	<body>
    <form id="login-form" class="login-form" name="form1" action="" method="POST">

    <?php
    if(isset($_POST['retour']) AND ($_POST['retour'] == 'Page accueil')) { header("Location:index.php"); }
    session_start();
    ?>
    <form id='login-form' class='login-form' name='form1' action='' method='POST'>
    Ajouter les acteurs : </br>
    <?php
		$nb_acteur = $_SESSION['nb_acteur'];
		for ($nombre_de_lignes = 1; $nombre_de_lignes <= $nb_acteur; $nombre_de_lignes++){
            echo "Acteur n°".$nombre_de_lignes." : <br/>";
			echo "Nom de l'acteur : <input type='text' name='nom_acteur.$nombre_de_lignes'><br/>";
			echo "Prénom de l'acteur : <input type='text' name='prenom_acteur.$nombre_de_lignes'><br/><br/>";
        }
        echo "<button type='submit' name='ajouter_acteur'>Ajouter les acteurs de l'épisode</button><br/>";
    
    if(isset($_POST['nom_acteur.$nombre_de_lignes']) && !empty($_POST['nom_acteur.$nombre_de_lignes']) && isset($_POST['prenom_acteur.$nombre_de_lignes']) && !empty($_POST['prenom_acteur.$nombre_de_lignes'])){
        $nom_acteur=$_POST['nom_acteur.$nombre_de_lignes'];
        $prenom_acteur=$_POST['prenom_acteur.$nombre_de_lignes'];
        $bdd= new PDO('mysql:host=localhost;dbname=group12;charset=utf8','group12','KS/7yNYP8l');
		if (!$bdd) {
			die('Impossible de se connecter au serveur MySQL : '.mysql_error());
		}
		else{
            $req_acteur= $bdd->query("SELECT numero FROM personne WHERE nom='$nom_acteur' AND prenom='$prenom_acteur'");
            if($req_acteur->rowCount()){
                while ($tuple_acteur = $req_acteur->fetch()) {
                    $numero_acteur=$tuple_acteur['numero'];
                    $req_joue= $bdd->query("INSERT INTO joue_dans VALUES ('$numero_acteur', '$num_saison', '$num_episode', '$nom_serie')");
			        if ($req_joue) {
				        echo "L'acteur ".$nombre_de_lignes." a bien été ajouté.";
			        }
			        else {
				        echo "L'acteur ".$nombre_de_lignes." n'a pas été ajouté.";
			        }
                }
            }
			else {
				echo "Il n'y a pas d'acteur avec ce nom et ce prénom dans la base de données.";
			}
		}
	}
	session_unset();
?>






        <input type="submit" name="retour" value="Page accueil"/><br />
    </form>
    </body>
</html>