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
		$bdd= new PDO('mysql:host=localhost;dbname=group12;charset=utf8','group12','KS/7yNYP8l');
		if (!$bdd) {
			die('Impossible de se connecter au serveur MySQL : '.mysql_error());
		}
		else{
			$req_episode= $bdd->query("SELECT regarde.n_saison, regarde.n_episode, regarde.nom_serie, COUNT( * ) AS nombre_de_spectateurs
            FROM episodes, regarde
            WHERE episodes.n_saison = regarde.n_saison
            AND episodes.n_episode = regarde.n_episode
            AND episodes.nom_serie = regarde.nom_serie
            GROUP BY regarde.nom_serie, regarde.n_saison, regarde.n_episode");
            ?>
            <div style="overflow-y: scroll; height:350px;">
            <?php
			if($req_episode->rowCount()){
                while ($tuple_episode = $req_episode->fetch()) {
                    $nombre=$tuple_episode['nombre_de_spectateurs'];
                    $nom_serie=$tuple_episode['nom_serie'];
                    $num_saison=$tuple_episode['n_saison'];
                    $num_episode=$tuple_episode['n_episode'];
                    echo $nombre." personnes ont regardé l'épisode ".$num_episode." de la saison ".$num_saison." de la série ".$nom_serie.".<br/>";   
                }
            }
            ?>
            </div><br />
            <?php
		}
?>

    
        <input type="submit" name="retour" value="Page accueil"/><br />
    </form>
	</body>
</html>