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
    <form id="login-form" class="login-form" name="acteur" action="" method="POST">
    
    <?php
    if(isset($_POST['retour']) AND ($_POST['retour'] == 'Page accueil')) { header("Location:index.php"); }
    if(isset($_POST['oui']) AND ($_POST['oui'] == 'OUI')) { header("Location:acteur.php"); }
    if(isset($_POST['non']) AND ($_POST['non'] == 'NON')) { 
        header("Location:index.php");
        session_unset(); 
    }
    session_start();
    ?>
    
    <div><select name="nom_acteur"></div>
        <?php
            $bdd= new PDO('mysql:host=localhost;dbname=group12;charset=utf8','group12','KS/7yNYP8l');
			$bdd->exec("SET CHARACTER SET utf8");
            $request= $bdd->query("SELECT nom FROM acteur INNER JOIN personne ON personne.numero = acteur.numero");
            while ($datas =  $request->fetch(PDO::FETCH_ASSOC))
            {
        ?>	
            <option><?php echo $datas["nom"] ?></option>
			<?php
            
             }
            ?>
        </select></br>
    <div><select name="prenom_acteur"></div>
        <?php
            $bdd= new PDO('mysql:host=localhost;dbname=group12;charset=utf8','group12','KS/7yNYP8l');
			$bdd->exec("SET CHARACTER SET utf8");
            $request= $bdd->query("SELECT prenom FROM acteur INNER JOIN personne ON personne.numero = acteur.numero");
            while ($datas =  $request->fetch(PDO::FETCH_ASSOC))
            {
        ?>	
            <option><?php echo $datas["prenom"] ?></option>
			<?php
            
             }
            ?>
        </select></br>
        <button type='submit' name='ajouter_acteur'>Ajouter l'acteur à cet épisode</button><br/>
    <?php
    if(isset($_POST['nom_acteur']) && !empty($_POST['nom_acteur']) && isset($_POST['prenom_acteur']) && !empty($_POST['prenom_acteur'])){
        $nom_serie = $_SESSION['nom_serie'];
		$num_saison = $_SESSION['num_saison'];
		$num_episode = $_SESSION['num_episode'];
        $nom_acteur=$_POST['nom_acteur'];
        $prenom_acteur=$_POST['prenom_acteur'];
        $bdd= new PDO('mysql:host=localhost;dbname=group12;charset=utf8','group12','KS/7yNYP8l');
		$bdd->exec("SET CHARACTER SET utf8");
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
                        echo "L'acteur a bien été ajouté. Voulez-vous ajouter un autre acteur pour cet épisode ?<br/>";
                        echo "<input type='submit' name='oui' value='OUI'/>";
                        echo "<input type='submit' name='non' value='NON'/><br />";
			        }
			        else {
                        echo "L'acteur n'a pas été ajouté.<br/>";
                        echo " <input type='submit' name='retour' value='Page accueil'/><br />";;
			        }
                }
            }
			else {
                echo "Il n'y a pas d'acteur avec ce nom et ce prénom dans la base de données.";
                echo " <input type='submit' name='retour' value='Page accueil'/><br />";
			}
		}
    }
    else{
        echo " <input type='submit' name='retour' value='Page accueil'/><br />";
    }
?>
    </form>
    </body>
</html>