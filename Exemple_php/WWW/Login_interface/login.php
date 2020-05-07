        <?php
			include ("verif_pwd.php");
		?>
		<?php if(isset($_SESSION['user_info']) && is_array($_SESSION['user_info'])) { 
            include ("Gen_bdd/sql_bdd.php");
        ?>
			<form id="login-form" class="login-form" name="form1">
                
				<div id="form-content">
					<div class="welcome">
						<?php echo $_SESSION['user_info']['username']  ?>, vous êtes connecté. 
						<br /><br />
						<a href="index.php?ac=logout" style="color:#3ec038">Logout</a>
					</div>	
				</div>
		
			</form>	
		<?php } else { ?>
			
			<form id="login-form" class="login-form" name="form1" method="post" action="index.php">
				<input type="hidden" name="is_login" value="1">
				<div class="h1">Entrez le nom d'utilisateur<br/> et le mot de passe</div>
				<div id="form-content">
					<div class="group">
						<label for="username">Nom d'utilisateur</label>
						<div><input id="username" name="username" class="form-control required" type="username" placeholder="Nom d'utilisateur"></div>
					</div>
				<div class="group">
						<label for="name">Mot de passe</label>
						<div><input id="password" name="password" class="form-control required" type="password" placeholder="Mot de passe"></div>
					</div>
					<?php if($error) { ?>
						<em>
							<label class="err" for="password" generated="true" style="display: block;"><?php echo $error ?></label>
						</em>
					<?php } ?>
					<div class="group submit">
						<label class="empty"></label>
						<div><input name="submit" type="submit" value="Login"/></div>
					</div>
				</div>
				<div id="form-loading" class="hide"><i class="fa fa-circle-o-notch fa-spin"></i></div>
			</form>
		<?php } ?>   