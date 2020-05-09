
				<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
		<?php
		session_start();
		?>
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
								 
							<div class="group">	
														
								<form class="login-form" method="post" action="" name="tableSelection">
								A quelle table souhaitez-vous accéder?	
								<div><select name="liste"></div>
								<option value="acteur"> acteur </option>
								<option value="disponible_sur"> disponible_sur </option>
								<option value="episodes"> episodes </option>
								<option value="est_abonne"> est_abonne </option>
								<option value="joue_dans"> joue_dans </option>
								<option value="pays"> pays </option>
								<option value="personne"> personne </option>
								<option value="plateforme_streaming"> plateforme_streaming </option>
								<option value="regarde"> regarde </option>
								<option value="serie"> serie </option>
								<option value="utilisateur"> utilisateur </option>
								</select>
								
							</div>
							<input type="submit" value="Aller" /> <br/><br/>
							<input type="submit" name="retour" value="Page accueil"/><br />
		                </form>
					</div>
				</div>	
				<div class="right"><a href="index.php?ac=logout">Logout</a></div>
</form>		
				
	<?php
	if(isset($_POST['retour']) AND ($_POST['retour'] == 'Page accueil')) { header("Location:index.php"); }
	if(isset($_POST['liste'])){
		$_SESSION['liste'] = $_POST['liste'];
				echo"Veuillez entrez les informations nécéssaires à une recherche";
				
				$bdd= new PDO('mysql:host=localhost;dbname=group12;charset=utf8','group12','KS/7yNYP8l');
		if (!$bdd) {
						die('Impossible de se connecter au serveur MySQL : ' . mysql_error());
				}
	
		$rs= $bdd->query('SELECT * FROM '.$_SESSION['liste'].'');
		$fields = array_keys($rs->fetch(PDO::FETCH_ASSOC));
		$_SESSION['field'] = $fields;

		?>
	<form id="login-form" class="login-form" name="filtering" method="post" action="">
	<?php
	
		for($i = 0; $i<sizeof($_SESSION['field']);$i++)
		{
		$type = $rs->getColumnMeta($i);
	    if(strpos($type[native_type],'VAR')!== false)
		{
			$type1[$i]=text;
			$request[$i] = CONTAINS;
		$_SESSION['request'][$i] = $request[$i];
		}
		else if(strpos($type[native_type],'DATE')!== false)
		{
			$type1[$i]=date;
			$request[$i] = EQUALS;
		$_SESSION['request'][$i] = $request[$i];
		}
		else if(strpos($type[native_type],'LONG')!== false)
		{
			$type1[$i] =number;
			$request[$i] = EQUALS;
		$_SESSION['request'][$i] = $request[$i];
		}
		echo"<div class='group'><label for=".$fields[$i].">".$fields[$i]."</label><input name=".$fields[$i]."  type=".$type1[$i]." placeholder=".$fields[$i]." /></div>";
        }
        ?>
		<input type='submit' value='Filtre' /> <br/>
		</form>
        <?php
	}
	if(isset($_SESSION['field'])){
	for($i=0; $i<sizeof($_SESSION['field']);$i++)
	{
		if(isset($_POST[$_SESSION['field'][$i]])&& !empty($_POST[$_SESSION['field'][$i]])&& empty($condition)){
			if($_SESSION['request'][$i] == EQUALS)
			{
				$condition = "".$_SESSION['field'][$i]. " =" .$_POST[$_SESSION['field'][$i]]. "";
			}
		else{
		$condition = "".$_SESSION['field'][$i]. " LIKE '%" .$_POST[$_SESSION['field'][$i]]. "%'";
	}
		}
	else if(isset($_POST[$_SESSION['field'][$i]])&& !empty($_POST[$_SESSION['field'][$i]])&& !empty($condition)){
		if($_SESSION['request'][$i] == EQUALS)
			{
		$condition = $condition. " AND ".$_SESSION['field'][$i]. " = " .$_POST[$_SESSION['field'][$i]]. "";
			}else{
		$condition = $condition. " AND ".$_SESSION['field'][$i]. " LIKE '%" .$_POST[$_SESSION['field'][$i]]. "%'";
	}
	}
	}
	if(!isset($bdd))
	{
	$bdd= new PDO('mysql:host=localhost;dbname=group12;charset=utf8','group12','KS/7yNYP8l');
		if (!$bdd) {
						die('Impossible de se connecter au serveur MySQL : ' . mysql_error());
				}
	}
		$rs= $bdd->query('SELECT * FROM '.$_SESSION['liste'].' WHERE '.$condition);
		echo "<table>";
		while($tuple= $rs->fetch()){
			echo"<tr>";
			for($i=0; $i<sizeof($_SESSION['field']);$i++)
			{
			echo "<td>".$tuple[$_SESSION['field'][$i]]. "</td>";
			}
			echo "</tr>";
		}
		echo "</table>";
	}
?>
		</body>  
	</html>