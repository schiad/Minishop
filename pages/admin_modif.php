<?php

if (isset($_POST["login_modif"]) || isset($_POST["newpw_modif"]) || isset($_POST["newpw2_modif"])) {
	$error = '';

	if ($_POST["newpw_modif"] !== $_POST["newpw2_modif"]) {
		$error = 'Les deux champs de mot de passe ne correspondent pas.';
	}

	if (empty($_POST["login_modif"]) || empty($_POST["newpw_modif"]) || empty($_POST["newpw2_modif"])) {
		$error = 'Tous les champs sont obligatoires';
	}

	$mysqli = db_connect();

	if (empty($error)) {

		$sql = "SELECT user_id FROM users WHERE login='" . $_POST["login_modif"] . "' LIMIT 1";
		$res = mysqli_query($mysqli, $sql) or die("Error : " . mysqli_error($mysqli));

		if (mysqli_num_rows($res) === 0) {
			$error = 'Utilisateur non existant.';
		}
	}

	if (empty($error)) {
		$login = mysqli_real_escape_string($mysqli, $_POST["login_modif"]);
		$query = "UPDATE users SET passwd='" . hash('whirlpool', $_POST["newpw_modif"]) . "' WHERE login='" . $login . "'";
		mysqli_query($mysqli, $query) or die("Error : " . mysqli_error($mysqli));

		?>
		<p class="success">Nouveau mot de passe enregistr&eacute.</p>
		<?php
	} else {
		echo '<p class="error">' . $error . '</p>';
	}

	mysqli_close($mysqli);
}
?>


<h4>Modification d'un mot de passe</h4>
<form action="?page=admin&view=user" method="post" autocomplete="off">
	<p>
		<label>Nom d'utilisateur</label><input type="text" name="login_modif" placeholder="Username"/>
	</p>
	<p>
		<label>Nouveau mot de passe</label><input type="password" name="newpw_modif" placeholder="Password"/>
	</p>
	<p>
		<label>Confirmer le nouveau mot de passe</label><input type="password" name="newpw2_modif" placeholder="New password" />
	</p>
	<button type="submit">Modifier le mot de passe</button>
</form>
