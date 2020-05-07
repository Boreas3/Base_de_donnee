<?php
			$error = '';
			if(isset($_POST['is_login'])){
				$sql = "SELECT * FROM ".$SETTINGS["USERS"]." WHERE `username` = '".mysql_real_escape_string($_POST['username'])."' AND `password` = '".mysql_real_escape_string($_POST['password'])."'";
				$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
				$user = mysql_fetch_assoc($sql_result);
				if(!empty($user)){
					
					$_SESSION['user_info'] = $user;
					$query = " UPDATE ".$SETTINGS["USERS"]." SET last_login = NOW() WHERE id=".$user['id'];
					mysql_query ($query, $connection ) or die ('request "Could not execute SQL query" '.$query);
				}
				else{
					$error = "Mauvais nom d'utilisateur/mot de passe.";
				}
			}
			
			if(isset($_GET['ac']) && $_GET['ac'] == 'logout'){
				$_SESSION['user_info'] = null;
				unset($_SESSION['user_info']);
			}
		?>