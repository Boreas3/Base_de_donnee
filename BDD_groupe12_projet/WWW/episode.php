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

<?php
	if(isset($_POST['retour']) AND ($_POST['retour'] == 'Page accueil')) { header("Location:index.php"); }
	if(isset($_POST['acteur']) AND ($_POST['acteur'] == 'Ajouter les acteurs')) { header("Location:acteur.php"); } 
	session_start();
?>

<form id="login-form" class="login-form" name="form1" action="" method="POST">
	Ajouter un nouvel épisode : <br/>
		Nom de la série : 
        <select name="nom_serie">
        <?php
            $bdd= new PDO('mysql:host=localhost;dbname=group12;charset=utf8','group12','KS/7yNYP8l');
			$bdd->exec("SET CHARACTER SET utf8");
            $request = $bdd->query("SELECT nom_serie FROM serie");
            while ($datas =  $request->fetch(PDO::FETCH_ASSOC))
            {
        ?>	
            <option><?php echo $datas["nom_serie"] ?></option>
			<?php
             }
            ?>
        </select></br>
		Numéro de saison : <input type='number' name='num_saison'><br/>
		Numéro d'épisode : <input type='number' name='num_episode'><br/>
		Durée : <input type='text' name='duree'><br/>
		Synopsis : <input type='text' name='synopsis'><br/>
		<button type='submit' name='ajouter'>Ajouter</button><br/>	
<?php
	if(isset($_POST['nom_serie']) && !empty($_POST['nom_serie']) && isset($_POST['num_saison']) && !empty($_POST['num_saison']) && isset($_POST['num_episode']) && !empty($_POST['num_episode']) && isset($_POST['duree']) && !empty($_POST['duree']) && isset($_POST['synopsis']) && !empty($_POST['synopsis'])){
        $_SESSION['nom_serie']= $_POST['nom_serie'];
		$_SESSION['num_saison']= $_POST['num_saison'];
		$_SESSION['num_episode'] = $_POST['num_episode'];
		$_SESSION['duree'] = $_POST['duree'];
		$_SESSION['synopsis'] = $_POST['synopsis'];
		$nom_serie = $_SESSION['nom_serie'];
		$num_saison = $_SESSION['num_saison'];
		$num_episode = $_SESSION['num_episode'];
		$duree = $_SESSION['duree'];
		$synopsis = $_SESSION['synopsis'];
		$bdd= new PDO('mysql:host=localhost;dbname=group12;charset=utf8','group12','KS/7yNYP8l');
		$bdd->exec("SET CHARACTER SET utf8");
        if (!$bdd) {
			die('Impossible de se connecter au serveur MySQL : '.mysql_error());
		}
		else{
			$req_episode= $bdd->query("INSERT INTO episodes VALUES ('$num_saison', '$num_episode', '$duree', '$synopsis', '$nom_serie')");
			if ($req_episode) {
				echo "L'épisode a bien été ajouté. Veuillez maintenant ajouter les acteurs.<br/>";
				echo "<input type='submit' name='acteur' value='Ajouter les acteurs'/><br />";
			}
			else {
				echo "La série n'a pas été ajoutée.";
			}
		}
	}
?>
        <br/><input type="submit" name="retour" value="Page accueil"/><br />
    </form>
    </body>
</html>