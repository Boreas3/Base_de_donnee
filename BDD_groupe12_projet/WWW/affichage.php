
				<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=10; IE=9; IE=8; IE=7; IE=EDGE" />
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
        <script src="https://unpkg.com/floatthead"></script>
        <script>
        $(() => $('table').floatThead());
        </script>
    </head>
	<body>
	
	<?php
		if(isset($_POST['retour']) AND ($_POST['retour'] == 'Page accueil')) { header("Location:index.php"); }
		session_start();
		if(isset($_POST['liste']) && !empty($_POST['liste'])){
			$liste = $_POST['liste'];
		}
	?>
		<div class="group">	
			<form class="login-form" method="post" action="" name="tableSelection">
			A quelle table souhaitez-vous accéder?
				
				<div><select name="liste"></div>
					<option value="acteur" <?php if ($liste == "acteur")echo "selected" ?>> acteur </option>
					<option value="disponible_sur" <?php if ($liste == "disponible_sur")echo "selected" ?>> disponible_sur </option>
					<option value="episodes" <?php if ($liste == "episodes")echo "selected" ?>> episodes </option>
					<option value="est_abonne" <?php if ($liste == "est_abonne")echo "selected" ?>> est_abonne </option>
					<option value="joue_dans" <?php if ($liste == "joue_dans")echo "selected" ?>> joue_dans </option>
					<option value="pays" <?php if ($liste == "pays")echo "selected" ?>> pays </option>
					<option value="personne" <?php if ($liste == "personne")echo "selected" ?>> personne </option>
					<option value="plateforme_streaming" <?php if ($liste == "plateforme_streaming")echo "selected" ?>> plateforme_streaming </option>
					<option value="regarde" <?php if ($liste == "regarde")echo "selected" ?>> regarde </option>
					<option value="serie" <?php if ($liste == "serie")echo "selected" ?>> serie </option>
					<option value="utilisateur" <?php if ($liste == "utilisateur")echo "selected" ?>> utilisateur </option>
				</select>
		</div>
			<input type="submit" value="Aller" /> <br/><br/>
			<input type="submit" name="retour" value="Page accueil"/><br />
			</form>		
				
<?php
	if(isset($_POST['liste'])){
		echo "<form id='login-form' class='login-form' name='filtering' method='post' action=''>";
		$_SESSION["liste"] = $_POST['liste'];
		echo"Veuillez entrez les informations nécéssaires à une recherche";
		
		$bdd= new PDO('mysql:host=localhost;dbname=group12;charset=utf8','group12','KS/7yNYP8l');
		$bdd->exec("SET CHARACTER SET utf8");
        if (!$bdd) {
			die('Impossible de se connecter au serveur MySQL : ' . mysql_error());
		}
	
		$rs= $bdd->query('SELECT * FROM '.$_SESSION["liste"].'');
		$fields = array_keys($rs->fetch(PDO::FETCH_ASSOC));
		$_SESSION['field'] = $fields;
		for($i = 0; $i<sizeof($_SESSION['field']);$i++){
			$type = $rs->getColumnMeta($i);
	    	if(strpos($type[native_type],'VAR')!== false){
				$type1[$i]=text;
				$request[$i] = CONTAINS;
				$_SESSION['request'][$i] = $request[$i];
			}
			else if(strpos($type[native_type],'DATE')!== false){
				$type1[$i]=date;
				$request[$i] = EQUALS;
				$_SESSION['request'][$i] = $request[$i];
			}
			else if(strpos($type[native_type],'LONG')!== false){
				$type1[$i] =number;
				$request[$i] = EQUALS;
				$_SESSION['request'][$i] = $request[$i];
			}
			echo"<div class='group'><label for=".$fields[$i].">".$fields[$i]."</label><input name=".$fields[$i]."  type=".$type1[$i]." placeholder=".$fields[$i]." /></div>";
        
        }
		echo"<input type='submit' value='Filtre' /> <br/>";
		echo"</form>";
	}
	if(isset($_SESSION['field'])){
		for($i=0; $i<sizeof($_SESSION['field']);$i++){
			if(isset($_POST[$_SESSION['field'][$i]])&& !empty($_POST[$_SESSION['field'][$i]])&& empty($condition)){
				if($_SESSION['request'][$i] == EQUALS){
					$condition = "".$_SESSION['field'][$i]. " =" .$_POST[$_SESSION['field'][$i]]. "";
				}
				else{
					$condition = "".$_SESSION['field'][$i]. " LIKE '%" .$_POST[$_SESSION['field'][$i]]. "%'";
				}
			}
			else if(isset($_POST[$_SESSION['field'][$i]])&& !empty($_POST[$_SESSION['field'][$i]])&& !empty($condition)){
				if($_SESSION['request'][$i] == EQUALS){
					$condition = $condition. " AND ".$_SESSION['field'][$i]. " = " .$_POST[$_SESSION['field'][$i]]. "";
				}else{
					$condition = $condition. " AND ".$_SESSION['field'][$i]. " LIKE '%" .$_POST[$_SESSION['field'][$i]]. "%'";
				}
			}
		}
		if(!isset($bdd)){
			$bdd= new PDO('mysql:host=localhost;dbname=group12;charset=utf8','group12','KS/7yNYP8l');
			$bdd->exec("SET CHARACTER SET utf8");
            if (!$bdd) {
				die('Impossible de se connecter au serveur MySQL : ' . mysql_error());
			}
		}
        $rs= $bdd->query('SELECT * FROM '.$_SESSION['liste'].' WHERE '.$condition);
        
		if($rs->rowCount()){
			echo "<form id='login-form' class='login-form' name='filtering' method='post' action=''>";
			echo "Ce que vous cherchez est bien dans la base de données : <br/>";
			?>
            
            <div style="overflow-y: scroll; height:320px;">
            
			<table>
            <thead>
                        <tr style="text-align:left">
                        <?php
				for($i=0; $i<sizeof($_SESSION['field']);$i++){
					echo "<th>".$_SESSION['field'][$i]. "</th>";
                }
            ?>
                        </tr>
                    </thead>
                    <tbody>
            <?php
            
			while($tuple= $rs->fetch()){
            ?>
				<tr>
            <?php
				for($i=0; $i<sizeof($_SESSION['field']);$i++){
					echo "<td>".$tuple[$_SESSION['field'][$i]]. "</td>";
                }
            ?>
				</tr>
            <?php    
            }
            ?>
            </tbody>
		    </table>
			</div><br />
            
			</form>
            <?php
		}
		else {
			echo "<form id='login-form' class='login-form' name='filtering' method='post' action=''>";
			echo "Ce que vous cherchez ne correspond pas à une valeur dans la base de données.";
			echo "</form>";
		}
	}
?>
		</body>  
	</html>