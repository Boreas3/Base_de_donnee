<html>
	<head>
		<title>Test de PHP : Login</title>
	</head>
	<body>
		
		<?php 
		
		header('X-XSS-Protection:0');
		
		session_start();
		
		
		//Retirer les variables de session si on s'est déconnectés
		if(isset($_POST['disconnect']))
		{
			session_unset();
		}
		
		//N'oubliez pas d'alller changer vos identifiants
		include 'credentials.php';
		
		$bdd = new PDO('mysql:host=localhost;dbname=group35', $login, $pass);
    
    if($bdd == NULL)
    	echo "Problème de connection";
    
    if(isset($_POST["login"]))
    {


			$query = "SELECT * FROM users WHERE Login = '" . str_replace("'", "\'",$_POST["login"]) . "' AND Pass = '" . str_replace("'", "\'",$_POST["pass"]) . "' ";
			//$query = "SELECT * FROM users WHERE Login = '" . ($_POST["login"]) . "' AND Pass = '" . ($_POST["pass"]) . "' ";
			
			//echo $query;
			$req = $bdd->query($query);
			$tuple = $req->fetch();
		
			if($tuple)
			{
				$_SESSION['login'] = $tuple["Login"];
			}
			else
				echo "Votre login/mot de passe est incorrect<BR><BR>";
		}
		
		
		if(isset($_SESSION['login']))
		{
			echo "<h1>Bienvenue ". $_SESSION['login'] . "</h1><BR>";
			
			if(isset($_POST['texte']))
			{
				//echo "Vous avez écrit : " . $_POST['texte'] . "<BR>";
				echo "Vous avez écrit : " . htmlentities($_POST['texte']) . "<BR>";
			}
			?>
			
			<!-- Formulaire pour se déconnecter -->
			<form method="post" action="login.php">
			<p>
				<input type="hidden" name="disconnect" value="yes">
				<input type="submit" value="Deconnection"/>
			</p>
			</form>
			
			<h2>Entrez un petit texte</h2>
			
			<form method="post" action="login.php">
				<p>
					<input type="text" name="texte"/>
					<input type="submit" value="Envoyer"/>
				</p>
			</form>
			
			<?php 
		}
		else
		{
			
		?>
		
		<h1>Veuillez entrer vos identifiants</h1>
		
		<form method="post" action="login.php">
			<p>
				<input type="text" name="login" required>
				<input type="password" name="pass" required>
				<input type="submit" value="Envoyer"/>
			</p>
			</form>
		
		<?php
	  }
	  ?>
		
	</body>
</html>