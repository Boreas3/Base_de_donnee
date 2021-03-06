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
	if(isset($_POST['nom_plateforme']) && !empty($_POST['nom_plateforme'])){
		$plateforme = $_POST['nom_plateforme'];
	}
?>
    <form id="login-form" class="login-form" name="form1" action="" method="POST">
	
    Quelle plateforme voulez-vous ?
    
		<select name="nom_plateforme">
        <?php
            $bdd= new PDO('mysql:host=localhost;dbname=group12;charset=utf8','group12','KS/7yNYP8l');
			$request = $bdd->query("SELECT nom_platf FROM plateforme_streaming");
            while ($datas =  $request->fetch(PDO::FETCH_ASSOC))
            {
        ?>	
            <option><?php echo $datas["nom_platf"] ?></option>
			<?php
             }
            ?>
        </select></br>
        <button type="submit">Rechercher</button></br>
<?php
	if(isset($_POST['nom_plateforme']) && !empty($_POST['nom_plateforme'])){
		$plateforme = $_POST['nom_plateforme'];
		$bdd= new PDO('mysql:host=localhost;dbname=group12;charset=utf8','group12','KS/7yNYP8l');
		$bdd->exec("SET CHARACTER SET utf8");
        if (!$bdd) {
			die('Impossible de se connecter au serveur MySQL : '.mysql_error());
		}
		else{
			$req_pays= $bdd->query("SELECT * FROM pays WHERE nom_platf='$plateforme'");
			if($req_pays->rowCount()){
                ?>
                <table>
                    <thead>
                        <tr style="text-align:left">
                            <th>Nom de la plateforme</th>
                            <th>Pays</th>
                        </tr>
                    </thead>
                <tbody>
                <?php
                while ($tuple_pays = $req_pays->fetch()) {
                    echo "<tr><td>" .$tuple_pays['nom_platf']."</td>";
                    echo "<td>" .$tuple_pays['pays']."</td></tr>";
                }
                echo "
                    </tbody>
                    </table>";
			}
		}
	}
?>
    <br />
        <input type="submit" name="retour" value="Page accueil"/><br />
    </form>
	</body>
</html>