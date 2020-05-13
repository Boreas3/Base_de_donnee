<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf8">
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
	$bdd= new PDO('mysql:host=localhost;dbname=group12;charset=utf8','group12','KS/7yNYP8l');
    $bdd->exec("SET CHARACTER SET utf8");
    if (!$bdd) {
		die('Impossible de se connecter au serveur MySQL : '.mysql_error());
	}
	else{
        ?>
		Les personnes ayant regardé tous les épisodes de Black Mirror sont : </br>
                    
                <table>
                    <thead>
                        <tr style="text-align:left">
                            <th>Nom</th>
                            <th>Prénom</th>
                        </tr>
                    </thead>
                    <tbody>
        <?php      
        $req_nb_max= $bdd->query("SELECT COUNT(numero) AS nombre_de_personne FROM personne");
		if($req_nb_max->rowCount()){
			while ($tuple_nb_max = $req_nb_max->fetch()) {
				$nb_max=$tuple_nb_max['nombre_de_personne'];
				for($num = 1; $num<=$nb_max; $num++){
					$req_utilisateur= $bdd->query("SELECT * FROM regarde WHERE nom_serie='Black Mirror' AND numero='$num'");
					if($req_utilisateur->rowCount()==5){
						$req_identite=$bdd->query("SELECT * FROM personne WHERE numero='$num'");
						if($req_identite->rowCount()){
							while($tuple_identite=$req_identite->fetch()){
								echo "<tr><td>" .$tuple_identite['nom']."</td>";
								echo "<td>" .$tuple_identite['prenom']."</td></tr>";
							}
						}
					}
				}
			}
		}
		echo "</tbody>
						</table>";
	}
?>
		<br/><input type="submit" name="retour" value="Page accueil"/><br />
    </form>
	</body>
</html>