<?php

session_start();
require_once("include/fct.inc.php");
require_once ("include/class.pdoBdChaudoudoux.inc.php");
require_once ("include/matching.php");
require_once ("include/search.php");

include("vues/v_entete.php");
?>
<div id="globale">

            <div id="connexion">

               <form method="POST">
					<h2>Enregistrement</h2>
					<!--<label for="username">Nom d'utilisateur:</label>
					<input type="text" id="username" name="username" required>-->

					<label for="password">Mot de passe:</label>
					<input type="password" id="txtMdp" class="connexion" name="txtMdp" placeholder="mot de passe" maxlength="15" size="30" value="" required>

					<button type="submit" id="ok" value="Register">register</button>
				</form>

<?php

if(isset($_POST["txtMdp"])){
	$signup_password_var = filter_var(htmlentities($_POST['txtMdp']),FILTER_SANITIZE_STRING);
	$options = [
		'cost' => 12,
	];
	echo password_hash($signup_password_var, PASSWORD_BCRYPT, $options);
}


